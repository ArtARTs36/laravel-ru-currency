<?php

namespace ArtARTs36\LaravelRuCurrency\Providers;

use ArtARTs36\CbrCourseFinder\Contracts\Finder;
use ArtARTs36\LaravelRuCurrency\Ports\Console\Commands\FetchCoursesCommand;
use Illuminate\Support\ServiceProvider;

class CurrencyProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Finder::class, \ArtARTs36\CbrCourseFinder\Finder::class);

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->commands(FetchCoursesCommand::class);

            require __DIR__ . '/../../database/seeders/CurrencySeeder.php';
        }
    }
}
