## Laravel RuCurrency

![PHP Composer](https://github.com/ArtARTs36/laravel-ru-currency/workflows/Testing/badge.svg?branch=master)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
<a href="https://poser.pugx.org/artarts36/laravel-ru-currency/d/total.svg">
<img src="https://poser.pugx.org/artarts36/laravel-ru-currency/d/total.svg" alt="Total Downloads">
</a>

This package provides currencies with courses For Laravel

## Installation

1. Run: `composer require artarts36/laravel-ru-currency`
2. Add provider `ArtARTs36\LaravelRuCurrency\Provider\CurrencyProvider::class` into your providers in app.php
3. Run: `php artisan migrate`
4. Run: `php artisan db:seed --class="\ArtARTs36\LaravelRuCurrency\Database\Seeders\RuCurrencySeeder"`
5. Run: `php artisan ru-currency:fetch-courses`

If you see the error `Target [Psr\Http\Client\ClientInterface] is not instantiable while building [ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\CourseFetcher, ArtARTs36\CbrCourseFinder\Finder]`, then add the following line to your provider:
```php
$this->app->bind(ClientInterface::class, \GuzzleHttp\Client::class);
```

## Commands for Application

| Command                                     | Description                  |
|---------------------------------------------|------------------------------|
| ru-currency:fetch-courses                   | Fetch actual courses         |
| ru-currency:fetch-courses --date=2020-02-03 | Fetch actual courses at date |

## Development Console

| Command               | Description                        |
|-----------------------|------------------------------------|
| composer lint         | Check code on PSR (PHP CS Sniffer) |
| composer stat-analyse | Run stat-analyse (PHPStan)         |
| composer test         | Run tests (PHPUnit)                |
