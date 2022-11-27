<?php

namespace ArtARTs36\LaravelRuCurrency\Operation\Course\Fetcher;

use ArtARTs36\CbrCourseFinder\Contracts\CourseCollection;
use Illuminate\Support\Collection;

class RecordingParams
{
    /**
     * @param Collection<string, int> $currencies
     */
    public function __construct(
        public Collection $currencies,
        public int $toCurrencyId,
        public CourseCollection $courses,
    ) {
        //
    }
}
