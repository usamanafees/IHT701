<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hr_company_settings_general extends Model
{
    protected $table = 'hr_general_company_settings';
    use SoftDeletes;

    protected $fillable = ['id','manager_id','show_filters', 'menu_personal_information','menu_expenses','menu_documents','price_km','deleted_at','created_at','updated_at'];
}
