<?php

namespace ArtARTs36\LaravelRuCurrency\Contracts;

use ArtARTs36\CbrCourseFinder\Data\CourseBag;

interface CourseCreator
{
    /**
     * Create courses from external data.
     * @return int - count of created courses
     * @throws CourseCreatingException
     */
    public function create(CourseBag $courses): int;
}
