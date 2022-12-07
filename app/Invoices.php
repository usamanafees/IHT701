<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
    use SoftDeletes;
    protected $table = 'invoices';
    protected $fillable = [
		'uid',
		'inv_date',
		'remarks',
		'due',
		'po',
		'sequence',
		'retention', 
		'inv_retention', 
		'inv_subtotal',
		'inv_vat',
		'inv_discount',
		'currency',
		'tax_exemption_reason',
		'cid',
		'brand_templates_id',
		'brands_id',
		'total_invoice_value',
        'fault_value',
        'serie',
        'is_receipt',
        'hash',
        'code_hash',
        'hash_control',
        'self_billing_indicator',
        'cash_vat_scheme_indicator',
        'system_entry_date',
        'atcud',
        'sourceid',
        'source_billing',
        'serial_number',
        'third_parties_billing_indicator',
        'created_at',
        'status'
	];
	
	public function  BrandsTemplate()
    {
    	return $this->belongsTo('App\BrandsTemplate','brand_templates_id');
    }
    public function  Brands()
    {
    	return $this->belongsTo('App\Brands','brands_id');
    }
    public function Clients()
    {
        return $this->belongsTo('App\Clients', 'cid');
    }
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }


    public function LineItems(){
    	return $this->hasMany('App\LineItems','invid','id');
    }

    public function User()
    {
        return $this->belongsTo('App\User', 'uid');
    }
}
