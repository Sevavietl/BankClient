<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HttpBankClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'BankClient\Domain\Contract\HttpBankClientInterface',
            'BankClient\Service\HttpBankClient\HttpBankClient'
        );
    }
}
