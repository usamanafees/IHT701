<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMS_Sender extends Model
{
    protected $table = 'sms_sender';
    protected $fillable = ['sender', 'state', 'expiration_date','user_id'];

	public function SMS()
    {
        return $this->hasMany('App\SMS');
    }
	public function User()
    {
        return $this->belongsTo('App\User');
    }
}






