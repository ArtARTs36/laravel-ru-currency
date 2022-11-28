<?php

namespace ArtARTs36\LaravelRuCurrency\Tests\Unit;

use ArtARTs36\CbrCourseFinder\Data\Course;
use ArtARTs36\CbrCourseFinder\Data\CourseBag;
use ArtARTs36\CbrCourseFinder\Data\CourseCollection;
use ArtARTs36\CbrCourseFinder\Data\CurrencyCode;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\Recorder;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\RecordingParams;
use ArtARTs36\LaravelRuCurrency\Tests\TestCase;
use Illuminate\Support\Collection;

class CourseRecorderTest extends TestCase
{
    public function providerForTestCreateRecords(): array
    {
        return [
            [
                new RecordingParams(new Collection(), new CourseBag(new CourseCollection([]), new \DateTime(), CurrencyCode::ISO_AMD)),
                [],
            ],
            [
                new RecordingParams(
                    new Collection(),
                    new CourseBag(
                        new CourseCollection([
                            new Course(new \ArtARTs36\CbrCourseFinder\Data\Currency(CurrencyCode::ISO_AMD, ''), 1, 2, 3),
                        ]),
                        new \DateTime(),
                        CurrencyCode::ISO_AMD,
                    ),
                ),
                [],
            ],
            [
                new RecordingParams(
                    new Collection([
                        CurrencyCode::ISO_AMD->value => 2,
                        CurrencyCode::ISO_RUB->value => 1,
                    ]),
                    new CourseBag(
                        new CourseCollection([
                            new Course(
                                new \ArtARTs36\CbrCourseFinder\Data\Currency(CurrencyCode::ISO_AMD, ''),
                                1,
                                2,
                                3,
                            ),
                        ]),
                        $d = new \DateTime(),
                        CurrencyCode::ISO_RUB,
                    ),
                ),
                [
                    [
                        \ArtARTs36\LaravelRuCurrency\Model\Course::FIELD_FROM_CURRENCY_ID => 2,
                        \ArtARTs36\LaravelRuCurrency\Model\Course::FIELD_TO_CURRENCY_ID => 1,
                        \ArtARTs36\LaravelRuCurrency\Model\Course::FIELD_VALUE => 2.0,
                        \ArtARTs36\LaravelRuCurrency\Model\Course::FIELD_NOMINAL => 1.0,
                        \ArtARTs36\LaravelRuCurrency\Model\Course::FIELD_ACTUAL_AT => $d,
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestCreateRecords
     * @covers \ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\Recorder::createRecords
     */
    public function testCreateRecords(RecordingParams $params, array $expected): void
    {
        $recorder = new Recorder();

        self::assertEquals($expected, $recorder->createRecords($params));
    }
}
