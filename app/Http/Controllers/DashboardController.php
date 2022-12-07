<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Invoices;
use Carbon\Carbon;
use App\User;
use App\SMS;
use Auth;
use DB;
use App\Modules;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class DashboardController extends Controller
{
	public function change_module(Request $request)
    {
          $selected_modules = Auth::user()->access_modules;
		  $selected_modules = explode(',',$selected_modules);
		  $all_modules = Modules::all();
		  return View('users.change_module',compact('selected_modules','all_modules'));
    }
	public function index(){
		//$modules = explode(',', Auth::user()->access_modules);
		// if((in_array(2,$modules)))
		// {
		// 	return $this->AdminDashboard(); //Admin dashoboard is basically invoice dashboard

		// }
		// else
		// {
			return $this->ContributerDashboard();
		//}
	}
	public function choose_module(Request $request)
	{
		if(isset($request->modules) && !empty($request->modules) && isset($request->uid) && !empty($request->uid))
		{
			$user = User::find($request->uid);
			$module_ids = $request->modules;
			array_push($module_ids,"1");
			$module_ids = implode(',', $module_ids);
            $user->access_modules = $module_ids;
			$user->choose_module = 1;
			$user->save();
		}
		return redirect()->route('/');
	}
	public function ContributerDashboard(){
		
		if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray())) {
            $smss = DB::table('sms_person as s')
                ->select('s.*', 'sms_sender.sender')
                ->join('sms_sender', 'sms_sender.id', '=', 's.sender')
                //->where('s.user_id',Auth::user()->id)->latest('created_at')
                ->take(5)
                ->get();

            //start of invoices widget
            //start compare for widget today for admin
            $today = Invoices::whereDate('created_at', Carbon::today())->count();
            $yesterday = Invoices::whereDate('created_at', Carbon::yesterday())->count();
            if ($yesterday > $today) {
                $set_compare_today_invoice = 0;
                $set_compare_diff = -($today - $yesterday);
            } else if ($yesterday < $today) {
                $set_compare_today_invoice = 1;
                $set_compare_diff = ($today - $yesterday);
            } else {
                $set_compare_today_invoice = 2;
                $set_compare_diff = ($today - $yesterday);
            }
            //end compare for widget today for admin


            //start compare for widget month for admin
            $last_month_invoice = Invoices::whereMonth('created_at', date("m", strtotime("-1 month")))->whereYear('created_at',date("yyyy"))->count();
            $today_month_invoice = Invoices::whereMonth('created_at', date("m"))->whereYear('created_at',date("yyyy"))->count();
            if ($last_month_invoice > $today_month_invoice) {
                $set_compare_month_invoice = 0;
                $set_compare_diff_month = -($today_month_invoice - $last_month_invoice);
            } else if ($last_month_invoice < $today_month_invoice) {
                $set_compare_month_invoice = 1;
                $set_compare_diff_month = ($today_month_invoice - $last_month_invoice);
            } else {
                $set_compare_month_invoice = 2;
                $set_compare_diff_month = ($today_month_invoice - $last_month_invoice);
            }
            //end compare for widget month for admin

            //start compare for widget year for admin
            $last_year_invoice = Invoices::whereYear('created_at', date("Y", strtotime("-1 year")))->count();
            $today_year_invoice = Invoices::whereYear('created_at', date("Y"))->count();
            if ($last_year_invoice > $today_year_invoice) {
                $set_compare_year_invoice = 0;
                $set_compare_diff_year = -($today_year_invoice - $last_year_invoice);
            } else if ($last_year_invoice < $today_year_invoice) {
                $set_compare_year_invoice = 1;
                $set_compare_diff_year = $today_year_invoice - $last_year_invoice;
            } else {
                $set_compare_year_invoice = 2;
                $set_compare_diff_year = ($today_year_invoice - $last_year_invoice);
            }
            $values = "aaa";
            $days = "aaa";
            $smss = DB::table('sms_person as s')
                ->select('s.*', 'sms_sender.sender')
                ->join('sms_sender', 'sms_sender.id', '=', 's.sender')
                ->where('s.user_id', Auth::user()->id)
                ->latest('created_at')->take(100)
                ->get();


            //start of SMS widget
            //start compare for widget today for admin
            $today_sms = SMS::whereDate('created_at', Carbon::today())->count();
            $yesterday_sms = SMS::whereDate('created_at', Carbon::yesterday())->count();


            if ($yesterday_sms > $today_sms) {
                $set_compare_today_sms = 0;
                $set_compare_diff_sms = -($today_sms - $yesterday_sms);
            } else if ($yesterday_sms < $today_sms) {
                $set_compare_today_sms = 1;
                $set_compare_diff_sms = $today_sms - $yesterday_sms;
            } else {
                $set_compare_today_sms = 2;
                $set_compare_diff_sms = $today_sms - $yesterday_sms;
            }
            //end compare for widget today for admin


            //start compare for widget month for admin
            $last_month_sms = SMS::whereMonth('created_at', date("m", strtotime("-1 month")))->whereYear('created_at',date('Y'))->count();
            $today_month_sms = SMS::whereMonth('created_at', date("m"))->whereYear('created_at',date('Y'))->count();
            if ($last_month_sms > $today_month_sms) {
                $set_compare_month_sms = 0;
                $set_compare_diff_sms_month = -($today_month_sms - $last_month_sms);
            } else if ($last_month_sms < $today_month_sms) {
                $set_compare_month_sms = 1;
                $set_compare_diff_sms_month = $today_month_sms - $last_month_sms;
            } else {
                $set_compare_month_sms = 2;
                $set_compare_diff_sms_month = $today_month_sms - $last_month_sms;
            }
            //end compare for widget month for admin

            //start compare for widget year for admin
            $last_year_sms = SMS::whereYear('created_at', date("Y", strtotime("-1 year")))->count();
            $today_year_sms = SMS::whereYear('created_at', date("Y"))->count();
            if ($last_year_sms > $today_year_sms) {
                $set_compare_year_sms = 0;
                $set_compare_diff_sms_year = -($today_year_sms - $last_year_sms);
            } else if ($last_year_sms < $today_year_sms) {
                $set_compare_year_sms = 1;
                $set_compare_diff_sms_year = ($today_year_sms - $last_year_sms);
            } else {
                $set_compare_year_sms = 2;
                $set_compare_diff_sms_year = ($today_year_sms - $last_year_sms);
            }
            //end compare for widget year for admin
            //end of SMS widget

        }else
		{
				$smss=DB::table('sms_person as s')
				->select('s.*','sms_sender.sender')
				->join('sms_sender','sms_sender.id','=','s.sender')
				->where('s.user_id',Auth::user()->id)->latest('created_at')->take(5)
				->get();

				// $user = User::with('AccountSettings')->find(Auth::user()->id);
				// $invoices = Invoices::all();
				// $invoices_array =  Invoices::orderBy('id', 'DESC')->get()->toArray();
				// $values = [''];
				// $days = [''];
				// $total = 0;
				// if(count($invoices_array) > 30){
				// 	for($i = 0; $i < 30; $i++){
				// 				$values[$i] = $invoices_array[$i]['total_invoice_value'];
				// 				$date = Carbon::parse($invoices_array[$i]['created_at']);
				// 				$days[$i] = $date->format('d-F-yy');
				// 	}
				// }else{
				// 	for($i = 0; $i < count($invoices_array); $i++){
				// 				$values[$i] = $invoices_array[$i]['total_invoice_value'];
				// 				$date = Carbon::parse($invoices_array[$i]['created_at']);
				// 				$days[$i] = $date->format('d-F-yy');
				// 	}
				// }
				// $total = max($values);
				$values = "aaa";
				$days = "aaa";

            //start of SMS widget
            //start compare for widget today for user
            $today_sms = SMS::where('user_id',Auth::user()->id)->whereDate('created_at', Carbon::today())->count();
            $yesterday_sms= SMS::whereDay('created_at',date("d",strtotime("-1 day")))->where('user_id',Auth::user()->id)->count();

            if ($yesterday_sms > $today_sms) {
                $set_compare_today_sms = 0;
                    $set_compare_diff_sms = -($today_sms - $yesterday_sms);
            }
            else if ($yesterday_sms < $today_sms) {
                $set_compare_today_sms = 1;
                    $set_compare_diff_sms = ($today_sms - $yesterday_sms);
            }
            else {
                $set_compare_today_sms = 2;
                    $set_compare_diff_sms = $today_sms - $yesterday_sms;
            }
            //end compare for widget today for user


            //start compare for widget month for user
            $last_month_sms= SMS::whereMonth('created_at',date("m",strtotime("-1 month")))->where('user_id',Auth::user()->id)->count();
            $today_month_sms= SMS::whereMonth('created_at',date("m"))->where('user_id',Auth::user()->id)->count();
            if ($last_month_sms > $today_month_sms) {
                $set_compare_month_sms = 0;
                    $set_compare_diff_sms_month = -($today_month_sms - $last_month_sms);
            }
            else if ($last_month_sms < $today_month_sms) {
                $set_compare_month_sms = 1;
                    $set_compare_diff_sms_month = ($today_month_sms - $last_month_sms);
            }
            else {
                $set_compare_month_sms = 2;
                    $set_compare_diff_sms_month = ($today_month_sms - $last_month_sms);
            }
            //end compare for widget month for user

            //start compare for widget year for user
            $last_year_sms= SMS::whereYear('created_at',date("Y",strtotime("-1 year")))->where('user_id',Auth::user()->id)->count();
            $today_year_sms= SMS::whereYear('created_at',date("Y"))->where('user_id',Auth::user()->id)->count();
            if ($last_year_sms > $today_year_sms) {
                $set_compare_year_sms = 0;
                    $set_compare_diff_sms_year = -($today_year_sms - $last_year_sms);
            }
            else if ($last_year_sms < $today_year_sms) {
                $set_compare_year_sms = 1;
                    $set_compare_diff_sms_year = ($today_year_sms - $last_year_sms );

            }
            else {
                $set_compare_year_sms = 2;
                    $set_compare_diff_sms_year = ($today_year_sms - $last_year_sms);
            }
            //end compare for widget year for user
            //end of SMS widget



            //start of invoices widget
            //start compare for widget today for user
            $today = Invoices::where('uid',Auth::user()->id)->whereDate('created_at', Carbon::today())->count();
            $yesterday= Invoices::whereDay('created_at',date("d",strtotime("-1 day")))->where('uid',Auth::user()->id)->count();
            if ($yesterday > $today) {
                $set_compare_today_invoice = 0;
                    $set_compare_diff = -($today - $yesterday );
            }
            else if ($yesterday < $today) {
                $set_compare_today_invoice = 1;
                    $set_compare_diff = ($today - $yesterday );
            }
            else {
                $set_compare_today_invoice = 2;
				$set_compare_diff = $today - $yesterday ;
            }
            //end compare for widget today for user


            //start compare for widget month for user
            $last_month_invoice= Invoices::whereMonth('created_at',date("m",strtotime("-1 month")))->where('uid',Auth::user()->id)->count();
            $today_month_invoice= Invoices::whereMonth('created_at',date("m"))->where('uid',Auth::user()->id)->count();
            if ($last_month_invoice > $today_month_invoice) {
                $set_compare_month_invoice = 0;
                    $set_compare_diff_month = -($today_month_invoice - $last_month_invoice);
            }
            else if ($last_month_invoice < $today_month_invoice) {
                $set_compare_month_invoice = 1;
                    $set_compare_diff_month = ($today_month_invoice - $last_month_invoice);
            }
            else {
                $set_compare_month_invoice = 2;
                    $set_compare_diff_month = ($today_month_invoice - $last_month_invoice);
            }
            //end compare for widget month for user

            //start compare for widget year for user
            $last_year_invoice= Invoices::whereYear('created_at',date("Y",strtotime("-1 year")))->where('uid',Auth::user()->id)->count();
            $today_year_invoice= Invoices::whereYear('created_at',date("Y"))->where('uid',Auth::user()->id)->count();
            if ($last_year_invoice > $today_year_invoice) {
                $set_compare_year_invoice = 0;
                    $set_compare_diff_year = -($today_year_invoice - $last_year_invoice);
            }
            else if ($last_year_invoice < $today_year_invoice) {
                $set_compare_year_invoice = 1;
                    $set_compare_diff_year = ($today_year_invoice - $last_year_invoice);
            }
            else {
                $set_compare_year_invoice = 2;
                    $set_compare_diff_year = ($today_year_invoice - $last_year_invoice);
            }
            //end compare for widget year for user
            //end of invoices widget


		}
		$all_modules = Modules::all();
        $user = User::find(Auth::user()->id);
        if(!isset($user->user_fee_list)) {
            DB::table('users')->where('id',Auth::user()->id)->update(['user_fee_list'=>'{"1":["23","IVA Portugal Continental"],"2":["18","IVA Portugal Açores"],"3":["22","IVA Portugal Madeira"],"4":["0","Isento"]}']);
        }
		return view('dashboard.contributerdashboard',compact('all_modules','smss','values','days','today_sms','last_year_sms','set_compare_month_sms','set_compare_year_sms','today_month_sms','today_year_sms','set_compare_today_sms','today','set_compare_diff','set_compare_today_invoice','today_month_invoice','set_compare_diff_month','set_compare_month_invoice','today_year_invoice','set_compare_diff_year','set_compare_year_invoice','last_year_invoice','set_compare_diff_sms','set_compare_diff_sms_month','set_compare_diff_sms_year'));
	

	}
    public function AdminDashboard(){

        $user = User::with('AccountSettings')->find(Auth::user()->id);
    	$invoices = Invoices::all();
    	$invoices_array =  Invoices::orderBy('id', 'DESC')->get()->toArray();
    	$values = [''];
    	$days = [''];
    	$total = 0;
    	if(count($invoices_array) > 30){
    		for($i = 0; $i < 30; $i++){
						$values[$i] = $invoices_array[$i]['total_invoice_value'];
						$date = Carbon::parse($invoices_array[$i]['created_at']);
						$days[$i] = $date->format('d-F-yy');
	    	}
    	}else{
    		for($i = 0; $i < count($invoices_array); $i++){
						$values[$i] = $invoices_array[$i]['total_invoice_value'];
						$date = Carbon::parse($invoices_array[$i]['created_at']);
						$days[$i] = $date->format('d-F-yy');
	    	}
    	}
    	$total = max($values);




// sms data

		$today_sms = SMS::whereDate('created_at', Carbon::today())->count();
		//dd($today);
		$now = Carbon::now();
		$month = $now->month;
		$year =$now->year;
		$to = Carbon::today();

		$all_sms = SMS::all()->count();
		//$all_sms = SMS::where('user_id',Auth::user()->id)->whereBetween('created_at', [$from_last_year, $to])->count();




		return view('dashboard.admindashboard',compact('today_sms','all_sms','invoices','values','days','total','user','set_compare_year_sms','set_compare_month_sms','set_compare_year_sms','today_month_sms','today_year_sms','set_compare_today_sms','today','set_compare_diff','set_compare_today_invoice','today_month_invoice','set_compare_diff_month','set_compare_month_invoice','today_year_invoice','set_compare_diff_year','set_compare_year_invoice'));

	}
	


}
