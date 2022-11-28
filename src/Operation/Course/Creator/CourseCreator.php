<?php

namespace ArtARTs36\LaravelRuCurrency\Operation\Course\Creator;

use ArtARTs36\CbrCourseFinder\Contracts\CourseCollection;
use ArtARTs36\CbrCourseFinder\Data\CourseBag;
use ArtARTs36\LaravelRuCurrency\Contracts\CourseCreatingException;
use ArtARTs36\LaravelRuCurrency\Contracts\CourseRepository;
use ArtARTs36\LaravelRuCurrency\Contracts\CurrencyRepository;
use ArtARTs36\LaravelRuCurrency\Exception\CurrencyNotFound;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\CourseRecorder;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\RecordingParams;
use Illuminate\Contracts\Config\Repository;

class CourseCreator implements \ArtARTs36\LaravelRuCurrency\Contracts\CourseCreator
{
    public function __construct(
        protected CurrencyRepository $currencies,
        protected CourseRepository $courses,
        protected Repository $config,
        protected CourseRecorder $recorder,
    ) {
        //
    }

    /**
     * @throws CourseCreatingException
     */
    public function create(CourseBag $courses): int
    {
        $currencies = $this->currencies->mapIdOnIsoCode();

        if (! $currencies->has($courses->toCurrencyIsoCode->value)) {
            throw CurrencyNotFound::make($courses->toCurrencyIsoCode->value);
        }

        $records = $this->recorder->createRecords(new RecordingParams($currencies, $courses));

        if (count($records) === 0) {
            return 0;
        }

        return $this->courses->insertOrIgnore($records);
    }
}
