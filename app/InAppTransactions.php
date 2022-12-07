<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InAppTransactions extends Model
{
    protected $table = 'in_app_transactions';
    protected $fillable = [
		'user_id',
		'transaction_details',
		'debited_amount',
		'credited_amount',
		'private_description',
		'movement',
		'movement_type',
		'balance',
		'commission',
	];
	
	public function User()
    {
        return $this->belongsTo('App\User');
    }
}
