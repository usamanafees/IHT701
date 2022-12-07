<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\AccountSettings;
use App\ApiLogs;
use App\Countries;
use App\Subsidiaries;
use App\User;
use App\InAppTransactions;
use Auth;
use DateTime;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use App\Http\Controllers\SMSController;
use Spatie\Permission\Models\Role;
use App\SMS;
use DB;
use Mail;
use Config;
use Log;

class AccountSettingsController extends Controller
{
    public function user_account_settings(){

        return view('accounts.user_account_settings');
    }

    public function changePassword(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");

    }




    public function company_info($id){
    	$user = User::with('Subsidiaries')->find($id);
    	return view('accounts.company_details',compact('user'));
    }

    public function account_balance(){
        $user = User::with('Subsidiaries','AccountSettings')->find(Auth::user()->id);
        
        $fdate = $user->AccountSettings->created_at;
        $tdate = $user->AccountSettings->expires_on;

        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
        
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');

    	return view('accounts.account_details',compact('user','days'));
    }
    public function Billing_data(Request $request){
    	$user = User::with('Subsidiaries')->find(Auth::user()->id);
    	$countries = Countries::All();
    	return view('accounts.billing_data',compact('user','countries'));
    }
    public function Billing_store(Request $request){

    	$user = User::find(Auth::user()->id);

    	if($user->email != $request->email){
    		$this->validate($request, [
            'email' => 'required|email|max:255|unique:users',
          ]);

    		$user->email = $request->email;
    	}

    	$user->company_name =  $request->company_name;
    	$user->country_id =  $request->country_id;
    	$user->update();

    	$subsid = Subsidiaries::where('user_id',$user->id)->first();
        // $subsid->taxpayer = $request->taxpayer;
        $subsid->city = $request->city;
        $subsid->postal_code = $request->postal_code;
        $subsid->address = $request->address;
        $subsid->user_id = $user->id;
        $subsid->vat_number = $request->vat_number;
        $subsid->update();

        return redirect()->back();
    	
    }

    public function manage_plan(){
        return view('accounts.manage_plan');
    }

    public function payment_plan($id){
       
        $totalDuration = 0;
        $totalAmount = 0;
        $Months = 0;
        $PlanType = 0;
        
        $id = explode('-', $id);

        $totalDuration = $id['0'];
        $totalAmount = $id['1'];
        $Months = $id['2'];
        
        if(count($id) > 3 ){
            $PlanType = $id['3'];
        }

        $user = User::with('Subsidiaries','AccountSettings')->find(Auth::user()->id);
        $countries = Countries::All();

        $fdate = $user->AccountSettings->created_at;
        $tdate = $user->AccountSettings->expires_on;

        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
        
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');

        return view('accounts.order',compact('user','countries','days','totalDuration','totalAmount','Months','PlanType'));
    }

    public function paypal_order($id){
	   dd([env('PAYPAL_CLIENT_ID'),env('PAYPAL_SECRET_ID')]);
       $user = User::with('Subsidiaries','AccountSettings')->find(Auth::user()->id);
       $payment_code = explode('-', $user->AccountSettings->payment_code);
       $totalAmount = $payment_code['1'];
        $apiContext = new ApiContext(
              new OAuthTokenCredential(
                env('PAYPAL_CLIENT_ID'),
                env('PAYPAL_SECRET_ID')
              )
            );
        $apiContext->setConfig([
        'mode' => env('PAYPAL_MODE')
        ]);
        // Create new payer and method
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // Set redirect URLs
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('process.paypal'))
          ->setCancelUrl(route('process.paypal.cancel'));

        // Set payment amount
        $amount = new Amount();
        $amount->setCurrency("USD")
          ->setTotal($totalAmount);

        // Set transaction object
        $transaction = new Transaction();
        $transaction->setAmount($amount)
          ->setDescription("Payment description");

        // Create the full payment object
        $payment = new Payment();
        $payment->setIntent('sale')
          ->setPayer($payer)
          ->setRedirectUrls($redirectUrls)
          ->setTransactions(array($transaction));

          // Create payment with valid API context
            try {

              $payment->create($apiContext);

              // Get PayPal redirect URL and redirect the customer
              $approvalUrl = $payment->getApprovalLink();

              $billing_user_data = $user->Subsidiaries->toArray();

              return redirect($approvalUrl);

              // Redirect the customer to $approvalUrl
            } catch (PayPal\Exception\PayPalConnectionException $ex) {
              echo $ex->getCode();
              echo $ex->getData();
              die($ex);
            } catch (Exception $ex) {
              die($ex);
            }
    }

    public function process_paypal(Request $request){
      // dd("process");
        $apiContext = new ApiContext(
              new OAuthTokenCredential(
                env('PAYPAL_CLIENT_ID'),
                env('PAYPAL_SECRET_ID')
              )
            );
        // Get payment object by passing paymentId
        $paymentId = $request->paymentId;
        $payment = Payment::get($paymentId, $apiContext);
        $payerId = $request->PayerID;

        // Execute payment with payer ID
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
          // Execute payment
          $result = $payment->execute($execution, $apiContext);
          // return redirect('accounts/'.Auth::user()->id.'/billing_data')->with('success','Congratulations! You have successfully bought the selected Plan');
          return redirect()->route('account.balance')->with('success','Congratulations! You have successfully bought the selected Plan');
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
          echo $ex->getCode();
          echo $ex->getData();
          die($ex);
        } catch (Exception $ex) {
          die($ex);
        }
    }
    public function process_paypal_cancel(){
        return redirect()->route('account.balance')->with('error','Sorry! Your payment has been canceled.');
    }
	public function in_app_transaction($amount , $user_id , $transaction_detail, $debit, $commission , $private_description = "" , $movement  = "" , $movement_type = "" )
	{
		$user = User::find($user_id);
		if(isset($user->AccountSettings) && isset($user->AccountSettings->in_app_credit)){
			if($debit){
         $amount = $commission > 0 ? $amount + $commission : $amount;
				 AccountSettings::where('user_id',$user->id)->update(['in_app_credit' => ($user->AccountSettings->in_app_credit - $amount)]);
				 if($commission > 0){
					$company_account = AccountSettings::where('user_id',0)->get()->first();
					$company_account->update(['in_app_credit' => $company_account->in_app_credit  + $commission]); 
					InAppTransactions::create([
					'user_id' => 0,
					'transaction_details' => "Commission ".$transaction_detail,
					'debited_amount' =>  0 ,
					'credited_amount' => $commission,
					'balance' => $company_account->in_app_credit ,
					]); 
				 }
      }else{
				 AccountSettings::where('user_id',$user->id)->update(['in_app_credit' => ($user->AccountSettings->in_app_credit + $amount)]);
			}
			$balance = AccountSettings::where('user_id',$user->id)->get()->first();
			InAppTransactions::create([
			'user_id' => $user->id,
			'transaction_details' => $transaction_detail,
			'debited_amount' => $debit ? $amount : 0 ,
			'credited_amount' => $debit ? 0 : $amount,
			'private_description' => $private_description,
			'movement' => $movement,
			'movement_type' => $movement_type,
			'balance' => $balance->in_app_credit,
			]);
			return "Transaction Excuted Successfully"; 			
	
		}
		else{
			return "Not Enough Credit, Please recharge your account!";			
		}
		
	}
  public function contact_client_via_email()
  {
    $clients = User::all();
		return view('admin.contact_client',compact('clients'));
  }
public function contact_client_via_email_s(Request $request)
{
  

  $user = User::where('id',Auth::user()->id)->first();
  $users = User::whereIn('id',$request->client)->get();	
  $request->request->add(['ip' => $this->getIp()]);
  $request_array = $this->prepareRequestArray($request,'Contact Clients');
  $request->client_names = array();
  $request->client = array();
  foreach($users as $u)
  {
    $request->client[] =$u->id;
    $request->client_names[] =$u->company_name;
  }	
  if(isset($request->check_box))
  {
    $active_users = User::where('active',1)->get();
	$request->client = array();
	$request->client_names = array();
    foreach($active_users as $u)
    {
      $request->client[] =$u->id;
      $request->client_names[] =$u->company_name;
    } 
  }
  $msg = $request->message;
  foreach($request->client as $c)
  {
	  $data['user']= User::where('id',$c)->first();
	  $data['message']=$request->message;
    $data['subject'] = $request->subject;
    try{
	  Mail::send('admin.contact_client_email',['data' => $data], function($message) use($data){
	  $message->to($data['user']['email']);
    $message->subject($data['subject']);
    //dd(Config::get('mail.from.address'),Config::get('mail.from.name'));
	  $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
  });       
    $this->createApiLog($user->id,"Contact Client",4,$c, $request_array,json_encode(['message'=>'success','Email'=>'Sent','result'=>array($data['user'])]),$user->phone_no,\Request::url());
    }
    catch(Exception $e)  
    {
      $this->createApiLog($user->id,"Contact Client",4,$c, $request_array,json_encode(['message'=>'error','result'=>array($data['user'],$e->getMessage())]),$user->phone_no,\Request::url());

    }
}  
  
  
  // ApiLogs::create([
	//   'user_id' => Auth::user()->id,
	//   'request' => json_encode([
	// 			   "Client Names" => $request->client_names,
	// 			   "Email Subject" => $request->subject,
	// 			   "Email Message" => $request->message,
	// 			   ]),
	//   'action' => "Contact Client",
	//   'module_id'=>4,
  // ]);

  return redirect()->back()->with(array('responseCode' => 200 ,'message' =>'Emails has been sent'));
}
	public function balanceMovements(Request $request){
		$clients = User::all();
		return view('accounts.movements',compact('clients'));
	}
	public function savebalanceMovements(Request $request){
		$request->validate([
			'client' => 'required',
			'description' => 'required',
			'type_of_movement' => 'required',
			'movement' => 'required',
      'movement_value' => 'required|numeric']);
		$amount = $request->movement_value;
		$client = $request->client;
		$description = $request->description;
		$private_description = $request->private_description;
		$debit = $request->movement == "debit" ? true : false;
		$movement = $request->movement;
		$movement_type = $request->type_of_movement;
		$message = $this->in_app_transaction($amount , $client , $description, $debit ,0, $private_description, $movement , $movement_type);
		$responseCode = ($message == "Transaction Excuted Successfully") ? 200 : 100;
		return redirect()->back()->with(array('responseCode' => $responseCode ,'message' => $message));
  }

	public function listbalanceMovements(Request $request){
		$sms_controller = new SMSController();
		$filter = $sms_controller->getFilter($request->filter , $request->start_date, $request->end_date);
		 if(is_null($request->sort)){
            $sort = 'desc';
        }
        else{
            $sort = $request->sort;
        }
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
		
		return view('accounts.listMovements',compact('filter','start_date','end_date'));
	}
	
	
	function listbalanceMovementsAjax(Request $request){
		$sms_controller = new SMSController();
		$filter = $sms_controller->getFilter($request->filter , $request->start_date, $request->end_date);
		$filter = str_replace("date","in_app_transactions.created_at",$filter);
		// dd($filter);
		$columns = array( 
            0 =>'id', 
            1 =>'users.id',
            2 =>'name',
            3 =>'private_description',
            4 =>'description',
            5 =>'created_at',
            6 =>'hours',
            7 =>'value',
            8 =>'balance',
        ); 
        $orderby = "id";
        if(isset($request->order[0]["column"]))
        {

          $orderby = $columns[$request->order[0]["column"]];
        }
        //$orderby = isset($columns[$request->order[0]["column"]]) ? $columns[$request->order[0]["column"]] : "id";
  
  
        $dir = isset($request->order[0]["dir"]) ? $request->order[0]["dir"] : "DESC";
        $totalData = InAppTransactions::whereRaw($filter)->count();            
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
            
        if(empty($request->input('search.value')))
        {   
			$smses = InAppTransactions::leftJoin('users', function($join) {
			$join->on('in_app_transactions.user_id', '=', 'users.id');
			})
			->select('in_app_transactions.*','users.name','in_app_transactions.created_at')		
			->whereRaw($filter)
			->offset($start)   
			->limit($limit)
			->orderBy($orderby,$dir)
			->get();		
        }else {
            $term = $request->input('search.value'); 
 
            $smses =  InAppTransactions::leftJoin('users', function($join) {
                $join->on('in_app_transactions.user_id', '=', 'users.id');
                })
                ->select('in_app_transactions.*','users.name','in_app_transactions.created_at')
				->whereRaw($filter)
				->where(function ($query) use ($term) {
					if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray())){
						$query->orWhere('users.name','LIKE','%'.$term.'%');
					}
					$query->orWhere('in_app_transactions.id','LIKE','%'.$term.'%');
					$query->orWhere('transaction_details','LIKE','%'.$term.'%');
					if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray())){
						$query->orWhere('private_description','LIKE','%'.$term.'%');
					}
					$query->orWhere('movement','LIKE','%'.$term.'%');
					$query->orWhere('movement_type','LIKE','%'.$term.'%');
				})->offset($start)
				->limit($limit)
				->orderBy($orderby,$dir)
				->get();
 
            $totalFiltered = InAppTransactions::leftJoin('users', function($join) {
                $join->on('in_app_transactions.user_id', '=', 'users.id');
                })
                ->select('in_app_transactions.*','users.name') 		
				->whereRaw($filter)
				->where(function ($query) use ($term) {
					if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray())){
						$query->orWhere('users.name','LIKE','%'.$term.'%');
					}
					$query->orWhere('in_app_transactions.id','LIKE','%'.$term.'%');
					$query->orWhere('transaction_details','LIKE','%'.$term.'%');
					if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray())){
						$query->orWhere('private_description','LIKE','%'.$term.'%');
					}
					$query->orWhere('movement','LIKE','%'.$term.'%');
					$query->orWhere('movement_type','LIKE','%'.$term.'%');
				})->count();
        }
        $data = array();
        if(!empty($smses))
        {
            foreach ($smses as $key=>$sms)
            {
                $nestedData['id'] = $sms->id;
                $nestedData['clientid'] = $sms->user_id;
                $nestedData['client'] = in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()) ? $sms->name : "";
                $nestedData['private_description'] = in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()) ? $sms->private_description : "";
                $nestedData['description'] = $sms->transaction_details;
                $nestedData['date'] = \Carbon\Carbon::parse($sms->created_at)->format("d-m-Y");
                $nestedData['hours'] = \Carbon\Carbon::parse($sms->created_at)->format("H:i:s");
                $nestedData['value'] = $sms->debited_amount > 0 ?   number_format(($sms->debited_amount * -1) , 3,",","," ) :  number_format($sms->credited_amount,3,",",","); 
                $nestedData['balance'] = number_format($sms->balance,3,",",",");
				$data[]              = $nestedData;
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


    public function listbalanceMovementsUser(Request $request){
      $sms_controller = new SMSController();
      $filter = $sms_controller->getFilter($request->filter , $request->start_date, $request->end_date);
       if(is_null($request->sort)){
              $sort = 'desc';
          }
          else{
              $sort = $request->sort;
          }
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
      
      return view('accounts.listMovementsUsers',compact('filter','start_date','end_date'));
    }










    
	function listbalanceMovementsAjaxSimpleUser(Request $request){
		$sms_controller = new SMSController();
		$filter = $sms_controller->getFilter($request->filter , $request->start_date, $request->end_date);
		$filter = str_replace("date","in_app_transactions.created_at",$filter);
	
		$columns = array( 
      0 =>'id', 
      1 =>'users.id',
      2 =>'name',
      3 =>'private_description',
      4 =>'description',
      5 =>'created_at',
      6 =>'hours',
      7 =>'value',
      8 =>'balance',
        ); 
        $orderby = "id";
        if(isset($request->order[0]["column"]))
        {

          $orderby = $columns[$request->order[0]["column"]];
        }
        //$orderby = isset($columns[$request->order[0]["column"]]) ? $columns[$request->order[0]["column"]] : "id";
  
  
        $dir = isset($request->order[0]["dir"]) ? $request->order[0]["dir"] : "DESC";
        $totalData = InAppTransactions::whereRaw($filter)->count();            
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
            
        if(empty($request->input('search.value')))
        {   
			$smses = InAppTransactions::leftJoin('users', function($join) {
     $join->on('in_app_transactions.user_id', '=', 'users.id');
      
			})
      ->select('in_app_transactions.*','users.name','in_app_transactions.created_at')
      ->where('users.id','=',Auth::user()->id)		
			->whereRaw($filter)
			->offset($start)   
			->limit($limit)
			->orderBy($orderby,$dir)
			->get();		
        }else {
            $term = $request->input('search.value'); 
 
            $smses =  InAppTransactions::leftJoin('users', function($join) {
                $join->on('in_app_transactions.user_id', '=', 'users.id');
                })
                ->select('in_app_transactions.*','users.name','in_app_transactions.created_at')
                ->where('users.id','=',Auth::user()->id)		
				->whereRaw($filter)
				->where(function ($query) use ($term) {
					if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray())){
						$query->orWhere('users.name','LIKE','%'.$term.'%');
					}
					$query->orWhere('in_app_transactions.id','LIKE','%'.$term.'%');
					$query->orWhere('transaction_details','LIKE','%'.$term.'%');
					if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray())){
						$query->orWhere('private_description','LIKE','%'.$term.'%');
					}
					$query->orWhere('movement','LIKE','%'.$term.'%');
					$query->orWhere('movement_type','LIKE','%'.$term.'%');
				})->offset($start)
				->limit($limit)
				->orderBy($orderby,$dir)
				->get();
 
            $totalFiltered = InAppTransactions::leftJoin('users', function($join) {
                $join->on('in_app_transactions.user_id', '=', 'users.id');
                })
                ->select('in_app_transactions.*','users.name') 
                ->where('users.id','=',Auth::user()->id)				
				->whereRaw($filter)
				->where(function ($query) use ($term) {
					if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray())){
						$query->orWhere('users.name','LIKE','%'.$term.'%');
					}
					$query->orWhere('in_app_transactions.id','LIKE','%'.$term.'%');
					$query->orWhere('transaction_details','LIKE','%'.$term.'%');
					if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray())){
						$query->orWhere('private_description','LIKE','%'.$term.'%');
					}
					$query->orWhere('movement','LIKE','%'.$term.'%');
					$query->orWhere('movement_type','LIKE','%'.$term.'%');
				})->count();
        }
        $data = array();
        if(!empty($smses))
        {
            foreach ($smses as $key=>$sms)
            {
                $nestedData['id'] = $sms->id;
                $nestedData['clientid'] = $sms->user_id;
                $nestedData['client'] = in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()) ? $sms->name : "";
                $nestedData['private_description'] = in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()) ? $sms->private_description : "";
                $nestedData['description'] = $sms->transaction_details;
                $nestedData['date'] = \Carbon\Carbon::parse($sms->created_at)->format("d-m-Y");
                $nestedData['hours'] = \Carbon\Carbon::parse($sms->created_at)->format("H:i:s");
                $nestedData['value'] = $sms->debited_amount > 0 ?   number_format(($sms->debited_amount * -1) , 3,",","," ) :  number_format($sms->credited_amount,3,",",","); 
                $nestedData['balance'] = number_format($sms->balance,3,",",",");
				$data[]              = $nestedData;
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
        'request' => json_encode((array)$request),
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
      $request_array["ip"] = $request->ip;
      $request_array["session_id"] = "";
      $request_array["user_agent"] = $request->header('User-Agent');
      $request_array["script_name"] = "app/Http/Controllers/API/SMSController.php";
      $request_array["host"] = "";
      $request_array["function"] = $action;
      $request_array["args"] = $request->all();
      $request_array["0"] = "false";
      return $request_array;
      }

      public function add_digi_signature(Request $request){
        if(isset($request->action) && $request->action == "save"){
          $request->validate([
            'file' => 'required|mimes:jpeg,png,jpg,svg|max:2048',
          ]);

          $fileName = time().'.'.$request->file->extension();
          $request->file->move(public_path('img/digital_signature'), $fileName);
          
          $user = User::find(Auth::user()->id);
          $user->digital_signature =  $fileName;
          $user->update();
          session(['responseCode' => 200, 'message' => 'Digital signature successfully uploaded.']);
          // dd($fileName);
          return back();
        }
        $user = User::find(Auth::user()->id);
        return view('digitalsign', compact('user'));
      }

  public function delete_digi_signature($id){

    $user = User::find(Auth::user()->id);
    $user->digital_signature = '';
    $user->save();
    session(['responseCode' => 200, 'message' => 'Digital signature successfully deleted.']);
    return back();
  }
}
