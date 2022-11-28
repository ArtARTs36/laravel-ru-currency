<?php

namespace ArtARTs36\LaravelRuCurrency\Tests\Unit;

use ArtARTs36\CbrCourseFinder\Data\CourseBag;
use ArtARTs36\CbrCourseFinder\Data\CourseCollection;
use ArtARTs36\CbrCourseFinder\Data\Currency;
use ArtARTs36\CbrCourseFinder\Data\CurrencyCode;
use ArtARTs36\LaravelRuCurrency\Model\Course;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Creator\Creator;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\Recorder;
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
                new CourseCollection([]),
                'RUB',
                0,
            ],
            // #2
            [
                new CourseCollection(
                    [
                        new \ArtARTs36\CbrCourseFinder\Data\Course(
                            new Currency(CurrencyCode::ISO_AMD, ''),
                            1.0,
                            1.0,
                            1.0,
                        ),
                    ],
                ),
                'RUB',
                1,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestCreate
     * @covers Creator::create
     */
    public function testCreate(CourseCollection $courses, string $currencyCode, int $expected): void
    {
        $currencyRepo = $this->mock(EloquentCurrencyRepository::class, static function (MockInterface $mock) use ($currencyCode, $courses) {
            $map = [
                $currencyCode => $id = 1,
            ];

            /** @var \ArtARTs36\CbrCourseFinder\Data\Course $course */
            foreach ($courses as $course) {
                $map[$course->currency->isoCode->value] = ++$id;
            }

            $mock
                ->shouldReceive('mapIdOnIsoCode')
                ->andReturn(new Collection($map));
        });

        $courseRepo = $this->mock(EloquentCourseRepository::class, static function (MockInterface $mock) use ($expected) {
            $mock
                ->shouldReceive('insertOrIgnore')
                ->andReturn($expected);
        });

        $creator = new Creator($currencyRepo, $courseRepo, new Repository(), new Recorder());

        self::assertEquals($expected, $creator->create(new CourseBag(
            $courses,
            new \DateTime(),
            CurrencyCode::from($currencyCode),
        )));
    }
}
