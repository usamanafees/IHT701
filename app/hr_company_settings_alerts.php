<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hr_company_settings_alerts extends Model
{
    use SoftDeletes;
    protected $table = 'hr_alerts_company_settings';

    protected $fillable = ['id','manager_id', 'type','remember_time','status','deleted_at','created_at','updated_at'];
}
