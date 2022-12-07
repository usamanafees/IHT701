<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\User;
use App\SMS;
use \Carbon\Carbon;
use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\SMSController;
use Log;
class ChargeOndeliveryStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ChargeOn:DeliveryStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Charge user after checking the delivery status of the message';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $smses = SMS::whereDate('created_at', '>', Carbon::today()->subDays(2))->get();
        $smses = $smses->where('paid_check','!=','sent');

    if(isset($smses) && !empty($smses))
    {
        foreach($smses as $s)
        { 
            $ez4u = new SMSController;
           try{
            $data = $ez4u->ez4u_estado_sms($s->provider_sms_id);
            $response = json_decode($data, true);
            if(isset($response['MessageInfo']['DeliveryStatus']))
            {
                        $delivery_status= $response['MessageInfo']['DeliveryStatus'];
                        if($delivery_status == 1)
                        {
                            SMS::where('id',$s->id)->update(['paid_check' =>"sent"]);
                        }
                        // elseif($delivery_status == 3)
                        // {
                        //     SMS::where('id',$s->id)->update(['paid_check' =>"error"]);
                        // }
                        else
                        {
                            SMS::where('id',$s->id)->update(['paid_check' =>"pending"]);
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
  }
}