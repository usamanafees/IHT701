<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hr_company_settings_vacations extends Model
{
    protected $table = 'hr_vacations_company_settings';
    use SoftDeletes;

    protected $fillable = ['id','manager_id','name', 'days_limit','period','bookings','food_subsidy','paid','deleted_at','created_at','updated_at'];
}
