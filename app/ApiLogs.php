<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiLogs extends Model
{
    protected $table = 'apilogs';
    protected $fillable = ['sms_id', 'user_id', 'response','request','mobile_number','action','module_id','record_id'];
}
