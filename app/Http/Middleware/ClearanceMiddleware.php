<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ClearanceMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {        
        if (Auth::user()->hasPermissionTo('Administer roles & permissions')) //If user has this //permission
    {
            return $next($request);
        }

        if ($request->is('brands/add'))//If user is creating a brand
         {
            if (!Auth::user()->hasPermissionTo('Create Brand'))
         {
                abort('401');
            } 
         else {
                return $next($request);
            }
        }
        if ($request->is('brands/edit/*'))
         {
            if (!Auth::user()->hasPermissionTo('Edit Brand')) {
                abort('401');
            } else {
                return $next($request);
            }
        }
        if ($request->is('brands'))
         {
            if (!Auth::user()->hasPermissionTo('View Brands')) {
                abort('401');
            } else {
                return $next($request);
            }
        }
       
        if ($request->is('items'))
         {
            if (!Auth::user()->hasPermissionTo('View Items')) {
                abort('401');
            } else {
                return $next($request);
            }
        }
        if ($request->is('items/edit/*'))
         {
            if (!Auth::user()->hasPermissionTo('Edit Items')) {
                abort('401');
            } else {
                return $next($request);
            }
        }
        if ($request->is('/items/add'))
         {
            if (!Auth::user()->hasPermissionTo('Create Items')) {
                abort('401');
            } else {
                return $next($request);
            }
        }

        if ($request->is('clients'))
         {
            if (!Auth::user()->hasPermissionTo('View Client')) {
                abort('401');
            } else {
                return $next($request);
            }
        }
        if ($request->is('clients/edit/*'))
         {
            if (!Auth::user()->hasPermissionTo('Edit Client')) {
                abort('401');
            } else {
                return $next($request);
            }
        }
        if ($request->is('/clients/add'))
         {
            if (!Auth::user()->hasPermissionTo('Create Client')) {
                abort('401');
            } else {
                return $next($request);
            }
        }

        if ($request->is('invoices'))
         {
            if (!Auth::user()->hasPermissionTo('View Invoice')) {
                abort('401');
            } else {
                return $next($request);
            }
        }
        if ($request->is('invoices/edit/*'))
         {
            if (!Auth::user()->hasPermissionTo('Edit Invoice')) {
                abort('401');
            } else {
                return $next($request);
            }
        }
        if ($request->is('/invoices/add'))
         {
            if (!Auth::user()->hasPermissionTo('Create Invoice')) {
                abort('401');
            } else {
                return $next($request);
            }
        }
        return $next($request);
    }
}