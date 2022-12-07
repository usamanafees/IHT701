<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Billing_Alerts;
use App\BillingAlllertC;
use App\Invoices;
use App\User;
use App\Clients;
use DB;
use Mail;
use Config;
use GuzzleHttp\Client;
use \Carbon\Carbon;
class BillingAlerts extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'BillingAlerts';
    /**
     * The console command description.
     * @var string
     */
    protected $description = 'This is billing alerts scheduling';
    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $all_schedules = BillingAlllertC::all();
        if(isset($all_schedules) && !empty($all_schedules))
        {
            foreach($all_schedules as $all_sch)
            {
                $invoices = Invoices::where('uid',$all_sch->uid)
                ->where('due','!=','Immediately')
                ->whereNotNull('due')
                ->get();
                if(isset($invoices) && !empty($invoices))
                {
                    foreach($invoices as $inv)
                    {
                       $last_date = date('Y-m-d', strtotime($inv->created_at. ' + '.$inv->due.' days'));
                       $current_date = date('Y-m-d', strtotime(Carbon::now()));

                       if($all_sch->is_before == 1)
                       {
                            $scheduled_date =  date('Y-m-d', strtotime( $last_date . ' - '.$all_sch->days_before.' days'));
                           //dd( $inv->created_at,$last_date,$scheduled_date ,$all_sch->days_before);
                            if($scheduled_date == $current_date)
                            {
                               
                                if($all_sch->email_before == 1)
                                {
                                    $user = User::find($inv->uid);
                                    $client = Clients::where('id',$inv->uid)->first();
                                    $this->send_email($client,$all_sch->email_subject_before,$all_sch->email_message_before);
                                }
                                if($all_sch->sms_before == 1)
                                {   
                                    
                                   $user = User::find($inv->uid);
                                   $client = Clients::where('id',$inv->uid)->first();
                                   $this->send_sms($user,$client,$all_sch->sms_message_before);
                                }
                                continue;
                            }else
                            {
                                continue;
                            }
                       }if($all_sch->is_before == 0 ||  $all_sch->is_before = NULL)
                       {  
                            $scheduled_date =  date('Y-m-d', strtotime( $last_date . ' + '.$all_sch->days_after.' days'));
                            
                            if($scheduled_date == $current_date)
                            {
                                if($all_sch->email_after == 1)
                                {
                                    $user = User::find($inv->uid);
                                    $client = Clients::where('id',$inv->uid)->first();
                                    $this->send_email($client,$all_sch->email_subject_after,$all_sch->email_message_after);
                                }
                                if($all_sch->sms_after == 1)
                                {
                                    $user = User::find($inv->uid);
                                    $client = Clients::where('id',$inv->uid)->first();
                                    $this->send_sms($user,$client,$all_sch->sms_message_after);
                                }
                            }else
                            {
                                continue;
                            }
                       }
                   }
                } 
            }
       }
   }

    public function send_email($clt,$sub,$msg)
    {
        $data = array();
        $data['txt'] = $msg;
        Mail::send('taxauthority.functionalities.billing_alerts_email',$data, function($message) use($clt,$sub,$msg){
            $message->to($clt->email);
            $message->subject($sub);
            $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
        });
    }
    public function send_sms($usr,$clt,$msg)
    {
        $msg = str_replace('%name%', $clt->name, $msg);
        $string = implode(",",json_decode($clt->mobile));
        $mobile_num = str_replace(',', '', $string);
        $client = new \GuzzleHttp\Client();
        $response =  $client->post(
            url('/').'/api/addSMS',
                    array(
                        'form_params' => array(
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjI4ZDlkMzA0OWE5NmRhZTJhZWU2ZGQ5YjM3NjRjOGFiZWEyZmZjMTI2OGZkMjExZGJmZWM5ODE1ODAxZTg3ZmI5ZDQwNzRkYzkzODIyMmQ4In0.eyJhdWQiOiIxMSIsImp0aSI6IjI4ZDlkMzA0OWE5NmRhZTJhZWU2ZGQ5YjM3NjRjOGFiZWEyZmZjMTI2OGZkMjExZGJmZWM5ODE1ODAxZTg3ZmI5ZDQwNzRkYzkzODIyMmQ4IiwiaWF0IjoxNTk1MjMxMTkwLCJuYmYiOjE1OTUyMzExOTAsImV4cCI6MTYyNjc2NzE5MCwic3ViIjoiMSIsInNjb3BlcyI6W119.zQim3aUEAzZERM75udlpVD8FLdD8rOw4-rP4jPOtxa5fI9PonOgjZQ9lrXL9KGMN076rl_cQqJyWar824geN-iw-yC1W-cRom0OvXoVrmKhAelqp3UPijNvEZ_0OSH2rtNa9w3gGiYsm5yUyUYaOFM2TMPSgKeshQ88s3I_PFFxFmuY5XGmr2pjMvK5h2CDRPYsupFrJYDKO1UiTBmCBPVDPYcg3c9wI-4DVrYYl2q7E14PHSfp1qIsEIR2_pcjU8VJu1FY89KryIc9M8LDtZxcy1bRuc8l7sPOtZCUkpOhZPDRVcZ6ClYmRLuYg0Vj9damgDZ-etE-yk6s3R0_U79Tm7zcYxz1fSQv-5NBCb4PJKBJn2coBYsD0CrQXvGGp-xwP6rUU5KjOf-tfo0zPI6x4TdRRV95UDAUDtMv3G_LC_JpIKTPgQqp7TUm3uztuNCYhUF1OWhnCSk2SS7T0C5eagvv8A17lZGu7VgT5GGIzNjbgqqvL18LtFrJAcV9uLhnmToxNlyuHwxFgv1UPSnYy6ViRRt9pEBXe2WUef0_96Ni1Pe22jv56MRmvh8O779bHUn2sUA7dwYbHW-YbzVOZ2DOCOABouFjpabRoE1giEniLoAHbaom6fqjBiArGyxxEQIj8yWRvNyfx8ONMvxbzE-1wo8ZFM352qvydH4M',
                            'accountid' => $usr->id,
                            'apikey' =>  $usr->api_key,
                            'message' => $msg,
                            'sender' => '2',
                            'mobile_num' => $mobile_num,
                        )
                    )
            );
    }
}
