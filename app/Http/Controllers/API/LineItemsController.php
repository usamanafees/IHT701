<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\LineItems;
use App\Items; 
use App\Invoices; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class LineItemsController extends Controller {
     /** 
     * Add Item api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function addLineItem(Request $request){
        $request->validate($this->addLineItemRules());
        $item = Items::where('code', '=', $request['code'])->first();
        //calculations and comparisions to make line item request
        return response()->json(['message'=>'success','result'=>array($this->saveLineItem($item,$request->all()))], 201);
    }
    /** 
     * Get Items api 
     * 
     * @return \Illuminate\Http\Response 
     */
    
    public function getLineItems(){
        $lineitems = LineItems::all();
        if($lineitems){
            return response()->json(['message'=>'success','result'=>array($lineitems)], 200); 
        }else{
            return response()->json(['message'=>'error','result'=>array('Line Items not found')], 200); 
        }
    }
    /** 
     * Get Line Item api 
     * 
     * @return \Illuminate\Http\Response 
     */
    
    public function getLineItem(Request $request, $id){
        $lineitem = LineItems::find($id);
        if($lineitem){
            return response()->json(['message'=>'success','result'=>array($lineitem)], 200);
        }
        return response()->json(['message'=>'error','result'=>array('Line Item not found')], 200);
    }


    /** 
     * Update Line Item api 
     * 
     * @return \Illuminate\Http\Response 
     */
    
    public function updateLineItem(Request $request, $id){
        $lineitem = LineItems::find($id);
        if($lineitem){
            $request->validate($this->updateLineItemRules());
            $lineitem->update($request->all());
            return response()->json(['message'=>'success','result'=>array($lineitem)], 200);
        }
        return response()->json(['message'=>'error','result'=>array('Line Item not found')], 200);
    }
    /** 
     * Delete Line Item api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function deleteLineItem(Request $request, $id){
        $lineitem = LineItems::find($id);
        if($lineitem){
            $lineitem->delete();
            return response()->json(['message'=>'success','result'=>array('Line Item deleted')], 200);
        }
        return response()->json(['message'=>'error','result'=>array('Invalid Id')], 200);
    }

    public function getItemsCodes(){
        $Items = Items::All();
        $codes = '';
        foreach($Items as $Item){
            $codes .= $Item->code.', ';
        }
        return $codes;
    }
    public function getInvoiceIds(){
        $Invoices = Invoices::All();
        $codes = '';
        foreach($Invoices as $Invoice){
            $codes .= $Invoice->id.', ';
        }
        return $codes;
    }
    public function addLineItemRules(){
        return array(
            'code' => 'required|in:'.$this->getItemsCodes(),
            'invid' => 'numeric|required|in:'.$this->getInvoiceIds(), 
            'unit_price' => 'numeric', 
            'qty' => 'numeric',
            'vat' => 'required|in:23,18,22,0',
            'discount' => 'required|numeric',
        );
    }
    public function updateLineItemRules(){
        return array(
            'code' => 'in:'.$this->getItemsCodes(),
            'invid' => 'numeric|in:'.$this->getInvoiceIds(), 
            'unit_price' => 'numeric', 
            'qty' => 'numeric',
            'vat' => 'in:23,18,22,0',
            'discount' => 'numeric',
        );
    }
    public function saveLineItem($item,$request){
        $total = 0;
        $lineItem = new LineItems();
        $qty = (isset($request['qty']) && !empty($request['qty'])) ? $request['qty'] : 1;
        $unit_price = (isset($request['unit_price']) && !empty($request['unit_price'])) ? $request['unit_price'] : $item->price;
        if(preg_match("/^[0-9,]+$/", $unit_price)){
            $unit_price = (int) str_replace(',', '', $unit_price);
        }
        $total = $qty * $unit_price;
        $data = array(
            'discount' => $request['discount'],
            'invid' => $request['invid'],
            'unit_price' => $unit_price,
            'qty' => $qty,
            'vat' => $request['vat'],
            'total' => $total,
            'code' => $item->code,
            'description' => $item->description,
        );
        return LineItems::create($data);
    }
}