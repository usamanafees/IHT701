<?php
namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use App\SMS;
use App\Http\Controllers\SMSController;
use Log;
class DeliveryStatusAfterOneMinute implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $sms_id;
    public function __construct($sms_id)
    {
        $this->sms_id = $sms_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sleep(12);
        $ez4u = new SMSController;
        try{
         $data = $ez4u->ez4u_estado_sms($this->sms_id);
         $response = json_decode($data, true);
         if(isset($response['MessageInfo']['DeliveryStatus']))
         {
            $delivery_status= $response['MessageInfo']['DeliveryStatus'];
            if($delivery_status == 1)
            {
                SMS::where('provider_sms_id',$this->sms_id)->update(['paid_check' =>"sent"]);
            }
            else
            {
                SMS::where('provider_sms_id',$this->sms_id)->update(['paid_check' =>"pending"]);
            }
         }
        else
        {
            Log::error($response);
        }
         }
         catch(Exception $e)
         {
             Log::error($e);
         }
    }
}
