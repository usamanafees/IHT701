<?php namespace App\Http\Middleware;

use Closure;
use Session;
use Redirect;

class Language  {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //echo \Session::has('locale'); exit;
        if(!\Session::has('locale'))
        {
            \Session::put('locale', \Config::get('app.locale'));
            \App::setLocale(\Session::get('locale'));
        }else {
            //echo Session::get('locale'); exit;
            \App::setLocale(\Session::get('locale'));
        }
        \App::setLocale(\Session::get('locale'));
        app()->setLocale(\Session::get('locale'));

        return $next($request);
    }
}