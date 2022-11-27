<?php

namespace ArtARTs36\LaravelRuCurrency\Tests\Feature;

abstract class TestCase extends \ArtARTs36\LaravelRuCurrency\Tests\TestCase
{
    public function setup() : void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testing']);

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadLaravelMigrations(['--database' => 'testing']);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');
        $app['config']->set('app.debug', true);
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
