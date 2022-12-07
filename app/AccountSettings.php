<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountSettings extends Model
{
    protected $table = 'account_settings';
    protected $fillable = [
					    	'duration',
							'amount',
							'balance',
							'expires_on',
							'total_documents',
							'used_documents',
							'total_users',
							'used_users',
							'free_sms_total',
							'free_sms_used',
							'bought_sms_total',
							'bought_sms_used',
							'user_id',
							'payment_code',
							'in_app_credit'
					    ];

    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
