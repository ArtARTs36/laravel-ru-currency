<?php

namespace ArtARTs36\LaravelRuCurrency\Contracts;

use ArtARTs36\CbrCourseFinder\Contracts\SearchException;

interface CourseFetcher
{
    /**
     * Fetch courses at date.
     * @throws CourseCreatingException
     * @throws SearchException
     */
    public function fetchAt(\DateTimeInterface $date): int;
}
