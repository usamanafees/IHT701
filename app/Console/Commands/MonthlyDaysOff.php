<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\User;
use Mail;
use Config;
class MonthlyDaysOff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MonthlyDaysOff';

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
        $users =  User::all();
        foreach($users as $user)
        {
            if(isset($user->Hr_account_settings->days_off_month) && ($user->Hr_account_settings->days_off_month == 0))
            {

                    $this->send_email($user,'Submit the expected days off for this month',$user->Hr_account_settings->confirmation_key);
                
            }
        }   
    }
    public function send_email($clt,$sub,$key)
    {
        $data = array();
        $data['api_key'] = $key;
        Mail::send('Hr.email.monthly_days_off',$data, function($message) use($clt,$sub){
            $message->to($clt->email);
            $message->subject($sub);
            $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
        });
    }
}
