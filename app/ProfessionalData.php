<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfessionalData extends Model
{
    use SoftDeletes;
    protected $table = 'professional_data';
    protected $fillable = ['employee_code','prof_phone','prof_email','cost_center','country','region','job_role','job_role_desc','manager','base_salary','expenses','food_allowance','value_per_hour','felexible_work_hours','observations'];
}
