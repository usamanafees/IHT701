<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\DayssoffRequest;
use App\User;
use Mail;
use Config;
class DaysOffAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DaysOffAlertsForManager';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
       $requests = DayssoffRequest::all();
       $date = date("Y-m-d", strtotime("-14 days", strtotime(\Carbon\Carbon::now())));
       foreach($requests as $req)
       {
            if($req->period == 'days')
            {
                if($req->start_date == $date)
                {
                    $this->email_parameters($req);
                }
            }
            if($req->period == '1/2day')
            {
                if($req->date == $date)
                {
                    $this->email_parameters($req);
                }
            }
       }   
    }

    public function email_parameters($req)
    {
        $user = User::find($req->assigned_to);
        if(isset($user) && !empty($user))
        {
            $employee= User::find($req->employee_id);
            if(isset($employee) && !empty($employee))
            {
                $this->send_email($user,$employee,$req);
            }
        }
    }

    public function send_email($clt,$emp,$req)
    {
        $data = array();
        $data['req'] = $req;
        $data['emp'] = $emp;
        Mail::send('Hr.email.request_alert_email',$data, function($message) use($clt,$emp){
        $message->to($clt->email);
        $message->subject('Days Off Alert');
        $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
        });
    }
}