<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hr_company_settings_holidays extends Model
{
    protected $table = 'hr_holidays_company_settings';
    use SoftDeletes;

    protected $fillable = ['id','manager_id','name', 'date','recurrence','country','region','deleted_at','created_at','updated_at'];
}
