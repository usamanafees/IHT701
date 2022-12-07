<?php

namespace App\Console\Commands;
use App\Http\Controllers\CommonController;
use Illuminate\Console\Command;
use \Carbon\Carbon;
use Log;
use Illuminate\Http\Request;
use Mail;
use App\User;
use Config;
class SaftSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SaftSchedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will send email of saft file every month';

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
        $common = new CommonController;
        $now = Carbon::now();
        $users = User::where('saft_schedule',1)->get();
        
        foreach($users as $user)
        {
            $values = new Request(
                array(
                    "options" =>"month",
                    "dropdownMonth" =>"".$now->month."",
                    "dropdownYear" =>"".$now->year."",
                    "comminfrom" =>"command",
                    "uid" =>$user->id
                )
            );
            
            $result = $common->saftdownload($values);
            if($result == "generated")
            {
                $ebody = "Generated SAFT ";
                Mail::raw('',function ($message) use($ebody,$user) {
                $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
                $message->to($user->email);
                $message->subject('Saft for this month');
                $message->setBody($ebody, 'text/html');
                $message->attach(public_path().'/files/SAFT-PT.xml');
                });
            }
        }

     
        
    }
}