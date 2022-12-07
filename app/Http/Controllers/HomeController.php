<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use Redirect;
use Session;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_based_login()
    {



        $puid = Session::get('previous_user');
        $user = User::findOrFail($puid);
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
           Auth::loginUsingId($puid);
           return Redirect()->route('/');           
       }
       else
       {
          echo "invalid request";    
       }

       


    }
   public function index()
    {
        return view('home');
    }
    public function searchajax($val)
    {
        $data;
        if(ctype_digit($val))
        {
            $data = User::where('id', $val)->get();
        }
         else{
             $data = User::where('name', 'like', '%' . $val . '%')
            ->orWhere('email', 'like', '%' . $val . '%')
            ->orWhere('company_name', 'like', '%' . $val . '%')->get();            
             }             
        return (response()->json($data));        
    }
    
    
    public function developer()
    {
        return view('users.developer');
    }

}
