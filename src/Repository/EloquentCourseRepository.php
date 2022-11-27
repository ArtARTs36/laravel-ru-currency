<?php

namespace ArtARTs36\LaravelRuCurrency\Repository;

use ArtARTs36\LaravelRuCurrency\Contracts\CourseRepository;
use ArtARTs36\LaravelRuCurrency\Model\Course;

class EloquentCourseRepository implements CourseRepository
{
    public function insertOrIgnore(array $values): int
    {
        return Course::query()->insertOrIgnore($values);
    }
}
