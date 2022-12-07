<?php

namespace App\Console\Commands;

use App\Billing_Alerts;
use App\Clients;
use App\Invoices;
use App\User;
use http\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckAllDaysSmsEmailBefore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CheckAllDaysSmsEmailBefore';

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
        $data = Billing_Alerts::where('uid', Auth::user()->id);
        $days_before = $data->days_before;
        $send_email = $data->email_before;
       // $send_sms = $data->sms_before;
        $send_email_to_me = $data->send_me_email_before;
        $email_subject = $data->email_subject_before;
        $email_message = $data->email_message_before;
        //$sms_message = $data->sms_message_before;

        $invoices = Invoices::where('uid', Auth::user()->id);
        $invoice_date = $invoices->inv_date;
        $client = $invoices->cid;

        $clients = Clients::where('id', $client);
        $client_email = $clients->email;
        $client_phone = $clients->mobile;

        $users=User::where('id',Auth::user()->id);
        $users_email=$users->email;

        $today =
        $datetime1= new \DateTime($invoice_date);
        $datetime2 = new \DateTime();

        $total_days = $invoice_date - date('Y-m-d H:i:s');
        if ($total_days == $days_before) {
            if ($send_email == 1) {
                $data['user'] = $client_email;
                $data['message'] = $email_message;
                $data['subject'] = $email_subject;
                try {
                    Mail::send('admin.contact_client_email', ['data' => $data], function ($message) use ($data) {
                        $message->to($data['user']);
                        $message->subject($data['subject']);
                        dd(Config::get('mail.from.address'),Config::get('mail.from.name'));
                        $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
                    });
                } catch (Exception $e) {
                }
                if($send_email_to_me){
                    $data['users'] = $users_email;
                    $data['message'] = $email_message;
                    $data['subject'] = $email_subject;
                    try {
                        Mail::send('admin.contact_client_email', ['data' => $data], function ($message) use ($data) {
                            $message->to($data['users']);
                            $message->subject($data['subject']);
                            dd(Config::get('mail.from.address'),Config::get('mail.from.name'));
                            $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
                        });
                    } catch (Exception $e) {
                    }
                }
            }
        }
    }
}
