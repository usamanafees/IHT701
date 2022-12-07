<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Items extends Model
{
	use SoftDeletes;
    protected $table = 'items';
    protected $fillable = ['code', 'unit', 'price','tax','rrp','description','user_id','type'];
}