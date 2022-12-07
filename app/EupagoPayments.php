<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EupagoPayments extends Model
{
    use SoftDeletes;
    protected $table = 'eupago_payments';
	protected $fillable = ['id', 'eupago_id', 'phone','amount','tax','approved','user_id','created_at', 'updated_at','reference'];
}
