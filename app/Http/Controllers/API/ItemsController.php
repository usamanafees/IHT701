<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Items; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class ItemsController extends Controller {
     /** 
     * Add Item api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function addItem(Request $request){
			if(isset($request->code) && isset($request->price) && isset($request->tax) && !isset($request->rrp)){
				$request->request->add(['rrp' => $request->price + $request->tax]);
			}elseif(isset($request->code) && isset($request->rrp) && isset($request->tax) && !isset($request->price)){
				$request->request->add(['price' => $request->rrp - $request->tax]);
			}
			else{
				$this->validate($request, [
				'code' => 'required|unique:items', 
				'rrp' => 'numeric|required', 
				'price' => 'numeric|required', 
			],[
				'code.required' => 'Code field is required',
				'rrp.required' => 'RRP is required if you do not provide Price & Tax',
				'price.required' => 'Price is required if you do not provide RRP & Tax',
			]);
		}
        $item = Items::create($request->all());
        return response()->json(['message'=>'success','result'=>array($item)], 201);
    }
    /** 
     * Get Items api 
     * 
     * @return \Illuminate\Http\Response 
     */
    
    public function getItems(){
        $items = Items::all();
        if($items){
            return response()->json(['message'=>'success','result'=>array($items)], 200); 
        }else{
            return response()->json(['message'=>'error','result'=>array('Items not found')], 200); 
        }
    }
    /** 
     * Get Item api 
     * 
     * @return \Illuminate\Http\Response 
     */
    
    public function getItem(Request $request, $id){
        $item = Items::find($id);
        if($item){
            return response()->json(['message'=>'success','result'=>array($item)], 200);
        }
        return response()->json(['message'=>'error','result'=>array('Item not found')], 200);
    }
     /** 
     * Get Item by Code api 
     * 
     * @return \Illuminate\Http\Response 
     */
    
    public function getItemByCode(Request $request, $code){
        $item = Items::where('code', $code)->first();
        if($item){
            return response()->json(['message'=>'success','result'=>array($item)], 200);
        }
        return response()->json(['message'=>'error','result'=>array('Item with code '.$code.' not found')], 200);
    }
    /** 
     * Update Item api 
     * 
     * @return \Illuminate\Http\Response 
     */
    
    public function updateItem(Request $request, $id){
        $item = Items::find($id);
        if($item){
            $request->validate($this->updateItemsRules());
            $item->update($request->all());
            return response()->json(['message'=>'success','result'=>array($item)], 200);
        }
        return response()->json(['message'=>'error','result'=>array('Item not found')], 200);
    }
    /** 
     * Delete Item api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function deleteItem(Request $request, $id){
        $item = Items::find($id);
        if($item){
            $item->delete();
            return response()->json(['message'=>'success','result'=>array('Item deleted')], 200);
        }
        return response()->json(['message'=>'error','result'=>array('Invalid Id')], 200);
    }

    public function addItemsRules(){
        return array(
            'code' => 'required|unique:items', 
            'rrp' => 'numeric|required', 
            'price' => 'numeric|required', 
            // 'description' => 'required',
            // 'tax' => 'required|in:23,18,22,0',
            // 'unit' => 'required|in:Hour,Day,Unit,Service,Other',
        );
    }
    public function updateItemsRules(){
        return array(
            'code' => 'unique:items', 
            'rrp' => 'numeric', 
            'price' => 'numeric',
            'tax' => 'in:23,18,22,0',
            'unit' => 'in:Hour,Day,Unit,Service,Other',
        );
    }
}