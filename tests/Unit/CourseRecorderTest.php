<?php

namespace ArtARTs36\LaravelRuCurrency\Tests\Unit;

use ArtARTs36\CbrCourseFinder\Data\Course;
use ArtARTs36\CbrCourseFinder\Data\CourseCollection;
use ArtARTs36\LaravelRuCurrency\Model\Currency;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\CourseRecorder;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\RecordingParams;
use ArtARTs36\LaravelRuCurrency\Tests\TestCase;
use Illuminate\Support\Collection;

class CourseRecorderTest extends TestCase
{
    public function providerForTestCreateRecords(): array
    {
        return [
            [
                new RecordingParams(new Collection(), 1, new CourseCollection([], new \DateTime())),
                [],
            ],
            [
                new RecordingParams(
                    new Collection(),
                    1,
                    new CourseCollection([
                        new Course('abc', '', 1, 2, 3),
                    ], new \DateTime()),
                ),
                [],
            ],
            [
                new RecordingParams(
                    new Collection([
                        'abc' => new Currency([
                            Currency::FIELD_ID => 2,
                        ]),
                    ]),
                    1,
                    new CourseCollection([
                        new Course('abc', '', 1, 2, 3),
                    ], $d = new \DateTime()),
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
     * @covers \ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\CourseRecorder::createRecords
     */
    public function testCreateRecords(RecordingParams $params, array $expected): void
    {
        $recorder = new CourseRecorder();

        self::assertEquals($expected, $recorder->createRecords($params));
    }
}
