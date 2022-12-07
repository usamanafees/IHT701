<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Countries;
use App\SMS;
use App\SMS_Sender;
use App\SMS_Templates;
use Auth;
use App\SMSProvider;
use App\User;
use App\ApiLogs;
use App\Modules;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Support\Facades\Input;
use DateTime;
class SMSController extends Controller {
	
	
	public function wp_notify_sms(Request $request)
	{
	   $user= User::where('api_key',$request->api_key)->first();
	   if(isset($user) && !empty($user))
	   {
		   return response()->json(["user"=>$user,"result"=>"success"]);
	   }else
	   {
		return response()->json(["result"=>"error"]);
	   }
	}
    public function addSMS(Request $request) {
        $module = Modules::where('name','SMS')->first();
		$api_request = $request->all();
		$users = User::where('id', $request->accountid)->first();
		$request->request->add(['ipp' => $this->getIp()]);
		$request_array = $this->prepareRequestArray($request);
        // Base rules which includes Messaage and sender validation
		$v = \Validator::make($request->all(), $this->addSMSBaseRules($request));
		if ($v->fails())
		{
			$number = isset($request->mobile_num) ?$request->mobile_num : $request->mobile_num_blk;
			$this->createApiErrorLog($users->id ,$module->id,NULL, $request , $v->errors(),$request_array, $number );
			return json_encode(["message" => "error" , "result" =>$v->errors()]);
		} 
		
        // Bulk Add
        if (isset($request->blk_Add) && !empty($request->blk_Add) && $request->blk_Add == '1') {
            if (isset($request->mobile_num_blk) && !empty($request->mobile_num_blk)) {
                $mobile_numbers = explode(',', $request->mobile_num_blk);
                if (empty($mobile_numbers)) {
					$this->createApiErrorLog($users->id ,$module->id,NULL, $request , ['message' => 'error', 'result' => array('mobile_num_blk not found') ],$request_array ,"");
                    return response()->json(['message' => 'error', 'result' => array('mobile_num_blk not found') ], 200);
                }
                foreach ($mobile_numbers as $number) {
                    $request_number = new Request(array('mobile' => $number));
					$v = \Validator::make(array('mobile' => $number), $this->addSMSNumberRule());
					if ($v->fails())
					{
						$number = preg_match('/\D/', $number) == 0 ? $number : "";
						$this->createApiErrorLog($users->id ,$module->id,NULL, $request , $v->errors(),$request_array ,$number);
						return json_encode(["message" => "error" , "result" =>$v->errors()]);
					}
					
                }
            } else {
				$this->createApiErrorLog($users->id ,$module->id,NULL, $request , ['message' => 'error', 'result' => array('mobile_num_blk not valid it should be comma seperated 9 digit number') ,  ],$request_array , $request->mobile_num_blk);
                return response()->json(['message' => 'error', 'result' => array('mobile_num_blk not valid it should be comma seperated 9 digit number') ], 200);
            }
        } else {
            if (isset($request->mobile_num) && !empty($request->mobile_num)) {
                $request->mobile_num = str_replace(' ', '',$request->mobile_num);
                $v = \Validator::make(array('mobile' => $request->mobile_num), $this->addSMSNumberRule());
				if ($v->fails())
				{
					$number = preg_match('/\D/', $request->mobile_num) == 0 ? $request->mobile_num : "";
					$this->createApiErrorLog($users->id ,$module->id,NULL, $request , $v->errors(),$request_array,$number);
					return json_encode(["message" => "error" , "result" =>$v->errors()]);
				}
				
				
            } else {
				$this->createApiErrorLog($users->id ,$module->id,NULL, $request , ['message' => 'error', 'result' => array('mobile_num not found') ],$request_array,"");
                return response()->json(['message' => 'error', 'result' => array('mobile_num not found') ], 200);
            }
        }
        //Save SMS as Template
        if (isset($request->template_Add) && !empty($request->template_Add) && $request->template_Add == '1') {
			$number = isset($request->mobile_num) ? $request->mobile_num : $request->mobile_num_blk;
            if (isset($request->template_name) && !empty($request->template_name)) {
               $v = \Validator::make(array('template_name' => $request->template_name), $this->addSMSTemplateRule());
				if ($v->fails())
				{
					$this->createApiErrorLog($users->id ,$module->id,NULL, $request , $v->errors(),$request_array,$number);
					return json_encode(["message" => "error" , "result" => $v->errors()]);
				}
            } else {
				$this->createApiErrorLog($users->id ,$module->id,NULL, $request , ['message' => 'error', 'result' => array('template_name not found') ],$request_array,$number);
                return response()->json(['message' => 'error', 'result' => array('template_name not found') ], 200);
            }
        }
        if (isset($request->sms_schedule) && !empty($request->sms_schedule)) {
			$number = isset($request->mobile_num) ? $request->mobile_num : $request->mobile_num_blk;
            $v = \Validator::make($request->all(), $this->addSMSSheduleRule());
			if ($v->fails())
			{
				$this->createApiErrorLog($users->id ,$module->id,NULL, $request , $v->errors(),$request_array,$number);
				return json_encode(["message" => "error" , "result" => $v->errors()]);
			}
        }
        //validating Date
        if (isset($request->sms_schedule)) {
			$number = isset($request->mobile_num) ? $request->mobile_num : $request->mobile_num_blk;
            $date = explode(" ", $request->sms_schedule);
            $dat = explode('/', $date[0]);
           
            if (!checkdate($dat[1], $dat[0], $dat[2])) {
				$this->createApiErrorLog($users->id ,$module->id,NULL, $request , ['message' => 'error', 'result' => array('Invalid formate, Please Enter Correct Date Format (dd/mm/yyyy H:M)') ],$request_array,$number );
                return response()->json(['message' => 'error', 'result' => array('Invalid formate, Please Enter Correct Date Format (dd/mm/yyyy H:M)') ], 200);
            }
            if (isset($date[1])) {
                $time = explode(":", $date[1]);
                $request->request->add(['start_date' => $date[0]]);
				if(isset($time[0]) && isset($time[1]) && !empty($time[0]) && !empty($time[1])){
					$request->request->add(['hh' => $time[0]]);
					$request->request->add(['mm' => $time[1]]);
				}
            } else {
				$this->createApiErrorLog($users->id ,$module->id,NULL, $request , ['message' => 'error', 'result' => array('Invalid formate, Please Enter Time (dd/mm/yyyy H:M)') ],$request_array,$number);
                return response()->json(['message' => 'error', 'result' => array('Invalid formate, Please Enter Time (dd/mm/yyyy H:M)') ], 200);
            }
        }
        //Validaing Time
        if (!isset($request->hh) || !isset($request->mm)) {
            $request->request->add(['hh' => "00"]);
            $request->request->add(['mm' => "00"]);
        }
        $request->request->add(['sms_api' => "true"]);
        return app('App\Http\Controllers\SMSController')->store($request, $users , $api_request);
    }
    public function getSenders(Request $request){
        $senders = SMS_Sender::all();
        $codes = '';
        foreach($senders as $sender){
            if($sender->id == $request->sender){
            $codes .= $sender->id.', ';
            }
            if($sender->sender == $request->sender){
                $codes .= $sender->sender.', ';
            }
        }
        return $codes;
    }
    public function addSMSBaseRules(Request $request){
        return array(
            'message' => 'required',
            'sender' => 'required|in:'.$this->getSenders($request),
        );
    }
    public function addSMSNumberRule(){
        return array(
            'mobile' => 'required|numeric|digits_between:9,9',
        );
    }
    public function addSMSTemplateRule(){
        return array(
            'template_name' => 'required',
        );
    }
    public function addSMSSheduleRule(){
        return array(
            'accountid' => 'required|numeric',
             'start_date' => 'date_format:d/m/Y',
            // 'hh' => 'required|numeric|in:00,01,02,03,04,06,05,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23',
            // 'mm' => 'required|numeric|in:00,01,02,03,04,06,05,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59',
        );  
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
	public function createApiErrorLog($user_id ,$module_id,$record_id, $request , $error , $request_array,$mobile_number){
		ApiLogs::create([
			'user_id' => $user_id,
			'request' => json_encode($request_array),
			'response' => json_encode(["message" => "error" , "result" =>$error]),
            'mobile_number' => $mobile_number,
            'action' => "SUBMIT SMS",
             'module_id'=>$module_id,
             'record_id'=>$record_id
		]);
		return true;
	}
	public function prepareRequestArray($request){
		$request_array = array();
		$request_array["ip"] = $request->ipp;
		$request_array["session_id"] = "";
		$request_array["user_agent"] = $request->header('User-Agent');
		$request_array["script_name"] = "app/Http/Controllers/API/SMSController.php";
		$request_array["host"] = "";
		$request_array["function"] = "addSMS";
		$request_array["args"] = $request->all();
		$request_array["0"] = "false";
		return $request_array;
	}

}

