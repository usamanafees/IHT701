<?php

namespace App\Http\Middleware;
use Closure;
use App\Hr_Account_settings;
use App\User;
use App\Modules;
use Auth;
class Hr_middleware
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
        if(Auth::user()->is_hr_admin == 'admin' || in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
        {
            return $next($request);
        }else
        {
              if(!empty(Auth::user()->Hr_account_settings) && (Auth::user()->Hr_account_settings->accepted == 1))
              {
                return $next($request);
              }else
              {
                dd("you are not a part of this system , contact your manager or check your mail");
              }
            
        }
        
    }
}
