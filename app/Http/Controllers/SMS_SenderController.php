<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\SMS_Sender;
use Auth;
use App\User;
use App\Http\Controllers\AccountSettingsController;
use App\ApiLogs;
use App\Modules;
use Illuminate\Support\Facades\Validator;
class SMS_SenderController extends Controller
{
   public function index()
    { $sms_sender;
        if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
        {
            $sms_sender = SMS_Sender::all();
        }else
        {
            $sms_sender = SMS_Sender::where('user_id',Auth::user()->id)->get();
        }
        return view('sms.sender.list',compact('sms_sender'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        $user = User::with('AccountSettings')->find(Auth::user()->id);
        return view('sms.sender.create',compact('user'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $module = Modules::where('name','SMS')->first();
        $user = User::where('id',Auth::user()->id)->first();
        $request->request->add(['ipp' => $this->getIp()]);
        $request_array = $this->prepareRequestArray($request);
        $check = 0 ;
        $transaction_msg = "";
            // $this->validate($request, [
            //     'sender' => 'required|max:11|min:1|unique:sms_sender|regex:/^[^a-z\s-]+$/',
            // ]);
            $validator = Validator::make($request->all(), [
            	'sender' => 'required|max:11|min:1|unique:sms_sender|regex:/^[^a-z\s-]+$/',
            ]);
            if($validator->fails())
            {
                $this->createApiLog($user->id,"Create Sender",$module->id,NULL, $request_array,json_encode(['message'=>'error','result'=>array($validator->errors())]),$user->phone_no,\Request::url());
                return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
            }
            $offerSender =  $request->offerSender;
            $user_rate = Auth::user()->sender_rate;   
        if($user_rate > 0)
        { 
            if($offerSender != "true")
            {
                $account_settings = new AccountSettingsController();
                $transaction_msg = $account_settings->in_app_transaction($user_rate,Auth::user()->id,"SMS Sender Creation",true,0);
            }
            else
            {
                $account_settings = new AccountSettingsController();
                $transaction_msg = $account_settings->in_app_transaction(0,Auth::user()->id,"SMS Sender Creation",true,0);
            }
        }
        else
        {  
            $check = 1;
        }
            if($transaction_msg == "Transaction Excuted Successfully" || $check==1)
            {
                $sms_sender = new SMS_Sender();
                $sms_sender->sender = $request->sender;
                $sms_sender->state = 'pending';
                $sms_sender->expiration_date = 'Unlimited';
                $sms_sender->user_id = Auth::user()->id;
                $sms_sender->save();
                $this->createApiLog($user->id,"Create Sender",$module->id,$sms_sender->id, $request_array,json_encode(['message'=>'success','result'=>array($sms_sender)]),$user->phone_no,\Request::url());
                return redirect()->route('sender');
            }
            else
            {
                $this->createApiLog($user->id,"Create Sender",$module->id,$sms_sender->id, $request_array,json_encode(['message'=>'error','result'=>"Not Enough Credit, Please Recharge Your Account!"]),$user->phone_no,\Request::url());
                return redirect()->back()->with(['error' => "Not Enough Credit, Please Recharge Your Account!"]);
            }       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function update_sender(Request $request)
     {
        $send = array();
        $send['sender'] = $request->sender;
        $sms_sender = SMS_Sender::find($request->id);
        if($sms_sender->sender != $request->sender)
        {
                    $v = Validator::make($send,
                    [
                        'sender' => 'required|max:11|min:1|unique:sms_sender|regex:/^[^a-z\s-]+$/',
                    ]);
                    if($v->fails()) {
                        return response()->json(['result'=>'error','data'=>$sms_sender]);
                    }
        }
        $sms_sender->sender = $request->sender;
        if($request->date != null)
        { 
            $sms_sender->expiration_date = $request->date;
        }
        else
        {
            $sms_sender->expiration_date = 'Unlimited';
        }
        $sms_sender->update();
        return response()->json(['result'=>"success",'data'=>$sms_sender]);
     }
    public function edit($id)
    {
        $sms_sender = SMS_Sender::find($id);
        return view('sms.sender.edit',compact('sms_sender'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sms_sender = SMS_Sender::find($id);

        if($sms_sender->sender != $request->sender){
        	$this->validate($request, [
            'sender' => 'required|max:11|min:11|unique:sms_sender',
          ]);
        }

        $sms_sender->sender = $request->sender;
        $sms_sender->state = 'pending';
        $sms_sender->expiration_date = 'Unlimited';
        $sms_sender->user_id = Auth::user()->id;
        $sms_sender->update();

        return redirect()->route('sms_senders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SMS_Sender::find($id)->delete();
        return redirect()->route('sms_senders');
    }

    // public function sender_list_ajax(){
    //     $sms_senders = SMS_Sender::all()->toArray();
    //     return json_encode($sms_senders);
    // }
	
	public function approve ($id)
	{
		$sender = SMS_Sender::find($id);
		$sender->update(['state' => 'approved']);
		return redirect()->back()->with('success' , "Sender Approved Successfully");	
	}
	public function disapprove ($id)
	{
		SMS_Sender::find($id)->update(['state' => 'disapproved']);
		return redirect()->back()->with('success' , "Sender Disapproved Successfully");
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
    public function prepareRequestArray($request){
		$request_array = array();
		$request_array["ip"] = $request->ipp;
		$request_array["session_id"] = "";
		$request_array["user_agent"] = $request->header('User-Agent');
		$request_array["script_name"] = "app/Http/Controllers/API/SMS_senderController.php";
		$request_array["host"] = "";
		$request_array["function"] = "store --sender";
		$request_array["args"] = $request->all();
		$request_array["0"] = "false";
		return $request_array;
	}



    
}

