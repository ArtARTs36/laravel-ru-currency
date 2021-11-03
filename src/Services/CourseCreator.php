<?php

namespace ArtARTs36\LaravelRuCurrency\Services;

use ArtARTs36\CbrCourseFinder\Contracts\CourseCollection;
use ArtARTs36\CbrCourseFinder\CurrencyCode;
use ArtARTs36\LaravelRuCurrency\Contracts\CurrencyRepository;
use ArtARTs36\LaravelRuCurrency\Models\Course;
use ArtARTs36\LaravelRuCurrency\Models\Currency;
use Illuminate\Contracts\Config\Repository;

class CourseCreator
{
    protected CurrencyRepository $currencies;

    protected Repository $config;

    public function __construct(CurrencyRepository $currencies, Repository $config)
    {
        $this->currencies = $currencies;
        $this->config = $config;
    }

    public function createOnDefaultCurrency(CourseCollection $courses): int
    {
        return $this->create($courses, $this->config->get('ru_currency.default'));
    }

    public function create(CourseCollection $courses, string $toCurrencyCode = null): int
    {
        $currencies = $this->currencies->pluck(Currency::FIELD_ISO_CODE, Currency::FIELD_ID);
        $records = [];

        $toCurrencyId = $currencies[$toCurrencyCode];

        /** @var \ArtARTs36\CbrCourseFinder\Course $course */
        foreach ($courses as $course) {
            if (! $currencies->has($course->getIsoCode())) {
                continue;
            }

            $records[] = [
                Course::FIELD_TO_CURRENCY_ID => $toCurrencyId,
                Course::FIELD_FROM_CURRENCY_ID => $currencies->get($course->getIsoCode()),
                Course::FIELD_VALUE => $course->getValue(),
                Course::FIELD_NOMINAL => $course->getNominal(),
                Course::FIELD_ACTUAL_AT => $courses->getActualDate(),
            ];
        }

        return Course::query()->insertOrIgnore($records);
    }
}
