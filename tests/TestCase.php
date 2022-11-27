<?php

namespace ArtARTs36\LaravelRuCurrency\Tests;

use ArtARTs36\LaravelRuCurrency\Provider\CurrencyProvider;
use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        $app->bind(ClientInterface::class, Client::class);

        return [
            CurrencyProvider::class,
        ];
    }
}
