<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class RulesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('card_number', function ($attribute, $value, $parameters) {
            $regex = '/^\d{4} \d{4} \d{4} \d{4}$/';

            if (preg_match($regex, $value)) {
                return true;
            }

            return false;
        });

        Validator::extend('card_expiration', function ($attribute, $value, $parameters) {
            $regex = '/^\d{2}\/\d{2}$/';

            if (preg_match($regex, $value)) {
                return true;
            }

            return false;
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
