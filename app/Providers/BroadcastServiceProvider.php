<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;
use Auth;
use Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Pusher\Pusher;
use Config;
class BroadcastServiceProvider extends ServiceProvider
{
    protected $app;
    protected $pusher;

    public function __construct($app)
    {
        Log::info(env('PUSHER_APP_KEY'));
        $this->app = $app;
        $this->pusher = new Pusher(env('PUSHER_APP_KEY'),env('PUSHER_APP_SECRET'),env('PUSHER_APP_ID'));
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->routesAreCached()) {
            return;
        }
        $flag = 0;
        $attributes = ['middleware' => ['web']];
        $this->app['router']->group($attributes, function ($router) {
            $router->post('api/broadcasting/auth',function(Request $request)
            {

                $flag = 1;
                if (Str::startsWith($request->channel_name, 'private')) {
                    if(Auth::user() !== null)
                    {
                        return json_decode($this->pusher->socket_auth($request->channel_name, $request->socket_id), true);
                   
                    }else
                    {
                        return response()->json("you are not authorized");
                    }
                }
            });
        });
        if($flag == 0)
        {
            Broadcast::routes();
        }
        require base_path('routes/channels.php');
    }
}
