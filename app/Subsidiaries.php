<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subsidiaries extends Model
{
 	protected $table = 'subsidiaries';
    protected $fillable = ['taxpayer', 'city', 'postal_code','address','user_id','vat_number'];

    public function User()
    {
        return $this->belongsTo('App\User');
    }
}





