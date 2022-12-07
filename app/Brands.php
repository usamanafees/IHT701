<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brands extends Model
{
    use SoftDeletes;
    protected $table = 'brands';
    protected $fillable = [
    			'name','url','logo','company_name','company_vat','Company_Address','series'
    		];

    public function  BrandsTemplate()
    {
    	return $this->hasMany('App\BrandsTemplate');
    }

    public function  Invoices()
    {
    	return $this->belongsTo('App\Invoices');
    }
}
