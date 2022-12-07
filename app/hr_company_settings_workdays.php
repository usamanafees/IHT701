<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hr_company_settings_workdays extends Model
{
    protected $table = 'hr_workdays_company_settings';
    use SoftDeletes;

    protected $fillable = ['id','manager_id','monday', 'tuesday','wednesday','thursday','friday','holidays_workdays','deleted_at','created_at','updated_at'];
}
