<?php

namespace ArtARTs36\LaravelRuCurrency\Tests\Unit;

use ArtARTs36\CbrCourseFinder\Data\CourseCollection;
use ArtARTs36\LaravelRuCurrency\Model\Course;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Creator\CourseCreator;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\CourseRecorder;
use ArtARTs36\LaravelRuCurrency\Repository\EloquentCourseRepository;
use ArtARTs36\LaravelRuCurrency\Repository\EloquentCurrencyRepository;
use ArtARTs36\LaravelRuCurrency\Tests\TestCase;
use Illuminate\Config\Repository;
use Illuminate\Support\Collection;
use Mockery\MockInterface;

final class CourseCreatorTest extends TestCase
{
    public function providerForTestCreate(): array
    {
        return [
            // #1
            [
                new CourseCollection(
                    [],
                    new \DateTime('2020-01-01 14:00:00')
                ),
                'RUB',
                0,
            ],
            // #2
            [
                new CourseCollection(
                    [
                        new \ArtARTs36\CbrCourseFinder\Data\Course(
                            'RUB',
                            'RUB',
                            1.0,
                            1.0,
                            1.0,
                        )
                    ],
                    new \DateTime('2020-01-01 14:00:00')
                ),
                'RUB',
                1,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestCreate
     * @covers CourseCreator::create
     */
    public function testCreate(CourseCollection $courses, string $currencyCode, int $expected): void
    {
        $currencyRepo = $this->mock(EloquentCurrencyRepository::class, static function (MockInterface $mock) use ($currencyCode) {
            $mock
                ->shouldReceive('mapIdOnIsoCode')
                ->andReturn(new Collection([
                    $currencyCode => 1,
                ]));
        });

        $courseRepo = $this->mock(EloquentCourseRepository::class, static function (MockInterface $mock) {
            $mock
                ->shouldReceive('insertOrIgnore')
                ->andReturn(1);
        });

        $creator = new CourseCreator($currencyRepo, $courseRepo, new Repository(), new CourseRecorder());

        self::assertEquals($expected, $creator->create($courses, $currencyCode));
    }
}
