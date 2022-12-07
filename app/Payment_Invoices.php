<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_Invoices extends Model
{
    protected $table = 'payment_invoices';
    protected $fillable = [
        'id',
        'value_paid',
        'payment_date',
        'payment_method',
        'fault_value',
        'observations',
        'invoices_id',
        'created_at',
        'updated_at'
    ];
}
