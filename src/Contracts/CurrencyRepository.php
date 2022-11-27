<?php

namespace ArtARTs36\LaravelRuCurrency\Contracts;

use Illuminate\Support\Collection;

interface CurrencyRepository
{
    public function pluck(string $key, string $value): Collection;

    public function all(): Collection;

    public function insertOrIgnore(array $values): int;
}
