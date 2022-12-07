<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    protected $table = 'detail_users';

    protected $fillable = ['civil_state', 'birth_date','emergency_name'
    ,'emergency_phone','emergency_kinship','citizen_card','fiscal_id','social_security','driving_licence','car_plate'
    ,'other_docs','academic_degree','school','course','number_dependents','deficiencies','income_ownership','bank_name','iban','swift','facebook','twitter','linkedin','updated_at','created_at','deleted_at'];
}
