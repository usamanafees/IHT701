<?php

namespace App\Http\Middleware;
use App\Modules;
use Closure;
use Illuminate\Support\Facades\Auth;
class Generic_middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next , $modulename)
    {  
       
        $modules = explode(',', Auth::user()->access_modules);
        $flag= 0;
        
        foreach($modules as $mdid)
        {            
            $abc = Modules::select('name')->where('id',$mdid)->first();
            if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
            {
            
                $flag = 1;
            
            }elseif(isset($abc))
            {
                if($modulename === $abc->name)
                {
                $flag = 1;
                }
            }  
        
        }
        if($flag === 1)
            {
                return $next($request);
            }else
            {
                return response('Method not allowed'); 
        
            }  
            
        
    //     if (Auth::user()->hasPermissionTo("smsv")) //If user has this //permission
    // {
    //     $modules = explode(',', Auth::user()->access_modules);
    //     if(in_array($moduleid,$modules))
    //     {
    //         return $next($request);
    //         //$abc = $request->route()->parameter('abc');
    //         //dd($request->abc);

    //     }else
    //     {
    //         return response('Method not allowed'); 

    //     }      
    // }
    // else
    // {
                      
    // } 
    // }
}
}
