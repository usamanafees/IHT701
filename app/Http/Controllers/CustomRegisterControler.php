<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Subsidiaries;
use Auth;
use App\AccountSettings;
use Mail;
use App\Hr_Account_settings;
use Spatie\Permission\Models\Role;
use Config;
class CustomRegisterControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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

    public function store(Request $request)
    {	
         $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users',
          ]);

        // $module = env('DEFAULT_ALLOWED_MODULES','');
        // $role = env('DEFAULT_ALLOWED_ROLES','');
        // $roles = explode(',', $role);

        $api_key = $this->create_guid();
        $sms_cost = \config('sms.sms_cost');
        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'country_id' =>  $request->country_id,
            'company_name' =>  $request->company_name,
            'phone_no' =>  $request->phone_no,
            'sms_cost'=>   $sms_cost,
            'api_key' =>   $api_key,
            'access_modules' => "1",
        ]);
        $role_r = Role::where('name', '=', 'Client')->firstOrFail();  
        if (isset($role_r)) {
            $user->assignRole($role_r); //Assigning role to user
        }
          $id = $user->id;
        return redirect()->route('setup.account',$id);
    }

    //Ajax call for unique Email in custom Signup
    public function checkEmail(Request $request){
        $email = $request->email;
        $isExists = User::where('email',$email)->first();
        return $isExists;
    }

    //Ajax call for check Email and verify Email in forgot Email
    public function verifyEmail(Request $request){
        $email = $request->email;
        $user = User::where('email',$email)->first();
        if(!$user)
        {
            return "This email does not exist.";
        }
        else
        {
            if($user->email_verification == 0)
            {
                return "Your email is not varified. Varify your email first.";
            }
        }
        return "done";
    }

    public function account_Setup($id){
        $user = User::find($id);
        return view('auth.account_setup',compact('user'));
    }



    public function email_verification($id){
        $user = User::find($id);
        $data['user'] = $user;
        Mail::send('auth.email_confirmation',$data, function($message) use($data){
            $message->to($data['user']['email']);
            $message->subject('Intelidus 360 Email Confirmation');
            $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
        });

        return view('auth.email_verification',compact('user'));
    }

    public function email_confirmation($token)
    {
        $user = User::where('api_key',$token)->first();
        if(!is_null($user))
        {
            $user->email_verification = 1;
            $user->save();
            $emc=1;
        }
        else
        {
            $emc=0;
        }
        // $u = User::find($user->id);
        // Auth::loginUsingId($user->id);
        return view ('auth.login',compact('emc'));
    }
    public function resend_email()
    {
        if (Auth::check())
        {
            $user = User::find(Auth::user()->id);
            if($user['email_verification'] == 1)
            {
                return redirect()->route('/');
            }
        }
        return view('auth.resend_email');
    }
    public function resend_email_submit()
    {
        if (Auth::check())
        {
            $user = User::find(Auth::user()->id);
            $data['user'] = $user;
            Mail::send('auth.email_confirmation',$data, function($message) use($data){
                $message->to($data['user']['email']);
                $message->subject('Intelidus 360 Email Confirmation');
                $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
            });
            Auth::logout();
        }
        return redirect()->route('/');
    }

    public function account_Setup_done(Request $request, $id){
        $subsid = new Subsidiaries();
        $subsid->taxpayer = $request->taxpayer;
        $subsid->city = $request->city;
        $subsid->postal_code = $request->postal_code;
        $subsid->address = $request->address;
        $subsid->user_id = $id;
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
        $account_Settings->user_id = $id;
        $account_Settings->payment_code = 'Monthly-24-Small';
        $account_Settings->balance = date('Y-m-d', strtotime("+30 days"));
        $account_Settings->save();


        $user = User::find($id);
        // Auth::loginUsingId($user->id);
        return redirect()->route('custom_register.email_verification', $user->id);

        // return redirect()->route('login');
           
    }

    public function forgotPassword()
    {
        return view('auth.forgot_password.forgot_password');
    }
    public function varify(Request $request)
    {
        $key = $this->create_guid();
        $email = $request->email;
        $user = User::where('email',$email)->first();
        $user->recover_password = $key;
        $user->save();
        $data['user'] = $user;
        Mail::send('auth.forgot_password.recover_password',$data, function($message) use($data){
            $message->to($data['user']['email']);
            $message->subject('Intelidus 360 Recover Password');
            $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
            // $message->from(env('MAIL_USERNAME'), 'Intelidus 360');
        });
        return view('auth.forgot_password.varify');
    }


    public function reset_password($key)
    {
        $user = User::where('recover_password',$key)->first();
        if(!$user)
        {
            return redirect()->route('/');
        }
        return view('auth.forgot_password.reset', compact('user'));
    }
    public function updates_password(Request $request)
    {
        $user = User::find($request->id);
        if(!is_null($user))
        {
            $user->password = bcrypt($request->password);
            $user->save();
            return view('auth.forgot_password.updated')->with('message','Your password has been updated successfully.');
        }
        else
        {
            return view('auth.forgot_password.updated')->with('message','There is an error while updating your Password.please try again.');
        }
    }
    public function hr_module_confirmation(Request $request)
    {
       
        $hr_s = Hr_Account_settings::where('confirmation_key',$request->token)->first();
        $user = User::find($hr_s->uid);
        if(!is_null($user))
        {
            $hr_s->accepted = 1;
            $hr_s->save();
            Auth::loginUsingId($user->id);
            return Redirect()->route('/');    
        }
        else
        {
            dd('you are not authorized');
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
