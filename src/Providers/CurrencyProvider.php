<?php

namespace ArtARTs36\LaravelRuCurrency\Providers;

use ArtARTs36\CbrCourseFinder\Contracts\Finder;
use ArtARTs36\LaravelRuCurrency\Contracts\CurrencyRepository;
use ArtARTs36\LaravelRuCurrency\Database\Seeders\RuCurrencySeeder;
use ArtARTs36\LaravelRuCurrency\Ports\Console\Commands\FetchCoursesCommand;
use ArtARTs36\LaravelRuCurrency\Repositories\EloquentCurrencyRepository;
use Illuminate\Support\ServiceProvider;

class CurrencyProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Finder::class, \ArtARTs36\CbrCourseFinder\Finder::class);
        $this->app->bind(CurrencyRepository::class, EloquentCurrencyRepository::class);;

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->commands(FetchCoursesCommand::class);

            require __DIR__ . '/../../database/Seeders/RuCurrencySeeder.php';
        }
    }
}
