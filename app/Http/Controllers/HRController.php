<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Controllers\UsersController;
use App\ProfessionalData;
use App\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Countries;
use App\Country_Region;
use App\User;
use App\Team;
use Spatie\Permission\Models\Role;
use App\Hr_Account_settings;
use App\DayssoffRequest_attachment;
use App\DayssoffRequest;
use App\hr_company_settings_alerts;
use App\hr_company_settings_extradays;
use App\hr_company_settings_general;
use App\hr_company_settings_holidays;
use App\hr_company_settings_vacations;
use App\hr_company_settings_workdays;
use App\MonthDayOff;
use App\Modules;
use Mail;
use Config;
use Log;
use Auth;
use DB;
use App\Events\BroadCastMessage;
use App\Notification;




class HrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = array();
        if (Auth::user()->is_hr_admin == 'admin' || in_array("Administrator", Auth::user()->roles()->pluck('name')->toArray())) {
            //$hr_s = Hr_Account_settings::where('created_by',Auth::user()->id)->orwhere('manager',Auth::user()->id)->select('uid')->get();
            $users = User::with('Hr_account_settings')->where('is_hr_admin', Auth::user()->id)->get();
            return view('Hr.dashboard', compact('users'));
        }

        if (in_array("Employee", Auth::user()->roles()->pluck('name')->toArray())) {
            return view('Hr.employee.employee_dashboard');
        }

        if (in_array("Manager", Auth::user()->roles()->pluck('name')->toArray())) {
            $hr_s = Hr_Account_settings::where('created_by', Auth::user()->id)->orwhere('manager', Auth::user()->id)->select('uid')->get();
            $users = User::with('Hr_account_settings')->where('is_hr_admin', Auth::user()->is_hr_admin)->whereIn('id', $hr_s)->get();
        }
        return view('Hr.dashboard', compact('users'));
    }

    public function create_employee()
    {
        $roles = Role::all();
        $users = User::all();
        $countries = Countries::whereIn('id', array(6, 27, 30, 49, 57, 73, 81, 91, 126, 132, 138, 145, 156, 160, 171, 195, 203, 222, 223))->get();
        return view('Hr.create_employee', compact('countries', 'users', 'roles'));
    }

    public function set_region(Request $request)
    {
        $country_regions = Country_Region::where('country_id', $request->cid)->get();
        return response()->json(['success' => 'true', 'regions' => $country_regions]);
    }

    public function store_employee(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $module = Modules::where('name', 'Human Resource')->firstOrFail();
        if (isset($module) && !empty($module)) {
            $user->access_modules = $module->id;
        }
        $user->country_id = $request->country;
        $pass = md5(uniqid(rand(), true));
        $user->password = bcrypt($pass);
        $user->email_verification = 1;
        $user->choose_module = 1;
        if (Auth::user()->is_hr_admin == 'admin') {
            $user->is_hr_admin = Auth::user()->id;
        } else {
            $user->is_hr_admin = Auth::user()->is_hr_admin;
        }
        $user->save();
        $role = Role::where('id', $request->role)->firstOrFail();
        if (isset($role) && !empty($role)) {
            $user->assignRole($role);
        }
        $hr_settings = new Hr_Account_settings();
        $hr_settings->country_region_id = $request->region;
        $hr_settings->uid = $user->id;
        $hr_settings->manager = $request->manager;
        $user_controller = new UsersController();
        $hr_settings->confirmation_key = $user_controller->create_guid();
        $hr_settings->accepted = 0;
        $hr_settings->created_by = Auth::user()->id;
        $hr_settings->save();
        if ($request->send_invite == "on") {
            $this->send_invite_email($user, $hr_settings, $pass);
        }
        return Redirect()->route('hr.dashboard');
    }

    public function send_invite_email($user, $hr_settings, $pass)
    {
        $user['hr_settings'] = $hr_settings;
        $user['pass'] = $pass;
        $data['user'] = $user;
        Mail::send('Hr.invitation_email', $data, function ($message) use ($data) {
            $message->to($data['user']['email']);
            $message->subject('Module Confirmation email ');
            $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
        });
    }

    public function delete_employee(Request $request)
    {
        if (isset($request->uid) && !empty($request->uid)) {
            $user = User::find($request->uid)->delete();
            if ($user == 1) {
                Hr_Account_settings::where('uid', $request->uid)->delete();
                return response()->json(['success' => 'true', 'id' => $request->uid]);
            } else {
                return response()->json(['success' => 'false', 'id' => $request->uid]);
            }
        }
        return response()->json(['success' => 'false', 'id' => $request->uid]);
    }

    public function manager_emp(Request $request)
    {
        $user = User::find($request->id);
        if (isset($user) && !empty($user)) {
            if (in_array("Manager", $user->roles()->pluck('name')->toArray())) {
                $hr_s = Hr_Account_settings::where('manager', $user->id)->select('uid')->get();
                $users = User::with('Hr_account_settings')->whereIn('id', $hr_s)->get();
            }
        }
        return view('Hr.manager_employees', compact('users'));
    }

    public function create_team()
    {
        $users = array();
        if (in_array("Manager", Auth::user()->roles()->pluck('name')->toArray())) {
            $hr_s = Hr_Account_settings::where('manager', Auth::user()->id)->select('uid')->get();
            $users = User::with('Hr_account_settings')->whereIn('id', $hr_s)->get();
        }
        if (Auth::user()->is_hr_admin == 'admin') {
            $hr_s = Hr_Account_settings::where('created_by', Auth::user()->id)->orwhere('manager', Auth::user()->id)->select('uid')->get();
            $users = User::with('Hr_account_settings')->whereIn('id', $hr_s)->get();
        }
        return view('Hr.create_team', compact('users'));
    }

    public function store_team(Request $request)
    {
        $emp = explode(',', $request->emp_obj);
        $team = new Team();
        $team->name = $request->name;
        $team->created_by = $request->uid;
        if (Auth::user()->is_hr_admin == 'admin') {
            $team->belongs_to = Auth::user()->id;
        } else {
            $team->belongs_to = Auth::user()->is_hr_admin;
        }
        $team->save();
        foreach ($emp as $e) {
            DB::table('team_user')->insert(array(
                'user_id' => $e,
                'team_id' => $team->id,
            ));
        }
        return Redirect()->route('hr.all_teams');
    }

    public function all_teams()
    {
        $teams;
        if (Auth::user()->is_hr_admin == 'admin' || in_array("Administrator", Auth::user()->roles()->pluck('name')->toArray())) {
            $teams = Team::where('belongs_to', Auth::user()->id)->get();
        } else {
            $teams = Team::where('created_by', Auth::user()->id)->where('belongs_to', Auth::user()->is_hr_admin)->get();
        }
        return view('Hr.all_teams', compact('teams'));
    }

    public function delete_team(Request $request)
    {
        if (isset($request->tid) && !empty($request->tid)) {
            $team = Team::find($request->tid)->delete();
            if ($team == 1) {
                return response()->json(['success' => 'true', 'id' => $request->tid]);
            } else {
                return response()->json(['success' => 'false', 'id' => $request->tid]);
            }
        }
        return response()->json(['success' => 'false', 'id' => $request->tid]);
    }

    public function edit_team(Request $request)
    {
        if (isset($request->id) && !empty($request->id)) {
            $team = Team::find($request->id);
            if (isset($team) && !empty($team)) {
                $sel_users = DB::table('team_user')->where('team_id', $team->id)->get()->pluck('user_id');
                $users = array();
                if (in_array("Manager", Auth::user()->roles()->pluck('name')->toArray())) {
                    $hr_s = Hr_Account_settings::where('manager', Auth::user()->id)->select('uid')->get();
                    $users = User::with('Hr_account_settings')->whereIn('id', $hr_s)->get();
                }
                if (Auth::user()->is_hr_admin == 'admin') {
                    $hr_s = Hr_Account_settings::where('created_by', Auth::user()->id)->orwhere('manager', Auth::user()->id)->select('uid')->get();
                    $users = User::with('Hr_account_settings')->whereIn('id', $hr_s)->get();
                }
                $sel_users = json_decode(json_encode($sel_users), true);
                return view('Hr.edit_team', compact('users', 'sel_users', 'team'));
            } else {
                echo "team does not exist";
            }
        } else {
            echo "id does not exist";
        }
    }

    public function store_edit_team(Request $request)
    {
        $team = Team::find($request->team_id);
        if (isset($team) && !empty($team)) {
            $emp = explode(',', $request->emp_obj);
            DB::table('team_user')->where('team_id', $request->team_id)->delete();
            $team->name = $request->name;
            $team->created_by = $request->uid;
            if (Auth::user()->is_hr_admin == 'admin') {
                $team->belongs_to = Auth::user()->id;
            } else {
                $team->belongs_to = Auth::user()->is_hr_admin;
            }
            $team->save();
            foreach ($emp as $e) {
                DB::table('team_user')->insert(array(
                    'user_id' => $e,
                    'team_id' => $team->id,
                ));
            }
        }
        return Redirect()->route('hr.all_teams');
    }

    public function store_dayoff_attachments(Request $request)
    {
        $link = public_path() . '/hr/attachments';
        $file = $request->file('file');
        $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $name = md5(uniqid()) . '.' . $ext;
        $file->move($link, $name);
        return response()->json([
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function delete_dayoff_attachments(Request $request)
    {
        $path = public_path() . '/hr/attachments//' . $request->filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $request->filename;
    }

    public function store_request_days_off(Request $request)
    {
        $dayssoffrequest = new DayssoffRequest();
        if (isset($request->self_days_off) && $request->self_days_off == "on") {
            $dayssoffrequest->employee_id = Auth::user()->id;
        } else {
            $dayssoffrequest->employee_id = $request->employee;
        }
        $dayssoffrequest->off_type = $request->type;
        $dayssoffrequest->period = $request->period;
        if ($request->period == 'days') {
            $dayssoffrequest->start_date = $request->s_date;
            $dayssoffrequest->end_date = $request->e_date;
        }
        if ($request->period == '1/2day') {
            $dayssoffrequest->date = $request->_date;
            $dayssoffrequest->period_of_day = $request->period_of_day;
        }
        $user = User::find(Auth::user()->id);
        if (isset($user) && !empty($user)) {
            $dayssoffrequest->assigned_to = $user->Hr_account_settings->manager;
        }
        $dayssoffrequest->observation = $request->observation;
        if ((isset($request->is_manager) && ($request->is_manager == 'true')) && !isset($request->self_days_off)) {
            $dayssoffrequest->approved = 1;
        }
        $dayssoffrequest->save();
        if (isset($request->attachments) && !empty($request->attachments)) {
            foreach ($request->attachments as $atc) {
                $atchment = new DayssoffRequest_attachment();
                $atchment->dayssoff_requests_id = $dayssoffrequest->id;
                $atchment->name = $atc;
                $atchment->save();
            }
        }
        if (isset($request->is_manager) && ($request->is_manager == 'true')) {
            return redirect()->route('hr.all_requests');
        } else {
            return view('Hr.employee.employee_dashboard');
        }
    }

    public function all_requests()
    {
        $requests = DayssoffRequest::where('assigned_to', Auth::user()->id)->whereNotIn('id',MonthDayOff::select('daysOffRequest_id')->get())->get();
        return view('Hr.manager.all_requests', compact('requests'));
    }

    public function approve_request(Request $request)
    {
        if (isset($request->rid) && !empty($request->rid)) {
            $req = DayssoffRequest::find($request->rid);
            if (isset($req) && !empty($req)) {
                $req->approved = 1;
                $req->save();
                return response()->json(['success' => 'true', 'id' => $request->rid]);
            } else {
                return response()->json(['success' => 'false', 'id' => $request->rid]);
            }
        }
        return response()->json(['success' => 'false', 'id' => $request->rid]);
    }

    public function request_status(Request $request)
    {
        $requests = DayssoffRequest::where('employee_id', Auth::user()->id)->get();
        return view('Hr.employee.request_status', compact('requests'));
    }

    public function employee_edit_personal_data(Request $request, $id)
    {
        $value_exists = DB::table('detail_users')->where('user_id', '=', $id)->first();

        if (isset($value_exists) && !empty($value_exists)) {
            $employee_details = DB::table('detail_users')
                ->leftJoin('users', 'detail_users.user_id', '=', 'users.id')
                ->where('users.id', '=', $id)
                ->select('detail_users.id', 'user_id', 'name', 'address', 'postal_code', 'location', 'phone_no', 'email', 'civil_state', 'birth_date', 'emergency_name', 'emergency_kinship', 'emergency_phone', 'citizen_card', 'fiscal_id', 'social_security', 'driving_license', 'car_plate', 'other_docs', 'academic_degree', 'school', 'course', 'number_dependents', 'deficiencies', 'income_ownership', 'bank_name', 'iban', 'swift', 'facebook', 'twitter', 'linkedin')
                ->get();

        } else {
            $employee_details = new Employee();
            $employee_details->user_id = $id;
            $employee_details->save();

            $employee_details = DB::table('detail_users')
                ->leftJoin('users', 'detail_users.user_id', '=', 'users.id')
                ->where('users.id', '=', $id)
                ->select('detail_users.id', 'user_id', 'name', 'address', 'postal_code', 'location', 'phone_no', 'email', 'civil_state', 'birth_date', 'emergency_name', 'emergency_kinship', 'emergency_phone', 'citizen_card', 'fiscal_id', 'social_security', 'driving_license', 'car_plate', 'other_docs', 'academic_degree', 'school', 'course', 'number_dependents', 'deficiencies', 'income_ownership', 'bank_name', 'iban', 'swift', 'facebook', 'twitter', 'linkedin')
                ->get();
        }
        return view('Hr.edit.employee_personal_data', compact('employee_details'));
    }

    public function employee_edit_professional_data(Request $request, $id)
    {
        $value_exists_2 = DB::table('professional_data')->where('user_id', '=', $id)->first();

        if (isset($value_exists_2) && !empty($value_exists_2)) {
            $employee_details_prof = DB::table('professional_data')
                ->leftJoin('users', 'professional_data.user_id', '=', 'users.id')
                ->where('users.id', '=', $id)
                ->select('professional_data.id', 'user_id', 'employee_code', 'prof_phone', 'prof_email', 'cost_center', 'country', 'region', 'job_role', 'job_role_desc', 'manager', 'base_salary', 'expenses', 'food_allowance', 'value_per_hour', 'felexible_work_hours', 'observations')
                ->get();
        } else {
            $employee_details_prof = new ProfessionalData();
            $employee_details_prof->user_id = $id;
            $employee_details_prof->save();

            $employee_details_prof = DB::table('professional_data')
                ->leftJoin('users', 'professional_data.user_id', '=', 'users.id')
                ->where('users.id', '=', $id)
                ->select('professional_data.id', 'user_id', 'employee_code', 'prof_phone', 'prof_email', 'cost_center', 'country', 'region', 'job_role', 'job_role_desc', 'manager', 'base_salary', 'expenses', 'food_allowance', 'value_per_hour', 'felexible_work_hours', 'observations')
                ->get();
        }
        return view('Hr.edit.employee_professional_data', compact('employee_details_prof'));

    }


    public function employee_make_edit_personal_data(Request $request, $id)
    {

        $employee = Employee::find($id);

        $employee->civil_state = $request->get('civil_state');
        $employee->birth_date = $request->get('birth_date');
        $employee->emergency_name = $request->get('emergency_name');
        $employee->emergency_phone = $request->get('emergency_phone');
        $employee->emergency_kinship = $request->get('emergency_kinship');
        $employee->citizen_card = $request->get('citizen_card');
        $employee->fiscal_id = $request->get('fiscal_id');
        $employee->social_security = $request->get('social_security');
        $employee->driving_license = $request->get('driving_license');
        $employee->car_plate = $request->get('car_plate');
        $employee->other_docs = $request->get('other_docs');
        $employee->academic_degree = $request->get('academic_degree');
        $employee->school = $request->get('school');
        $employee->course = $request->get('course');
        $employee->number_dependents = $request->get('number_dependents');
        $employee->deficiencies = $request->get('deficiencies');
        $employee->income_ownership = $request->get('income_ownership');
        $employee->bank_name = $request->get('bank_name');
        $employee->iban = $request->get('iban');
        $employee->swift = $request->get('swift');
        $employee->facebook = $request->get('facebook');
        $employee->twitter = $request->get('twitter');
        $employee->linkedin = $request->get('linkedin');

        $users = User::find($employee->user_id);
        $users->name = $request->get('name');
        $users->address = $request->get('address');
        $users->postal_code = $request->get('postal_code');
        $users->location = $request->get('location');
        $users->phone_no = $request->get('phone_no');
        $users->email = $request->get('email');

        $employee->update();
        $users->update();
        return redirect()->route('hr.dashboard');
    }

    public function employee_make_edit_professional_data(Request $request, $id)
    {
        $Professional_data = ProfessionalData::find($id);
        $Professional_data->employee_code = $request->get('employee_code');
        $Professional_data->prof_phone = $request->get('prof_phone');
        $Professional_data->prof_email = $request->get('prof_email');
        $Professional_data->cost_center = $request->get('cost_center');
        $Professional_data->country = $request->get('country');
        $Professional_data->region = $request->get('region');
        $Professional_data->job_role = $request->get('job_role');
        $Professional_data->job_role_desc = $request->get('job_role_desc');
        $Professional_data->manager = $request->get('manager');
        $Professional_data->base_salary = $request->get('base_salary');
        $Professional_data->expenses = $request->get('expenses');
        $Professional_data->food_allowance = $request->get('food_allowance');
        $Professional_data->value_per_hour = $request->get('value_per_hour');
        $Professional_data->felexible_work_hours = $request->get('felexible_work_hours');
        $Professional_data->observations = $request->get('observations');

        $Professional_data->update();
        return redirect()->route('hr.dashboard');
    }

    public function company_settings_alerts()
    {
        $company_alerts = hr_company_settings_alerts::where('manager_id',Auth::user()->id)->get();
        return view('hr.company.settings.alerts.index', compact('company_alerts'));
    }

    public function company_settings_vacations()
    {
        $company_vacations = hr_company_settings_vacations::where('manager_id',Auth::user()->id)->get();
        return view('hr.company.settings.vacations.index', compact('company_vacations'));
    }

    public function company_settings_extradays()
    {
        $company_extradays = hr_company_settings_extradays::where('manager_id',Auth::user()->id)->get();
        return view('hr.company.settings.extradays.index', compact('company_extradays'));
    }

    public function company_settings_holidays()
    {
        $company_holidays = hr_company_settings_holidays::where('manager_id',Auth::user()->id)->get();
        return view('hr.company.settings.holidays.index', compact('company_holidays'));
    }

    public function company_settings_workdays()
    {
        $company_workdays = hr_company_settings_workdays::where('manager_id',Auth::user()->id)->get();
        return view('hr.company.settings.workdays.index', compact('company_workdays'));
    }

    public function company_settings_general()
    {
        $company_general = hr_company_settings_general::where('manager_id',Auth::user()->id)->first();
        return view('hr.company.settings.general.index', compact('company_general'));
    }
    public function add_days_off(Request $request)
    {
        $users = array();
        if (in_array("Manager", Auth::user()->roles()->pluck('name')->toArray())) {
            $hr_s = Hr_Account_settings::where('manager', Auth::user()->id)->select('uid')->get();
            $users = User::with('Hr_account_settings')->whereIn('id', $hr_s)->get();
        }
        if (Auth::user()->is_hr_admin == 'admin') {
            $hr_s = Hr_Account_settings::where('created_by', Auth::user()->id)->orwhere('manager', Auth::user()->id)->select('uid')->get();
            $users = User::with('Hr_account_settings')->whereIn('id', $hr_s)->get();
        }
        return view('Hr.manager.add_daysoff_request', compact('users'));
    }

    public function company_settings_alerts_edit($id)
    {
        $company_alerts = hr_company_settings_alerts::find($id);
        return view('hr.company.settings.alerts.edit', compact('company_alerts'));
    }

    public function company_settings_alerts_update($id, Request $request)
    {
        $company_alerts = hr_company_settings_alerts::find($id);

        $company_alerts->remember_time = $request->trigger;
        $company_alerts->status = $request->status;
        $company_alerts->manager_id=Auth::user()->id;
        $company_alerts->save();

        return redirect()->route('hr.company.settings.alerts');
    }

    public function company_settings_vacations_edit($id)
    {

        $company_vacations = hr_company_settings_vacations::find($id);
        return view('hr.company.settings.vacations.edit', compact('company_vacations'));
    }

    public function company_settings_vacations_edit_update($id, Request $request)
    {
        //dd($request->food_subsidy);
        $company_vacations = hr_company_settings_vacations::find($id);
        $company_vacations->name = $request->name;
        $company_vacations->period = $request->period;
        $company_vacations->days_limit = $request->limit;
        $company_vacations->bookings = $request->scheduling;
        $company_vacations->manager_id=Auth::user()->id;

        if (empty($request->food_subsidy)) {
            $company_vacations->food_subsidy = 0;
        } else {
            $company_vacations->food_subsidy = 1;
        }
        if (empty($request->paid)) {
            $company_vacations->paid = 0;
        } else {
            $company_vacations->paid = 1;
        }
        $company_vacations->save();
        return redirect()->route('hr.company.settings.vacations');
    }

    public function company_settings_vacations_showcreate()
    {
        return view('hr.company.settings.vacations.create');
    }

    public function company_settings_vacations_create(Request $request)
    {
        $company_vacations = new hr_company_settings_vacations();

        $company_vacations->name = $request->name;
        $company_vacations->period = $request->period;
        $company_vacations->days_limit = $request->limit;
        $company_vacations->bookings = $request->scheduling;
        $company_vacations->manager_id=Auth::user()->id;

        if (empty($request->food_subsidy)) {
            $company_vacations->food_subsidy = 0;
        } else {
            $company_vacations->food_subsidy = 1;
        }
        if (empty($request->paid)) {
            $company_vacations->paid = 0;
        } else {
            $company_vacations->paid = 1;
        }
        $company_vacations->save();
        return redirect()->route('hr.company.settings.vacations')->with('success', 'Vacation created!');
    }


    public function company_settings_vacations_delete(Request $request)
    {
        $vacations = hr_company_settings_vacations::find($request->vacation_id)->delete();
        if ($vacations == 1) {
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
        return response()->json(['success' => 'false']);
    }

    public function company_settings_extradays_add()
    {
        $countries = Countries::whereIn('id', array(6, 27, 30, 49, 57, 73, 81, 91, 126, 132, 138, 145, 156, 160, 171, 195, 203, 222, 223))->get();
        return view('Hr.company.settings.extradays.create', compact('countries'));
    }

    public function company_settings_extradays_add_create(Request $request)
    {
        $date = $request->date;
        $date_formated_day = date("d", strtotime($date));
        $date_formated_month = date("M", strtotime($date));

        $extradays = new hr_company_settings_extradays();
        $extradays->name = $request->name;
        $extradays->recurrence = $request->recurrence;
        $extradays->date = $date_formated_day . " of " . $date_formated_month;
        $extradays->manager_id=Auth::user()->id;

        $region = Country_Region::where('id', $request->region)->pluck('name')->first();
        $country = Countries::where('id', $request->country)->pluck('name')->first();

        if ($request->checkboxes == "all") {
            $extradays->country = "All Countries";
            $extradays->region = "All Regions";
        } else {
            $extradays->country = $region;
            $extradays->region = $country;
        }
        $extradays->save();

        return redirect()->route('hr.company.settings.extradays')->with('success', 'Extra day added!');
    }

    public function company_settings_extradays_delete(Request $request)
    {
        $extradays = hr_company_settings_extradays::find($request->extradays_id)->delete();
        if ($extradays == 1) {
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
        return response()->json(['success' => 'false']);
    }

    public function company_settings_holidays_delete(Request $request)
    {
        $holidays = hr_company_settings_holidays::find($request->holidays_id)->delete();
        if ($holidays == 1) {
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
        return response()->json(['success' => 'false']);
    }

    public function company_settings_holidays_add()
    {
        $countries = Countries::whereIn('id', array(6, 27, 30, 49, 57, 73, 81, 91, 126, 132, 138, 145, 156, 160, 171, 195, 203, 222, 223))->get();
        return view('Hr.company.settings.holidays.create', compact('countries'));
    }

    public function company_settings_holidays_add_create(Request $request)
    {
        $date = $request->date;
        $date_formated_day = date("d", strtotime($date));
        $date_formated_month = date("M", strtotime($date));

        $holidays = new hr_company_settings_holidays();
        $holidays->name = $request->name;
        $holidays->recurrence = $request->recurrence;
        $holidays->date = $date_formated_day . " of " . $date_formated_month;
        $holidays->manager_id=Auth::user()->id;

        $region = Country_Region::where('id', $request->region)->pluck('name')->first();
        $country = Countries::where('id', $request->country)->pluck('name')->first();

        if ($request->checkboxes == "all") {
            $holidays->country = "All Countries";
            $holidays->region = "All Regions";
        } else {
            $holidays->country = $region;
            $holidays->region = $country;
        }
        $holidays->save();

        return redirect()->route('hr.company.settings.holidays')->with('success', 'Holiday added!');
    }

    public function company_settings_general_edit_filters()
    {
        $company_general = hr_company_settings_general::where('manager_id',Auth::user()->id)->first();
        return view('Hr.company.settings.general.edit_filters',compact('company_general'));
    }

    public function company_settings_general_edit_menus()
    {
        $company_general = hr_company_settings_general::where('manager_id',Auth::user()->id)->first();
        return view('Hr.company.settings.general.edit_menus',compact('company_general'));
    }

    public function company_settings_general_edit_km()
    {
        $company_general = hr_company_settings_general::where('manager_id',Auth::user()->id)->first();
        return view('Hr.company.settings.general.edit_km',compact('company_general'));
    }

    public function company_settings_general_edit_filters_update(Request $request,$id){

        $filters_update=hr_company_settings_general::find($id);
        if(!empty($request->default_filters)){
            $filters_update->show_filters=1;
        }else{
            $filters_update->show_filters=0;
        }
        $filters_update->save();
        return redirect()->route('hr.company.settings.general');
    }

    public function company_settings_general_edit_menus_update(Request $request,$id){

        $menus_update=hr_company_settings_general::find($id);
        if(!empty($request->personal_information)){
            $menus_update->menu_personal_information=1;
        }else{
            $menus_update->menu_personal_information=0;
        }
        if(!empty($request->expenses)){
            $menus_update->menu_expenses=1;
        }else{
            $menus_update->menu_expenses=0;
        }
        if(!empty($request->documents)){
            $menus_update->menu_documents=1;
        }else{
            $menus_update->menu_documents=0;
        }
        $menus_update->save();
        return redirect()->route('hr.company.settings.general');
    }

    public function company_settings_general_edit_km_update(Request $request,$id){

        $km_update=hr_company_settings_general::find($id);

        $km_update->price_km=$request->km_price;
        $km_update->save();
        return redirect()->route('hr.company.settings.general');
    }

    public function hr_resend_invite($id){
        $user=User::find($id);
        $pass = md5(uniqid(rand(), true));
        $user->password = bcrypt($pass);
        $user->save();
        $hr_settings = Hr_Account_settings::where('uid',$id)->first();
        $this->send_invite_email($user, $hr_settings, $pass);
        return Redirect()->route('hr.dashboard')->with('success','Email resend with success!');
    }


    public function calender_days_off(Request $request)
    {  
        if($request->ajax())
    	{
            $response = array();
            if($request->start != NULL && $request->end !=NULL)
            {
                $data = DayssoffRequest::with(['users' => function($qry) {
                    $qry->select('id','name')->first();
                }])->where('assigned_to',Auth::user()->id)->get();
                $i=0;
                foreach($data as $dat)
                {
                    $response[$i]['title'] = $dat->users->name;
                    $response[$i]['id'] = $dat->id;
                    $response[$i]['start'] = $dat->start_date;
                    $response[$i]['end'] = $dat->end_date;
                    $response[$i]['description'] = $dat->observation;
                    $i++;
                }
            }
            return response()->json($response);
    	}
        return View('Hr.ViewTotalDaysOff');
    }
    public function calender_event_action(Request $request)
    {
        if($request->ajax())
    	{
    		if($request->type == 'update')
    		{
                Log::info($request);
    			$event = DayssoffRequest::find($request->id);
                if(isset($event) && !empty($event))
                {
                    $event->start_date =  $request->start;
                    $event->end_date = $request->end;
                    $event->save();
                    return response()->json(['flag'=>1]);
                }else
                {
                    return response()->json(['flag'=>0]);
                }
    		}
    		if($request->type == 'delete')
    		{
    			$event = DayssoffRequest::find($request->id)->delete();
                if($event)
                {
                    return response()->json(['flag'=>1]);
                }else
                {
                    return response()->json(['flag'=>0]);
                }
    			return response()->json($event);
    		}
    	}
    }
    public function add_monthly_daysoff(Request $request)
    {
        if(isset(Auth::user()->Hr_account_settings) && Auth::user()->Hr_account_settings->confirmation_key == $request->token)
        {
            $users = array();
            if(in_array("Manager" , Auth::user()->roles()->pluck('name')->toArray()))
            {
                $hr_s = Hr_Account_settings::where('manager',Auth::user()->id)->select('uid')->get();
                $users = User::with('Hr_account_settings')->whereIn('id',$hr_s)->get();
            }
            elseif(Auth::user()->is_hr_admin == 'admin')
            {
                $hr_s = Hr_Account_settings::where('created_by',Auth::user()->id)->orwhere('manager',Auth::user()->id)->select('uid')->get();
                $users = User::with('Hr_account_settings')->whereIn('id',$hr_s)->get();
            }
            else
            {
                $users = Auth::user();
            }
            return view('Hr.set_monthly_days_off',compact('users'));
        }else
        {
            dd("you are not authorized");
        }
    }
    public function monthly_days_off_store(Request $request)
    {
            if(isset($request->self_days_off) && $request->self_days_off=="on")
            {
                $employee_id = Auth::user()->id;
            }else
            {
                $employee_id = $request->employee;
            }
            if(isset($request->days_off) && !empty($request->days_off))
            {
                foreach( $request->days_off as $days_off)
                {
                    $dayssoffrequest = new DayssoffRequest();
                    $dayssoffrequest->off_type = $days_off[2];
                    $dayssoffrequest->period = "days";
                    $dayssoffrequest->start_date = $days_off[0];
                    $dayssoffrequest->end_date = $days_off[1];
                    $dayssoffrequest->employee_id = $employee_id;
                    if(in_array("Manager" , Auth::user()->roles()->pluck('name')->toArray()))
                    {
                        $dayssoffrequest->approved = 1;
                    }
                    $dayssoffrequest->assigned_to = Auth::user()->Hr_account_settings->manager;
                    $dayssoffrequest->observation = $request->observation;
                    $dayssoffrequest->save(); 
                    if(isset($request->attachments)&& !empty($request->attachments))
                    {
                        foreach($request->attachments as $atc)
                        {
                           $atchment = new DayssoffRequest_attachment();
                           $atchment->dayssoff_requests_id = $dayssoffrequest->id;
                           $atchment->name = $atc;
                           $atchment->save();
                        }
                    }
                    $month_days_off = new MonthDayOff();
                    $month_days_off->user_id = Auth::user()->id;
                    $month_days_off->employee_id = Auth::user()->id;
                    $month_days_off->month_date = date("Y-m");
                    $month_days_off->daysOffRequest_id = $dayssoffrequest->id;
                    $month_days_off->save();
                }
            }
            if(isset($request->half_dyas) && !empty($request->half_dyas))
            {
                foreach( $request->half_dyas as $half_dyas)
                {
                    $dayssoffrequest = new DayssoffRequest();
                    $dayssoffrequest->off_type = $half_dyas[2];
                    $dayssoffrequest->period = "1/2day";
                    $dayssoffrequest->date = $half_dyas[0];
                    $dayssoffrequest->period_of_day = $half_dyas[1];
                    $dayssoffrequest->employee_id = $employee_id;
                    if(in_array("Manager" , Auth::user()->roles()->pluck('name')->toArray()))
                    {
                        $dayssoffrequest->approved = 1;
                    }
                    $dayssoffrequest->assigned_to = Auth::user()->Hr_account_settings->manager;
                    $dayssoffrequest->observation = $request->observation;
                    $dayssoffrequest->save();
                    if(isset($request->attachments)&& !empty($request->attachments))
                    {
                        foreach($request->attachments as $atc)
                        {
                           $atchment = new DayssoffRequest_attachment();
                           $atchment->dayssoff_requests_id = $dayssoffrequest->id;
                           $atchment->name = $atc;
                           $atchment->save();
                        }
                    }
                    $month_days_off = new MonthDayOff();
                    $month_days_off->user_id = Auth::user()->id;
                    $month_days_off->employee_id = Auth::user()->id;
                    $month_days_off->month_date = date("Y-m");
                    $month_days_off->daysOffRequest_id = $dayssoffrequest->id;
                    $month_days_off->save();
                }
            }
            if(in_array("Manager" , Auth::user()->roles()->pluck('name')->toArray()))
            {
                return redirect()->route('hr.all_requests');
            }else
            {
                return view('Hr.employee.employee_dashboard');
            }
    }
    public function employee_month_days_off(Request $request)
    {
        $requests = MonthDayOff::with('daysOff')->where('user_id', $request->id)->where('month_date',date("Y-m"))->get();
        $requset_ids = array();
        foreach($requests as $req)
        {
            $requset_ids[] = $req->daysOff->id;
        }
        $requset_ids = implode(",",$requset_ids);
        return view('Hr.view_monthly_Days_off_request',compact('requests','requset_ids'));
    }
    public function approve_employye_month_days_off(Request $request)
    {
        
        $request_ids = explode(",",$request->request_ids);
        if(count($request_ids) > 0)
        {
            foreach($request_ids as $rid)
            {
                $req = DayssoffRequest::find($rid);
                if(isset($req) && !empty($req)) {
                    $req->approved = 1;
                    $req->save();
                }
            }
        $user = User::find($request->user_id);
        $this->send_email($user,'Monthly days off request Accepted successfully');
        }
        return redirect()->back();
    }
    public function send_email($clt,$sub)
    {
        $data = array();
        Mail::send('Hr.email.accepted_monthly_days_off',$data, function($message) use($clt,$sub){
            $message->to($clt->email);
            $message->subject($sub);
            $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
        });
    }
    public function broadcast_message (Request $request)
    {
        $nti = new Notification();
        $nti->sender_id = Auth::user()->id;
        $nti->recepient_id = $request->uid;
        $nti->message = $request->msg;
        $nti->user_id = Auth::user()->id;
        $saved = $nti->save();
        if($saved)
        {
            event(new BroadCastMessage($request->msg,$request->uid));
            return response()->json(['success'=>'true']);
        }else
        {
            return response()->json(['success'=>'false']);
        }
    }
}