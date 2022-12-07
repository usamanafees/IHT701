<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Invoices; 
use App\Clients;
use App\LineItems;
use App\Items;
use App\Countries;
use App\Brands;
use App\User;
use App\BrandsTemplate;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
class InvoicesController extends Controller {
    /** 
     * Get Invoices api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function getInvoices(){
        $invoices = Invoices::with('LineItems')->get();
        if($invoices){
            return response()->json(['message'=>'success','result'=>array($invoices)], 200); 
        }else{
            return response()->json(['message'=>'error','result'=>array('Invoices not found')], 200); 
        }
    }
     /** 
     * Get Invoice api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function getInvoice(Request $request, $id){
        $invoice = Invoices::with('LineItems')->find($id);
        if($invoice){
            return response()->json(['message'=>'success','result'=>array($invoice)], 200);
        }
        return response()->json(['message'=>'error','result'=>array('Invoice not found')], 200);
    }

    /** 
     * Add Invoice api 
     * 
     * @return \Illuminate\Http\Response 
     */
    // public function addInvoice(Request $request){
    //     $request->validate($this->getAddInvoiceRules());
    //     $updated_request = array_merge($request->all(), array('uid' => Auth::id()));
    //     $invoice = Invoices::create($updated_request);
    //     return response()->json(['message'=>'success','result'=>array($invoice)], 201);
    // }
    /** 
     * Update Invoice api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function updateInvoice(Request $request, $id){
        // return response()->json($request->all());
        $invoice = Invoices::find($id);
        if($invoice){
            $request->validate($this->getUpdateInvoiceRules());

            $lineitems = json_decode($request->lineitems , true);
            // return response()->json($request->lineitems);
            if(!$lineitems){
                return response()->json(['message'=>'error','result'=>array('lineItems is not a valid json')], 200);
            }

            //validate if lineitems are set of array
            if(!$this->look_for_array($lineitems)){
                return response()->json(['message'=>'error','result'=>array('lineItems is not in valid format')], 200);
            }

            // validate lineitems
            foreach($lineitems as $linitem){
                $request_linitem = new Request($linitem);
                $request_linitem->validate($this->addLineItemRules());
            }

            $updated_request = array_merge($request->all(), array('uid' => Auth::id()));
            $invoice->update($updated_request);
            $invid = $invoice->id;

            $created_line_item = array();
            LineItems::where('invid',$id)->delete();
            foreach($lineitems as $linitem){
                $request_linitem = new Request($linitem);
                $item = $this->CheckExistenceOrCreateItem($linitem);
                $created_line_item [] = $this->saveLineItem($item, array_merge($linitem, array('invid'=>$invid)));
            }

            // return response()->json(['message'=>'success','result'=>array($invoice)], 200);
            return response()->json(['message'=>'success','result'=>array('invoice'=>$invoice,'lineitems'=>$created_line_item)], 200);
        }
        return response()->json(['message'=>'error','result'=>array('Invoice not found')], 200);
    }

     /** 
     * Delete Invoice api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function deleteInvoice(Request $request, $id){
        $delete_related_lineitems = (isset($request->all()['delete_invoices']) && $request->all()['delete_invoices']=='true') ? true : false;
        $invoice = Invoices::find($id);
        if($invoice){
            if($delete_related_lineitems){
                LineItems::where('invid', $invoice->id)->delete();
            }
            $invoice->delete();
            return response()->json(['message'=>'success','result'=>array('Invoice deleted')], 200);
        }
        return response()->json(['message'=>'error','result'=>array('Invalid Id')], 200);
    }
         /** 
     * Add Invoice with line items api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function addInvoice(Request $request){
        $userObj = User::find($request->accountid);
        // if(isset($request->inv_date)){
        //     $dateObj = Carbon::parse($request->invoice_date);
        //     $request->request->add(['inv_date' => $dateObj->toDateTimeString()]);
        // }
        //validate invoice
        $request->validate($this->getAddInvoiceWithLineItemsRules());

        //validate if lineitems are valid json
        $lineitems = json_decode($request->lineitems , true);
        // return response()->json($request->lineitems);
        if(!$lineitems){
            return response()->json(['message'=>'error','result'=>array('lineItems is not a valid json')], 200);
        }

        //validate if lineitems are set of array
        if(!$this->look_for_array($lineitems)){
            return response()->json(['message'=>'error','result'=>array('lineItems is not in valid format')], 200);
        }

        // validate lineitems
        foreach($lineitems as $linitem){
            $request_linitem = new Request($linitem);
            $request_linitem->validate($this->addLineItemRules());
        }
        $updated_request = array_merge($request->all(), array('uid' => $userObj->id));
        $invoice = Invoices::create($updated_request);
        $invid = $invoice->id;
        $created_line_item = array();
        foreach($lineitems as $linitem){
            $item = $this->CheckExistenceOrCreateItem($linitem);
            $created_line_item [] = $this->saveLineItem($item, array_merge($linitem, array('invid'=>$invid)));
        }

        //Strting Work for final data
        $lnItem = $created_line_item;
        $SubTotal = 0; $Discount = 0; $Vat = 0; $Total = 0; $line_item_discount_calc = 0;
        foreach($lnItem as $linitem){
                
                $line_item_vat = floatval($linitem['vat']);
                $line_item_discount = floatval($linitem['discount']); 
                $line_item_total = $linitem['qty'] * $linitem['unit_price'];

                if(is_nan($line_item_total)){$line_item_total = 0;}
                if(is_nan($line_item_discount)){$line_item_discount = 0;}
                if(is_nan($line_item_vat)){$line_item_vat = 0;}

                $SubTotal = floatval($SubTotal) +  floatval($line_item_total);
                $Discount = floatval($Discount) +  ($line_item_total * ($line_item_discount / 100));
                $line_item_discount_calc = ($line_item_total * ($line_item_discount / 100));
                $line_item_vat_calc = ($line_item_total * ($line_item_vat / 100));
                
                $Vat = floatval($Vat) + (($line_item_total - $line_item_discount_calc) * ($line_item_vat / 100)); 
            }

            $Total = floatval($SubTotal) - floatval($Discount) + floatval($Vat);
            $invoice = Invoices::find($invid);
            $invoice->total_invoice_value = $Total;
            $invoice->update();

             return response()->json(['message'=>'success','result'=>array('invoice'=>$invoice,'lineitems'=>$created_line_item)], 200);
    }


    public function CheckExistenceOrCreateItem($request){
        $item = Items::where('code', '=', $request['code'])->first();
        if($item){
            return $item;
        }else{
            $request['price'] = $request['unit_price'];
            $item = Items::create($request);
            return $item;
        }
    }
    public function saveLineItem($item,$request){
        $total = 0;
        $lineItem = new LineItems();
        $qty = (isset($request['qty']) && !empty($request['qty'])) ? $request['qty'] : 1;
        $vat = (isset($request['vat']) && !empty($request['vat'])) ? $request['vat'] : 0;
        $discount = (isset($request['discount']) && !empty($request['discount'])) ? $request['discount'] : 0;
        $unit_price = (isset($request['unit_price']) && !empty($request['unit_price'])) ? $request['unit_price'] : $item->price;
        if(preg_match("/^[0-9,]+$/", $unit_price)){
            $unit_price = (int) str_replace(',', '', $unit_price);
        }
        $total = $qty * $unit_price;
        $data = array(
            'discount' => $discount,
            'invid' => $request['invid'],
            'unit_price' => $unit_price,
            'qty' => $qty,
            'vat' => $vat,
            'total' => $total,
            'code' => $item->code,
            'description' => $item->description,
        );
        return LineItems::create($data);
    }
    public function look_for_array($test_var) {
        if(!is_array($test_var)){
            return false;
        }
        foreach ($test_var as $key => $el) {
          if (is_array($el)) {
            return true;
          }
        }
        return false;
      }

    public function getClientsCode(){
        $clients = Clients::All();
        $codes = '';
        foreach($clients as $client){
            $codes .= $client->id.', ';
        }
        return $codes;
    }
    public function getBrandCode(){
        $brands = Brands::All();
        $codes = '';
        foreach($brands as $brand){
            $codes .= $brand->id.', ';
        }
        return $codes;
    }
    public function getTemplateCode(){
        $templates = BrandsTemplate::All();
        $codes = '';
        foreach($templates as $template){
            $codes .= $template->id.', ';
        }
        return $codes;
    }
    
    public function getAddInvoiceRules(){
        return array(
            'inv_date' => 'date_format:Y-m-d H:i:s', 
            'remarks' => 'required', 
            'due' => 'required|in:15,30,45,90,Other', 
            'po' => 'required|numeric',
            'sequence' => 'required|in:A',
            'retention' => 'required|numeric',
            'currency' => 'required|in:USD_$,GBP_£,CAD_C$,AUD_A$,ZAR_R,AFN_؋,ALL_L,DZD_د.ج,AOA_Kz,ARS_$,AMD_դր.,AWG_ƒ,AZN_¤,BSD_$,BHD_ب.د,BDT_¤,BBD_$,BYR_Br,BZD_$,BMD_$,BTN_¤,BOB_Bs.,BAM_KM,BWP_P,BRL_R$,BND_$,BGN_лв,BIF_Fr,KHR_¤,CVE_Esc,KYD_$,XAF_Fr,XPF_Fr,CLP_$,CNY_¥,COP_$,KMF_Fr,CDF_Fr,CRC_₡,HRK_kn,CUC_$,CUP_$,CZK_Kč,DKK_kr.,DJF_Fr,DOP_$,XCD_$,EGP_ج.م,ERN_Nfk,EEK_KR,ETB_¤,FKP_£,FJD_$,GMD_D,GEL_ლ,GHS_₵,GIP_£,GTQ_Q,GNF_Fr,GYD_$,HTG_G,HNL_L,HKD_$,HUF_Ft,ISK_kr,INR_Rs,IDR_Rp,IRR_﷼,IQD_ع.د,ILS_₪,JMD_$,JPY_¥,JOD_د.ا,KZT_〒,KES_Sh,KWD_د.ك,KGS_¤,LAK_₭,LVL_Ls,LBP_ل.ل,LSL_L,LRD_$,LYD_ل.د,LTL_Lt,MOP_P,MKD_ден,MGA_¤,MWK_MK,MYR_RM,MVR_Rf,MRO_UM,MUR_₨,MXN_$,MDL_L,MNT_₮,MAD_MAD,MZN_MZN,MMK_K,NAD_$,NPR_₨,ANG_ƒ,TWD_$,NZD_$,NIO_C$,NGN_₦,KPW_₩,NOK_kr,OMR_ر.ع.,PKR_₨,PAB_B/.,PGK_K,PYG_₲,PEN_S/.,PHP_₱,PLN_zł,QAR_ر.ق,RON_L,RUB_р.,RWF_Fr,SHP_£,SVC_₡,WST_T,STD_Db,SAR_ر.س,RSD_дин.,SCR_₨,SLL_Le,SGD_$,SBD_$,SOS_Sh,KRW_₩,LKR_Rs,SDG_£,SRD_$,SZL_L,SEK_kr,CHF_Fr,SYP_ل.س,TJS_ЅМ,TZS_Sh,THB_฿,TOP_T$,TTD_$,TND_د.ت,TRY_TL,TMM_m,UGX_Sh,UAH_₴,AED_د.إ,UYU_$,UZS_¤,VUV_Vt,VEF_BsFVND_₫,XOF_Fr,YER_﷼,ZMK_ZK,ZWR_$,XDR_SDR,TMT_m,VEB_Bs',
            'tax_exemption_reason' => 'required|in:M09,M08,M07,M06,M05,M04,M03,M02,M01,M16,M15,M14,M13,M12,M11,M10,M99,',
            'cid' => 'required|numeric|in:'.$this->getClientsCode(),
        );
    }
    public function getAddInvoiceWithLineItemsRules(){
        return array(
            'inv_date' => 'date_format:Y-m-d H:i:s', 
            'remarks' => '', 
            'due' => 'in:15,30,45,90,Other', 
            'po' => 'numeric',
            'sequence' => 'in:A',
            'retention' => 'numeric',
            'currency' => 'required|in:USD_$,GBP_£,CAD_C$,AUD_A$,ZAR_R,AFN_؋,ALL_L,DZD_د.ج,AOA_Kz,ARS_$,AMD_դր.,AWG_ƒ,AZN_¤,BSD_$,BHD_ب.د,BDT_¤,BBD_$,BYR_Br,BZD_$,BMD_$,BTN_¤,BOB_Bs.,BAM_KM,BWP_P,BRL_R$,BND_$,BGN_лв,BIF_Fr,KHR_¤,CVE_Esc,KYD_$,XAF_Fr,XPF_Fr,CLP_$,CNY_¥,COP_$,KMF_Fr,CDF_Fr,CRC_₡,HRK_kn,CUC_$,CUP_$,CZK_Kč,DKK_kr.,DJF_Fr,DOP_$,XCD_$,EGP_ج.م,ERN_Nfk,EEK_KR,ETB_¤,FKP_£,FJD_$,GMD_D,GEL_ლ,GHS_₵,GIP_£,GTQ_Q,GNF_Fr,GYD_$,HTG_G,HNL_L,HKD_$,HUF_Ft,ISK_kr,INR_Rs,IDR_Rp,IRR_﷼,IQD_ع.د,ILS_₪,JMD_$,JPY_¥,JOD_د.ا,KZT_〒,KES_Sh,KWD_د.ك,KGS_¤,LAK_₭,LVL_Ls,LBP_ل.ل,LSL_L,LRD_$,LYD_ل.د,LTL_Lt,MOP_P,MKD_ден,MGA_¤,MWK_MK,MYR_RM,MVR_Rf,MRO_UM,MUR_₨,MXN_$,MDL_L,MNT_₮,MAD_MAD,MZN_MZN,MMK_K,NAD_$,NPR_₨,ANG_ƒ,TWD_$,NZD_$,NIO_C$,NGN_₦,KPW_₩,NOK_kr,OMR_ر.ع.,PKR_₨,PAB_B/.,PGK_K,PYG_₲,PEN_S/.,PHP_₱,PLN_zł,QAR_ر.ق,RON_L,RUB_р.,RWF_Fr,SHP_£,SVC_₡,WST_T,STD_Db,SAR_ر.س,RSD_дин.,SCR_₨,SLL_Le,SGD_$,SBD_$,SOS_Sh,KRW_₩,LKR_Rs,SDG_£,SRD_$,SZL_L,SEK_kr,CHF_Fr,SYP_ل.س,TJS_ЅМ,TZS_Sh,THB_฿,TOP_T$,TTD_$,TND_د.ت,TRY_TL,TMM_m,UGX_Sh,UAH_₴,AED_د.إ,UYU_$,UZS_¤,VUV_Vt,VEF_BsFVND_₫,XOF_Fr,YER_﷼,ZMK_ZK,ZWR_$,XDR_SDR,TMT_m,VEB_Bs,EUR_€',
            'tax_exemption_reason' => 'in:M09,M08,M07,M06,M05,M04,M03,M02,M01,M16,M15,M14,M13,M12,M11,M10,M99,',
            'cid' => 'required|numeric|in:'.$this->getClientsCode(),
            'brand_templates_id ' => 'in:'.$this->getTemplateCode(),
            'lineitems'=>'required'
        );
    }
    public function getUpdateInvoiceRules(){
        return array( 
            'inv_date' => 'date_format:Y-m-d H:i:s',
            'due' => 'in:15,30,45,90,Other', 
            'po' => 'numeric',
            'sequence' => 'in:A',
            'retention' => 'numeric',
            'currency' => 'in:USD_$,GBP_£,CAD_C$,AUD_A$,ZAR_R,AFN_؋,ALL_L,DZD_د.ج,AOA_Kz,ARS_$,AMD_դր.,AWG_ƒ,AZN_¤,BSD_$,BHD_ب.د,BDT_¤,BBD_$,BYR_Br,BZD_$,BMD_$,BTN_¤,BOB_Bs.,BAM_KM,BWP_P,BRL_R$,BND_$,BGN_лв,BIF_Fr,KHR_¤,CVE_Esc,KYD_$,XAF_Fr,XPF_Fr,CLP_$,CNY_¥,COP_$,KMF_Fr,CDF_Fr,CRC_₡,HRK_kn,CUC_$,CUP_$,CZK_Kč,DKK_kr.,DJF_Fr,DOP_$,XCD_$,EGP_ج.م,ERN_Nfk,EEK_KR,ETB_¤,FKP_£,FJD_$,GMD_D,GEL_ლ,GHS_₵,GIP_£,GTQ_Q,GNF_Fr,GYD_$,HTG_G,HNL_L,HKD_$,HUF_Ft,ISK_kr,INR_Rs,IDR_Rp,IRR_﷼,IQD_ع.د,ILS_₪,JMD_$,JPY_¥,JOD_د.ا,KZT_〒,KES_Sh,KWD_د.ك,KGS_¤,LAK_₭,LVL_Ls,LBP_ل.ل,LSL_L,LRD_$,LYD_ل.د,LTL_Lt,MOP_P,MKD_ден,MGA_¤,MWK_MK,MYR_RM,MVR_Rf,MRO_UM,MUR_₨,MXN_$,MDL_L,MNT_₮,MAD_MAD,MZN_MZN,MMK_K,NAD_$,NPR_₨,ANG_ƒ,TWD_$,NZD_$,NIO_C$,NGN_₦,KPW_₩,NOK_kr,OMR_ر.ع.,PKR_₨,PAB_B/.,PGK_K,PYG_₲,PEN_S/.,PHP_₱,PLN_zł,QAR_ر.ق,RON_L,RUB_р.,RWF_Fr,SHP_£,SVC_₡,WST_T,STD_Db,SAR_ر.س,RSD_дин.,SCR_₨,SLL_Le,SGD_$,SBD_$,SOS_Sh,KRW_₩,LKR_Rs,SDG_£,SRD_$,SZL_L,SEK_kr,CHF_Fr,SYP_ل.س,TJS_ЅМ,TZS_Sh,THB_฿,TOP_T$,TTD_$,TND_د.ت,TRY_TL,TMM_m,UGX_Sh,UAH_₴,AED_د.إ,UYU_$,UZS_¤,VUV_Vt,VEF_BsFVND_₫,XOF_Fr,YER_﷼,ZMK_ZK,ZWR_$,XDR_SDR,TMT_m,VEB_Bs,EUR_€',
            'tax_exemption_reason' => 'in:M09,M08,M07,M06,M05,M04,M03,M02,M01,M16,M15,M14,M13,M12,M11,M10,M99,',
            'cid' => 'numeric|in:'.$this->getClientsCode(),
            'lineitems'=>'required'

        );
    }
    public function addLineItemRules(){
        return array(
            'code' => 'required',
            'unit_price' => 'required|numeric', 
            'qty' => 'numeric',
            'vat' => 'in:23,18,22,0',
            'discount' => 'numeric',
        );
    }
    
}