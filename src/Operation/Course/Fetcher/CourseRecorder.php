<?php

namespace ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher;

use ArtARTs36\LaravelRuCurrency\Model\Course;

class CourseRecorder
{
    public function createRecords(RecordingParams $params): array
    {
        $records = [];

        /** @var \ArtARTs36\CbrCourseFinder\Data\Course $course */
        foreach ($params->courses as $course) {
            if (! $params->currencies->has($course->isoCode)) {
                continue;
            }

            $records[] = [
                Course::FIELD_TO_CURRENCY_ID => $params->toCurrencyId,
                Course::FIELD_FROM_CURRENCY_ID => $params->currencies->get($course->isoCode),
                Course::FIELD_VALUE => $course->value,
                Course::FIELD_NOMINAL => $course->nominal,
                Course::FIELD_ACTUAL_AT => $params->courses->getActualDate(),
            ];
        }

        return $records;
    }
}
