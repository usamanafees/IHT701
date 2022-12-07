<?php

namespace App\Http\Controllers;

use Cassandra\Date;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Invoices;
use App\LineItems;
use Auth;
use App\Clients;
use App\PDFInvoices;
use PDF;
use App;
use App\Brands;
use App\BrandsTemplate;
use Carbon\Carbon;
use App\Credit_note_line_item;
use App\Credit_note;
use Log;
use App\User;
use DB;
use App\Payment_Invoices;
use App\Items;
use Response;


class InvoicesController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'clearance']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home(){

        if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
        {

            //compare for widget for invoices year for admin
            $last_year_invoice= Invoices::whereYear('created_at',date("Y",strtotime("-1 year")))->count();
            $today_year_invoice= Invoices::whereYear('created_at',date("Y"))->count();
            if ($last_year_invoice > $today_year_invoice)
                $set_compare_year_invoice=0;
            else if ($last_year_invoice < $today_year_invoice)
                $set_compare_year_invoice=1;
            else
                $set_compare_year_invoice=2;
            //end compare for widget year for adimn

            //compare for widget for invoices month for admin
            $last_month_invoice= Invoices::whereMonth('created_at',date("m",strtotime("-1 month")))->count();
            $today_month_invoice= Invoices::whereMonth('created_at',date("m"))->count();
            if ($last_month_invoice > $today_month_invoice)
                $set_compare_month_invoice=0;
            else if ($last_month_invoice < $today_month_invoice)
                $set_compare_month_invoice=1;
            else
                $set_compare_month_invoice=2;
            //end compare for widget month for admin


            //compare for widget for invoices today for admin
            $today = Invoices::whereDate('created_at', Carbon::today())->count();
            $yesterday= Invoices::whereDay('created_at',date("d",strtotime("-1 day")))->count();
            if ($yesterday > $today)
                $set_compare_today_invoice=0;
            else if ($yesterday < $today)
                $set_compare_today_invoice=1;
            else
                $set_compare_today_invoice=2;
            //end compare for widget today for admin


            $invoices=Invoices::
                latest('created_at')->take(100)
                ->get();

        }



        else{
            //compare for widget year for user
            $last_year_invoice= Invoices::whereYear('created_at',date("Y",strtotime("-1 year")))->where('uid',Auth::user()->id)->count();
            $today_year_invoice= Invoices::whereYear('created_at',date("Y"))->where('uid',Auth::user()->id)->count();
            if ($last_year_invoice > $today_year_invoice)
                $set_compare_year_invoice=0;
            else if ($last_year_invoice < $today_year_invoice)
                $set_compare_year_invoice=1;
            else
                $set_compare_year_invoice=2;
            //end compare for widget year for user



            //compare for widget for invoices today for user
            $today = Invoices::where('uid',Auth::user()->id)->whereDate('created_at', Carbon::today())->count();
            $yesterday= Invoices::whereDay('created_at',date("d",strtotime("-1 day")))->where('uid',Auth::user()->user_id)->count();
            if ($yesterday > $today)
                $set_compare_today_invoice=0;
            else if ($yesterday < $today)
                $set_compare_today_invoice=1;
            else
                $set_compare_today_invoice=2;
            //end compare for widget today for user



            //compare for widget month for user
            $last_month_invoice= Invoices::whereMonth('created_at',date("m",(date("m")-1)))->where('uid',Auth::user()->id)->count();
            $today_month_invoice= Invoices::whereMonth('created_at',date("m"))->where('uid',Auth::user()->id)->count();

            if ($last_month_invoice > $today_month_invoice) {
                $set_compare_month_invoice=0;
            }
            else if ($last_month_invoice < $today_month_invoice) {
                $set_compare_month_invoice=1;
            }
            else {
                $set_compare_month_invoice=2;
            }
            //end compare for widget month

            $invoices=Invoices::
            where('uid',Auth::user()->id)
                ->latest('created_at')->take(100)
                ->get();

        }


        return view('invoices.home',compact('invoices','today_year_invoice','set_compare_year_invoice','today_month_invoice','set_compare_month_invoice','today','set_compare_today_invoice'));


    }
    public function index(){

        if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
        {
            $invoices = Invoices::where('is_receipt','!=','receipt')->where('is_receipt','!=','')->orWhereNull('is_receipt')->with('BrandsTemplate','User','LineItems','Brands')->get();
        }
        else
        {
            $invoices = Invoices::where('is_receipt','!=','receipt')->where('is_receipt','!=','simplified')->orWhereNull('is_receipt')->where('uid',Auth::user()->id)->with('BrandsTemplate','User','LineItems','Brands')->get();
        }
        $user = User::find(Auth::user()->id);
        if(isset($user) && !empty($user))
        {
            $fee_list = json_decode($user->user_fee_list);
        }else
        {
            $fee_list = "";
        }
        $fee_list = json_encode($fee_list);
        $is_invoice = "invoice";

        //dd($invoices);
        return view('invoices.index',compact('invoices','is_invoice','fee_list' ));
    }

    public function index_receipt()
    {
        if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
        {
            $invoices = Invoices::where('is_receipt','receipt')->with('BrandsTemplate','User','LineItems','Brands')->get();
        }
        else
        {
            $invoices = Invoices::where('uid',Auth::user()->id)->where('is_receipt','receipt')->with('BrandsTemplate','User','LineItems','Brands')->get();
        }
        $is_receipt = "receipt";
        return view('invoices.invoice_receipt_index',compact('invoices','is_receipt'));
    }

    public function index_simplified()
    {
        if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
        {
            $invoices = Invoices::where('is_receipt','simplified')->with('BrandsTemplate','User','LineItems','Brands')->get();
        }
        else
        {
            $invoices = Invoices::where('uid',Auth::user()->id)->where('is_receipt','simplified')->with('BrandsTemplate','User','LineItems','Brands')->get();
        }
        $is_simplified = "simplified";
        // dd($invoices);
        return view('invoices.simplified_index',compact('invoices','is_simplified'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $inv_type = $request->inv_type;
        $user = User::find(Auth::user()->id);
        if(isset($user) && !empty($user))
        {
            $fee_list = json_decode($user->user_fee_list);
        }else
        {
            $fee_list = "";
        }
        $brands = Brands::All();
        return view('invoices.create',compact('fee_list','brands','inv_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
        $invoices = new Invoices();
        $invoices->save();

        return redirect()->route('invoices');
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
    public function edit(Request $request,$id)
    {
        $invoices = Invoices::find($id);
        $line_items = LineItems::where('invid',$invoices->id)->get();
        $client = Clients::withTrashed()->find($invoices->cid);
        $user = User::find($client->user_id);
        if(isset($user) && !empty($user))
        {
            $fee_list = json_decode($user->user_fee_list);
        }else
        {
            $fee_list = "";
        }
        //dd($fee_list);
        $user2 = User::find(Auth::user()->id);
        if(isset($user2) && !empty($user2))
        {
            $user_default_fee_list = json_decode($user2->user_fee_list);
        }else
        {
            $user_default_fee_list = "";
        }
        $brands = Brands::All();
        $inv_type = $request->inv_type;
        $templates = BrandsTemplate::where('brands_id', '=', $invoices->brands_id)->get();
        return view('invoices.edit',compact('user_default_fee_list','inv_type','fee_list','invoices','line_items','client','brands','templates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->ArraysOfObjects = json_decode($request->ArraysOfObjects,true);
        $total = 0; $discount = 0; $vat = 0; $grand_total = 0;
        $var=$request->total_invoice_value;
        $var1=str_replace(',', '.', $var);
        $var2=str_replace(' ','',$var1);
        $brand_serie=Brands::find($request->brands_id);
        $invoice = Invoices::where('id', $id)
            ->update(['inv_date' => Carbon::parse($request->invoice_date),
                'uid' => Auth::id(),
                'remarks' => $request->invoice_remarks,
                'due' => $request->invoice_due,
                'po' => $request->invoice_po,
                'sequence' => $request->invoice_sequence,
                'retention' => $request->invoice_retention,
                'currency' => $request->invoice_currency,
                'tax_exemption_reason' => $request->invoice_tax_exemption_reason,
                'cid' =>$request->client_id,
                'brand_templates_id' => $request->brand_templates_id,
                'brands_id' =>  $request->brands_id,
                'total_invoice_value' => number_format((float)$var2,2,'.', ''),
                'is_receipt'=> $request->inv_type ,
                'serie' => $brand_serie->series,
                'atcud'=> '0',
                'sourceid'=>'0',
                'source_billing'=>'P',
                'self_billing_indicator'=>'0',
                'cash_vat_scheme_indicator'=>'0',
                'third_parties_billing_indicator'=>'0',
            ]);

        //Delete old line items
        $line_items = LineItems::where('invid','=',$id)->delete();
        //Create New Line Items
        $code_index = 0;
        foreach($request->ArraysOfObjects as $line_item)
        {
            //unit_price, description, vat, qt
            $items=Items::where('price','=',number_format((float)$line_item['line_item_unit_price'],2,'.', ''))->where('description','=',$request->line_item_description[$code_index])->
            where('tax','=',$line_item['line_item_vat'])->where('code','=',$request->line_item_code[$code_index])->pluck('id')->first();
            if(empty($items))
                $items='';
            LineItems::create([
                'invid' => $id,
                'item_id' =>$items,
                // 'code' => $line_item['line_item_code'],
                'code' => $request->line_item_code[$code_index],
                // 'description' => $line_item['line_item_description'],
                'description' => $request->line_item_description[$code_index++],
                'unit_price' => number_format((float)$line_item['line_item_unit_price'],2,'.', ''),
                'qty' => $line_item['line_item_qty'],
                'vat' => $line_item['line_item_vat'],
                'discount' => number_format((float)$line_item['line_item_discount'],2,'.', ''),
                'total' =>number_format((float)$line_item['line_item_total']+((float)$line_item['line_item_total']*($line_item['line_item_vat']/100)),2,'.', ''),
            ]);
            $total += $line_item['line_item_total'];
            $discount += $line_item['line_item_total'] * ($line_item['line_item_discount']/100);
            $discount_placeholder = $line_item['line_item_total'] * ($line_item['line_item_discount']/100);
            $vat += ($line_item['line_item_total'] - $discount_placeholder ) * ($line_item['line_item_vat']/100);
            $vat_placeholder = ($line_item['line_item_total'] - $discount_placeholder ) * ($line_item['line_item_vat']/100);
            $grand_total += $line_item['line_item_total'] - $discount_placeholder + $vat_placeholder;
        }
        switch ($request->invoicebtn){
            case 'saveDraft':
                //dd(number_format((float)$total,2,'.', ''));
                Invoices::where('id',$id)->update([
                    'inv_subtotal' => number_format((float)$total,2,'.', ''),
                    'inv_vat' => $vat,
                    'inv_discount' => $discount,
                    'status'=>'draft'
                ]);
                break;

            case 'saveInvoice':
                $invoices=Invoices::find($id);
                $hash=$this->AT_sign_invoice($invoices,$grand_total);

                $hash_code=$hash[0].$hash[10].$hash[20].$hash[30];

                if($request->inv_type=="invoice") {
                    $invoices->update([
                        'inv_subtotal' => number_format((float)$total,2,'.', ''),
                        'inv_vat' => $vat,
                        'inv_discount' => number_format((float)$discount,2,'.', ''),
                        'hash_control' => 1,
                        'hash' => $hash,
                        'code_hash' => $hash_code,
                        'fault_value' => (float)$var1,
                        'status' => 'final'
                    ]);
                }else if($request->inv_type=="receipt" || $request->inv_type=="simplified"){
                    $invoices->update([
                        'inv_subtotal' => number_format((float)$total,2,'.', ''),
                        'inv_vat' => $vat,
                        'inv_discount' => number_format((float)$discount,2,'.', ''),
                        'hash_control' => 1,
                        'hash' => $hash,
                        'code_hash' => $hash_code,
                        'fault_value' => '0,00',
                        'status' => 'paid'
                    ]);
                }
                break;
        }if($request->inv_type == "simplified"){
        return redirect()->route('invoice_simplified');
    }
        if($request->inv_type == "receipt"){
            return redirect()->route('invoice_receipt');
        }else{
            return redirect()->route('invoices');
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        if(isset($request->invoice_id) && !empty($request->invoice_id)) {
            LineItems::where('invid',$request->invoice_id)->delete();
            $invoice=Invoices::find($request->invoice_id)->delete();
            if ($invoice == 1) {
                return response()->json(['success' => 'true', 'id' => $request->invoice_id]);
            } else {
                return response()->json(['success' => 'false', 'id' => $request->invoice_id]);
            }
        }
        return response()->json(['success'=>'false','id'=>$request->invoice_id]);
    }
    public function createNewInvoiceAJAX(Request $request)
    {
        $request->ArraysOfObjects = json_decode($request->ArraysOfObjects,true);
        $total = 0; $discount = 0; $vat = 0; $grand_total = 0;
        //Check client existsed or not
        if(!empty($request->client_id)){
            $client_id = $request->client_id;
        }
        if(empty($request->client_id)){
            $client = new Clients();
            $client->name = $request->name;
            $client->vat_number = $request->vat_number;
            $client->country = $request->country;
            $client->address = $request->address;
            $client->postal_code=$request->postal_code;
            $client->city=$request->city;
            $client->user_id = Auth::user()->id;
            $client->telephone = json_encode(array(null,null));
            $client->mobile = json_encode(array(null,null));
            $client->primary_mobile = json_encode(array(null,null));
            $client->primary_telephone = json_encode(array(null,null));
            $client->save();
            $client_id = $client->id;
        }
        $var=$request->total_invoice_value;
        $var1=str_replace(',', '.', $var);
        $var2=str_replace(' ','',$var1);
        $brand_serie=Brands::find($request->brands_id);
        $invoice = Invoices::create([
            'inv_date' => Carbon::parse($request->invoice_date),
            'uid' => Auth::id(),
            'remarks' => $request->invoice_remarks,
            'due' => $request->invoice_due,
            'po' => $request->invoice_po,
            'sequence' => $request->invoice_sequence,
            'retention' => $request->invoice_retention,
            'currency' => $request->invoice_currency,
            'tax_exemption_reason' => $request->invoice_tax_exemption_reason,
            'cid' => $client_id,
            'brand_templates_id' => $request->brand_templates_id,
            'brands_id' => $request->brands_id,
            'total_invoice_value' => number_format((float)$var2,2,'.', ''),
            'is_receipt' => $request->inv_type,
            'serie' => $brand_serie->series,
            'atcud' => '0',
            'sourceid' => '0',
            'source_billing' => 'P',
            'self_billing_indicator' => '0',
            'cash_vat_scheme_indicator' => '0',
            'third_parties_billing_indicator' => '0',

        ]);
        $code_index = 0;
        foreach($request->ArraysOfObjects as $line_item)
        {
            LineItems::create([
                'invid' => $invoice->id,
                'item_id' =>$request->idd[$code_index] ,
                 //'code' => $line_item['line_item_code'],
                'code' => $request->line_item_code[$code_index],
                // 'description' => $line_item['line_item_description'],
                'description' => $request->line_item_description[$code_index++],
                'unit_price' => number_format((float)$line_item['line_item_unit_price'],2,'.', ''),
                'qty' => $line_item['line_item_qty'],
                'vat' => $line_item['line_item_vat'],
                'discount' => number_format((float)$line_item['line_item_discount'],2,'.', ''),
                'total' => number_format((float)$line_item['line_item_total']+((float)$line_item['line_item_total']*($line_item['line_item_vat']/100)),2,'.', ''),

            ]);
            $total += $line_item['line_item_total'];
            $discount += $line_item['line_item_total'] * ($line_item['line_item_discount']/100);
            $discount_placeholder = $line_item['line_item_total'] * ($line_item['line_item_discount']/100);
            $vat += ($line_item['line_item_total'] - $discount_placeholder ) * ($line_item['line_item_vat']/100);
            $vat_placeholder = ($line_item['line_item_total'] - $discount_placeholder ) * ($line_item['line_item_vat']/100);
            $grand_total += $line_item['line_item_total'] - $discount_placeholder + $vat_placeholder;
        }
        switch ($request->invoicebtn){
            case 'saveDraft':
                Invoices::where('id',$invoice->id)->update([
                    'inv_subtotal' => number_format((float)$total,2,'.', ''),
                    'inv_vat' => $vat,
                    'inv_discount' => $discount,
                    'status'=>'draft'
                ]);
                break;

            case 'saveInvoice':
                $hash=$this->AT_sign_invoice($invoice,$grand_total);

                $hash_code=$hash[0].$hash[10].$hash[20].$hash[30];

                if($request->inv_type=="invoice") {
                    Invoices::where('id', $invoice->id)->update([
                        'inv_subtotal' => number_format((float)$total,2,'.', ''),
                        'inv_vat' => number_format((float)$vat,2,'.', ''),
                        'inv_discount' => number_format((float)$discount,2,'.', ''),
                        'hash_control' => 1,
                        'hash' => $hash,
                        'code_hash' => $hash_code,
                        'fault_value' => (float)$var1,
                        'status' => 'final'
                    ]);
                }else if($request->inv_type=="receipt" || $request->inv_type=="simplified"){
                    Invoices::where('id', $invoice->id)->update([
                        'inv_subtotal' => number_format((float)$total,2,'.', ''),
                        'inv_vat' => number_format((float)$vat,2,'.', ''),
                        'inv_discount' => number_format((float)$discount,2,'.', ''),
                        'hash_control' => 1,
                        'hash' => $hash,
                        'code_hash' => $hash_code,
                        'fault_value' => '0.00',
                        'status' => 'paid'
                    ]);
                }
                break;
        } if($request->inv_type == "simplified")
    {
        return redirect()->route('invoice_simplified');
    }
        if($request->inv_type == "receipt"){
            return redirect()->route('invoice_receipt');
        }else{
            return redirect()->route('invoices');
        }
    }

    public function GetInvoice(Request $request){
        $invoice = Invoices::with('Clients')->where('id',$request->invoice_id)->first();
        // dd($invoice->Clients->Countries);
        $line_items = LineItems::where('invid','=',$request->invoice_id)->get();

        $pdf = PDFInvoices::where('invoices_id','=',$invoice->id)->first();
        if(empty($pdf)){
            $contents = NULL;
        }else{
            $contents = json_decode($pdf->pdf_data);
        }

        $currency = explode('_', $invoice->currency);
        $currency =$currency[1];
        return view('invoices.template',compact('invoice','line_items','contents','currency'));
    }
    public function print_invoice(Request $request){

        $data = $request->pdf_data;
        $invoice_id = $request->invoice_id;
        $uid = Auth::user()->id;

        $pdf = PDFInvoices::where('invoices_id','=',$invoice_id)->first();
        if(empty($pdf)){
            $pdf = new PDFInvoices();
            $pdf->pdf_data = json_encode($request->pdf_data);
            $pdf->invoices_id = $request->invoice_id;
            $pdf->user_id = $uid;
            $pdf->save();
            $title = 'Invoice-'.$pdf->id.'-file'.rand();
            $contents = json_decode($pdf->pdf_data);
            $pdf = App::make('dompdf.wrapper');
            $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->loadView('invoices.print', compact('contents'));

            return $pdf->download($title.'.pdf');

        }else{
            $pdf->pdf_data = json_encode($request->pdf_data);
            $pdf->invoices_id = $request->invoice_id;
            $pdf->user_id = $uid;
            $pdf->update();

            $title = 'Invoice-'.$pdf->id.'-file'.rand();

            $contents = json_decode($pdf->pdf_data);
            $pdf = App::make('dompdf.wrapper');
            $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->loadView('invoices.print', compact('contents'));

            return $pdf->download($title.'.pdf');
        }
    }
    public function download_invoice($id){

        $pdf = PDFInvoices::where('invoices_id','=',$id)->first();
        $title = 'Invoice-'.$pdf->id.'-file'.rand();

        $contents = json_decode($pdf->pdf_data);
        $pdf = App::make('dompdf.wrapper');
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->loadView('invoices.print', compact('contents'));

        return $pdf->download($title.'.pdf');
    }
    public function download_invoice_pdf($id, $digital = 0){
        $invoice = Invoices::find($id);
       
        $invoice_items = LineItems::where('invid', '=', $invoice->id)->get();
        $client = Clients::with('Countries')->where('id', '=', $invoice->cid)->first();

        $currency = explode('_', $invoice->currency);
        $currency =$currency[1];
        $invoice_new = New Invoices();
        $invoice_line_items = New LineItems();
        $client_new = New Clients();

        $invoices = array();
        $line_items = array();
        $clients = array();

        $invoice_new = $invoice_new->getTableColumns();
        $invoice_line_items = $invoice_line_items->getTableColumns();
        $client_new = $client_new->getTableColumns();

        $template = BrandsTemplate::withTrashed()->find($invoice->brand_templates_id);
  
        $header = json_decode($template->header);
        $footer = json_decode($template->footer);
        $body = json_decode($template->body);
        $header = trim($header,'""');
        $footer =  trim($footer,'""');
        $body =  trim($body,'""');

        foreach($invoice_new as $col_name)
        {
            $invoice_var = '$invoice_'.$col_name;
            $body  = str_replace("{$invoice_var}",isset($invoice->$col_name)?$invoice->$col_name:'N/A', $body);
            $header  = str_replace("{$invoice_var}",isset($invoice->$col_name)?$invoice->$col_name:'N/A', $header);
            $footer  = str_replace("{$invoice_var}",isset($invoice->$col_name)?$invoice->$col_name:'N/A', $footer);
        }

        foreach($client_new as $col_name)
        {
            $client_var = '$client_'.$col_name;
            $body  = str_replace("{$client_var}",isset($client->$col_name)?$client->$col_name:'N/A', $body);
            $header  = str_replace("{$client_var}",isset($client->$col_name)?$client->$col_name:'N/A', $header);
            $footer  = str_replace("{$client_var}",isset($client->$col_name)?$client->$col_name:'N/A', $footer);
        }



        $client_var = '$client_Countries';
        $body  = str_replace("$client_var",isset($client->Countries->name)?$client->Countries->name:'N/A', $body);
        $header  = str_replace("$client_var",isset($client->Countries->name)?$client->Countries->name:'N/A', $header);
        $footer  = str_replace("$client_var",isset($client->Countries->name)?$client->Countries->name:'N/A', $footer);


        $currency_var = '$currency';
        $body  = str_replace("$currency_var",$currency, $body);
        $header  = str_replace("$currency_var",$currency, $header);
        $footer  = str_replace("$currency_var",$currency, $footer);
        $base64 = 'none';
        if($digital == 1){
            $user = User::find(Auth::user()->id);
            if($user->digital_signature != ''){

                $path = asset('/img/digital_signature/'.$user->digital_signature);
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $arrContextOptions=array(
                    "ssl"=>array(
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                );

                $response = file_get_contents($path, false, stream_context_create($arrContextOptions));
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($response);
                // $footer = ''.$footer;
            }
            // dd($base64);
        }
        $items = $invoice_items->toArray();

        $id ='';
        $invid = '';
        $code = '';
        $description = '';
        $unit_price = '';
        $qty = '';
        $vat = '';
        $discount = '';
        $total = '';
        $created_at = '';
        $updated_at = '';
        $litems = array(
            "id" ,
            "invid",
            "code",
            "description",
            "unit_price",
            "qty",
            "vat",
            "discount",
            "total",
            "created_at",
            'updated_at' ,);
            //dd($items);
            for($i = 0; $i < count($items); $i++){
            $item = $items[$i];
            for($j = 0; $j<count($item) ; $j++){
                
                if($j == 0){
                    $id .=  $item[$litems[$j]].'<hr>';
                }
                if($j == 1){
                    $invid .=  $item[$litems[$j]].'<hr>';
                }
                if($j == 2){
                    $code .=  $item[$litems[$j]].'<hr>';
                }
                if($j == 3){
                    $description .=  $item[$litems[$j]].'<hr>';
                }
                if($j == 4){
                    $unit_price .=  $item[$litems[$j]].$currency.'<hr>';
                }
                if($j == 5){
                    $qty .=  $item[$litems[$j]].'<hr>';
                }
                if($j == 6){
                    $vat .=  $item[$litems[$j]].'%'.'<hr>';
                }
                if($j == 7){
                    $discount .=  $item[$litems[$j]].'<hr>';
                }
                if($j == 8){
                    $total .=  $item[$litems[$j]].$currency.'<hr>';
                }
                if($j == 9){
                    $created_at .=  \Carbon\Carbon::parse($item[$litems[$j]])->format('d m Y').'<hr>';
                }
                if($j == 10){
                    $updated_at .=  $item[$litems[$j]].'<hr>';
                }
            }
        }
        $final_items = array(
                "id" => $id ,
                "invid" => $invid,
                "code" => $code,
                "description" => $description,
                "unit_price" => $unit_price,
                "qty" => $qty,
                "vat" => $vat,
                "discount" => $discount,
                "total" => $total,
                "created_at" => $created_at,
                'updated_at' => $updated_at ,
            );
         
        $firstValue = '';
        $firstNum = 0;
        $lastValue = '';
        $lastNum = 0;
        $element ='tr';
        $startElement = '<' . $element;
        $endElement = '</' . $element . '>';
        foreach ($litems as $name) {

                $curNum = strpos($body, '$items_' . $name);
                if ($curNum) {
                    if ($curNum < $firstNum || $firstNum == 0) {
                        $firstValue = '$items_' . $name;
                        $firstNum = $curNum;
                    }
                    if ($curNum > $lastNum) {
                        $lastValue = '$items_' . $name;
                        $lastNum = $curNum;
                    }
                }
        }

    if ($firstValue !== '' && $lastValue !== '') {
    
        //Converting Text
        
        $tparts = explode($firstValue, $body);
        $temp = $tparts[0];
      
        //check if there is only one line item
        if ($firstNum == $lastNum) {
            $linePart = $firstValue;
        } else {
            $tparts = explode($lastValue, $tparts[1]);
            $linePart = $firstValue . $tparts[0] . $lastValue;
        }
    
        // print_r($linePart);
        // die;
        $tcount = strrpos($temp, $startElement);
        $lsValue = substr($temp, $tcount);
        $tcount = strpos($lsValue, ">") + 1;
        $lsValue = substr($lsValue, 0, $tcount);

        //Read line end values
        $tcount = strpos($tparts[1], $endElement) + strlen($endElement);
        $leValue = substr($tparts[1], 0, $tcount);
        $tdTemp = explode($lsValue, $temp);

        $linePart = $lsValue . $tdTemp[count($tdTemp) - 1] . $linePart . $leValue;
        $parts = explode($linePart, $body);
        $body = $parts[0];

        //Converting Line Items
        if (count($items) != 0) {
            foreach ($items as $item) {
                if ($items != null) {
                    $nlp = $linePart;
                    foreach($litems as $li)
                    {
                        $nlp = str_replace('$items_'.$li,$item[$li],$nlp);
                    }
                    $body .=$nlp;
                }
            }
        }
        $body .= $parts[1];
    }
    
        // echo $body;
        // die;


        //  foreach($invoice_line_items as $col_name)
        // {
        //     $items_var = '$items_'.$col_name;
        //     $body = str_replace("{$items_var}",
        //     isset($final_items[$col_name])?$final_items[$col_name]:'N/A'
        //     ,$body);
        // }
        //return View('invoices.print', compact('body','header','footer','base64'));
        $pdf = App::make('dompdf.wrapper');
        $pdf->setOptions(['isHtml5ParserEnabled' => false, 'isRemoteEnabled' => false]);
        $pdf->loadView('invoices.print', compact('body','header','footer','base64'));
        $title = 'Invoice-file'.rand();
        return $pdf->download($title.'.pdf');
    }

    public function preview_template_invoice(Request $request){

        $id = $request->invoice_id;

        $invoice = Invoices::find($id);
        $invoice_items = LineItems::where('invid', '=', $invoice->id)->get();
        $client = Clients::with('Countries')->where('id', '=', $invoice->cid)->first();

        $currency = explode('_', $invoice->currency);
        $currency =$currency[1];
        $invoice_new = New Invoices();
        $invoice_line_items = New LineItems();
        $client_new = New Clients();

        $invoices = array();
        $line_items = array();
        $clients = array();

        $invoice_new = $invoice_new->getTableColumns();
        $invoice_line_items = $invoice_line_items->getTableColumns();
        $client_new = $client_new->getTableColumns();

        $template = BrandsTemplate::withTrashed()->find($invoice->brand_templates_id);
        $header = json_decode($template->header);
        $footer = json_decode($template->footer);
        $body = json_decode($template->body);

        $header = trim($header,'""');
        $footer =  trim($footer,'""');
        $body =  trim($body,'""');


        foreach($invoice_new as $col_name)
        {
            $invoice_var = '$invoice_'.$col_name;
            $body  = str_replace("{$invoice_var}",isset($invoice->$col_name)?$invoice->$col_name:'N/A', $body);
            $header  = str_replace("{$invoice_var}",isset($invoice->$col_name)?$invoice->$col_name:'N/A', $header);
            $footer  = str_replace("{$invoice_var}",isset($invoice->$col_name)?$invoice->$col_name:'N/A', $footer);
        }

        foreach($client_new as $col_name)
        {
            $client_var = '$client_'.$col_name;
            $body  = str_replace("{$client_var}",isset($client->$col_name)?$client->$col_name:'N/A', $body);
            $header  = str_replace("{$client_var}",isset($client->$col_name)?$client->$col_name:'N/A', $header);
            $footer  = str_replace("{$client_var}",isset($client->$col_name)?$client->$col_name:'N/A', $footer);
        }



        $client_var = '$client_Countries';
        $body  = str_replace("$client_var",isset($client->Countries->name)?$client->Countries->name:'N/A', $body);
        $header  = str_replace("$client_var",isset($client->Countries->name)?$client->Countries->name:'N/A', $header);
        $footer  = str_replace("$client_var",isset($client->Countries->name)?$client->Countries->name:'N/A', $footer);


        $currency_var = '$currency';
        $body  = str_replace("$currency_var",$currency, $body);
        $header  = str_replace("$currency_var",$currency, $header);
        $footer  = str_replace("$currency_var",$currency, $footer);

        $items = $invoice_items->toArray();

        $id ='';
        $invid = '';
        $code = '';
        $description = '';
        $unit_price = '';
        $qty = '';
        $vat = '';
        $discount = '';
        $total = '';
        $created_at = '';
        $updated_at = '';

        $litems = array(
            "id" ,
            "invid",
            "code",
            "description",
            "unit_price",
            "qty",
            "vat",
            "discount",
            "total",
            "created_at",
            'updated_at' ,);

        for($i = 0; $i < count($items); $i++){
            $item = $items[$i];
            // dd(count($item));
            for($j = 0; $j<count($item) ; $j++){
                if($j == 0){
                    $id .=  $item[$litems[$j]].'<hr>';
                }
                if($j == 1){
                    $invid .=  $item[$litems[$j]].'<hr>';
                }
                if($j == 2){
                    $code .=  $item[$litems[$j]].'<hr>';
                }
                if($j == 3){
                    $description .=  $item[$litems[$j]].'<hr>';
                }
                if($j == 4){
                    $unit_price .=  $item[$litems[$j]].$currency.'<hr>';
                }
                if($j == 5){
                    $qty .=  $item[$litems[$j]].'<hr>';
                }
                if($j == 6){
                    $vat .=  $item[$litems[$j]].'%'.'<hr>';
                }
                if($j == 7){
                    $discount .=  $item[$litems[$j]].'<hr>';
                }
                if($j == 8){
                    $total .=  $item[$litems[$j]].$currency.'<hr>';
                }
                if($j == 9){
                    $created_at .=  \Carbon\Carbon::parse($item[$litems[$j]])->format('d m Y').'<hr>';
                }
                if($j == 10){
                    $updated_at .=  $item[$litems[$j]].'<hr>';
                }
            }
        }
        $final_items = array(
            "id" => $id ,
            "invid" => $invid,
            "code" => $code,
            "description" => $description,
            "unit_price" => $unit_price,
            "qty" => $qty,
            "vat" => $vat,
            "discount" => $discount,
            "total" => $total,
            "created_at" => $created_at,
            'updated_at' => $updated_at ,);

        foreach($invoice_line_items as $col_name)
        {
            $items_var = '$items_'.$col_name;
            $body = str_replace("{$items_var}",
                isset($final_items[$col_name])?$final_items[$col_name]:'N/A'
                ,$body);
        }
        $body = json_encode($body);
        $header = json_encode($header);
        $footer = json_encode($footer);
        return json_encode(['body'=>$body, 'header'=>$header, 'footer'=>$footer]);
    }

    public function showFees()
    {
        if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
        {
            $user =  User::all();
        }else{
            $user =  User::where('id',Auth::user()->id)->get();
        }
        $user = User::find(Auth::user()->id)->get();
        if(empty($user->user_fee_list)) {
            DB::table('users')->where('id',Auth::user()->id)->update(['user_fee_list'=>'{"1":["23","IVA Portugal Continental"],"2":["18","IVA Portugal Açores"],"3":["22","IVA Portugal Madeira"],"4":["0","Isento"]}']);
        }
        return view('invoices.fee.index',compact('user'));
    }
    public function fee_add(Request $request)
    {
        //dd($request->id);
        $user = User::find($request->id);
        return view('invoices.fee.add',compact('user'));
    }
    public function store_fee(Request $request)
    {
        $json_encoded = json_encode($request->fee);
        $user =  User::find($request->user_id);
        $user->user_fee_list = $json_encoded;
        $user->save();
        return $this->showFees();
    }


    function AT_sign_invoice($invoice,$grand_total){
        $config_AT['version']="1.1";
        $config_AT['passphrase']="autoridade tributaria";
        $config_AT['HashControl']=1;
        $config_AT['version_SAF-T']="1.04_01";
        $config_AT['Priv_key']="Intelidus Invoicing/keys/AT/2020-05/pfxKey.pem";
        $config_AT['Pub_key']="Intelidus Invoicing/keys/AT/2020-05/pfxcert.pem";
        $config_AT['FAC_priv_key']=public_path()."/keys/AT/at.key";
        $config_AT['Info_CA_key']="Intelidus Invoicing/keys/AT/2019/DGITA_Issuing_CA2.pem";
        $config_AT['nonce']="Intelidus Invoicing/keys/AT/2023/ChaveCifraPublicaAT2023.cer";

        $config_AT['certification_n']="2050/AT";
        $config_AT['productor_NIF']="505194031";
        $config_AT['ES_Productor_NIF']="B88581293 ";
        $config_AT['Webservice']=array("505194031/2","72a7bd324b");

        if(!$invoice->hash)
        {
            $f_ult=$this->last_invoice($invoice->serie, $invoice->cid, $invoice->is_receipt , $invoice->id);
            $last_hash=$f_ult;

        }
        else {
            $last_hash = $invoice->hash;
        }
        $date=new \DateTime($invoice->inv_date);
        $datecreated= new \DateTime($invoice->created_at);

        $string=$date->format('Y-m-d').";".$datecreated->format('Y-m-d').";".$invoice->id.";".number_format($grand_total,2,".","").";".$last_hash;

        openssl_sign($string, $key, file_get_contents($config_AT['FAC_priv_key']), OPENSSL_ALGO_SHA1);

        if(!$key)
            maili("bruno.duarte@intelidus.com","AT: Erro a gerar Chave", $string);

        return base64_encode($key);
    }

    function last_invoice($serie,$entity,$type,$id){
        switch ($type){
            case 'Invoice':
            default:
                $type="invoice";
                $sql=DB::table('invoices')->where('serie','=',$serie)->where('id','!=',$id)->where('is_receipt','=',$type)->where('cid','=',$entity)->OrderByDesc('id')->pluck('hash');
                break;
        }
        return $sql;
    }


    public function credit_note(Request $request)
    {
        if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
        {
            $credit_notes =  Credit_note::all();
        }else{
            $credit_notes = Credit_note::where('uid',Auth::user()->id)->get();
        }

        return view('invoices.index_credit_note',compact('credit_notes'));
    }
    public function add_credit_note(Request $request)
    {
        if(isset($request->invcd) && !empty($request->invcd)){
            $from_invoice = $request->invcd;
        }else{
            $from_invoice = "";
        }
        if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
        {
            $invoices =  Invoices::where("status","paid")->get();
        }else{
            $invoices = Invoices::where('uid',Auth::user()->id)->where("status","paid")->get();
        }
        return view('invoices.add_credit_note',compact('invoices','from_invoice'));
    }
    public function credit_note_line_items(Request $request)
    {

        $line_items = LineItems::where('invid',$request->inv_id)->get();
        return response()->json($line_items);
    }
    public function store_credit_note(Request $request)
    {
        $validated = $request->validate([
            'reason' => 'required',
            'date' => 'required',
            'invoices' => 'required',
            'inv_items' => 'required',
        ]);
        $invoices = implode(",",$request->invoices);
        $credit_note = new   Credit_note();
        $credit_note->reason = $request->reason;
        $credit_note->inv_id = $invoices;
        $credit_note->date = $request->date;
        $credit_note->uid =Auth::user()->id ;
        $credit_note->save();
        // Credit_note_line_item
        // Credit_note
        if(isset($request->inv_items) && !empty($request->inv_items))
        {
            foreach($request->inv_items as $itm)
            {
                $pieces = explode(",", $itm);
                $credit_note_ln = new Credit_note_line_item();
                $credit_note_ln->item_id = $pieces[1];
                //$credit_note_ln->inv_id = $pieces[0];
                $credit_note_ln->credit_notes_id = $credit_note->id;
                $credit_note_ln->save();
            }
        }
        return redirect()->route('credit_note');
    }
    public function delete_credit_note(Request $request)
    {
        if(isset($request->cr_id) && !empty($request->cr_id))
        {
            $del =  Credit_note::where('id',$request->cr_id)->delete();
            if($del == 1)
            {
                return response()->json(['success'=>'true','id'=>$request->cr_id]);
            }else
            {
                return response()->json(['success'=>'false','id'=>$request->cr_id]);
            }
        }
        return response()->json(['success'=>'false','id'=>$request->cr_id]);
    }

    public function edit_credit_note(Request $request)
    {

        if(isset($request->id) && !empty($request->id))
        {  $credit_note = Credit_note::find($request->id);
            if(isset($credit_note) && !empty($credit_note))
            {
                $c_line_item = Credit_note_line_item::where('credit_notes_id',$credit_note->id)->get();
                if(isset($credit_note->date) && !empty($credit_note->date))
                {
                    $time = strtotime($credit_note->date);
                    $credit_note->date =  date('Y-m-d',$time);
                }
                $sel_invoices = explode(",",$credit_note->inv_id);
                if(isset($c_line_item ) && !empty($c_line_item))
                {
                    $line_items = array();
                    foreach($c_line_item  as $cli)
                    {
                        $line_items[] = LineItems::find($cli->item_id);
                    }
                    $invoices = Invoices::where('uid',Auth::user()->id)->get();
                    return view('invoices.edit_credit_note',compact('credit_note','sel_invoices','invoices','line_items'));
                }
            }
        }
    }
    public function update_credit_note(Request $request)
    {
        $validated = $request->validate([
            'reason' => 'required',
            'date' => 'required',
            'invoices' => 'required',
            'inv_items' => 'required',
        ]);
        $invoices = implode(",", $request->invoices);
        $credit_note = Credit_note::find($request->credit_note_id);
        $credit_note->reason = $request->reason;
        $credit_note->inv_id = $invoices;
        $credit_note->date = $request->date;
        $credit_note->uid = Auth::user()->id;
        $credit_note->save();
        Credit_note_line_item::where('credit_notes_id', $credit_note->id)->delete();
        // Credit_note_line_item
        // Credit_note
        if (isset($request->inv_items) && !empty($request->inv_items)) {
            foreach ($request->inv_items as $itm) {
                $pieces = explode(",", $itm);
                $credit_note_ln = new Credit_note_line_item();
                $credit_note_ln->item_id = $pieces[1];
                $credit_note_ln->inv_id = $pieces[0];
                $credit_note_ln->credit_notes_id = $credit_note->id;
                $credit_note_ln->save();
            }
        }
        return redirect()->route('credit_note');
    }
    function invoices_paid($id){
        $invoice_paid=Invoices::find($id);
        $invoice_paid->status="paid";
        $invoice_paid->save();
        return redirect()->back();
    }

    function invoices_cancel(Request $request){
        if(isset($request->invoice_id) && !empty($request->invoice_id)) {
            $invoice_paid = Invoices::find($request->invoice_id);
            $invoice_paid->status = "canceled";
            $invoice_paid->save();
        }
        return response()->json(['success'=>'true','id'=>$request->invoice_id]);
    }

    function register_payment($id, Request $request){
        $value_paid=$request->value_paid;
        $payment_date=$request->date_payment;
        $payment_method=$request->payment_method;
        $observations=$request->observations;
        //dd($request->all());

        $already_paid=Invoices::where('id','=',$id)->pluck('fault_value')->first();

        $already_paid_space=str_replace(' ','', $already_paid);
        $already_paid_point=str_replace(',','.',$already_paid_space);
        $already_paid_fin=floatval($already_paid_point);

        $value_paid_point=str_replace(',','.',$value_paid);
        $conv_value_paid=(float)$value_paid_point;

        $fault_value=$already_paid_fin-$conv_value_paid;


        if($fault_value<0.0){
            return redirect()->back();
        }else if($fault_value==0.0){
            Payment_Invoices::create([
                'value_paid'=> $value_paid,
                'payment_date'=> $payment_date,
                'fault_value'=>$fault_value,
                'payment_method'=> $payment_method,
                'observations'=> $observations,
                'invoices_id'=>$id,
            ]);

            $invoice=Invoices::where('id','=',$id)->first();
            $invoice->fault_value=$fault_value;
            $invoice->status="paid";
            $invoice->save();

        }else{
            Payment_Invoices::create([
                'value_paid'=> $value_paid,
                'payment_date'=> $payment_date,
                'fault_value'=>$fault_value,
                'payment_method'=> $payment_method,
                'observations'=> $observations,
                'invoices_id'=>$id,
            ]);

            $invoice=Invoices::where('id','=',$id)->first();
            $invoice->fault_value=$fault_value;
            $invoice->save();

        }
        return redirect()->back();
    }

}