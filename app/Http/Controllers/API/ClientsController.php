<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Clients; 
use App\Countries;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class ClientsController extends Controller {
    /** 
     * Get Clients api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function getClients(){
        $clients = Clients::all();
        if($clients){
            return response()->json(['message'=>'success','result'=>array($clients)], 200); 
        }else{
            return response()->json(['message'=>'error','result'=>array('Clients not found')], 200); 
        }
    }
    /** 
     * Get Client api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function getClient(Request $request, $id){
        $client = Clients::find($id);
        if($client){
            return response()->json(['message'=>'success','result'=>array($client)], 200);
        }
        return response()->json(['message'=>'error','result'=>array('Client not found')], 200);
    }

    /** 
     * Add Client api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function addClient(Request $request){
        $request->validate($this->getAddClientRules());
        $client = Clients::create($request->all());
        return response()->json(['message'=>'success','result'=>array($client)], 201);
    }
    /** 
     * Update Client api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function updateClient(Request $request, $id){
        $client = Clients::find($id);
        if($client){
            $request->validate($this->getUpdateClientRules());
            $client->update($request->all());
            return response()->json(['message'=>'success','result'=>array($client)], 200);
        }
        return response()->json(['message'=>'error','result'=>array('Client not found')], 200);
    }

     /** 
     * Delete Client api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function deleteClient(Request $request, $id){
        $client = Clients::find($id);
        if($client){
            $client->delete();
            return response()->json(['message'=>'success','result'=>array('Client deleted')], 200);
        }
        return response()->json(['message'=>'error','result'=>array('Invalid Id')], 200);
    }

    public function getCountriesCode(){
        $countries = Countries::All();
        $codes = '';
        foreach($countries as $country){
            $codes .= $country->isd_code.', ';

        }
        return $codes;
    }
    public function getCountries(){
        $countries = Countries::All();
        $codes = '';
        foreach($countries as $country){
            $codes .= $country->iso_code.', ';

        }
        return $codes;
    }
    public function getAddClientRules(){
        return array(
            'name' => 'required', 
            'email' => 'email|unique:clients', 
            // 'vat_number' => 'required', 
            // 'main_url' => 'required|url',
            // 'code' => 'required|numeric',
            // 'postal_code' => 'required|numeric',
            // 'address' => 'required',
            // 'city' => 'required',
            // 'telephone_Code' => 'required|numeric|in:'.$this->getCountriesCode(),
            // 'telephone' => 'required|numeric',
            // 'mobile_Code' => 'required|numeric|in:'.$this->getCountriesCode(),
            // 'mobile' => 'required|numeric',
            // 'primary_telephone_code' => 'required|numeric|in:'.$this->getCountriesCode(),
            // 'primary_telephone' => 'required|numeric',
            // 'primary_email' => 'email',
            // 'country' => 'in:'.$this->getCountries()
        );
    }
    public function getUpdateClientRules(){
        return array( 
            'email' => 'email|unique:clients',
            // 'main_url' => 'url',
            // 'code' => 'numeric',
            // 'postal_code' => 'numeric',
            // 'telephone_Code' => 'numeric|in:'.$this->getCountriesCode(),
            // 'telephone' => 'required_with:telephone_Code|numeric',
            // 'mobile_Code' => 'numeric|in:'.$this->getCountriesCode(),
            // 'mobile' => 'required_with:mobile_Code|numeric',
            // 'primary_telephone_code' => 'numeric|in:'.$this->getCountriesCode(),
            // 'primary_telephone' => 'required_with:primary_telephone_code|numeric',
            // 'primary_email' => 'email',
            // 'country' => 'in:'.$this->getCountries()
        );
    }
    
}