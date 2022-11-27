<?php

namespace ArtARTs36\LaravelRuCurrency\Services;

use ArtARTs36\CbrCourseFinder\Contracts\CourseCollection;
use ArtARTs36\LaravelRuCurrency\Contracts\CourseCreatingException;
use ArtARTs36\LaravelRuCurrency\Contracts\CurrencyRepository;
use ArtARTs36\LaravelRuCurrency\Exception\CurrencyNotFound;
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

    /**
     * @throws CourseCreatingException
     */
    public function createOnDefaultCurrency(CourseCollection $courses): int
    {
        return $this->create($courses, $this->config->get('ru_currency.default'));
    }

    /**
     * @throws CourseCreatingException
     */
    public function create(CourseCollection $courses, string $toCurrencyCode): int
    {
        $currencies = $this->currencies->mapIdOnIsoCode();
        $records = [];

        if (! $currencies->has($toCurrencyCode)) {
            throw CurrencyNotFound::make($toCurrencyCode);
        }

        $toCurrencyId = $currencies->get($toCurrencyCode);

        /** @var \ArtARTs36\CbrCourseFinder\Data\Course $course */
        foreach ($courses as $course) {
            if (! $currencies->has($course->isoCode)) {
                continue;
            }

            $records[] = [
                Course::FIELD_TO_CURRENCY_ID => $toCurrencyId,
                Course::FIELD_FROM_CURRENCY_ID => $currencies->get($course->isoCode),
                Course::FIELD_VALUE => $course->value,
                Course::FIELD_NOMINAL => $course->nominal,
                Course::FIELD_ACTUAL_AT => $courses->getActualDate(),
            ];
        }

        return $this->currencies->insertOrIgnore($records);
    }
}
