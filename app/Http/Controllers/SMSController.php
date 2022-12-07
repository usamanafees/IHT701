<?php
namespace App\Http\Controllers;
use App\Http\Controllers\AccountSettingsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\EupagoPayments;
use App\Countries;
use App\SMS;
use App\SMS_Sender;
use App\SMS_Templates;
use App\SMSProvider;
use App\SMSRate;
use App\ApiLogs;
use App\User;
use App\AccountSettings;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use \Carbon\Carbon;
use App\Modules;
// use GuzzleHttp\Client;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;
use DB;
use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Support\Facades\Input;
use App\Events\CheckDeliveryStatusInQueueEvent;
use Config;
use Log;

// use GuzzleHttp\Client;


class SMSController extends Controller
{

    public function home(){
		
		if(in_array("Administrator",Auth::user()->roles()->pluck('name')->toArray()))
		{
				$now = Carbon::now();
				$month = $now->month;
				$year =$now->year;
				$last_30_days_sms = SMS::whereYear('created_at', '=', $year)
					->whereMonth('created_at', '=', $month)->count(); 

				$values = "aaa";
				$days = "aaa";
				$smss=DB::table('sms_person as s')
				->select('s.*','sms_sender.sender')
				->join('sms_sender','sms_sender.id','=','s.sender')
				->where('s.user_id',Auth::user()->id)
				->latest('created_at')->take(100)
				->get();

            //compare for widget for sms today for admin
            $today_sms = SMS::whereDate('created_at', Carbon::today())->count();
            $yesterday_sms= SMS::whereDay('created_at',date("d",strtotime("-1 day")))->count();
            if ($yesterday_sms > $today_sms)
                $set_compare_today_sms=0;
            else if ($yesterday_sms < $today_sms)
                $set_compare_today_sms=1;
            else
                $set_compare_today_sms=2;
            //end compare for widget today for admin

            //compare for widget for sms month for admin
            $last_month_sms= SMS::whereMonth('created_at',date("m",strtotime("-1 month")))->count();
            $today_month_sms= SMS::whereMonth('created_at',date("m"))->count();
            if ($last_month_sms > $today_month_sms)
                $set_compare_month_sms=0;
            else if ($last_month_sms < $today_month_sms)
                $set_compare_month_sms=1;
            else
                $set_compare_month_sms=2;
            //end compare for widget month for admin

            //compare for widget for sms year for admin
            $last_year_sms= SMS::whereYear('created_at',date("Y",strtotime("-1 year")))->count();
            $today_year_sms= SMS::whereYear('created_at',date("Y"))->count();
            if ($last_year_sms > $today_year_sms)
                $set_compare_year_sms=0;
            else if ($last_year_sms < $today_year_sms)
                $set_compare_year_sms=1;
            else
                $set_compare_year_sms=2;
            //end compare for widget year for admin
		}
		else
		{
				$smss=DB::table('sms_person as s')
				->select('s.*','sms_sender.sender')
				->join('sms_sender','sms_sender.id','=','s.sender')
				->where('s.user_id',Auth::user()->id)->latest('created_at')->take(100)
				->get();
				$now = Carbon::now();
				$month = $now->month;
				$year =$now->year;
				$last_30_days_sms = SMS::where('user_id',Auth::user()->id)->whereYear('created_at', '=', $year)
					->whereMonth('created_at', '=', $month)->count(); 

				$values = "aaa";
				$days = "aaa";


            //compare for widget for sms today for user
            $today_sms = SMS::where('user_id',Auth::user()->id)->whereDate('created_at', Carbon::today())->count();
            $yesterday_sms= SMS::whereDay('created_at',date("d",strtotime("-1 day")))->whereDate('created_at', Carbon::today())->where('user_id',Auth::user()->id)->count();
            if ($yesterday_sms > $today_sms)
                $set_compare_today_sms=0;
            else if ($yesterday_sms < $today_sms)
                $set_compare_today_sms=1;
            else
                $set_compare_today_sms=2;
            //end compare for widget today for user

            //compare for widget for sms month for user
            $last_month_sms= SMS::whereMonth('created_at',date("m",strtotime("-1 month")))->where('user_id',Auth::user()->id)->count();
            $today_month_sms= SMS::whereMonth('created_at',date("m"))->where('user_id',Auth::user()->id)->count();
            if ($last_month_sms > $today_month_sms)
                $set_compare_month_sms=0;
            else if ($last_month_sms < $today_month_sms)
                $set_compare_month_sms=1;
            else
                $set_compare_month_sms=2;
            //end compare for widget month for user

            //compare for widget for sms year for user
            $last_year_sms= SMS::whereYear('created_at',date("Y",strtotime("-1 year")))->where('user_id',Auth::user()->id)->count();
            $today_year_sms= SMS::whereYear('created_at',date("Y"))->where('user_id',Auth::user()->id)->count();
            if ($last_year_sms > $today_year_sms)
                $set_compare_year_sms=0;
            else if ($last_year_sms < $today_year_sms)
                $set_compare_year_sms=1;
            else
                $set_compare_year_sms=2;
            //end compare for widget year for user
		}
		return view('sms.home',compact('smss','values','days','today_sms','last_30_days_sms','last_year_sms','today_year_sms','set_compare_year_sms','today_month_sms','set_compare_month_sms','today_sms','set_compare_today_sms'));


	}
    public function submit(){
     
        $user = User::with('AccountSettings')->find(Auth::user()->id);
        if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
        {
            $templates = SMS_Templates::all();
			$senders = SMS_Sender::all();
           
        }else{
        $senders = SMS_Sender::where('user_id',$user->id)->get();
        $templates = SMS_Templates::where('user_id',Auth::user()->id)->get();

        }
        
        $countries = Countries::all();
        $service_providers = SMSProvider::first();
    	return view('sms.add',compact('countries','senders','templates','service_providers','user'));
    }
    public function get_rate(Request $request,$country_code){
        $country_id = Countries::where('isd_code',$country_code)->pluck('id');
        $providers = SMSRate::where('country_id',$country_id )->get();
        $min_rate = 99999;
        $row = array();
        foreach($providers as $provider){
            if($min_rate>$provider->rate){
                $row = $provider;
                $min_rate = $provider->rate;
            }
        }
        if($row != null){
       $sms_percentage = (Auth::user()->sms_cost_percentage);    
       $row->final_price = $row->rate*(1+$sms_percentage);
        }
       return $row; 
    }
    public function store(Request $request, User $users , $api_request = '') {
        //dd($request);
		$request_array = array();
        if ($users->id == null) {
            $users = User::with('AccountSettings')->where('id', Auth::user()->id)->first();
        }
        $sms_provider = SMSProvider::first();
        $count = 0;
        if ($sms_provider == null) {
            return redirect()->back()->with('error', 'No SMS Provider found. Please Add SMS Service Provider Before Sending SMS. Thanks');
        }
        if (isset($request->blk_Add) && !empty($request->blk_Add)) {
            $request->mobile_num = $request->mobile_num_blk;
        }
        $provider = $sms_provider->provider_name;
        $to = $request->mobile_Code . $request->mobile_num;
        if ($provider == 'Twilio') {
            $account_sid = $sms_provider->client_id;
            $auth_token = $sms_provider->client_secret;
            $twilio_number = $sms_provider->twilio_number;
            try {
                $client = new Client($account_sid, $auth_token);
                $client->messages->create('+' . $to, ['from' => $twilio_number, 'body' => $request->message]);
            }
            catch(Exception $e) {
                dd($e->getMessage());
            }
        }
        if ($provider == 'Nexmo') {
            env('NEXMO_KEY', $sms_provider->client_id);
            env('NEXMO_SECRET', $sms_provider->client_secret);
            try {
                Nexmo::message()->send(['to' => $to, 'from' => '16105552344', 'text' => $request->message]);
            }
            catch(Exception $e) {
                dd($e->getMessage());
            }
        }
        $sms_sender = SMS_Sender::where('id', $request->sender)->orWhere('sender', $request->sender)->first();
        $alfa_sender = ($sms_sender->sender);
        if ($provider == 'Ez4U_SMS') {
            $account_sid = $sms_provider->client_id;
            $auth_token = $sms_provider->client_secret;
            $client = new \GuzzleHttp\Client();
            $url = $sms_provider->ez4u_url;
            $data = array('account' => $sms_provider->client_id, 'licensekey' => $sms_provider->client_secret, 'phoneNumber' => $request->mobile_num, 'messageText' => $request->message, 'alfaSender' => $alfa_sender);
			$cost_commsion_total = 0;
			$number_of_sms = sizeof(explode(',', $request->mobile_num));
			$cost_rate =  $this->getCostRate($sms_provider,$request);
			$charge_able_cost = ($cost_rate * (1 + $users->sms_cost_percentage)) * $number_of_sms; 
            if($users->AccountSettings->in_app_credit - $charge_able_cost < 0 && sizeof(array_intersect($users->roles()->pluck('name')->toArray(), ['Administrator','SMS Free'])) == 0)
            { 
				if(isset($request->sms_api) && !empty($request->sms_api)){
					return response()->json(['message' => 'error', 'result' => "Your account doesn't have credit to send this message. Please recharge your account to use our services. Thank you!" ], 200);
				}else{
					return redirect()->back()->with('error', "Your account doesn't have credit to send this message. </br> Please recharge your account to use our services. </br> Thank you!");
				}
            }	
            if (isset($request->sms_schedule) && !empty($request->sms_schedule)) {
                $start_date = \Carbon\Carbon::parse(str_replace("/", "-", $request->start_date) . " " . $request->hh . ":" . $request->mm . ":00")->format("Y-m-d H:i:s");
                $data['startDate'] = $start_date;
            } else {
                $data['startDate'] = \Carbon\Carbon::now()->format("Y-m-d H:i:s");
            }
            try {
				if (isset($request->sms_api) && !empty($request->sms_api)) {
					$request_array["ip"] = $request->ipp;
					$request_array["session_id"] = "";
					$request_array["user_agent"] = $request->header('User-Agent');
					$request_array["script_name"] = "app/Http/Controllers/API/SMSController.php";
					$request_array["host"] = $request->host.":".$request->host1;
					$request_array["function"] = "addSMS";
					$request_array["args"] = $api_request;
					$request_array["0"] = "false";
				}
                $response = $client->post($url, ['form_params' => $data]); // sms sent
                $res = $response->getBody()->getContents();
                $data = json_decode($res, true);
               
                if ($response->getStatusCode() == 200 && !isset($data["ErrorCode"])) {
                    $mobile_numbers = explode(',', $request->mobile_num);
                    foreach ($mobile_numbers as $key => $mobile_number) {
                        $count++;
                        if (($data) == true) {
                            $sms_id = $data['SMSIDs'][$key]['SMSID'];
                            if (isset($request->sms_schedule) && !empty($request->sms_schedule)) {
                                $date = $start_date;
                                $sms_status = 1;
                            } else {
                                $date = $this->ez4u_estado_sms($sms_id);
                                $date = json_decode($date, true);
                                $date = $date['MessageInfo']['CreationTimeStamp'];
                                $sms_status = 0;
                            }
                            $sms = new SMS();
                            $sms_sender1 = SMS_Sender::where('sender', $request->sender)->first();
                            $sms->mobile_num = $mobile_number;
                            $sms->message = $request->message;
                            if ($sms_sender1 != null) {
                                $sms->sender = $sms_sender1->id;
                            }
                            if ($sms_sender1 == null) {
                                $sms->sender = $request->sender;
                            }
                            $sms->provider = $sms_provider->id;
                            $sms->mobile_code = $sms_provider->mobile_prefix == "" ?  $request->mobile_Code : $sms_provider->mobile_prefix;
                            $sms_percentage = ($users->sms_cost_percentage);
                            $sms_commission = $cost_rate * (1 + $sms_percentage);
                            $cost_commsion = $sms_commission - $cost_rate;
                            $sms->cost_charged = round($sms_commission, 3);
                            $sms->cost_commission = round($cost_commsion, 3);
                            $sms->user_id = $users->id;
                            $sms->add_comment = $request->admin_comment;
							$cost_commsion_total += round($cost_commsion, 3);
                            if (\Request::is('api/*')) {
                                $sms->channel = "API";
                            } else {
                                $sms->channel = "System";
                            }
                            $sms->state = "Sent";
                            $sms->date = $date;
                            $sms->provider_sms_id = $sms_id;
                            $sms->sms_status = $sms_status;
                            $sms->save();
                            if (\Request::is('api/*')) {
                                $module_for = Modules::where('name','SMS SUBMIT')->first();
                                $apilogs = new ApiLogs();
                                $apilogs->record_id = $sms->id;
                                $apilogs->action = "SMS SUBMIT";
                                $apilogs->module_id = $module_for->id;
                                $apilogs->user_id = $sms->user_id;
                            }
                        }
                    }
                    $amount = ($cost_rate * $count);
                    $transaction_detail = $count . " SMS Sent";
                    $account = new AccountSettingsController;
                    $account->in_app_transaction($amount, $users->id, $transaction_detail, true,$cost_commsion_total);
                } else {
                    if (isset($request->sms_api) && !empty($request->sms_api)) {
                        $apilogs = new ApiLogs();
                        $apilogs->user_id = $users->id;
                        $apilogs->response = isset($data["ErrorCode"])? json_encode(array("message" => "error" , "result" => $data["ErrorDesc"])) :  json_encode(['message' => 'error', 'result' => array('Unexpected HTTP status: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase()) ]);
                        $apilogs->request = json_encode($request_array);
						$apilogs->mobile_number = $request->mobile_num;
						$apilogs->save();
						if( isset($data["ErrorCode"])){
							return response()->json(['message' => 'error', 'result' => $data["ErrorDesc"] ], 200);
						}
						else{
							return response()->json(['message' => 'error', 'result' => array('Unexpected HTTP status: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase()) ], 200);
						}
                        
                    } else {
                        dd('Unexpected HTTP status: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
                    }
                }
            }
            catch(\GuzzleHttp\Exception\BadResponseException $e) {
                if (isset($request->sms_api) && !empty($request->sms_api)) {
                    $apilogs = new ApiLogs();
                    $apilogs->user_id = $users->id;
                    $apilogs->response = json_encode(['message' => 'error', 'result' => array('Error: ' . $e->getMessage()) ]);
					$apilogs->request = json_encode($request_array);
					$apilogs->mobile_number = $request->mobile_num;
                    $apilogs->save();
                    return response()->json(['message' => 'error', 'result' => array('Error: ' . $e->getMessage()) ], 200);
                } else {
                    dd('Error: ' . $e->getMessage());
                }
            }
        }
        if ($request->template_Add != null) {
            $name = $request->template_name;
            $template = $request->message;
            $sms_template = new SMS_Templates();
            $sms_template->name = $name;
            $sms_template->template = $template;
            $sms_template->user_id = $users->id;
            $sms_template->save();
        }
        $balance = AccountSettings::where('user_id', $users->id)->first();
        if (isset($request->sms_api) && !empty($request->sms_api)) {
            if (($data) == true) {
                
                event(new CheckDeliveryStatusInQueueEvent($sms->provider_sms_id));

                $apilogs->response = json_encode(['message' => 'success', 'result' => array('SMS_ID' => $sms->id, 'REMAINING_BALANCE' => $balance->in_app_credit) ]);
				$apilogs->request = json_encode($request_array); 
				$apilogs->save();
                return response()->json(['message' => 'success', 'result' => array('SMS_ID' => $sms->id, 'REMAINING_BALANCE' => $balance->in_app_credit) ], 200);
            } else {
                $apilogs->response = json_encode(['message' => 'success', 'result' => 'Mobile number is incorrect']);
				$apilogs->request = json_encode($request_array); 
				$apilogs->save();
                return redirect()->back()->with('success', 'Mobile number is incorrect');
            }
        } else {
            if (($data) == true) {

                event(new CheckDeliveryStatusInQueueEvent($sms->provider_sms_id));
                return redirect()->back()->with('success', 'SMS sent with SMS ID: ' . $sms->id . ' and Your Remaining Account Balance is: ' . $balance->in_app_credit);
            
            } else {
                return redirect()->back()->with('success', 'Mobile number in incorrect');
            }
        }
    }
    public function listAll(Request $request){
        
		$filter = $this->getFilter($request->filter , $request->start_date, $request->end_date);

		if(is_null($request->sort)){
            $sort = 'desc';
        }
        else{
            $sort = $request->sort;
        }
		$smses = SMS::leftJoin('users', function($join) {
            $join->on('sms_person.user_id', '=', 'users.id');
            })
            ->orderBy('sms_person.id', $sort)->select('sms_person.*','users.name')->whereRaw($filter)->toSql();
        $today = SMS::where('user_id',Auth::user()->id)->where('created_at','>=',\Carbon\Carbon::today())->count();
        $yesterday = SMS::where('user_id',Auth::user()->id)->where('created_at','>=',\Carbon\Carbon::today()->subDays(1))->where('created_at','<=',\Carbon\Carbon::today())->count();
		
		$start_date = $request->start_date;
		$end_date = $request->end_date;

        if(is_null($request->filter)){
            $filter = 'this_month';
			$start_date = "" ;
			$end_date = "";
        }
        else{
            $filter = $request->filter;
			if($request->filter != "select_date"){
				$start_date = "" ;
				$end_date = "";
			}
        }
        $roles = Role::get();
        $user = User::get();
        $today = SMS::where('user_id',Auth::user()->id)->where('created_at','>=',\Carbon\Carbon::today())->count();
        $yesterday = SMS::where('user_id',Auth::user()->id)->where('created_at','>=',\Carbon\Carbon::today()->subDays(1))->where('created_at','<=',\Carbon\Carbon::today())->count();

        if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray())){
            return view('sms.listAll',compact('smses','user','roles','today','yesterday','filter','start_date','end_date'));
        }
        else{
            return redirect()->route('/');
        }
    }
    public function apiLogs(Request $request){
        $action;
        if(isset($request->filter_action) && !empty($request->filter_action))
        {
            $action = $request->filter_action;
        }
        else
        {
            $action = "ALL";
        }
        $filter = $this->getFilterAPI($request->filter , $request->start_date, $request->end_date);
        
        if(is_null($request->sort)){
            $sort = 'desc';
        }
        else{
            $sort = $request->sort;
        }
        $api_logs = ApiLogs::join('users', function($join) {
            $join->on('apilogs.user_id', '=', 'users.id');
        })->join('sms_person', function($join) {
            $join->on('apilogs.sms_id', '=', 'sms_person.id');
        })->orderBy('apilogs.id', $sort)->select('apilogs.*','sms_person.*','users.name')->whereRaw($filter)->toSql();

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if(is_null($request->filter)){
            $filter = 'this_month';
            $start_date = "" ;
            $end_date = "";
        }
        else{
            $filter = $request->filter;
            if($request->filter != "select_date"){
                $start_date = "" ;
                $end_date = "";
            }
        }
        $roles = Role::get();
        $user = User::get();
        $today = ApiLogs::where('user_id', Auth::user()->id)->where('created_at','>=',\Carbon\Carbon::today())->count();
        $yesterday = ApiLogs::where('user_id', Auth::user()->id)->where('created_at','>=',\Carbon\Carbon::today()->subDays(1))->where('created_at','<=',\Carbon\Carbon::today())->count();
        if( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray())){
            return view('sms.apiLogs',compact('api_logs','user','roles','today','yesterday','action','filter','start_date','end_date'));
        }
        else{
            return redirect()->route('/');
        }
    }
    function apiLogsajax(Request $request) {

        $filter_action;
        $opr;
        if(isset($request->filter_action) && !empty($request->filter_action))
        {
            if($request->filter_action == "ALL")
            {
                $opr = "<>";
                $filter_action = NULL;
            }else
            {
                $opr = "=";
                $filter_action = $request->filter_action;
            }
        }
        else{ // shoper double
             $opr = "<>";
                $filter_action = NULL;
        }
        //Log::error($request->order[0]["column"]);
        $filter        = $this->getFilterAPI($request->filter, $request->start_date, $request->end_date);

        $columns       = array(
            0 => 'api_id',
            1=> 'action',
            2 => 'record_id',
            3 => 'api_id',
            4 => 'api_id',
            5 => 'users.id',
            6 => 'name',
            7 => 'state',
            8 => 'date',
            9 => 'date',
            10 => 'hours',
            11 => 'ip'
        );
        $orderby =  "api_id";
        if(isset($request->order[0]["column"]))
        {
            $orderby = $columns[$request->order[0]["column"]];
        }
       //$orderby       = isset($columns[$request->order[0]["column"]]) ? $columns[$request->order[0]["column"]] : "api_id";
        $dir           = isset($request->order[0]["dir"]) ? $request->order[0]["dir"] : "DESC";
        $totalData     = ApiLogs::whereRaw($filter)->where('action',$opr,$filter_action)->count();
        $totalFiltered = $totalData;
        $limit         = $request->input('length');
        $start         = $request->input('start');
		// dd([$orderby, $dir ,$start,$limit]);
        if (empty($request->input('search.value'))) {
            $smses = ApiLogs::leftJoin('users', function($join) {
                $join->on('apilogs.user_id', '=', 'users.id');
            })->leftJoin('sms_person', function($join) {
                $join->on('apilogs.sms_id', '=', 'sms_person.id');
            })->leftJoin('sms_provider', function($join) {
                $join->on('sms_provider.id', '=', 'sms_person.provider');
            })->leftJoin('sms_sender', function($join) {
                $join->on('sms_sender.id', '=', 'sms_person.sender');
            })->select('sms_person.*', 'users.company_name','apilogs.action as action','apilogs.record_id as record_id','apilogs.user_id as user_id', 'sms_provider.provider_name', 'apilogs.response','apilogs.request', 'sms_sender.sender', 'apilogs.created_at AS api_created_at','apilogs.id AS api_id','apilogs.mobile_number as api_m_number')->whereRaw($filter)->where('action',$opr,$filter_action)->offset($start)->limit($limit)->orderBy($orderby, $dir)->get();
        } else {
			// dd($request->input('search.value'));
            $term = $request->input('search.value');
			DB::enableQueryLog();
            $smses = ApiLogs::leftJoin('users', function($join) {
                $join->on('apilogs.user_id', '=', 'users.id');
            })->leftJoin('sms_person', function($join) {
                $join->on('apilogs.sms_id', '=', 'sms_person.id');
            })->leftJoin('sms_provider', function($join) {
                $join->on('sms_provider.id', '=', 'sms_person.provider');
            })->leftJoin('sms_sender', function($join) {
                $join->on('sms_sender.id', '=', 'sms_person.sender');
            })->select('sms_person.*', 'users.company_name', 'apilogs.action as action','apilogs.record_id as record_id','apilogs.user_id as user_id','sms_provider.provider_name', 'apilogs.response', 'apilogs.request','sms_sender.sender','apilogs.id AS api_id','apilogs.created_at AS api_created_at','apilogs.mobile_number as api_m_number')->where(function ($query) use($term){
				$query->orWhere('company_name', 'LIKE', '%' . $term . '%');
				$query->orWhere('mobile_num', 'LIKE', '%' . $term . '%');
				$query->orWhere('sms_person.id', 'LIKE', '%' . $term . '%');
				$query->orWhere('response', 'LIKE', '%' . $term . '%');
				$query->orWhere('apilogs.created_at', 'LIKE', '%' . $term . '%');
                $query->orWhere('apilogs.mobile_number', 'LIKE', '%' . $term . '%');
                $query->orWhere('action', 'LIKE', '%' . $term . '%');
			})
			->whereRaw($filter)->where('action',$opr,$filter_action)->orderBy($orderby, $dir)->offset($start)->limit($limit)->get();
			// dd(DB::getQueryLog());
            $totalFiltered = SMS::join('apilogs', function($join) {
                $join->on('apilogs.sms_id', '=', 'sms_person.id');
            })->join('users', function($join) {
                $join->on('apilogs.user_id', '=', 'users.id');
            })->leftJoin('sms_provider', function($join) {
                $join->on('sms_provider.id', '=', 'sms_person.provider');
            })->leftJoin('sms_sender', function($join) {
                $join->on('sms_sender.id', '=', 'sms_person.sender');
            })->select('sms_person.*', 'users.company_name','apilogs.action as action','apilogs.record_id as record_id','apilogs.user_id as user_id', 'sms_provider.provider_name', 'apilogs.response', 'apilogs.created_at AS api_created_at', 'sms_sender.sender')
			->where(function ($query) use($term){
				$query->orWhere('company_name', 'LIKE', '%' . $term . '%');
				$query->orWhere('mobile_num', 'LIKE', '%' . $term . '%');
				$query->orWhere('sms_person.id', 'LIKE', '%' . $term . '%');
				$query->orWhere('apilogs.response', 'LIKE', '%' . $term . '%');
                $query->orWhere('apilogs.created_at', 'LIKE', '%' . $term . '%');
                $query->orWhere('action', 'LIKE', '%' . $term . '%');
			})
			->whereRaw($filter)->where('action',$opr,$filter_action)->count();
        }
        $data = array();
        if (!empty($smses)) {
            foreach ($smses as $key => $sms) {
                $resp                          = json_decode($sms->response);
				$req 					   = json_decode($sms->request);
                $nestedData['api_id']          = $sms->api_id;
                $nestedData['sub']           = $sms->action;
                $nestedData['sms_id']              = $sms->record_id;
                $nestedData['sms_detail']      = "<span onclick='loadData($sms->api_id)' id='modal' data-id='$sms->id' data-target='#myModal-$sms->id' style='cursor: pointer'>[+]</span>";
                $nestedData['sms_detail_resp']      = "<span onclick='loadResponseData($sms->api_id)' id='modal' data-id='$sms->id' data-target='#myModal-$sms->id' style='cursor: pointer'>[+]</span>";
                $nestedData['clientid']        = $sms->user_id;
                $nestedData['name']            = $sms->company_name;
                $nestedData['mobile_num']      = isset($sms->mobile_num) ? $sms->mobile_num : $sms->api_m_number;
                $nestedData['state']           = (isset($resp->message)) ? $resp->message : "";
                $nestedData['date']            = \Carbon\Carbon::parse($sms->api_created_at)->format('d-m-Y');
                $nestedData['hours']           = \Carbon\Carbon::parse($sms->api_created_at)->format('H:i:s');
                $nestedData['ip']        	   = (isset($req->ip)) ? $req->ip : "";
                $data[]                        = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
    
    function listAllajax(Request $request){
        
	   $filter = $this->getFilter($request->filter , $request->start_date, $request->end_date);
       $columns = array( 
            0 =>'id',  
            1 =>'users.id',
            2 =>'name',
            3 =>'provider_name',
            4 =>'channel',
            5 =>'sender',
            6 =>'mobile_num',
            7 =>'state',
            8 =>'date',
            9 =>'hours',
            10 =>'cost_charged',
            11 =>'cost_commission',
        );

        $orderby = 'id';
        if(isset($request->order[0]["column"])){
            $orderby = $columns[$request->order[0]["column"]];
        }
		//$orderby = isset($columns[$request->order[0]["column"]]) ? $columns[$request->order[0]["column"]] : "id";
        $dir = isset($request->order[0]["dir"]) ? $request->order[0]["dir"] : "DESC";			
        $totalData = SMS::whereRaw($filter)->count();            
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
		
        if(empty($request->input('search.value')))
        {            
            $smses = SMS::leftJoin('users', function($join) {
            $join->on('sms_person.user_id', '=', 'users.id');
            })
			->leftJoin('sms_provider',function($join){
				$join->on('sms_provider.id', '=', 'sms_person.provider');
			})
			->leftJoin('sms_sender',function($join){
				$join->on('sms_sender.id', '=', 'sms_person.sender');
			})
            ->select('sms_person.*','users.name','sms_provider.provider_name') 
						 ->whereRaw($filter)
                         ->offset($start)   
                         ->limit($limit)
                         ->orderBy($orderby,$dir)
                         ->get();
        }else {
            $term = $request->input('search.value'); 
 
            $smses =  SMS::leftJoin('users', function($join) {
                $join->on('sms_person.user_id', '=', 'users.id');
                })
				->leftJoin('sms_provider',function($join){
					$join->on('sms_provider.id', '=', 'sms_person.provider');
				})
				->leftJoin('sms_sender',function($join){
					$join->on('sms_sender.id', '=', 'sms_person.sender');
				})
                ->select('sms_person.*','users.name','sms_provider.provider_name')
                ->where('name','LIKE','%'.$term.'%')
				->whereRaw($filter)
                ->orWhere('sms_person.id','LIKE','%'.$term.'%')
                ->orWhere('sms_provider.provider_name','LIKE','%'.$term.'%')
                ->orWhere('channel','LIKE','%'.$term.'%')
                ->orWhere('sms_sender.sender','LIKE','%'.$term.'%')
                ->orWhere('mobile_num','LIKE','%'.$term.'%')
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($orderby,$dir)
                            ->get();
 
            $totalFiltered = SMS::leftJoin('users', function($join) {
					$join->on('sms_person.user_id', '=', 'users.id');
                })
				->leftJoin('sms_provider',function($join){
					$join->on('sms_provider.id', '=', 'sms_person.provider');
				})
				->leftJoin('sms_sender',function($join){
					$join->on('sms_sender.id', '=', 'sms_person.sender');
				})
                ->select('sms_person.*','users.name')
                ->where('name','LIKE','%'.$term.'%')
                ->orWhere('sms_person.id','LIKE','%'.$term.'%')
                ->orWhere('sms_provider.provider_name','LIKE','%'.$term.'%')
                ->orWhere('channel','LIKE','%'.$term.'%')
                ->orWhere('sms_sender.sender','LIKE','%'.$term.'%')
                ->orWhere('mobile_num','LIKE','%'.$term.'%')
                ->count();
        }
        $data = array();
        if(!empty($smses))
        {
            foreach ($smses as $key=>$sms)
            {
                $nestedData['id'] = "<span onclick='loadData($sms->id)' id='modal' data-id='$sms->id' data-target='#myModal-$sms->id' style='cursor: pointer' class='openmodal'>".$sms->id."</span>";
                $nestedData['clientid'] = $sms->user_id;
                $nestedData['name'] = $sms->name;
                $nestedData['provider_name'] = $sms->provider_name;
                $nestedData['channel'] = $sms->channel;
                $nestedData['sender'] = isset($sms->SMSSender->sender)? $sms->SMSSender->sender : "" ;
                $nestedData['mobile_num'] = $sms->mobile_num;
                $nestedData['state'] = $sms->state;
                $nestedData['delivery'] = $sms->paid_check;
                $nestedData['date'] = \Carbon\Carbon::parse($sms->date)->format('d-m-Y');
                $nestedData['hours'] = \Carbon\Carbon::parse($sms->date)->format('H:i:s');
                $nestedData['cost_charged'] = number_format((float)$sms->cost_charged,3,",",",");
                $nestedData['cost_commission'] = number_format((float)$sms->cost_commission,3,",",",");
                $data[] = $nestedData;
            }
        }
        $json_data = array(
        "draw"            => intval($request->input('draw')),  
        "recordsTotal"    => intval($totalData),  
        "recordsFiltered" => intval($totalFiltered), 
        "data"            => $data
        );            
        echo json_encode($json_data); 
    }
    function listajax(Request $request){
		$filter = $this->getFilter($request->filter , $request->start_date, $request->end_date);
		$columns = array( 
            0 =>'id', 
            1 =>'users.name',
            2 =>'name',
            3 =>'provider_name',
            4 =>'channel',
            5 =>'sender',
            6 =>'mobile_num',
            7 =>'state',
            8 =>'date',
            9 =>'hours',
            10 =>'cost_charged',
            11 =>'cost_commission',
        ); 
        $orderby = "id";
        if(isset($request->order[0]["column"])){
            $orderby = $columns[$request->order[0]["column"]];
        }
        //$orderby = isset($columns[$request->order[0]["column"]]) ? $columns[$request->order[0]["column"]] : "id";
		$dir = isset($request->order[0]["dir"]) ? $request->order[0]["dir"] : "DESC";
        $totalData = SMS::where('user_id',Auth::user()->id)->whereRaw($filter)->count();            
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        if(empty($request->input('search.value')))
        {   
            $smses = SMS::leftJoin('users', function($join) {
            $join->on('sms_person.user_id', '=', 'users.id');
            })
			->leftJoin('sms_provider',function($join){
				$join->on('sms_provider.id', '=', 'sms_person.provider');
			})
			->leftJoin('sms_sender',function($join){
				$join->on('sms_sender.id', '=', 'sms_person.sender');
			})
            ->select('sms_person.*','users.name','sms_provider.provider_name')
                        ->where('sms_person.user_id',Auth::user()->id)
						 ->whereRaw($filter)
                         ->offset($start)   
                         ->limit($limit)
                         ->orderBy($orderby,$dir)
                         ->get();			 
        }else {
            $term = $request->input('search.value'); 
 
            $smses =  SMS::leftJoin('users', function($join) {
                $join->on('sms_person.user_id', '=', 'users.id');
                })
				->leftJoin('sms_provider',function($join){
					$join->on('sms_provider.id', '=', 'sms_person.provider');
				})
				->leftJoin('sms_sender',function($join){
					$join->on('sms_sender.id', '=', 'sms_person.sender');
				})
                ->select('sms_person.*','users.name','sms_provider.provider_name') 
				->where('sms_person.user_id','=',Auth::user()->id)
				->whereRaw($filter)
				->where(function ($query) use ($term) {
					$query->orWhere('name','LIKE','%'.$term.'%');
					$query->orWhere('sms_person.id','LIKE','%'.$term.'%');
					$query->orWhere('sms_provider.provider_name','LIKE','%'.$term.'%');
					$query->orWhere('channel','LIKE','%'.$term.'%');
					$query->orWhere('sms_sender.sender','LIKE','%'.$term.'%');
					$query->orWhere('mobile_num','LIKE','%'.$term.'%');
				})->offset($start)
                            ->limit($limit)
                            ->orderBy($orderby,$dir)
                            ->get();
 
            $totalFiltered = SMS::leftJoin('users', function($join) {
                $join->on('sms_person.user_id', '=', 'users.id');
                })
				->leftJoin('sms_provider',function($join){
					$join->on('sms_provider.id', '=', 'sms_person.provider');
				})
				->leftJoin('sms_sender',function($join){
					$join->on('sms_sender.id', '=', 'sms_person.sender');
				})
                ->select('sms_person.*','users.name')
                ->where('sms_person.user_id','=',Auth::user()->id)
				->whereRaw($filter)
				->where(function ($query) use ($term) {
					$query->orWhere('name','LIKE','%'.$term.'%');
					$query->orWhere('sms_person.id','LIKE','%'.$term.'%');
					$query->orWhere('sms_provider.provider_name','LIKE','%'.$term.'%');
					$query->orWhere('channel','LIKE','%'.$term.'%');
					$query->orWhere('sms_sender.sender','LIKE','%'.$term.'%');
					$query->orWhere('mobile_num','LIKE','%'.$term.'%');
				})->count();
        }
        $data = array();
        if(!empty($smses))
        {
            foreach ($smses as $key=>$sms)
            {
                $nestedData['id'] = "<span onclick='loadData($sms->id)' id='modal' data-id='$sms->id' data-target='#myModal-$sms->id' style='cursor: pointer';' class='openmodal'>".$sms->id."</span>";
                if ( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray())){
                    $nestedData['clientid'] = $sms->user_id;
                    $nestedData['name'] = $sms->name;
                    
					$nestedData['provider_name'] = $sms->provider_name;
					$nestedData['channel'] = $sms->channel;
				}
                $nestedData['sender'] = isset($sms->SMSSender->sender) ? $sms->SMSSender->sender : '';
                $nestedData['mobile_num'] = $sms->mobile_num;
                $nestedData['state'] = $sms->state;
                $nestedData['delivery'] = $sms->paid_check;
                $nestedData['date'] = \Carbon\Carbon::parse($sms->date)->format('d-m-Y');
                $nestedData['hours'] = \Carbon\Carbon::parse($sms->date)->format('H:i:s');
                $nestedData['cost_charged'] = number_format((float)$sms->cost_charged,3,",",",");
				if ( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray())){
					$nestedData['cost_commission'] = number_format((float)$sms->cost_commission,3,",",",");
				}
                $data[] = $nestedData;
            } 
        }
        $json_data = array(
        "draw"            => intval($request->input('draw')),  
        "recordsTotal"    => intval($totalData),  
        "recordsFiltered" => intval($totalFiltered), 
        "data"            => $data   
        );            
        echo json_encode($json_data); 
    }          
 

    public function getModel(Request $request){
        $id = $request->id;

        $smses = SMS::leftJoin('users', function($join) {
            $join->on('sms_person.user_id', '=', 'users.id');
            })
            ->leftJoin('sms_provider', function($join) {
                $join->on('sms_provider.id', '=', 'sms_person.provider');
            })
            ->leftJoin('sms_sender', function($join) {
                $join->on('sms_sender.id', '=', 'sms_person.sender');
            })
        
            ->orderBy('sms_person.id', 'desc')->where('sms_person.id',$id)->select('sms_person.*','users.name','sms_person.provider_sms_id','sms_provider.provider_name','sms_sender.sender AS sendername')->paginate(30);

            foreach ($smses as $key => $sms) {
                $sms_date = \Carbon\Carbon::parse($sms->created_at)->format("d-m-Y");
                $sms->sms_date = $sms_date . " AS ".\Carbon\Carbon::parse($sms->created_at)->format("H:i:s");

                $send_date = \Carbon\Carbon::parse($sms->date)->format("d-m-Y");
                $sms->send_date = $send_date . " AS ".\Carbon\Carbon::parse($sms->date)->format("H:i:s");
            }

       return json_encode($smses);
    }


    public function searchListAll(Request $request){
        $term = $request->search;
        $filter = 'all';
        $roles = Role::get();
        $user = User::get();
        $today = SMS::where('user_id',Auth::user()->id)->where('created_at','>=',\Carbon\Carbon::today())->count();
        $yesterday = SMS::where('user_id',Auth::user()->id)->where('created_at','>=',\Carbon\Carbon::today()->subDays(1))->where('created_at','<=',\Carbon\Carbon::today())->count();

        $smses = SMS::leftJoin('users', function($join) {
            $join->on('sms_person.user_id', '=', 'users.id');
            })
            ->orderBy('sms_person.id', 'desc')->select('sms_person.*','users.name')
            ->where('name','LIKE','%'.$term.'%')
            ->orWhere('sms_person.id','LIKE','%'.$term.'%')
            ->orWhere('provider','LIKE','%'.$term.'%')
            ->orWhere('channel','LIKE','%'.$term.'%')
            ->orWhere('sender','LIKE','%'.$term.'%')
            ->orWhere('mobile_num','LIKE','%'.$term.'%')
            ->paginate(30);

        return view('sms.listAll',compact('smses','user','roles','today','yesterday','filter','term'));
    }

    public function searchList(Request $request){
        $term = $request->search;
        $filter = 'all';
        $roles = Role::get();
        $user = User::get();
        $today = SMS::where('user_id',Auth::user()->id)->where('created_at','>=',\Carbon\Carbon::today())->count();
        $yesterday = SMS::where('user_id',Auth::user()->id)->where('created_at','>=',\Carbon\Carbon::today()->subDays(1))->where('created_at','<=',\Carbon\Carbon::today())->count();

        $smses = SMS::leftJoin('users', function($join) {
            $join->on('sms_person.user_id', '=', 'users.id');
            })
            ->orderBy('sms_person.id', 'desc')->select('sms_person.*','users.name')
            ->where(function($smses){
                    $smses->where('user_id',Auth::user()->id);
               })
              ->where(function($smses) use ($term){
                    $smses->orwhere('name','LIKE','%'.$term.'%')
                    ->orWhere('sms_person.id','LIKE','%'.$term.'%')
                    ->orWhere('provider','LIKE','%'.$term.'%')
                    ->orWhere('channel','LIKE','%'.$term.'%')
                    ->orWhere('sender','LIKE','%'.$term.'%')
                    ->orWhere('mobile_num','LIKE','%'.$term.'%');
              })
            ->paginate(30);

        return view('sms.list',compact('smses','user','roles','today','yesterday','filter','term'));
    }

    public function list(Request $request){
		$filter = $this->getFilter($request->filter , $request->start_date, $request->end_date);
		 if(is_null($request->sort)){
            $sort = 'desc';
        }
        else{
            $sort = $request->sort;
        }
		$smses = SMS::leftJoin('users', function($join) {
            $join->on('sms_person.user_id', '=', 'users.id');
            })
            ->orderBy('sms_person.id', $sort)->where('user_id',Auth::user()->id)->select('sms_person.*','users.name')->whereRaw($filter)->paginate(30);
		$start_date = $request->start_date;
		$end_date = $request->end_date;
       
        if(is_null($request->filter)){
            $filter = 'this_month';
			$start_date = "";
			$end_date = "";
        }else{
            $filter = $request->filter;
			if($request->filter != "select_date"){
				$start_date = "";
				$end_date = "";
			}
        }
        $roles = Role::get();
        $user = User::get();
        $today = SMS::where('user_id',Auth::user()->id)->where('created_at','>=',\Carbon\Carbon::today())->count();
        $yesterday = SMS::where('user_id',Auth::user()->id)->where('created_at','>=',\Carbon\Carbon::today()->subDays(1))->where('created_at','<=',\Carbon\Carbon::today())->count();

        return view('sms.list',compact('smses','user','roles','today','yesterday','filter','start_date','end_date'));

    }
    function ez4u_estado_sms($sms_id){
        $sms_provider = SMSProvider::get();
        $account = $sms_provider[0]['client_id'];
        $lic_key = $sms_provider[0]['client_secret'];
        $autenticar="account=$account&licensekey=$lic_key";
    
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL, "http://54.154.72.85/ez4usms/API/getSMSStatus.php");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $autenticar."&smsID=".$sms_id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $info_sms = json_decode(curl_exec($ch));
        curl_close($ch);
        $json = json_encode($info_sms);
        //return response()->json($info_sms);
		return json_encode($info_sms);
    }
	
	public function getFilter($filter, $start_date = '' , $end_date = ''){
       if(is_null($filter)){
            $filter = 'this_month';
        }
        else{
            $filter = $filter;
        }

        if($filter=='today'){
            $filter = 'Date(date) = CURDATE()';
        }
		else if($filter=='yesterday'){
            $yesterday = date("Y-m-d",strtotime("yesterday"));
            $filter = "Date(date) = '{$yesterday}'";
        }

        else if($filter=='this_week'){
			$start = \Carbon\Carbon::now()->startOfWeek();
			$end = \Carbon\Carbon::now()->endOfWeek();
            $filter = " date BETWEEN '{$start}' AND '{$end}' ";
        }

        else if($filter=='last_week'){
			$start = \Carbon\Carbon::now()->startOfWeek()->subWeek();
			$end = \Carbon\Carbon::now()->endOfWeek();
            $filter = " date BETWEEN '{$start}' AND '{$end}' ";
        }

        else if ($filter=='this_month') {
            $currentMonth = date('m');
			$filter = "MONTH(date) = '{$currentMonth}'";
        }

        else if ($filter=='last_month') {
            $currentMonth = date('m') -1;
            $filter = "MONTH(date) = '{$currentMonth}'";
        }

        else if ($filter=='before_last_month') {
            $currentMonth = date('m') -2;
            $filter = "MONTH(date) = '{$currentMonth}'";
        }

        else if ($filter=='last_qarter') {
			$inside_filter = (new Carbon)->submonths(3); 
            $filter = "date >'{$inside_filter}'";
        }

        else if ($filter=='last_half') {
			$inside_filter = (new Carbon)->submonths(6); 
             $filter = "date >'{$inside_filter}'";
        }

        else if ($filter=='this_year') {
			$start = \Carbon\Carbon::now()->startOfYear();
			$end = \Carbon\Carbon::now()->endOfYear();
			$filter = "date BETWEEN '{$start}' AND '{$end}'";
        }

        else if ($filter=='last_year') {
			$inside_filter = date('Y', strtotime('-1 year'));
            $filter = "YEAR(date) =  '{$inside_filter}'";
        }

        else if ($filter=='all') {
            $filter = " 1";
        }
        
        else if ($filter=='select_date') {
            if($start_date == $end_date)
            {
                $filter = "date LIKE '%{$start_date}%'";
            }else
            {
                $filter = "date BETWEEN '{$start_date}' AND '{$end_date}'";
            }
        }
		return $filter ; 
	}
    public function getFilterAPI($filter, $start_date = '' , $end_date = ''){

       if(is_null($filter)){
            $filter = 'this_month';
        }
        else{
            $filter = $filter;
        }

        if($filter=='today'){
            $filter = 'Date(apilogs.created_at) = CURDATE()';
        }
        else if($filter=='yesterday'){
            $yesterday = date("Y-m-d",strtotime("yesterday"));
            $filter = "Date(apilogs.created_at) = '{$yesterday}'";
        }

        else if($filter=='this_week'){
            $start = \Carbon\Carbon::now()->startOfWeek();
            $end = \Carbon\Carbon::now()->endOfWeek();
            $filter = " apilogs.created_at BETWEEN '{$start}' AND '{$end}' ";
        }

        else if($filter=='last_week'){
            $start = \Carbon\Carbon::now()->startOfWeek()->subWeek();
            $end = \Carbon\Carbon::now()->endOfWeek();
            $filter = " apilogs.created_at BETWEEN '{$start}' AND '{$end}' ";
        }

        else if ($filter=='this_month') {
            $currentMonth = date('m');
            $filter = "MONTH(apilogs.created_at) = '{$currentMonth}'";
        }

        else if ($filter=='last_month') {
            //$currentMonth = date('m') -1;
            $currentMonth = \Carbon\Carbon::now()->subMonth()->format('m');
            $filter = "MONTH(apilogs.created_at) = '{$currentMonth}'";
        }

        else if ($filter=='before_last_month') {
            $currentMonth = \Carbon\Carbon::now()->submonths(2)->format('m');
            $filter = "MONTH(apilogs.created_at) = '{$currentMonth}'";
        }

        else if ($filter=='last_qarter') {
            $inside_filter = (new Carbon)->submonths(3); 
            $filter = "apilogs.created_at >'{$inside_filter}'";
        }

        else if ($filter=='last_half') {
            $inside_filter = (new Carbon)->submonths(6); 
             $filter = "apilogs.created_at >'{$inside_filter}'";
        }

        else if ($filter=='this_year') {
            $start = \Carbon\Carbon::now()->startOfYear();
            $end = \Carbon\Carbon::now()->endOfYear();
            $filter = "apilogs.created_at BETWEEN '{$start}' AND '{$end}'";
        }

        else if ($filter=='last_year') {
            $inside_filter = date('Y', strtotime('-1 year'));
            $filter = "YEAR(apilogs.created_at) =  '{$inside_filter}'";
        }

        else if ($filter=='all') {
            $filter = " 1";
        }
        
        else if ($filter=='select_date') {
            //$filter = "apilogs.created_at BETWEEN '{$start_date}' AND '{$end_date}'";
            if($start_date == $end_date)
            {
                    $filter = "apilogs.created_at LIKE '%{$start_date}%'";
            }else
            {
                    $filter = "apilogs.created_at BETWEEN '{$start_date}' AND '{$end_date}'";
            }
        }
        return $filter ; 
    }
	public function getApiLogs(Request $request){
		$data_array = array();
		$api_logs = ApiLogs::find($request->id);
		$data_array["request"] = json_decode($api_logs->request);
		$data_array["response"] = json_decode($api_logs->response);
		$data_array["apilogs_id"] = $request->id;
		$data_array["action"] = $api_logs->action;
		return json_encode($data_array);
}
	public function getCostRate($sms_provider,$request){
		$cost_rate = 0;
		if ($sms_provider->mobile_prefix == ""){
			$code = explode("+", $request->mobile_Code);
			$mob_id = Countries::where('isd_code', $code[0])->pluck('id');
			$cost_rate = SMSRate::where('country_id', $mob_id)->min('rate');
		}else {
			$code = explode("+", $sms_provider->mobile_prefix);
			$mob_id = Countries::where('isd_code', $code[1])->pluck('id');
			$cost_rate = SMSRate::where('country_id', $mob_id)->min('rate');
		}
		return $cost_rate;
	}
	public function payments(Request $request){
        $clients = User::all();
        $tax_p = AccountSettings::select('tax')->where('user_id',Auth::user()->id)->first();
		return view('sms.payments',compact('clients','tax_p'));
	}
	public function addPayments(Request $request){
        $validator;
        $for_dados;
        $module = Modules::where('name','SMS')->first();
        $user = User::where('id',Auth::user()->id)->first();
        $request->request->add(['ipp' => $this->getIp()]);
        $request_array = $this->prepareRequestArray($request,"addPayments");
		$v = "";
		$tax_percentage = Auth::user()->AccountSettings->tax;
		if($request->type_of_movement == "PC:PT"){
            $validator = Validator::make($request->all(), [
               	'movement_value' => 'required|numeric|min:2',
				'type_of_movement' => 'required'
            ]);
			// $request->validate(array(
			// 	'movement_value' => 'required|numeric|min:2',
			// 	'type_of_movement' => 'required'
			// ));
		}else{
            $validator = Validator::make($request->all(), [
            	'movement_value' => 'required|numeric|min:2',
				'type_of_movement' => 'required',
				'mobile_number' => 'required|numeric|digits_between:9,9',
         ]);
			// $request->validate( array(
			// 	'movement_value' => 'required|numeric|min:2',
			// 	'type_of_movement' => 'required',
			// 	'mobile_number' => 'required|numeric|digits_between:9,9',
			// ));
        }      
        if($validator->fails())
        {
            $this->createApiLog($user->id,"Add Payment",$module->id,NULL, $request_array,json_encode(['message'=>'error','result'=>array($validator->errors())]),$user->phone_no,\Request::url());
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        }
        $tax_exempted_value =  $request->movement_value  / (1 + ($tax_percentage / 100 )) ; 
		$payment = EupagoPayments::create([
		"user_id" => Auth::user()->id,
		"phone" => isset($request->mobile_number) ? $request->mobile_number : '' ,
		"amount" => (float) $tax_exempted_value  ,
		"tax" => (float)($request->movement_value - $tax_exempted_value) ,
        "approved" => "No",
        "reference"=>$request->type_of_movement
		]);
		$result = '';
		try {
			$client = new \SoapClient(Config::get('app.Payment.PY_URL'), array('cache_wsdl' => WSDL_CACHE_NONE));
			switch($request->type_of_movement)
			{
				case 'PC:PT':
				$dados = array("chave" => Config::get('app.Payment.PY_API_KEY'),
					"valor" => (float)$request->movement_value,
					"id" => $payment->id,
					"admin_callback" => route("eupago_callback")."?payment_id=".$payment->id."&payment_hash=".base64_encode($payment->id.round($payment->amount,2)),
                    );
                // \Log::error([$dados]);
                $result = $client->gerarReferenciaMB($dados);
                $for_dados = $dados;
              
            
					break;
				case 'MW:PT':
					$dados = array("chave" => Config::get('app.Payment.PY_API_KEY'),
						"valor" => (float)$request->movement_value,
						"alias"=> $request->mobile_number,
						"id" => $payment->id,
						"admin_callback" => route("eupago_callback")."?payment_id=".$payment->id."&payment_hash=".base64_encode($payment->id.round($payment->amount,2)),
                        );
                    $result = $client->pedidoMBW($dados);
                    $for_dados = $dados;
					break;
			}
		} catch (Exception  $fault) {
			trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
            $this->createApiLog($user->id,"Add Payment",$module->id,$payment->id, $request_array,json_encode(['message'=>'error','result'=>array($payment,$result,$for_dados)]),$user->phone_no,\Request::url());
  
        }
		$payment->update(["eupago_id" => $result->referencia ]);
        // verifica erros na execução do serviço e exibe o resultado
		if (!is_soap_fault($result))
		{
            if ($result->estado == 0) 
            {
                if($request->type_of_movement == "MW:PT" )
                {
                    $this->createApiLog($user->id,"Add Payment",$module->id,$payment->id, $request_array,json_encode(['message'=>'success','result'=>array($payment,$result,$for_dados)]),$user->phone_no,\Request::url());
					return redirect()->back()->with(["responseCode" => 200 , "message" => "Please check the MB WAY app, the payment data was sent on it"]);
                }
                else
                {
                    $this->createApiLog($user->id,"Add Payment",$module->id,$payment->id, $request_array,json_encode(['message'=>'success','result'=>array($payment,$result,$for_dados)]),$user->phone_no,\Request::url());
					return redirect()->back()->with(["entidade" => $result->entidade , "referencia" => $result->referencia, "montante" => number_format($result->valor,2)." EUR"]);
				}
			}
			else{
                   $this->createApiLog($user->id,"Add Payment",$module->id,$payment->id, $request_array,json_encode(['message'=>'unknown','result'=>array($sms_sender,$result,$for_dados)]),$user->phone_no,\Request::url());
				   return false;
			}
		}
    }
    
    public function template_text($val)
    {
          $txt = SMS_Templates::where('id',$val)->first();
          return (response()->json($txt->template));
    }	
	public function eupago_callback(Request $request){
        $eupago_payment = EupagoPayments::find($request->payment_id);
		if(base64_decode($request->payment_hash) == $eupago_payment->id.$eupago_payment->amount){
			$process = EupagoPayments::where('id', $request->payment_id)->where("approved","No")->update(["approved" => "Yes"]);
			if($process){
			$account = new AccountSettingsController;
			$account->in_app_transaction($eupago_payment->amount, $eupago_payment->user_id, "Eupago Confirmed Payment", false,0,$eupago_payment->reference." #".$eupago_payment->eupago_id);
			return response()->json(['message' => 'Success', 'result' => "Payment with ID :".$eupago_payment->eupago_id." has been processed successfully. Thank you!" ], 200);
			}else{
				return response()->json(['message' => 'Error', 'result' => "Payment with ID :".$eupago_payment->eupago_id." has alreay been processed. Thank you!" ], 401);
			}
		}else{
			return response()->json(['message' => 'Error', 'result' => "You are not allowed to mark this payment as paid!" ], 401);
		}	
    }
    




    public function getIp(){
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
			if (array_key_exists($key, $_SERVER) === true){
				foreach (explode(',', $_SERVER[$key]) as $ip){
					$ip = trim($ip); // just to be safe
					if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
						return $ip;
					}
				}
			}
		}
	}
    public function createApiLog($user_id ,$action,$module_id,$record_id, $request , $response ,$mobile_number,$inquiry){
		ApiLogs::create([
			'user_id' => $user_id,
			'request' => json_encode($request),
			'response' => $response,
			'mobile_number' => $mobile_number,
             'inquiry' =>$inquiry,
             'action' => $action,
             'module_id'=>$module_id,
             'record_id'=>$record_id
            ]);
		return true;
    }
    public function prepareRequestArray($request,$action){
		$request_array = array();
		$request_array["ip"] = $request->ipp;
		$request_array["session_id"] = "";
		$request_array["user_agent"] = $request->header('User-Agent');
		$request_array["script_name"] = "app/Http/Controllers/API/SMSController.php";
		$request_array["host"] = "";
		$request_array["function"] = $action;
		$request_array["args"] = $request->all();
		$request_array["0"] = "false";
		return $request_array;
    }
    
}
