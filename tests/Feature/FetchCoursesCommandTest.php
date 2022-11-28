<?php

namespace ArtARTs36\LaravelRuCurrency\Tests\Feature;

use ArtARTs36\CbrCourseFinder\Contracts\Finder;
use ArtARTs36\CbrCourseFinder\Data\Course;
use ArtARTs36\CbrCourseFinder\Data\CourseBag;
use ArtARTs36\CbrCourseFinder\Data\CourseCollection;
use ArtARTs36\CbrCourseFinder\Data\Currency;
use ArtARTs36\CbrCourseFinder\Data\CurrencyCode;
use ArtARTs36\LaravelRuCurrency\Contracts\CurrencyRepository;
use Illuminate\Support\Collection;
use Mockery\MockInterface;

final class FetchCoursesCommandTest extends TestCase
{
    private const COMMAND_RUN = 'ru-currency:fetch-courses';

    /**
     * @covers \ArtARTs36\LaravelRuCurrency\Port\Console\Commands\FetchCoursesCommand::handle
     */
    public function testHandleOnCoursesNotFound(): void
    {
        $this
            ->mock(Finder::class, static function (MockInterface $mock) {
                $mock
                    ->shouldReceive('findAt')
                    ->once()
                    ->andReturn(new CourseBag(new CourseCollection([]), new \DateTime(), CurrencyCode::ISO_AMD));
            });

        $this
            ->artisan(self::COMMAND_RUN)
            ->expectsOutput('Created 0 courses')
            ->assertSuccessful();
    }

    /**
     * @covers \ArtARTs36\LaravelRuCurrency\Port\Console\Commands\FetchCoursesCommand::handle
     */
    public function testHandleOnDefaultCurrencyNotFound(): void
    {
        $this
            ->mock(CurrencyRepository::class, static function (MockInterface $mock) {
                $mock
                    ->shouldReceive('mapIdOnIsoCode')
                    ->once()
                    ->andReturn(new Collection());

                return $mock;
            });

        $this
            ->mock(Finder::class, static function (MockInterface $mock) {
                $mock
                    ->shouldReceive('findAt')
                    ->once()
                    ->andReturn(new CourseBag(
                        new CourseCollection([new Course(new Currency(CurrencyCode::ISO_RUB, ''), 1, 1, 1)]),
                        new \DateTime(),
                        CurrencyCode::ISO_RUB,
                    ));
            });

        $this
            ->artisan(self::COMMAND_RUN)
            ->expectsOutput('Courses not created: Currency with code RUB not found')
            ->assertFailed();
    }
}
