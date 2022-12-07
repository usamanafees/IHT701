<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
class Billing_Alerts extends Model
{
    protected $table = 'billing_alerts';
    protected $fillable = [
        'id',
        'uid',
        'sms_message_before',
        'email_message_before',
        'email_subject_before',
        'send_me_email_before',
        'days_before',
        'sms_before',
        'email_before',
        'sms_message_after',
        'email_message_after',
        'email_subject_after',
        'send_me_email_after',
        'is_before',
        'days_after',
        'sms_after',
        'email_after',
        'created_at',
        'updated_at'
    ];

}
