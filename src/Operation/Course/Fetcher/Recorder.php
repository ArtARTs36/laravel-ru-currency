<?php

namespace ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher;

use ArtARTs36\LaravelRuCurrency\Model\Course;

class Recorder
{
    /**
     * @return array<array<string, mixed>>
     */
    public function createRecords(RecordingParams $params): array
    {
        $records = [];

        $toCurrencyId = $params->currencies->get($params->courses->toCurrencyIsoCode->value);

        /** @var \ArtARTs36\CbrCourseFinder\Data\Course $course */
        foreach ($params->courses->courses as $course) {
            if (! $params->currencies->has($course->currency->isoCode->value)) {
                continue;
            }

            $records[] = [
                Course::FIELD_TO_CURRENCY_ID => $toCurrencyId,
                Course::FIELD_FROM_CURRENCY_ID => $params->currencies->get($course->currency->isoCode->value),
                Course::FIELD_VALUE => $course->value,
                Course::FIELD_NOMINAL => $course->nominal,
                Course::FIELD_ACTUAL_AT => $params->courses->actualDate,
            ];
        }

        return $records;
    }
}
