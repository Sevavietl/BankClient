<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use BankClient\Service\HttpBankClient\HttpBankClient;

class HttpBankClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('BankClient\Domain\Contract\HttpBankClientInterface', function($app) {
            return new HttpBankClient(
                $this->app->make('GuzzleHttp\ClientInterface')
            );
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
