<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSRate extends Model
{
    protected $table = 'sms_rates';
    protected $fillable = ['*'];
    public function SMSProvider()
    {
        return $this->belongsTo('App\SMSProvider','sms_provider_id');
    }
    public function Country()
    {
        return $this->belongsTo('App\Countries','country_id');
    }
}
