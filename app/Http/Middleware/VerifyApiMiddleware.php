<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use Route;
class VerifyApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::where('id',$request->accountid)->where('api_key',$request->apikey);
        if(($user->count())>0 ||  Route::currentRouteName() == "eupago_callback"){
            return $next($request);
        }
        else{
            return response()->json([
                'message' => 'Authentication failed',
            ]);
        }
    }
}
