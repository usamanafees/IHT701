<?php

namespace App\Http\Controllers;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Session;
use Response;
use App;
use Translation;
use DOMDocument;
use Log;
use Auth;
use DB;
use App\Clients;
use App\User;
use App\Items;
use App\Invoices;
use App\LineItems;
use App\Billing_Alerts;
use App\BillingAlllertC;
class CommonController extends Controller
{
    public function setlanguage(Request $request) {

        if(in_array($request->lng , ['pt','en'])) {
            session(['locale' => $request->lng]);
        }




        return redirect()->back();
    }
    public function saftdownload(Request $request)
    {
        if(isset($request->comminfrom)&& ($request->comminfrom == "command"))
        {
            $current_user = $request->uid;
        }else
        {
            $current_user = Auth::user()->id;
        }
        $month=$request->input("dropdownMonth");
        $year=$request->input("dropdownYear");
        $checkbox=$request->input("options");
        $day_in_month=cal_days_in_month(CAL_GREGORIAN,$month,$year);
        if($checkbox=="month") {
            $start_date = date("Y-m-d", mktime(0, 0, 0, $month, '01', $year));
            $end_date = date("Y-m-d", mktime(0, 0, 0, $month, $day_in_month, $year));
        }
        elseif ($checkbox=="date"){
            $start_date=$request->input("start_date");
            $end_date=$request->input("end_date");
            $year_start_date =date('Y', strtotime($start_date));
            $month_start_date=date('m',strtotime($start_date));
            $day_start_date=date('d',strtotime($start_date));
            $year_end_date =date('Y', strtotime($end_date));
            $month_end_date=date('m',strtotime($end_date));
            $day_end_date=date('d',strtotime($end_date));
        }

        $dan_d['Header'] = array(
            "AuditFileVersion" =>"1.04_01",
            "CompanyID" =>"505194031",
            "TaxRegistrationNumber" =>"505194031",
            "TaxAccountingBasis" =>"F",
            "CompanyName" =>"Intelidus, Informatica, Lda",
            "CompanyAddress" => array(
                "AddressDetail" =>"Rua do Paraiso, 260",
                "City" => "Porto",
                "PostalCode" => "4000-376",
                "Country" => "PT"
            ),
            "FiscalYear" => "".date("Y"),
            "StartDate" =>"".$start_date,
            "EndDate" => "".$end_date,

            "CurrencyCode" => "EUR",
            "DateCreated" => "".date("Y-m-d"),
            "TaxEntity" => "Global",
            "ProductCompanyTaxID" => "505194031",
            "SoftwareCertificateNumber" => "2050",
            "ProductID" => "Intelidus/Datasource",
            "ProductVersion" => "1.03",
        );
        $dom = new DOMDocument('1.0','WINDOWS-1252');
        $dom->formatOutput = true;
        $AuditFile = $dom->createElement('AuditFile');
        $AuditFile->setAttribute('xmlns',"urn:OECD:StandardAuditFile-Tax:PT_1.04_01");
        $AuditFile->setAttribute('xmlns:xsi',"http://www.w3.org/2001/XMLSchema-instance");
        $dom->appendChild($AuditFile);
        $Header = $dom->createElement('Header');
        $AuditFile->appendChild($Header);
        $MasterFiles = $dom->createElement('MasterFiles');
        $AuditFile->appendChild($MasterFiles);
        $SourceDocuments = $dom->createElement('SourceDocuments');
        $AuditFile->appendChild($SourceDocuments);
        $SalesInvoices = $dom->createElement('SalesInvoices');
        $SourceDocuments->appendChild($SalesInvoices);
        foreach($dan_d['Header'] as $x => $x_value)
        {
            if(gettype($x_value) == 'string')
            {
                $this->createChild($Header,$dom,$x,$x_value);
            }else
            {
                $second = $dom->createElement($x);
                $Header->appendChild($second);
                foreach($x_value as $x => $x_value)
                {
                    $this->createChild($second,$dom,$x,$x_value);
                }
            }
        }
        if($checkbox=="month"){
            $dan_d['customers'] = DB::select("SELECT clients.id,clients.name,clients.vat_number,clients.country,clients.main_url, clients.email,clients.code, clients.postal_code, clients.address, clients.city, clients.telephone, clients.mobile,clients.user_id,clients.self_billing_indicator from clients left join invoices on invoices.cid=clients.id where Month(invoices.created_at)='$month' and Year(invoices.created_at)='$year' and invoices.status!='draft' and clients.user_id='$current_user' group by clients.id");
        }
        else if($checkbox=="date"){
            $dan_d['customers'] = DB::table('clients')->join('invoices','clients.id','=','invoices.cid')->where('user_id',$current_user)->where('invoices.status','!=','draft')->WhereMonth('invoices.created_at','>=',$month_start_date)->WhereYear('invoices.created_at','>=',$year_start_date)
                ->WhereDay('invoices.created_at','>=',$day_start_date)->WhereMonth('invoices.created_at','<=',$month_end_date)->WhereYear('invoices.created_at','<=',$year_end_date)
                ->WhereDay('invoices.created_at','<=',$day_end_date)->select('clients.id','clients.name','clients.vat_number','clients.country', 'clients.main_url', 'clients.email', 'clients.code', 'clients.postal_code', 'clients.address', 'clients.city', 'clients.telephone', 'clients.mobile', 'clients.user_id')->groupBy('clients.id')->get();
        }
        foreach($dan_d['customers'] as $x )
        {
            $Customer = $dom->createElement('Customer');
            $MasterFiles->appendChild($Customer);
            $Customer->appendChild($dom->createElement('CustomerID',$x->id));
            $Customer->appendChild($dom->createElement('AccountID',$x->user_id));
            $Customer->appendChild($dom->createElement('CustomerTaxID',$x->vat_number));
            $Customer->appendChild($dom->createElement('CompanyName',$x->name));
            $BillingAddress = $dom->createElement('BillingAddress');
            $Customer->appendChild($BillingAddress);
            $BillingAddress->appendChild($dom->createElement('AddressDetail',$x->address));
            $BillingAddress->appendChild($dom->createElement('City',$x->city));
            $BillingAddress->appendChild($dom->createElement('PostalCode',$x->postal_code));
            $BillingAddress->appendChild($dom->createElement('Country',$x->country));
            $Customer->appendChild($dom->createElement('SelfBillingIndicator',$x->self_billing_indicator));
        }
        /*if($checkbox=="month"){
            $dan_d['Product'] = DB::table('items')->join('invl_items','invl_items.item_id','=','items.id')->join('invoices','invoices.id','=','invl_items.invid')->where('user_id',$current_user)->where('invoices.status','!=','draft')->WhereMonth('invoices.created_at','=',$month)->WhereYear('invoices.created_at','=',$year)->select('items.id','items.code','items.description','items.code')->groupBy('items.id')->get();
        }
        else if($checkbox=="date"){
            $dan_d['Product'] = DB::table('items')->join('invl_items','invl_items.item_id','=','items.id')->join('invoices','invoices.id','=','invl_items.invid')->where('user_id',$current_user)->where('invoices.status','!=','draft')->WhereMonth('created_at','>=',$month_start_date)->WhereYear('created_at','>=',$year_start_date)
                ->WhereDay('created_at','>=',$day_start_date)->WhereMonth('created_at','<=',$month_end_date)->WhereYear('created_at','<=',$year_end_date)
                ->WhereDay('created_at','<=',$day_end_date)->get();
        }*/
        //$dan_d['Product'] = Items::all()->take(15);
        if($checkbox=="month"){
            $dan_d['Product'] = DB::select("SELECT Min(items.id) as id,items.code, min(items.type) as type, min(items.price) as price, min(items.description) as description, min(items.tax) as tax, min(items.unit) as unit from items join invl_items on invl_items.code=items.code join invoices on invoices.id=invl_items.invid where Month(invoices.created_at)='$month' and Year(invoices.created_at)='$year' and items.user_id='$current_user' and invoices.status!='draft' group by code");
        }
        else if($checkbox=="date"){
            $dan_d['Product'] = DB::table('items')->where('user_id',$current_user)->WhereMonth('created_at','>=',$month_start_date)->WhereYear('created_at','>=',$year_start_date)
                ->WhereDay('created_at','>=',$day_start_date)->WhereMonth('created_at','<=',$month_end_date)->WhereYear('created_at','<=',$year_end_date)
                ->WhereDay('created_at','<=',$day_end_date)->get();
        }
        foreach($dan_d['Product'] as $x)
        {
            $Product = $dom->createElement('Product');
            $MasterFiles->appendChild($Product);
            $Product->appendChild($dom->createElement('ProductType',$x->type));
            $Product->appendChild($dom->createElement('ProductCode',$x->code));
            $Product->appendChild($dom->createElement('ProductDescription',$x->description));
            $Product->appendChild($dom->createElement('ProductNumberCode',$x->code));
        }
        $TaxTable = $dom->createElement('TaxTable');
        $MasterFiles->appendChild($TaxTable);
        $TaxTableEntry = $dom->createElement('TaxTableEntry');
        $TaxTable->appendChild($TaxTableEntry);
        $TaxTableEntry->appendChild($dom->createElement('TaxType','IVA'));
        $TaxTableEntry->appendChild($dom->createElement('TaxCountryRegion','PT'));
        $TaxTableEntry->appendChild($dom->createElement('TaxCode','NOR'));
        $TaxTableEntry->appendChild($dom->createElement('Description','IVA23'));
        $TaxTableEntry->appendChild($dom->createElement('TaxPercentage','23.0'));
        if($checkbox=="month"){
            $dan_d['Invoices'] = DB::table('invoices')->where('uid',$current_user)->where('status','!=','draft')->WhereMonth('created_at','=',$month)->WhereYear('created_at','=',$year)->get();
        }
        else if($checkbox=="date"){
            $dan_d['Invoices'] = DB::table('invoices')->where('uid',$current_user)->where('status','!=','draft')->WhereMonth('created_at','>=',$month_start_date)->WhereYear('created_at','>=',$year_start_date)
                ->WhereDay('created_at','>=',$day_start_date)->WhereMonth('created_at','<=',$month_end_date)->WhereYear('created_at','<=',$year_end_date)
                ->WhereDay('created_at','<=',$day_end_date)->get();
        }
        //$dan_d['Invoices'] = Invoices::where('uid',$current_user)->get();
        $invoice_count =  $dan_d['Invoices']->count();
        $total_credit = 0;
        foreach($dan_d['Invoices'] as $tat)
        {
            $number = str_replace(' ', '', $tat->total_invoice_value);
            $number=str_replace(',','.',$number);
            $number = (float)$number;
            $total_credit = $total_credit  + $number;
        }
        Log::info($total_credit);
        $SalesInvoices->appendChild($dom->createElement('NumberOfEntries',$invoice_count));
        $SalesInvoices->appendChild($dom->createElement('TotalDebit','0.00'));
        $SalesInvoices->appendChild($dom->createElement('TotalCredit',$total_credit));
        if($invoice_count > 0)
        {
            foreach($dan_d['Invoices'] as $i)
            {
                $Invoice = $dom->createElement('Invoice');
                $SalesInvoices->appendChild($Invoice);
                if($i->is_receipt=="invoice"){
                    $status="FT";
                    $Invoice->appendChild($dom->createElement('InvoiceNo',$status." ".$i->serie."/".$i->id));
                }
                else if($i->is_receipt=="receipt"){
                    $status="FR";
                    $Invoice->appendChild($dom->createElement('InvoiceNo',$status." ".$i->serie."/".$i->id));
                }
                $Invoice->appendChild($dom->createElement('ATCUD',$i->atcud));

                $DocumentStatus = $dom->createElement('DocumentStatus');
                $Invoice->appendChild($DocumentStatus);
                if($i->status== 'final'){
                    $status='N';
                    $DocumentStatus->appendChild($dom->createElement('InvoiceStatus',$status));
                }
                else if($i->status == 'canceled'){
                    $status='A';
                    $DocumentStatus->appendChild($dom->createElement('InvoiceStatus',$status));
                }else if($i->status=='paid'){
                    $status='F';
                    $DocumentStatus->appendChild($dom->createElement('InvoiceStatus',$status));
                }

                $date=date('Y-m-d',strtotime($i->updated_at));
                $hour=date('H:m:s',strtotime($i->updated_at));
                $invoicestatusdate=$date.'T'.$hour;
                $DocumentStatus->appendChild($dom->createElement('InvoiceStatusDate',$invoicestatusdate));
                $DocumentStatus->appendChild($dom->createElement('SourceID',$i->sourceid));
                $DocumentStatus->appendChild($dom->createElement('SourceBilling',$i->source_billing));
                $Invoice->appendChild($dom->createElement('Hash',$i->hash));
                $Invoice->appendChild($dom->createElement('HashControl',$i->hash_control));
                $Invoice->appendChild($dom->createElement('InvoiceDate',date('Y-m-d',strtotime($i->created_at))));
                if($i->is_receipt=="receipt"){
                    $Invoice->appendChild($dom->createElement('InvoiceType',"FR"));
                }else{
                    $Invoice->appendChild($dom->createElement('InvoiceType',"FT"));
                }
                $SpecialRegimes = $dom->createElement('SpecialRegimes');
                $Invoice->appendChild($SpecialRegimes);

                $SpecialRegimes->appendChild($dom->createElement('SelfBillingIndicator',$i->self_billing_indicator));
                $SpecialRegimes->appendChild($dom->createElement('CashVATSchemeIndicator',$i->cash_vat_scheme_indicator));
                $SpecialRegimes->appendChild($dom->createElement('ThirdPartiesBillingIndicator',$i->third_parties_billing_indicator));
                $Invoice->appendChild($dom->createElement('SourceID',$i->sourceid));
                $date=date('Y-m-d');
                $hour=date('H:m:s');
                $SystemEntryDate=$date.'T'.$hour;
                $Invoice->appendChild($dom->createElement('SystemEntryDate',$SystemEntryDate));
                $Invoice->appendChild($dom->createElement('CustomerID',$i->cid));

                $line_items = LineItems::where('invid',$i->id)->get();
                if(count($line_items) > 0)
                {
                    $line_no = 1;
                    foreach( $line_items as $l)
                    {
                        $Line = $dom->createElement('Line');
                        $Invoice->appendChild($Line);
                        $Line->appendChild($dom->createElement('LineNumber',$line_no));
                        $Line->appendChild($dom->createElement('ProductCode',$l->code));
                        $Line->appendChild($dom->createElement('ProductDescription',$l->description));
                        $Line->appendChild($dom->createElement('Quantity',$l->qty));
                        $Itemss = Items::find($l->item_id);
                        $Line->appendChild($dom->createElement('UnitOfMeasure','service'));
                        $Line->appendChild($dom->createElement('UnitPrice',$l->unit_price));
                        $Line->appendChild($dom->createElement('TaxPointDate',date('Y-m-d',strtotime($l->created_at))));
                        $Line->appendChild($dom->createElement('Description',$l->description));
                        $Line->appendChild($dom->createElement('CreditAmount',$l->total));

                        $Tax = $dom->createElement('Tax');
                        $Line->appendChild($Tax);
                        $Tax->appendChild($dom->createElement('TaxType','IVA'));
                        $Tax->appendChild($dom->createElement('TaxCountryRegion','PT'));
                        $Tax->appendChild($dom->createElement('TaxCode','NOR'));
                        $Tax->appendChild($dom->createElement('TaxPercentage','23.0'));
                        $line_no++;
                        //$Line->appendChild($dom->createElement('TaxExemptionReason','N/A'));
                        //$Line->appendChild($dom->createElement('TaxExemptionCode','N/A'));
                    }
                }
                $number = str_replace(' ', '', $i->total_invoice_value);
                $gross_total=str_replace(',','.',$number);

                $number1 = str_replace(' ', '', $i->inv_subtotal);
                $NetTotal=str_replace(',','.',$number1);

                $number2 = str_replace(' ', '', $i->inv_vat);
                $TaxPayable=str_replace(',','.',$number2);

                $DocumentTotals = $dom->createElement('DocumentTotals');
                $Invoice->appendChild($DocumentTotals);
                $DocumentTotals->appendChild($dom->createElement('TaxPayable',$TaxPayable));
                $DocumentTotals->appendChild($dom->createElement('NetTotal',$NetTotal));
                $DocumentTotals->appendChild($dom->createElement('GrossTotal',$gross_total));
            }
        }
        
        $dom->saveXML();
        $dom->save(public_path().'/files/SAFT-PT.xml');
        if(isset($request->comminfrom)&& ($request->comminfrom == "command"))
        {
            return "generated";
        }else
        {
            return view('taxauthority.saft-download');
        }
    }
    public function saft(){
        return view('taxauthority.saft');
    }
    public function createChild(&$tag,&$dom,$var,$value)
    {
        $tag->appendChild($dom->createElement($var,$value));
    }

    public function billingalerts()
    {  if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
        {
           $billing = BillingAlllertC::all();
        }else{
            $billing = BillingAlllertC::where('uid',Auth::user()->id)->get();
        }

        return view('taxauthority.index_billing_alert',compact('billing'));
    }
    public function add_billing_alerts(){
        $uid=Auth::user()->id;
        $billing=Billing_Alerts::where('uid',Auth::user()->id)->get();
        if($billing->count()==0){
            Billing_Alerts::create([
                'uid' => $uid
            ]);
        }
        $billings=Billing_Alerts::where('uid',Auth::user()->id)->get();
        return view('taxauthority.billing_alerts',['billings'=>$billings]);
    }
    public function del_billing_alerts(Request $request){
        if(isset($request->cr_id) && !empty($request->cr_id))
        {
           $del =  BillingAlllertC::where('id',$request->cr_id)->delete();
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
    public function billingalertsbefore(Request $request){
        
        $email_subject=$request->input('subject_before');
        $email_message=$request->input('email_message_before');
        $send_me=$request->input('checkbox_send_me_before');
        $sms_message=$request->input('sms_message_before');
        $active_sms=$request->input('send_message_before');
        $active_email=$request->input('send_email_before');
        $days_before=$request->input('number_days_before');

        if(isset($send_me))
            $send_me=1;
        else
            $send_me=0;

        if(isset($active_sms) && isset($active_email)) {

            $active_sms = 1;
            $active_email = 1;
            if(isset($request->edit) && !empty($request->edit))
            {
                DB::table('billing_alllert_cs')->where('id',$request->edit)->update(array(
                    'uid'=>Auth::user()->id,
                    'email_subject_before'=>$email_subject,
                    'email_message_before'=>$email_message,
                    'send_me_email_before'=>$send_me,
                    'sms_message_before'=>$sms_message,
                    'days_before'=>$days_before,
                    'sms_before'=>$active_sms,
                    'is_before'=>'1',
                    'email_before'=>$active_email
                ));

                return redirect()->route('billing-alerts');
            }
            
            DB::table('billing_alerts')->where('uid',Auth::user()->id)->update(array(
                'email_subject_before'=>$email_subject,
                'email_message_before'=>$email_message,
                'send_me_email_before'=>$send_me,
                'sms_message_before'=>$sms_message,
                'days_before'=>$days_before,
                'sms_before'=>$active_sms,
                'is_before'=>'1',
                'email_before'=>$active_email
            ));
            
            $check = BillingAlllertC::where('days_before',$days_before)
            ->where('is_before',1)->where('uid',Auth::user()->id)->first();
            if(isset($check) && !empty($check))
            {
                DB::table('billing_alllert_cs')->where('days_before',$days_before)
                ->where('is_before',1)->where('uid',Auth::user()->id)->update(array(
                    'uid'=>Auth::user()->id,
                    'email_subject_before'=>$email_subject,
                    'email_message_before'=>$email_message,
                    'send_me_email_before'=>$send_me,
                    'sms_message_before'=>$sms_message,
                    'days_before'=>$days_before,
                    'sms_before'=>$active_sms,
                    'is_before'=>'1',
                    'email_before'=>$active_email
                ));
            }else
            {
                DB::table('billing_alllert_cs')->insert(array(
                    'uid'=>Auth::user()->id,
                    'email_subject_before'=>$email_subject,
                    'email_message_before'=>$email_message,
                    'send_me_email_before'=>$send_me,
                    'sms_message_before'=>$sms_message,
                    'days_before'=>$days_before,
                    'sms_before'=>$active_sms,
                    'is_before'=>'1',
                    'email_before'=>$active_email
                ));
            }
        

        }else if(isset($active_sms) && !isset($active_email)) {
            $active_sms = 1;
            $active_email = 0;
            if(isset($request->edit) && !empty($request->edit))
            {
                DB::table('billing_alllert_cs')->where('id',$request->edit)->update(array(
                    'uid'=>Auth::user()->id,
                    'send_me_email_before'=>$send_me,
                    'sms_message_before'=>$sms_message,
                    'days_before'=>$days_before,
                    'sms_before'=>$active_sms,
                    'is_before'=>'1',
                    'email_before'=>$active_email
                )); 

                return redirect()->route('billing-alerts');
            }
            DB::table('billing_alerts')->where('uid',Auth::user()->id)->update(array(
                'send_me_email_before'=>$send_me,
                'sms_message_before'=>$sms_message,
                'days_before'=>$days_before,
                'sms_before'=>$active_sms,
                'is_before'=>'1',
                'email_before'=>$active_email
            ));
            $check = BillingAlllertC::where('days_before',$days_before)
            ->where('is_before',1)->where('uid',Auth::user()->id)->first();

            if(isset($check) && !empty($check))
            {
                DB::table('billing_alllert_cs')->where('days_before',$days_before)
                ->where('is_before',1)->where('uid',Auth::user()->id)->update(array(
                    'uid'=>Auth::user()->id,
                    'send_me_email_before'=>$send_me,
                    'sms_message_before'=>$sms_message,
                    'days_before'=>$days_before,
                    'sms_before'=>$active_sms,
                    'is_before'=>'1',
                    'email_before'=>$active_email
                )); 
            }else{
                DB::table('billing_alllert_cs')->insert(array(
                    'uid'=>Auth::user()->id,
                    'send_me_email_before'=>$send_me,
                    'sms_message_before'=>$sms_message,
                    'days_before'=>$days_before,
                    'sms_before'=>$active_sms,
                    'is_before'=>'1',
                    'email_before'=>$active_email
                ));
            }

        }else if(!isset($active_sms) && isset($active_email)){
            $active_sms = 0;
            $active_email = 1;

            if(isset($request->edit) && !empty($request->edit))
            {
                DB::table('billing_alllert_cs')->where('id',$request->edit)->update(array(
                    'uid'=>Auth::user()->id,
                    'email_subject_before'=>$email_subject,
                    'email_message_before'=>$email_message,
                    'send_me_email_before'=>$send_me,
                    'days_before'=>$days_before,
                    'sms_before'=>$active_sms,
                    'is_before'=>'1',
                    'email_before'=>$active_email
                ));

                return redirect()->route('billing-alerts');
            }
            DB::table('billing_alerts')->where('uid',Auth::user()->id)->update(array(
                'email_subject_before'=>$email_subject,
                'email_message_before'=>$email_message,
                'send_me_email_before'=>$send_me,
                'days_before'=>$days_before,
                'sms_before'=>$active_sms,
                'is_before'=>'1',
                'email_before'=>$active_email
            ));
            
            $check = BillingAlllertC::where('days_before',$days_before)
            ->where('is_before',1)->where('uid',Auth::user()->id)->first();

            if(isset($check) && !empty($check))
            {
                DB::table('billing_alllert_cs')->where('days_before',$days_before)
                ->where('is_before',1)->where('uid',Auth::user()->id)->update(array(
                    'uid'=>Auth::user()->id,
                    'email_subject_before'=>$email_subject,
                    'email_message_before'=>$email_message,
                    'send_me_email_before'=>$send_me,
                    'days_before'=>$days_before,
                    'sms_before'=>$active_sms,
                    'is_before'=>'1',
                    'email_before'=>$active_email
                ));
            }
            else{
            DB::table('billing_alllert_cs')->insert(array(
                'uid'=>Auth::user()->id,
                'email_subject_before'=>$email_subject,
                'email_message_before'=>$email_message,
                'send_me_email_before'=>$send_me,
                'days_before'=>$days_before,
                'sms_before'=>$active_sms,
                'is_before'=>'1',
                'email_before'=>$active_email
            ));
        }

        }else if(!isset($active_sms) && !isset($active_email)){
            $active_sms = 0;
            $active_email = 0;
            DB::table('billing_alerts')->where('uid',Auth::user()->id)->update(array(
                'days_before'=>$days_before,
                'sms_before'=>$active_sms,
                'email_before'=>$active_email
            ));
        }
        return redirect()->route('billing-alerts');
        //return redirect()->back()->with('success', 'The information about Before Expire Date Alert has been saved!');
    }

    public function billingalertsafter(Request $request){
        
        $email_subject=$request->input('subject_after');
        $email_message=$request->input('email_message_after');
        $send_me=$request->input('checkbox_send_me_after');
        $sms_message=$request->input('sms_message_after');
        $active_sms=$request->input('send_message_after');
        $active_email=$request->input('send_email_after');
        $days_after=$request->input('number_days_after');

        if(isset($send_me))
            $send_me=1;
        else
            $send_me=0;

        if(isset($active_sms) && isset($active_email)) {

            $active_sms = 1;
            $active_email = 1;
            if(isset($request->edit) && !empty($request->edit))
            {
              
               $aaa = DB::table('billing_alllert_cs')->where('id',$request->edit)->update(array(
                    'email_subject_after'=>$email_subject,
                    'email_message_after'=>$email_message,
                    'send_me_email_after'=>$send_me,
                    'sms_message_after'=>$sms_message,
                    'days_after'=>$days_after,
                    'sms_after'=>$active_sms,
                    'uid'=>Auth::user()->id,
                    'is_before'=>'0',
                    'email_after'=>$active_email
                ));
                
                return redirect()->route('billing-alerts');
            }
            DB::table('billing_alerts')->where('uid',Auth::user()->id)->update(array(
                'email_subject_after'=>$email_subject,
                'email_message_after'=>$email_message,
                'send_me_email_after'=>$send_me,
                'sms_message_after'=>$sms_message,
                'days_after'=>$days_after,
                'sms_after'=>$active_sms,
                'is_before'=>'0',
                'email_after'=>$active_email
            ));

            $check = BillingAlllertC::where('days_after',$days_after)
            ->where('is_before','!=',1)->where('uid',Auth::user()->id)->first();
            if(isset($check) && !empty($check))
            {
                DB::table('billing_alllert_cs')->where('uid',Auth::user()->id)
                ->where('days_after',$days_after)
                ->where('is_before','!=',1)->update(array(
                    'email_subject_after'=>$email_subject,
                    'email_message_after'=>$email_message,
                    'send_me_email_after'=>$send_me,
                    'sms_message_after'=>$sms_message,
                    //'days_after'=>$days_after,
                    'sms_after'=>$active_sms,
                    //'uid'=>Auth::user()->id,
                    'is_before'=>'0',
                    'email_after'=>$active_email
                ));
            }
            else
            {
                DB::table('billing_alllert_cs')->insert(array(
                    'email_subject_after'=>$email_subject,
                    'email_message_after'=>$email_message,
                    'send_me_email_after'=>$send_me,
                    'sms_message_after'=>$sms_message,
                    'days_after'=>$days_after,
                    'sms_after'=>$active_sms,
                    'uid'=>Auth::user()->id,
                    'is_before'=>'0',
                    'email_after'=>$active_email
                ));
            }
        
        }else if(isset($active_sms) && !isset($active_email)) {
            $active_sms = 1;
            $active_email = 0;
            if(isset($request->edit) && !empty($request->edit))
            {
                DB::table('billing_alllert_cs')->where('id',$request->edit)->update(array(
                    'uid'=>Auth::user()->id,
                    'send_me_email_after'=>$send_me,
                    'sms_message_after'=>$sms_message,
                    'days_after'=>$days_after,
                    'sms_after'=>$active_sms,
                    'is_before'=>'0',
                    'email_after'=>$active_email
                ));
                return redirect()->route('billing-alerts');
            }
            DB::table('billing_alerts')->where('uid',Auth::user()->id)->update(array(
                'send_me_email_after'=>$send_me,
                'sms_message_after'=>$sms_message,
                'days_after'=>$days_after,
                'sms_after'=>$active_sms,
                'is_before'=>'0',
                'email_after'=>$active_email
            ));
            $check = BillingAlllertC::where('days_after',$days_after)
            ->where('is_before','!=',1)->where('uid',Auth::user()->id)->first();
            if(isset($check) && !empty($check))
            {

                DB::table('billing_alllert_cs')->where('uid',Auth::user()->id)
                ->where('days_after',$days_after)
                ->where('is_before','!=',1)->update(array(
                    'uid'=>Auth::user()->id,
                    'send_me_email_after'=>$send_me,
                    'sms_message_after'=>$sms_message,
                    'days_after'=>$days_after,
                    'sms_after'=>$active_sms,
                    'is_before'=>'0',
                    'email_after'=>$active_email
                ));
                
            }else{
            DB::table('billing_alllert_cs')->insert(array(
                'uid'=>Auth::user()->id,
                'send_me_email_after'=>$send_me,
                'sms_message_after'=>$sms_message,
                'days_after'=>$days_after,
                'sms_after'=>$active_sms,
                'is_before'=>'0',
                'email_after'=>$active_email
            ));
        }
        }else if(!isset($active_sms) && isset($active_email)){
            $active_sms = 0;
            $active_email = 1;
            
            if(isset($request->edit) && !empty($request->edit))
            {
                DB::table('billing_alllert_cs')->where('id',$request->edit)->update(array(
                      'uid'=>Auth::user()->id,
                      'email_subject_after'=>$email_subject,
                      'email_message_after'=>$email_message,
                      'send_me_email_after'=>$send_me,
                      'days_after'=>$days_after,
                      'sms_after'=>$active_sms,
                      'is_before'=>'0',
                      'email_after'=>$active_email
                ));
                return redirect()->route('billing-alerts');
            }

            DB::table('billing_alerts')->where('uid',Auth::user()->id)->update(array(
                'email_subject_after'=>$email_subject,
                'email_message_after'=>$email_message,
                'send_me_email_after'=>$send_me,
                'days_after'=>$days_after,
                'sms_after'=>$active_sms,
                'is_before'=>'0',
                'email_after'=>$active_email
            ));
            $check = BillingAlllertC::where('days_after',$days_after)
            ->where('is_before','!=',1)->where('uid',Auth::user()->id)->first();
            if(isset($check) && !empty($check))
            {
                DB::table('billing_alllert_cs')->where('uid',Auth::user()->id)
                ->where('days_after',$days_after)
                ->where('is_before','!=',1)->update(array(
                    'uid'=>Auth::user()->id,
                    'email_subject_after'=>$email_subject,
                    'email_message_after'=>$email_message,
                    'send_me_email_after'=>$send_me,
                    'days_after'=>$days_after,
                    'sms_after'=>$active_sms,
                    'is_before'=>'0',
                    'email_after'=>$active_email
                ));
            }else{
                DB::table('billing_alllert_cs')->insert(array(
                    'uid'=>Auth::user()->id,
                    'email_subject_after'=>$email_subject,
                    'email_message_after'=>$email_message,
                    'send_me_email_after'=>$send_me,
                    'days_after'=>$days_after,
                    'sms_after'=>$active_sms,
                    'is_before'=>'0',
                    'email_after'=>$active_email
                ));
            }
            
        }else if(!isset($active_sms) && !isset($active_email)){
            $active_sms = 0;
            $active_email = 0;
            DB::table('billing_alerts')->where('uid',Auth::user()->id)->update(array(
                'days_after'=>$days_after,
                'sms_after'=>$active_sms,
                'email_after'=>$active_email
            ));
        }
        return redirect()->route('billing-alerts');
        // return redirect()->back()->with('success', 'The information about After Expire Date Alert has been saved!');
    }

    public function edit_billing_alerts(Request $request)
    {
        
       $billings =  BillingAlllertC::where('id',$request->id)->get();
       if(isset($billings) && !empty($billings) && count($billings) > 0)
       {
           return view('taxauthority.edit_billing_alerts',compact('billings'));
       }else{
        return redirect()->route('billing-alerts.edit');
       }

    }
    public function store_edit_billing_alerts()
    {

    }
    public function saft_scheduling(Request $request){
        $user = User::find($request->uid);
        if(isset($request->check_schedule) && !empty($request->check_schedule == "on"))
        {
            $user->saft_schedule =1;
            $user->save();
            return redirect()->back()->with('success','Email scheduling activated!');
        }else
        {
            $user->saft_schedule =0;
            $user->save();
            return redirect()->back()->with('success','Email scheduling deactivated!');
        }
        
    }
}

