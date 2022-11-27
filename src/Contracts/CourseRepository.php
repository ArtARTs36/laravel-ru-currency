<?php

namespace ArtARTs36\LaravelRuCurrency\Contracts;

interface CourseRepository
{
    /**
     * @param array<array<string, mixed>> $values
     */
    public function insertOrIgnore(array $values): int;
}
