<?php

namespace ArtARTs36\LaravelRuCurrency\Tests\Feature;

use ArtARTs36\LaravelRuCurrency\Contracts\CurrencyRepository;
use Illuminate\Support\Collection;
use Mockery\MockInterface;

final class FetchCoursesCommandTest extends TestCase
{
    /**
     * @covers \ArtARTs36\LaravelRuCurrency\Ports\Console\Commands\FetchCoursesCommand::handle
     */
    public function testHandleOnDefaultCurrencyNotFound(): void
    {
        $this
            ->mock(CurrencyRepository::class, static function (MockInterface $mock) {
                $mock
                    ->shouldReceive('pluck')
                    ->once()
                    ->andReturn(new Collection());

                return $mock;
            });

        $this
            ->artisan("money:fetch-courses")
            ->expectsOutput('Courses not created: Currency with code RUB not found')
            ->assertFailed();
    }
}
