<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hr_company_settings_extradays extends Model
{
    protected $table = 'hr_extradays_company_settings';
    use SoftDeletes;

    protected $fillable = ['id','name','manager_id', 'date','recurrence','country','region','deleted_at','created_at','updated_at'];
}
