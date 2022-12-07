<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMS_Templates extends Model
{
    protected $table = 'sms_templates';
    protected $fillable = ['name', 'template','user_id'];
}