<?php

namespace ArtARTs36\LaravelRuCurrency\Providers;

use ArtARTs36\CbrCourseFinder\Contracts\Finder;
use ArtARTs36\LaravelRuCurrency\Contracts\CurrencyRepository;
use ArtARTs36\LaravelRuCurrency\Ports\Console\Commands\FetchCoursesCommand;
use ArtARTs36\LaravelRuCurrency\Repositories\EloquentCurrencyRepository;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class CurrencyProvider extends ServiceProvider
{
    public function register()
    {
        $this
            ->app
            ->when(\ArtARTs36\CbrCourseFinder\Finder::class)
            ->needs(ClientInterface::class)
            ->give(fn (Container $container) => $container->make(Client::class));

        $this->mergeConfigFrom(__DIR__ . '/../../config/ru_currency.php', 'ru_currency');
        $this->app->bind(Finder::class, \ArtARTs36\CbrCourseFinder\Finder::class);
        $this->app->bind(CurrencyRepository::class, EloquentCurrencyRepository::class);

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->commands(FetchCoursesCommand::class);
        }
    }
}
