<?php

namespace App\Providers;

use App\OAuthToken;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('api_token')) {
                $token = OAuthToken::where('token', $request->input('api_token'))->first();

                if (!$token ||$token->isExpired()) {
                    return null;
                }

                return $token->user();
            }
        });
    }
}
