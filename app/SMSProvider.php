<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSProvider extends Model
{
    protected $table = 'sms_provider';
 	protected $fillable = ['*'];
	
	public function SMS()
    {
        return $this->hasMany('App\SMS');
    }

    public function SMSRate()
    {
        return $this->hasMany('App\SMSRate');
    }

}