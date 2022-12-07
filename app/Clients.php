<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clients extends Model
{
    use SoftDeletes;
	protected $table = 'clients';
    protected $fillable = ['id',
    			'name', 'vat_number', 'country','main_url'
		        ,'email','code','postal_code','address','city','telephone','mobile'
		        ,'primary_name','primary_email','primary_mobile','primary_telephone','user_id','economic_area'];
    public $rules = [
            'name' => 'required',
    ];

    // public  $dynamci_final=[ "name","vat_number","country","main_url","email","code","postal_code","address",
    //               "city","telephone_code","telephone_number","mobile_code","mobile_number","primary_name",
    //               "primary_email","p_m_c","p_m_n","p_t_c","p_t_n"]; 
    
    public  $dynamci_final=[ 
         'id','name', 'vat_number','vat','email', 'address','city','postal_code','country','not_map'
                            ,'qty','description','unit_price','created_at','uid'];
    public  $dynamci_final_eupago=[
        'id','name', 'vat_number','vat','email', 'address','city','postal_code','country','economic_area'
        ,'type_doc','description','unit_price','inv_date'
    ];

        
        //"art_id","name","vat_number","tax_value","email","address","city","postal_code","country","economic_area","payment_at_the_moment","file_name","commision","created_at"]; 
    public function Countries(){
    	return $this->hasOne('App\Countries', 'iso_code', 'country');
    }
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function dynamci_final_eupago()
    {
        return $this->dynamci_final_eupago;
    }
    public function dynamci_final()
    {
        return $this->dynamci_final;
    }
}
