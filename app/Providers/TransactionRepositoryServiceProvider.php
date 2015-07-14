<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use BankClient\Persistence\Laravel\Repository\TransactionRepository;
use App\Transaction;
use BankClient\Persistence\Laravel\Hydrator\HydratorInterface;
use BankClient\Domain\Entity\Transaction as TransactionEntity;

class TransactionRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('BankClient\Domain\Repository\TransactionRepositoryInterface', function($app) {
            return new TransactionRepository(
                new Transaction,
                $this->app->make('BankClient\Persistence\Laravel\Hydrator\HydratorInterface'),
                new TransactionEntity
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
