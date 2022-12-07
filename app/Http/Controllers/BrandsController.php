<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brands;
use App\BrandsTemplate;
use Illuminate\Support\Str;
use DB;
use View;
use App\Clients;
use App\Invoice;
use Log;
use Auth;
use App\Invoices;
use App\LineItems;


class BrandsController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'clearance']);
    }

    public function index()
    {
        if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
        {
            $brand = Brands::with('BrandsTemplate')->get();
        }else{
            $brand = Brands::where('user_id',Auth::user()->id)->with('BrandsTemplate')->get(); 
        }
        
        return view('brands.index',compact('brand'));
    }

    public function default_brand_template(Request $request)
    {
       $check = 1;
       try{
            DB::table('users')->where('id',$request->u_id)->update([
                'default_template'=> $request->t_id]
                );
        }catch(\Illuminate\Database\QueryException $ex)
        {
            $check = 0;
        }
        if($check== 1)
        {
            return response()->json(['success'=>'true','id'=>$request->t_id]);
        } else{
            return response()->json(['success'=>'false','id'=>$request->t_id]);
        }
    }
    public function default_brand(Request $request)
    {
        $check=1; 
        try{
            DB::table('users')->where('id',$request->u_id)->update([
                        'default_brand'=> $request->b_id]
                        );
        }catch(\Illuminate\Database\QueryException $ex)
        {
            $check = 0;
        }
        if($check == 1)
        {
            return response()->json(['success'=>'true','id'=>$request->b_id]);
        } 
        else{
            return response()->json(['success'=>'false','id'=>$request->b_id]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoice = array(
            'inv_date;Invoice Date',
            'inv_date;Invoice Date',
            'code_hash;Code Hash',
            'remarks;Remarks',
            'due;Due',
            'po;P.O',
            'sequence;Sequence',
            'retention;Retention',
            'inv_retention;Invoice Retention',
            'inv_subtotal;Invoice Subtotal',
            'inv_vat;Invoice Vat',
            'inv_discount;Invoice Discount',
            'currency;Currency',
            'tax_exemption_reason;Tax Exemption Reason',
            'serie;Serie'
        );
        $client = array(
            'name;Name',
            'vat_number;Vat Number',
            'country;Country',
            'main_url;Main URL',
            'email;Email',
            'code;Code',
            'postal_code;Postal Code',
            'address;Address',
            'city;City',
            'telephone;Telephone',
            'mobile;Mobile',
            'primary_name;Primary Name',
            'primary_email;Primary Email',
            'primary_mobile;Primary Mobile',
            'primary_telephone;Primary Telephone',
        );
        return view('brands.create',compact('invoice','client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->brand_id == 0){
            $brand = new Brands();
            $brand->name = $request->name;
            $brand->url = $request->url;
            $brand->logo = $request->logo;
            $brand->company_name = $request->company_name;
            $brand->company_vat = $request->company_vat;
            $brand->Company_Address = $request->Company_Address;
            $brand->series=$request->series;
            $brand->user_id = Auth::user()->id;
            $brand->save();
        }else{
            $brand = Brands::find($request->brand_id);
            $brand->name = $request->name;
            $brand->url = $request->url;
            $brand->logo = $request->logo;
            $brand->company_name = $request->company_name;
            $brand->company_vat = $request->company_vat;
            $brand->Company_Address = $request->Company_Address;
            $brand->series=$request->series;
            $brand->update();
            return json_encode('Saved');
        }
        // return json_encode($request->brand_id);
        // if($request->brand_id !== 0){

        // }
        // else{


        // for($i = 0; $i < count($request->body) ; $i++){
        //     $template = new BrandsTemplate();
        //     $template->header = json_encode($request->header);
        //     $template->footer = json_encode($request->footer);
        //     $template->body  = json_encode($request->body[$i]);
        //     $template->brands_id = $brand->id;
        //     if($i == 0){ $template->name = $request->name_1; }
        //     if($i == 1){ $template->name = $request->name_2; }
        //     $template->save();
        // }
        return json_encode('Saved');
        // }

    }

    public function store_with_template(Request $request)
    {
        $brand = new Brands();
        $brand->name = $request->name;
        $brand->url = $request->url;

        $brand->logo = $request->logo;
        $brand->company_name = $request->company_name;
        $brand->company_vat = $request->company_vat;
        $brand->Company_Address = $request->Company_Address;
        $brand->series=$request->series;
        $brand->user_id = Auth::user()->id;
        $brand->save();

        $template = new BrandsTemplate();
        $template->header = json_encode($request->header);
        $template->footer = json_encode($request->footer);
        $template->body  = json_encode($request->body);
        $template->brands_id = $brand->id;
        $template->name = $request->template_name_new;
        $template->save();

        return json_encode($template);
    }

    public function store_template_with_brand(Request $request)
    {
        $template = new BrandsTemplate();
        $template->header = json_encode($request->header);
        $template->footer = json_encode($request->footer);
        $template->body  = json_encode($request->body);
        $template->brands_id = $request->brand_id;
        $template->name = $request->template_name_new;
        $template->save();
        return json_encode($template);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brands::find($id);
        $brand_templates = BrandsTemplate::where('brands_id', $brand->id)->get();

        $invoice = array(
            'inv_date;Invoice Date',
            'inv_date;Invoice Date',
            'code_hash;Code Hash',
            'remarks;Remarks',
            'due;Due',
            'po;P.O',
            'sequence;Sequence',
            'retention;Retention',
            'inv_retention;Invoice Retention',
            'inv_subtotal;Invoice Subtotal',
            'inv_vat;Invoice Vat',
            'inv_discount;Invoice Discount',
            'currency;Currency',
            'tax_exemption_reason;Tax Exemption Reason',
            'total_invoice_value;Total Invoice Value',
            'serie;Serie'
        );
        $client = array(
            'name;Name',
            'vat_number;Vat Number',
            'country;Country',
            'main_url;Main URL',
            'email;Email',
            'code;Code',
            'postal_code;Postal Code',
            'address;Address',
            'city;City',
            'telephone;Telephone',
            'mobile;Mobile',
            'primary_name;Primary Name',
            'primary_email;Primary Email',
            'primary_mobile;Primary Mobile',
            'primary_telephone;Primary Telephone',
        );

        return view('brands.edit',compact('brand','brand_templates','invoice','client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return json_encode($request->name_1);
        $brand = Brands::find($request->brand_id);
        $brand->name = $request->name;
        $brand->url = $request->url;
        $brand->logo = $request->logo;
        $brand->company_name = $request->company_name;
        $brand->company_vat = $request->company_vat;
        $brand->Company_Address = $request->Company_Address;
        $brand->series=$request->series;
        $brand->update();

        //Delete Old templates
        // BrandsTemplate::where('brands_id','=',$brand->id)->delete();

        // Create Updated Once
        // for($i = 0; $i < count($request->body) ; $i++){
        //     $template = new BrandsTemplate();
        //     $template->header = json_encode($request->header);
        //     $template->footer = json_encode($request->footer);
        //     $template->body  = json_encode($request->body[$i]);
        //     $template->brands_id = $brand->id;
        //     if($i == 0){ $template->name = $request->name_1; }
        //     if($i == 1){ $template->name = $request->name_2; }
        //     $template->save();
        // }

        return json_encode('Updated');

        // return redirect()->route('brands');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BrandsTemplate::where('brands_id', $id)->get();
        Brands::find($id)->delete();
        return redirect()->route('brands');
    }

    public function brands_show_templates(Request $request){
        $brand_id = $request->brand_id;
        $templates = BrandsTemplate::where('brands_id', $brand_id)->get();

        return json_encode($templates);
    }

    public function brands_templates_get(Request $request){

        // $templates = BrandsTemplate::whereNotIn('brands_id','=',$request->brand_id)->get()->toArray();
        $templates = BrandsTemplate::all();
        return json_encode($templates);
    }

    public function remove_template(Request $request){
        BrandsTemplate::find($request->id)->delete();
        return 'deleted';
    }
    public function edit_template(Request $request){
        $template = BrandsTemplate::find($request->id);
        return json_encode($template);
    }

    public function brands_template_update(Request $request){

        $template = BrandsTemplate::find($request->template_id);
        $template->header = json_encode($request->header);
        $template->footer = json_encode($request->footer);
        $template->body  = json_encode($request->body);
        $template->brands_id = $request->brand_id;
        $template->name = $request->template_name_new;
        $template->update();

        return json_encode('Data Updated');

    }
    public function brands_template_selected(Request $request){
        // return json_encode($request->templates_ids);
        $templates = BrandsTemplate::whereIn('id',$request->templates_ids)->get();
        return json_encode($templates);
    }
    public function store_template_with_brand_previous_selected(Request $request){

        $brand = Brands::find($request->brand_id);
        $brand->name = $request->name;
        $brand->url = $request->url;
        $brand->logo = $request->logo;
        $brand->company_name = $request->company_name;
        $brand->company_vat = $request->company_vat;
        $brand->Company_Address = $request->Company_Address;
        $brand->series=$request->series;
        $brand->update();

        $templates = BrandsTemplate::whereIn('id',$request->templates_ids)->get()->toArray();

        for($i = 0; $i < count($templates) ; $i++){
            $template = new BrandsTemplate();
            $template->header = $templates[$i]['header'];
            $template->footer = $templates[$i]['footer'];
            $template->body  = $templates[$i]['body'];
            $template->brands_id = $brand->id;
            $template->name = $templates[$i]['name'];
            $template->save();
        }
        $templates = BrandsTemplate::whereIn('id',$request->templates_ids)->get();
        return json_encode($template);
    }
    public function store_with_template_previous_selected(Request $request){

        $brand = new Brands();
        $brand->name = $request->name;
        $brand->url = $request->url;
        $brand->logo = $request->logo;
        $brand->company_name = $request->company_name;
        $brand->company_vat = $request->company_vat;
        $brand->Company_Address = $request->Company_Address;
        $brand->series=$request->series;
        $brand->save();

        $templates = BrandsTemplate::whereIn('id',$request->templates_ids)->get()->toArray();

        for($i = 0; $i < count($templates) ; $i++){
            $template = new BrandsTemplate();
            $template->header = $templates[$i]['header'];
            $template->footer = $templates[$i]['footer'];
            $template->body  = $templates[$i]['body'];
            $template->brands_id = $brand->id;
            $template->name = $templates[$i]['name'];
            $template->save();
        }

        $templates = BrandsTemplate::whereIn('id',$request->templates_ids)->get();
        return json_encode($template);
    }

    public function brand_template_module_list(Request $request){
        if($request->module_id == 'invoice'){
            $fields = array(
                'inv_date;Invoice Date',
                'inv_date;Invoice Date',
                'code_hash;Code Hash',
                'remarks;Remarks',
                'due;Due',
                'po;P.O',
                'sequence;Sequence',
                'retention;Retention',
                'inv_retention;Invoice Retention',
                'inv_subtotal;Invoice Subtotal',
                'inv_vat;Invoice Vat',
                'inv_discount;Invoice Discount',
                'currency;Currency',
                'tax_exemption_reason;Tax Exemption Reason',
                'total_invoice_value;Total Invoice Value',
                'serie;Serie'
            );

        }
        if($request->module_id == 'client'){
            $fields = array(
                'name;Name',
                'vat_number;Vat Number',
                'country;Country',
                'main_url;Main URL',
                'email;Email',
                'code;Code',
                'postal_code;Postal Code',
                'address;Address',
                'city;City',
                'telephone;Telephone',
                'mobile;Mobile',
                'primary_name;Primary Name',
                'primary_email;Primary Email',
                'primary_mobile;Primary Mobile',
                'primary_telephone;Primary Telephone',
            );
        }
        if($request->module_id == 'items'){
            $fields = array(
                'code;Code',
                'description;Description',
                'unit_price;Unit Price',
                'qty;Qty',
                'vat;Vat',
                'discount;Discount',
                'total;Total',
            );
        }

        return json_encode($fields);
    }

    public function preview_template(Request $request){

        $template = BrandsTemplate::find($request->id);

        $invoice_new = New Invoices();
        $invoice_line_items = New LineItems();
        $client_new = New Clients();

        $invoice_new = $invoice_new->getTableColumns();
        $invoice_line_items = $invoice_line_items->getTableColumns();
        $client_new = $client_new->getTableColumns();

        $header = json_decode($template->header);
        $footer = json_decode($template->footer);
        $body = json_decode($template->body);

        $header = trim($header,'""');
        $footer =  trim($footer,'""');
        $body =  trim($body,'""');

        $dummy_invoice=array("inv_1","inv_2","inv_3","inv_4","inv_5");
        $dummy_client=array("client_1","client_2","client_3","client_4","client_5");
        $dummy_line_item=array("lineIten_1","lineIten_2","lineIten_3","lineIten_4","lineIten_5");

        foreach($invoice_new as $col_name)
        {
            $invoice_var = '$invoice_'.$col_name;
            $body  = str_replace("{$invoice_var}",$dummy_invoice[array_rand($dummy_invoice)], $body);
            $header  = str_replace("{$invoice_var}",$dummy_invoice[array_rand($dummy_invoice)], $header);
            $footer  = str_replace("{$invoice_var}",$dummy_invoice[array_rand($dummy_invoice)], $footer);
        }

        foreach($client_new as $col_name)
        {
            $client_var = '$client_'.$col_name;
            $body  = str_replace("{$client_var}",$dummy_client[array_rand($dummy_client)], $body);
            $header  = str_replace("{$client_var}",$dummy_client[array_rand($dummy_client)], $header);
            $footer  = str_replace("{$client_var}",$dummy_client[array_rand($dummy_client)], $footer);
        }

        foreach($invoice_line_items as $col_name)
        {
            $items_var = '$items_'.$col_name;
            $body = str_replace("{$items_var}",$dummy_line_item[array_rand($dummy_line_item)],$body);
        }



        $client_var = '$client_Countries';
        $body  = str_replace("$client_var",'Portgal', $body);
        $header  = str_replace("$client_var",'Portgal', $header);
        $footer  = str_replace("$client_var",'Portgal', $footer);


        $currency_var = '$currency';
        $body  = str_replace("$currency_var",'$', $body);
        $header  = str_replace("$currency_var",'$', $header);
        $footer  = str_replace("$currency_var",'$', $footer);

        $body = json_encode($body);
        $header = json_encode($header);
        $footer = json_encode($footer);
        $name = json_encode($template->name);

        return json_encode(['body'=>$body, 'header'=>$header, 'footer'=>$footer, 'name'=> $name]);
        // return json_encode($template);
    }
}



