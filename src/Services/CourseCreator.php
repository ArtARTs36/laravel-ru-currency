<?php

namespace ArtARTs36\LaravelRuCurrency\Services;

use ArtARTs36\CbrCourseFinder\Contracts\CourseCollection;
use ArtARTs36\CbrCourseFinder\CurrencyCode;
use ArtARTs36\LaravelRuCurrency\Contracts\CurrencyRepository;
use ArtARTs36\LaravelRuCurrency\Models\Course;
use ArtARTs36\LaravelRuCurrency\Models\Currency;

class CourseCreator
{
    protected CurrencyRepository $currencies;

    public function __construct(CurrencyRepository $currencies)
    {
        $this->currencies = $currencies;
    }

    public function create(CourseCollection $courses, ?Currency $toCurrency = null)
    {
        $currencies = $this->currencies->pluck(Currency::FIELD_ISO_CODE, Currency::FIELD_ID);
        $records = [];

        $toCurrency ??= $currencies[CurrencyCode::ISO_RUB];

        /** @var \ArtARTs36\CbrCourseFinder\Course $course */
        foreach ($courses as $course) {
            if (! $currencies->has($course->getIsoCode())) {
                continue;
            }

            $records[] = [
                Course::FIELD_TO_CURRENCY_ID => $toCurrency->id,
                Course::FIELD_FROM_CURRENCY_ID => $currencies->get($course->getIsoCode()),
                Course::FIELD_VALUE => $course->getValue(),
                Course::FIELD_NOMINAL => $course->getNominal(),
                Course::FIELD_ACTUAL_AT => $courses->getActualDate(),
            ];
        }

        Course::query()->insert($records);
    }
}
