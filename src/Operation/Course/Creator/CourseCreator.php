<?php

namespace ArtARTs36\LaravelRuCurrency\Operation\Course\Creator;

use ArtARTs36\CbrCourseFinder\Contracts\CourseCollection;
use ArtARTs36\LaravelRuCurrency\Contracts\CourseCreatingException;
use ArtARTs36\LaravelRuCurrency\Contracts\CourseRepository;
use ArtARTs36\LaravelRuCurrency\Contracts\CurrencyRepository;
use ArtARTs36\LaravelRuCurrency\Exception\CurrencyNotFound;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\CourseRecorder;
use ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher\RecordingParams;
use Illuminate\Contracts\Config\Repository;

class CourseCreator
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

        if (! $currencies->has($toCurrencyCode)) {
            throw CurrencyNotFound::make($toCurrencyCode);
        }

        /** @var int $toCurrencyId */
        $toCurrencyId = $currencies->get($toCurrencyCode);

        $records = $this->recorder->createRecords(new RecordingParams($currencies, $toCurrencyId, $courses));

        if (count($records) === 0) {
            return 0;
        }

        return $this->courses->insertOrIgnore($records);
    }
}
