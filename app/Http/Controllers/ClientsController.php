<?php

namespace App\Http\Controllers;

use App\Brands;
use Illuminate\Http\Request;
use App\Clients;
use App\ApiLogs;
use App\User;
use App\Items;
use App\LineItems;
use App\Invoices;
use App\Countries;
use Auth;
use Illuminate\Http\Response;
use Log;
use Email;
use Mail;
use Config;
use DB;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use Svg\Tag\Line;

class ClientsController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'clearance']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $client;
        if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
        {
            $client = Clients::all();
        }else{
            $client = Clients::where('user_id',Auth::user()->id)->get();

        }
        return view('clients.index',compact('client'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $countries = Countries::All();
        $user = User::find(Auth::user()->id);
        if(isset($user) && !empty($user))
        {
            $fee_list = json_decode($user->user_fee_list);
        }else
        {
            $fee_list = "";
        }
        return view('clients.create',compact('countries','fee_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vat_number' => 'required',
            //'date' => 'required',
        ]);
        $client = new Clients();

        // $validator = Validator::make($request->all(),$client->rules);
        // if($validator->fails()) {
        //     return response()->json(['errors'=>$validator->errors()]);
        // }

        $request->telephone = json_encode(array($request->telephone_Code,$request->telephone)) ;
        $request->mobile = json_encode(array($request->mobile_Code,$request->mobile)) ;
        $request->primary_mobile = json_encode(array($request->primary_mobile_code,$request->primary_mobile)) ;
        $request->primary_telephone = json_encode(array($request->primary_telephone_code,$request->primary_telephone)) ;
        $client->name = $request->name;
        $client->vat_number = $request->vat_number;
        $client->country = $request->country;
        $client->main_url = $request->main_url;

        $client->email = $request->email;
        $client->code = $request->code;
        $client->postal_code = $request->postal_code;
        $client->address = $request->address;
        $client->city = $request->city;

        $client->telephone = $request->telephone;
        $client->mobile = $request->mobile;

        $client->primary_name = $request->primary_name;
        $client->primary_email = $request->primary_email;

        $client->primary_mobile = $request->primary_mobile;
        $client->primary_telephone = $request->primary_telephone;
        $client->user_id = Auth::user()->id;
        $client->default_fee = $request->fee;
        $client->self_billing_indicator='0';
        $client->vat_exemption = $request->vatexpn;
        $client->save();
        return redirect()->route('clients');
    }
    public function store_csv(Request $request)
    {
        $err= 0;
        $id_error=array();
        $check_foreach = 0;
        $dataee = "1970-01-01";
        $map = json_decode($request->arr);
        $filePath = public_path().'\files\no_err'.$request->path;
        $file=fopen($filePath, 'r');
        $header= fgetcsv($file);
        $escapedHeader=[];
        // validate
        foreach ($header as $key => $value)
        {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('[^a-z]', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        $data=array(array());
        $j = 0;
        while($columns=fgetcsv($file))
        {
            $check_l = 0;
            $string_version = implode(',', $columns);
            $string_version_two =str_replace(',', "", $string_version);
            $result = explode(';',$string_version_two);
            foreach($result as $res)
            {
                $data[$j][] = utf8_encode($res);
            }
            $j++;
        }
        fclose($file);
        $invoices_arrays = array();
        for($i=0;$i<count($data);$i++)
        {
            unset($invoices_arrays);
            $invoices_arrays = array();
            $invoices_arrays[] = $data[$i];
            for($j=$i+1;$j<count($data);$j++)
            {
                if($data[$i][0] == $data[$j][0] && $data[$i][13] == $data[$j][13])
                {
                    $invoices_arrays[] = $data[$j];
                    unset($data[$j]);
                    $data = array_values($data);
                }
            }
            $check_foreach = 0;
            $invoice_sub_total = 0;
            $invoice_vat_total = 0;
            $invoice_create_check = 0;
            $new_invoice;
            for($k=0; $k<count($invoices_arrays);$k++)
            {   try{
                $client;
                if($check_foreach == 0)
                {
                    $client = Clients::find($invoices_arrays[$k][0]);
                    if(!isset($client) && empty($client))
                    {
                        $client = new Clients();
                        $client->id = $invoices_arrays[$k][0];
                        $client->name = $invoices_arrays[$k][1];
                        $client->vat_number = $invoices_arrays[$k][2];
                        $client->email = $invoices_arrays[$k][4];
                        $client->address = $invoices_arrays[$k][5];
                        $client->city = $invoices_arrays[$k][6];
                        $client->postal_code = $invoices_arrays[$k][7];
                        $client->country = $invoices_arrays[$k][8];
                        $client->save();
                    }
                    $new_invoice = new Invoices();
                    $new_invoice->cid = $client->id;
                    $new_invoice->created_at = $invoices_arrays[$k][13] == "0.68000" ? \Carbon\Carbon::now() : $invoices_arrays[$k][13];
                    $new_invoice->save();
                    $invoice_create_check = 1;
                    $check_foreach = 1;
                }
                $invl_item = new LineItems();

                $invl_item->vat =  $invoices_arrays[$k][3];
                $invl_item->qty =  $invoices_arrays[$k][10];
                $invl_item->description = $invoices_arrays[$k][11];
                $invl_item->code = $invoices_arrays[$k][11];
                $invl_item->total = $invoices_arrays[$k][12];
                $invl_item->unit_price = $invoices_arrays[$k][12];
                $invl_item->invid = $new_invoice->id;
                $invl_item->save();

                $invoice_sub_total = $invoice_sub_total + ($invoices_arrays[$k][12] * $invoices_arrays[$k][10]);
                $invoice_vat_total =  $invoice_vat_total + $this->calculate_vat($invoices_arrays[$k][3],$invoices_arrays[$k][12]);
            }catch(\Illuminate\Database\QueryException $ex)
            {
                $err = 1;
                $id_error[] = $invoices_arrays[$k];
            }
                //$total_invoice_value = $total_invoice_value + ($invoice_sub_total + $invoice_vat_total);
            }
            if($invoice_create_check == 1)
            {
                $new_invoice1 = Invoices::find($new_invoice->id);
                $new_invoice1->inv_subtotal = $invoice_sub_total;
                $new_invoice1->inv_vat = $invoice_vat_total;
                $new_invoice1->total_invoice_value = $invoice_sub_total + $invoice_vat_total;
                $new_invoice1->currency = 'EUR_€';
                $new_invoice1->uid = Auth::user()->id;
                $new_invoice1->save();
            }
        }
        if($err == 0)
        {
            return  response()->json(["msg"=>"csv imported successfully","result"=>"success"]);
        }else
        {
            return  response()->json(['msg'=>$id_error,"result"=>"error"]);
        }

    }

    public function store_csv_eupago(Request $request)
    {
        $err = 0;
        ini_set('max_execution_time', 7200);
        $id_error = array();
        $check_foreach = 0;
        $dataee = "1970-01-01";
        $map = json_decode($request->arr);
        $filePath = public_path() . '/files/no_err' . $request->path;

        $file = fopen($filePath, 'r');
        $header = fgetcsv($file);
        $escapedHeader = [];
        $totalClientsAdded=0;
        $totalClientsUpdated=0;
        $totalInvoicesCreated=0;
        $totalItemsAdded=0;    
        foreach ($header as $key => $value) {
            $lheader = strtolower($value);
            $escapedItem = preg_replace('[^a-z]', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        $data = array(array());
        $j = 0;
        while ($columns = fgetcsv($file)) {
            $check_l = 0;
            $string_version = implode(',', $columns);
            $string_version_two = str_replace(',', "", $string_version);
            $result = explode(';', $string_version_two);
            foreach ($result as $res) {
                $data[$j][] = utf8_encode($res);
            }
            $j++;
        }
        fclose($file);
        $invoices_arrays = array();
        for ($i = 0; $i < count($data); $i++) {
            unset($invoices_arrays);
            $invoices_arrays = array();
            $invoices_arrays[] = $data[$i];
            for ($j = $i + 1; $j < count($data); $j++) {
                if ($data[$i][0] == $data[$j][0] && $data[$i][13] == $data[$j][13]) {
                    $invoices_arrays[] = $data[$j];
                    unset($data[$j]);
                    $data = array_values($data);
                }
            }
            $check_foreach = 0;
            for ($k = 0; $k < count($invoices_arrays); $k++) {
                if ($check_foreach == 0) {
                    $client = Clients::find($invoices_arrays[$k][0]);
                    if (empty($client) && !isset($client)) {
                        $client = new Clients();
                        $client->id = $invoices_arrays[$k][0];
                        $client->name = $invoices_arrays[$k][1];
                        $client->vat_number = $invoices_arrays[$k][2];
                        $client->email = $invoices_arrays[$k][4];
                        $client->address = $invoices_arrays[$k][5];
                        $client->city = $invoices_arrays[$k][6];
                        $client->postal_code = $invoices_arrays[$k][7];
                        $client->country = $invoices_arrays[$k][8];
                        $client->economic_area = $invoices_arrays[$k][9];
                        $client->self_billing_indicator = 0;
                        $client->user_id = Auth::user()->id;
                        $client->save();
                        $totalClientsAdded=$totalClientsAdded+1;
                    } else {
                        $client->update(['id' => $invoices_arrays[$k][0], 'name' => $invoices_arrays[$k][1],
                            'vat_number' => $invoices_arrays[$k][2], 'email' => $invoices_arrays[$k][4], 'address' => $invoices_arrays[$k][5], 'city' => $invoices_arrays[$k][6]
                            , 'postal_code' => $invoices_arrays[$k][7], 'country' => $invoices_arrays[$k][8], 'economic_area' => $invoices_arrays[$k][9]]);
                        }

                    $date = date('Y-m-d H:i:s', strtotime('-10 minutes'));

                    $new_invoice = Invoices::where('cid', $invoices_arrays[$k][0])->where('created_at', '>=', $date)->where('uid', Auth::user()->id)->orderBy('id', 'DESC')->first();
                    if (!isset($new_invoice) && empty($new_invoice)) {
                        $new_invoice = new Invoices();
                        $new_invoice->cid = $client->id;
                        $new_invoice->inv_date = date('Y-m-d');
                        if ($invoices_arrays[$k][10] == 0) {
                            $new_invoice->is_receipt = 'invoice';
                            $new_invoice->status = "draft";
                        } else {
                            $new_invoice->is_receipt = 'receipt';
                            $new_invoice->status = "draft";
                        }
                        $new_invoice->uid = Auth::user()->id;
                        $brands_serie=Brands::find('11');
                        $new_invoice->brand_templates_id = 10;
                        $new_invoice->brands_id = 11;
                        $new_invoice->currency = 'EUR_€';
                        $new_invoice->serie = $brands_serie->series;
                        $new_invoice->atcud = '0';
                        $new_invoice->sourceid = '0';
                        $new_invoice->source_billing = 'P';
                        $new_invoice->self_billing_indicator = '0';
                        $new_invoice->cash_vat_scheme_indicator = '0';
                        $new_invoice->third_parties_billing_indicator = '0';
                        $new_invoice->save();
                        $check_foreach = 1;
                        $totalInvoicesCreated=$totalInvoicesCreated+1;
                    } else {
                        $new_invoice->update(['cid' => $client->id, 'inv_date' => date('Y-m-d'),
                            'uid' => Auth::user()->id, 'brand_templates_id' => 10, 'brands_id' => 11, 'serie'=>$brands_serie->series]);
                    }

                    $items = Items::where('description', $invoices_arrays[$k][11])->where('price', $invoices_arrays[$k][12])->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->first();
                    if (!isset($items) && empty($items)) {
                        $items = new Items();

                        $items->type = "P";
                        $items->user_id = Auth::user()->id;
                        $items->code = "COM01";
                        $items->tax = $invoices_arrays[$k][3];
                        $items->unit = "Unit";
                        $items->price = $invoices_arrays[$k][12];
                        $items->description = $invoices_arrays[$k][11];
                        $items->save();
                        $totalItemsAdded=$totalItemsAdded+1;
                    } else {
                        $items->update(['code' => $invoices_arrays[$k][11], 'description' => $invoices_arrays[$k][11],
                            'type' => 'P', 'user_id' => Auth::user()->id, 'unit' => 'Unit', 'price' => $invoices_arrays[$k][12]
                            , 'tax' => $invoices_arrays[$k][3]]);
                    }

                    $invl_item = new LineItems();

                    $invl_item->vat = $invoices_arrays[$k][3];
                    $invl_item->qty = 1;
                    $invl_item->description = $invoices_arrays[$k][11];
                    $invl_item->code = $items->code;
                    $invl_item->total = $invoices_arrays[$k][12];
                    $invl_item->unit_price = $invoices_arrays[$k][12];
                    $invl_item->invid = $new_invoice->id;
                    $invl_item->item_id = $items->id;
                    $invl_item->discount = 0.00;
                    $invl_item->save();
                }
            }
        }
        if($err == 0)
        {
            return  response()->json(["msg"=>"Were added ".$totalClientsAdded." clients, ".$totalItemsAdded." items and ".$totalInvoicesCreated." invoices.","result"=>"success"]);
        }else
        {
            return  response()->json(['msg'=>$id_error,"result"=>"error"]);
        }
    }


    function calculate_vat($per,$val)
    {
        $var = $per/100;
        $var2 = $var*$val;
        return $var2;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $client = Clients::findorFail($id);
        $countries = Countries::All();

        $user = User::find($client->user_id);
        if(isset($user) && !empty($user))
        {
            $fee_list = json_decode($user->user_fee_list);
        }else
        {
            $fee_list = "";
        }

        $telephone = json_decode($client->telephone);
        $mobile = json_decode($client->mobile);
        $primary_mobile = json_decode($client->primary_mobile);
        $primary_telephone = json_decode($client->primary_telephone);

        return view('clients.edit',compact('fee_list','client','countries','telephone','mobile','primary_mobile','primary_telephone'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $request->telephone = json_encode(array($request->telephone_Code,$request->telephone)) ;
        $request->mobile = json_encode(array($request->mobile_Code,$request->mobile)) ;
        $request->primary_mobile = json_encode(array($request->primary_mobile_code,$request->primary_mobile)) ;
        $request->primary_telephone = json_encode(array($request->primary_telephone_code,$request->primary_telephone)) ;

        $client = Clients::find($id);
        $client->name = $request->name;
        $client->vat_number = $request->vat_number;
        $client->country = $request->country;
        $client->main_url = $request->main_url;

        $client->email = $request->email;
        $client->code = $request->code;
        $client->postal_code = $request->postal_code;
        $client->address = $request->address;
        $client->city = $request->city;

        $client->telephone = $request->telephone;
        $client->mobile = $request->mobile;

        $client->primary_name = $request->primary_name;
        $client->primary_email = $request->primary_email;

        $client->primary_mobile = $request->primary_mobile;
        $client->primary_telephone = $request->primary_telephone;
        $client->user_id = Auth::user()->id;
        $client->default_fee = $request->fee;
        $client->vat_exemption = $request->vatexpn;
        $client->update();

        return redirect()->route('clients');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        if(isset($request->client_id) && !empty($request->client_id)) {
            $clients = Clients::find($request->client_id)->delete();
            if ($clients == 1) {
                return response()->json(['success' => 'true', 'id' => $request->client_id]);
            } else {
                return response()->json(['success' => 'false', 'id' => $request->client_id]);
            }
        }
        return response()->json(['success'=>'false','id'=>$request->client_id]);
    }
    public function client_list(Request $request){
        $clients = Clients::where('user_id','=',Auth::user()->id)->get();
        return json_encode($clients);
    }
    public function client_live_Search(Request $request){
        $query = $request->client;
        $clients = Clients::where('name', 'like', '%'.$query.'%')->where('user_id','=',Auth::user()->id)->get();
        return json_encode($clients);
    }
    public function get_client_fee_list(Request $request)
    {
        $user = User::find($request->cl_id);
        if(isset($user) && !empty($user))
        {
            $fee_list = json_decode($user->user_fee_list);
        }else
        {
            $fee_list = "";
        }
        return json_encode($fee_list);
    }
    public function  contact_client_usr(Request $request)
    {
        $clients = Clients::where('user_id',Auth::user()->id)->get();
        return View('contact_client.contact_client',compact('clients'));
    }
    public function  contact_client_usr_post(Request $request)
    {
        if(isset($request->client) && !empty($request->client))
        {
            $sms_check = 0 ;
            $email_check = 0 ;
            foreach($request->client as $client)
            {
                if(isset($request->send_message_before) && !empty($request->send_message_before))
                {
                    $clt = Clients::find($client);
                    $msg = $request->sms_message_before;
                    $usr = User::find($clt->user_id);
                    $msg = str_replace('%name%', $clt->name, $msg);
                    $string = implode(",",json_decode($clt->mobile));
                    $mobile_num = str_replace(',', '', $string);
                    $clientt = new \GuzzleHttp\Client();
                    $response =  $clientt->post(
                        url('/').'/api/addSMS',
                        array(
                            'form_params' => array(
                                'Accept' => 'application/json',
                                'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjI4ZDlkMzA0OWE5NmRhZTJhZWU2ZGQ5YjM3NjRjOGFiZWEyZmZjMTI2OGZkMjExZGJmZWM5ODE1ODAxZTg3ZmI5ZDQwNzRkYzkzODIyMmQ4In0.eyJhdWQiOiIxMSIsImp0aSI6IjI4ZDlkMzA0OWE5NmRhZTJhZWU2ZGQ5YjM3NjRjOGFiZWEyZmZjMTI2OGZkMjExZGJmZWM5ODE1ODAxZTg3ZmI5ZDQwNzRkYzkzODIyMmQ4IiwiaWF0IjoxNTk1MjMxMTkwLCJuYmYiOjE1OTUyMzExOTAsImV4cCI6MTYyNjc2NzE5MCwic3ViIjoiMSIsInNjb3BlcyI6W119.zQim3aUEAzZERM75udlpVD8FLdD8rOw4-rP4jPOtxa5fI9PonOgjZQ9lrXL9KGMN076rl_cQqJyWar824geN-iw-yC1W-cRom0OvXoVrmKhAelqp3UPijNvEZ_0OSH2rtNa9w3gGiYsm5yUyUYaOFM2TMPSgKeshQ88s3I_PFFxFmuY5XGmr2pjMvK5h2CDRPYsupFrJYDKO1UiTBmCBPVDPYcg3c9wI-4DVrYYl2q7E14PHSfp1qIsEIR2_pcjU8VJu1FY89KryIc9M8LDtZxcy1bRuc8l7sPOtZCUkpOhZPDRVcZ6ClYmRLuYg0Vj9damgDZ-etE-yk6s3R0_U79Tm7zcYxz1fSQv-5NBCb4PJKBJn2coBYsD0CrQXvGGp-xwP6rUU5KjOf-tfo0zPI6x4TdRRV95UDAUDtMv3G_LC_JpIKTPgQqp7TUm3uztuNCYhUF1OWhnCSk2SS7T0C5eagvv8A17lZGu7VgT5GGIzNjbgqqvL18LtFrJAcV9uLhnmToxNlyuHwxFgv1UPSnYy6ViRRt9pEBXe2WUef0_96Ni1Pe22jv56MRmvh8O779bHUn2sUA7dwYbHW-YbzVOZ2DOCOABouFjpabRoE1giEniLoAHbaom6fqjBiArGyxxEQIj8yWRvNyfx8ONMvxbzE-1wo8ZFM352qvydH4M',
                                'accountid' => $usr->id,
                                'apikey' =>  $usr->api_key,
                                'message' => $msg,
                                'sender' => '2',
                                'mobile_num' => $mobile_num,
                            )
                        )
                    );
                    $sms_check = 1;
                }
                if(isset($request->send_email_before) && !empty($request->send_email_before))
                {

                    $request->request->add(['ip' => $this->getIp()]);
                    $request_array = $this->prepareRequestArray($request,'Contact Clients (user)');
                    $clt = Clients::find($client);
                    $user= User::where('id',$clt->user_id)->first();
                    $data = array();
                    $sub = $request->subject_before;
                    $data['txt'] = $request->email_message_before;
                    try{
                        Mail::send('contact_client.contact_client_template',$data, function($message) use($clt,$sub){
                            $message->to($clt->email);
                            $message->subject($sub);
                            $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
                        });
                        $email_check = 1;
                        $this->createApiLog($user->id,"Contact Client",4,$client, $request_array,json_encode(['message'=>'success','Email'=>'Sent','result'=>array($clt)]),$user->phone_no,\Request::url());
                    }
                    catch(Exception $e)
                    {
                        $this->createApiLog($user->id,"Contact Client",4,$client, $request_array,json_encode(['message'=>'error','result'=>array($clt,$e->getMessage())]),$user->phone_no,\Request::url());
                    }
                }
            }
            if($sms_check == 1 && $email_check == 0)
            {
                return redirect()->back()->with('success','SMS has been sent');
            }
            if($sms_check == 0 && $email_check == 1)
            {

                return redirect()->back()->with('success','Emial has been sent');
            }
            if($sms_check == 1 && $email_check == 1)
            {
                return redirect()->back()->with('success','Emial and SMS has been sent');
            }
        }else
        {
            return redirect()->back()->with('error','some thing went wrong');
        }

    }
    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }
    public function createApiLog($user_id ,$action,$module_id,$record_id, $request , $response ,$mobile_number,$inquiry){
        ApiLogs::create([
            'user_id' => $user_id,
            'request' => json_encode((array)$request),
            'response' => $response,
            'mobile_number' => $mobile_number,
            'inquiry' =>$inquiry,
            'action' => $action,
            'module_id'=>$module_id,
            'record_id'=>$record_id
        ]);
        return true;
    }
    public function prepareRequestArray($request,$action){
        $request_array = array();
        $request_array["ip"] = $request->ip;
        $request_array["session_id"] = "";
        $request_array["user_agent"] = $request->header('User-Agent');
        $request_array["script_name"] = "app/Http/Controllers/API/SMSController.php";
        $request_array["host"] = "";
        $request_array["function"] = $action;
        $request_array["args"] = $request->all();
        $request_array["0"] = "false";
        return $request_array;
    }

}
