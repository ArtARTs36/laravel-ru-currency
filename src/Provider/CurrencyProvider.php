<?php

namespace ArtARTs36\LaravelRuCurrency\Provider;

use ArtARTs36\CbrCourseFinder\Contracts\Finder as FinderContract;
use ArtARTs36\CbrCourseFinder\Finder;
use ArtARTs36\LaravelRuCurrency\Contracts\CourseCreator as CourseCreatorContract;
use ArtARTs36\LaravelRuCurrency\Contracts\CourseFetcher;
use ArtARTs36\LaravelRuCurrency\Contracts\CourseRepository;
use ArtARTs36\LaravelRuCurrency\Contracts\CurrencyRepository;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Creator\Creator;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\Fetcher;
use ArtARTs36\LaravelRuCurrency\Port\Console\Commands\FetchCoursesCommand;
use ArtARTs36\LaravelRuCurrency\Repository\EloquentCourseRepository;
use ArtARTs36\LaravelRuCurrency\Repository\EloquentCurrencyRepository;
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
            ->when(Finder::class)
            ->needs(ClientInterface::class)
            ->give(fn (Container $container) => $container->make(Client::class));

        $this->mergeConfigFrom(__DIR__ . '/../../config/ru_currency.php', 'ru_currency');
        $this->app->bind(FinderContract::class, Finder::class);
        $this->app->bind(CurrencyRepository::class, EloquentCurrencyRepository::class);
        $this->app->bind(CourseRepository::class, EloquentCourseRepository::class);
        $this->app->bind(CourseCreatorContract::class, Creator::class);
        $this->app->bind(CourseFetcher::class, Fetcher::class);

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->commands(FetchCoursesCommand::class);
        }
    }
}
