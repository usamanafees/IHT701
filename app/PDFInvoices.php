<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PDFInvoices extends Model
{
    protected $table = 'pdf_invoices';
    protected $fillable = ['pdf_data','user_id','invoices_id'];

    public function Invoices()
    {
        return $this->belongsTo('App\Invoices');
    }
}

