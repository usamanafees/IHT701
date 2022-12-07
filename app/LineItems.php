<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LineItems extends Model
{
	use SoftDeletes;
    protected $table = 'invl_items';
    protected $fillable = ['item_id','invid', 'code', 'type', 'description','unit_price','qty','vat','discount', 'total'];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function Invoices(){
    	return $this->belongsTo('App\Invoices', 'invid');
    }
}
