<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Countries;
use App\Modules;
use App\Subsidiaries;
use App\AccountSettings;
use Auth;
use Redirect;
use Illuminate\Support\Facades\DB;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

//Enables us to output flash messaging
use Session;

class UsersController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        $user = User::all();
        if(isset($request->name) || isset($request->company_name) || isset($request->location) || isset($request->address))
        {
            $user= User::Where(function ($query) use ($request) {

            if(isset($request->name) && !empty($request->name))
            {
                $query->orWhere('name','LIKE',"%".$request->name."%");
            }
            if(isset($request->company_name) && !empty($request->company_name))
            {
                $query->orWhere('company_name','LIKE',"%".$request->company_name."%");
            }
            if(isset($request->location) && !empty($request->location))
            {
                $query->orwhere('location','LIKE',"%".$request->location."%");
            }
            if(isset($request->address) && !empty($request->address))
            {
                $query->where('address',$request->address);
            }
        })->get();
       }
       $countries = Countries::join('users','countries.iso_code','users.country_id')->groupBy('countries.iso_code','countries.name')->get(['countries.iso_code','countries.name']);	   
       if(isset($request->cid))
       {
       $user= $user->where('id',$request->cid);
       }
       if(isset($request->email))
       {
        $user=$user->where('email',$request->email);
       }
       if(isset($request->phn))
       {
        $user=$user->where('phone_no',$request->phn);
       }
	   if(isset($request->country) && !empty($request->country))
       {
		 $user=$user->where('country_id',$request->country);
       }

	   if(isset($request->taxpayer_no) && !empty($request->taxpayer_no))
       {
		 $user=$user->where('taxpayer_no',$request->taxpayer_no);
       }
	   if(isset($request->postal_code) && !empty($request->postal_code))
       {
		 $user=$user->where('postal_code',$request->postal_code);
       }
	   if(isset($request->wid) && !empty($request->wid))
       {
		 $user=$user->where('wid',$request->wid);
       }
	   return view('users.index',compact('user','request','countries')); 
    }
    public function user_based_login($uid)
    {
        $user = User::findOrFail($uid);
        // if ( Auth::user()->roles()->pluck('name')->implode(' ')=='Administrator') 
        // {
        //     $previous_user_id = auth()->user()->id;
        //     session()->forget('previous_user');
        //     Session::put('previous_user', $previous_user_id);
        // }
       if(auth()->user()->can('mascaret') || $user->can('mascaret')) 
       {
           //dd($uid);
           $previous_user_id = auth()->user()->id;
           session()->forget('previous_user');
           Session::put('previous_user', $previous_user_id);
           Auth::loginUsingId($uid);
           return Redirect()->route('/');           
       }
       else
       {
          echo "invalid request";    
       }//dd($user);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    function create_guid()
    {
    $microTime = microtime();
    list($a_dec, $a_sec) = explode(' ', $microTime);

    $dec_hex = dechex($a_dec * 1000000);
    $sec_hex = dechex($a_sec);

    $this->ensure_length($dec_hex, 5);
    $this->ensure_length($sec_hex, 6);

    $guid = '';
    $guid .= $dec_hex;
    $guid .= $this->create_guid_section(3);
    $guid .= '-';
    $guid .= $this->create_guid_section(4);
    $guid .= '-';
    $guid .= $this->create_guid_section(4);
    $guid .= '-';
    $guid .= $this->create_guid_section(4);
    $guid .= '-';
    $guid .= $sec_hex;
    $guid .= $this->create_guid_section(6);

    return $guid;
    }

    function create_guid_section($characters)
    {
        $return = '';
        for ($i = 0; $i < $characters; ++$i) {
            $return .= dechex(mt_rand(0, 15));
        }

        return $return;
    }
    function ensure_length(&$string, $length)
    {
        $strlen = strlen($string);
        if ($strlen < $length) {
            $string = str_pad($string, $length, '0');
        } elseif ($strlen > $length) {
            $string = substr($string, 0, $length);
        }
    }
    public function create()
    {
        $roles = Role::get();
        $modules = Modules::All();
        $countries = Countries::All();
        return view('users.create', ['roles'=>$roles, 'modules'=>$modules, 'cntry'=>$countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            "access_module" => "required|array|min:1",
            "roles" => "required|array|min:1",
            "sms_percentage"  =>  "required|numeric",
            "country"=>"required",
          ]);
           
        $user = New User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->country_id =$request->country;
        if(isset($request->check_box))
        {
                $user->active= 1;
        }
        else{
            $user->active= 0;

        }
        $user->password = bcrypt($request->password);
        if(isset($request->access_module)){
            $module_ids = implode(',', $request->access_module);
            $user->access_modules = $module_ids;
        }
        if(in_array(5,$request->access_module))
        {
            $user->is_hr_admin = 'admin';
        }
        if(!in_array(5,$request->access_module))
        {
            $user->is_hr_admin = NULL;
        }
        if(!isset($request->tax_percentage))
        {
            $request->tax_percentage = 0;
        }
        $sms_cost = \config('sms.sms_cost');
        $user->sms_cost = $sms_cost;
        $user->sms_cost_percentage = $request->sms_percentage;
        $api_key = $this->create_guid();
        $user->api_key = $api_key;
        $user->email_verification = 1;
        $user->save();

        $subsid = new Subsidiaries();
        $subsid->user_id = $user->id;
        $subsid->save();

        $account_Settings = new AccountSettings();
        $account_Settings->duration = 'M';
        $account_Settings->amount = '24' ;
        $account_Settings->expires_on = date('Y-m-d', strtotime("+30 days"));
        $account_Settings->total_documents = '500';
        $account_Settings->used_documents = '10';
        $account_Settings->total_users = '5';
        $account_Settings->used_users = '1';
        $account_Settings->free_sms_total = '20';
        $account_Settings->free_sms_used = '0';
        $account_Settings->bought_sms_total = '10';
        $account_Settings->bought_sms_used = '';
        $account_Settings->user_id = $user->id;
        $account_Settings->payment_code = 'Monthly-24-Small';
        $account_Settings->balance = date('Y-m-d', strtotime("+30 days"));
        $account_Settings->tax = $request->tax_percentage;
        $account_Settings->save(); 
            
        $roles = $request['roles']; 
        //Retrieving the roles field
        //Checking if a role was selected
        // if(isset($roles) && !in_array(3,$roles))
        // {
        //     $role_r = Role::where('id', '=', 3)->firstOrFail();         
        //     $user->assignRole($role_r);
        // }
        if (isset($roles)) {
            foreach ($roles as $role) {
            $role_r = Role::where('id', '=', $role)->firstOrFail();         
            $user->assignRole($role_r); //Assigning role to user
            }
        }      
        return redirect()->route('users');
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
        
        $user = User::find($id);
        $roles = Role::get(); //Get all roles
        $modules = Modules::All();
        $selected_modules = explode (",", $user->access_modules);
        $user_role = $user->roles->pluck('id')->toArray();
        $cntry = Countries::All();
        $tax = AccountSettings::select('tax')->where('user_id',$id)->first();
        return view('users.edit',compact('user','roles','user_role','modules','selected_modules','cntry','tax'));
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
        //dd($request);
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpg,png,jpeg|max:2048',
            // 'email' => 'required|string|email|max:255|unique:users',
          ]);
        $user = User::find($id);
        $account = AccountSettings::where('user_id',$id)->first();
        if ($request->hasFile('image')) {
        $image = $request->file('image');
        $name = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = storage_path('images');
        $image->move($destinationPath, $name);
        $user->image = $destinationPath."\\".$name;
        }       
        $user->name = $request->name;        
        $this->validate($request, [
            'sms_percentage'  =>  'required|numeric',
            'country' => 'required',
            'tax_percentage' => 'required'             
            // 'email' => 'required|string|email|max:255|unique:users',
          ]);

        $user->country_id=$request->country;
       
          $user->sms_cost_percentage = $request->sms_percentage;
          $user->sender_rate = $request->sender_rate;
        
        if($user->email != $request->email){

             $this->validate($request, [
                'email' => 'required|string|email|max:255|unique:users',
              ]);
                $user->email = $request->email;
        }
        
        if(isset($request->access_module)){
            $module_ids = implode(',', $request->access_module);
            $user->access_modules = $module_ids;
        }
        if(in_array(5,$request->access_module))
        {
            $user->is_hr_admin = 'admin';
        }
        if(!in_array(5,$request->access_module))
        {
            $user->is_hr_admin = NULL;
        }
        $user->address = $request->address;
        $user->taxpayer_no = $request->taxpayer_no;
        $user->postal_code = $request->postal_code;
        $user->location = $request->location;
        $user->wid = $request->wid;
        if(isset($request->check_box))
        {
            $user->active = 1;
        }else
        {
            $user->active = 0;
  
        }
        $user->update();
        if($account !==null)
        {
            $account->tax = $request->tax_percentage;
            $account->update();
        }
       

        $roles = $request['roles']; //Retreive all roles

        if (isset($roles)) {
            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles
        }
        else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }

        return redirect()->back()->with(['success' => "user updated successfully!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users');
    }

    /**
     * Show the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function developer()
    // {
    //     return view('users.developer');
    // }

}
