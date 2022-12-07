<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    protected $table = 'sms_person';
    protected $fillable = ['moile_code', 'mobile_num', 'massege','user_id','provider','channel','state','date','cost_charged','cost_commission','paid_check'];

    public function User()
    {
        return $this->belongsTo('App\User');
    }
	public function SMSProvider()
    {
        return $this->belongsTo('App\SMSProvider','provider');
    }
	public function SMSSender()
    {
        return $this->belongsTo('App\SMS_Sender','sender');
    } 
}
