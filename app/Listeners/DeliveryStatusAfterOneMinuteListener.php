<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\SMS;
use App\Http\Controllers\SMSController;
use Log;
class DeliveryStatusAfterOneMinuteListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //sleep(30);
        $ez4u = new SMSController;
        try{
         $data = $ez4u->ez4u_estado_sms($event->sms_id);
         $response = json_decode($data, true);
         if(isset($response['MessageInfo']['DeliveryStatus']))
         {
                     $delivery_status= $response['MessageInfo']['DeliveryStatus'];
                     if($delivery_status == 1)
                     {
                         SMS::where('provider_sms_id',$event->sms_id)->update(['paid_check' =>"sent"]);
                     }
                     else
                     {
                         SMS::where('provider_sms_id',$event->sms_id)->update(['paid_check' =>"pending"]);
                     }
         }
             else
             {
                 \Log::error($response);
             }
         }
         catch(Exception $e)
         {
             \Log::error($e);
         }
    }
}
