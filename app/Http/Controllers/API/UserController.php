<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
class UserController extends Controller {
    public $registeruserrules = [
        'name' => 'required', 
        'email' => 'required|email|unique:users', 
        'password' => 'required', 
        'c_password' => 'required|same:password', 
    ];
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            return response()->json(['message'=>'success','result'=>array('token'=>'Bearer '.$user->createToken('MyApp')->accessToken)], 200);
        } 
        else{ 
            return response()->json(['message'=>'error','result'=>array('token'=>'')], 200);
        } 
    }
    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request){ 
        $request->validate($this->registeruserrules);
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input);
        return response()->json(['message'=>'success','result'=>array('token'=>'Bearer '.$user->createToken('MyApp')->accessToken)], 200);
    }
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details(){ 
        $user = Auth::user(); 
        return response()->json(['message'=>'success','result'=>array($user)], 200);
    } 
}