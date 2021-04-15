<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use stdClass;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }

    public function register()
    {
        $this->app->rebinding('request', function ($app, $request) {
            $request->setUserResolver(function ($guard = null) use ($app, $request) {
                //return call_user_func($app['auth']->userResolver(), $guard);

                $userId = $value = $request->header('X-User-ID', 0);
                $url = env('SERVICE_USER_URL') . 'users/' . $userId;

                try {
                    $response = Http::timeout(10)->get($url);
                    $object = new stdClass();
                    foreach ($response->json('data') as $key => $value) {
                        $object->$key = $value;
                    }
                    return $object;
                } catch (\Throwable $th) {
                    return [
                        'status' => 'error',
                        'code' => 500,
                        'message' => 'Service user unavailable'
                    ];
                }
            });
        });
    }
}
