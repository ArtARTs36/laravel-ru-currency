<?php

namespace ArtARTs36\LaravelRuCurrency\Contracts;

use ArtARTs36\CbrCourseFinder\Contracts\SearchException;

interface CourseFetcher
{
    /**
     * @throws CourseCreatingException
     * @throws SearchException
     */
    public function fetchAt(\DateTimeInterface $date): int;
}
