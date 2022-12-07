<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandsTemplate extends Model
{
   use SoftDeletes;
   protected $table = 'brand_templates';
   protected $fillable = [
    			'brands_id','header','footer','body','name'
    		];

    public function  Brands()
    {
    	return $this->belongsTo('App\Brands');
    }

    public function  Invoices()
    {
    	return $this->belongsTo('App\Invoices');
    }


}
