<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use GuzzleHttp\Client;

class GuzzleHttpClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('GuzzleHttp\ClientInterface', function($app) {
            return new Client([
                'base_uri' => env('BANK_SERVER_BASE_URI', 'localhost:8000') . '/transaction/',
            ]);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
