<?php

namespace ArtARTs36\LaravelRuCurrency\Contracts;

use Illuminate\Support\Collection;

interface CurrencyRepository
{
    /**
     * @return Collection<string, int>
     */
    public function mapIdOnIsoCode(): Collection;

    public function all(): Collection;

    public function insertOrIgnore(array $values): int;
}
