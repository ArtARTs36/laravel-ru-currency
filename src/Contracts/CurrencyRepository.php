<?php

namespace ArtARTs36\LaravelRuCurrency\Contracts;

use ArtARTs36\LaravelRuCurrency\Model\Currency;
use Illuminate\Support\Collection;

interface CurrencyRepository
{
    /**
     * Map id on iso_code.
     * @return Collection<string, int>
     */
    public function mapIdOnIsoCode(): Collection;

    /**
     * Get all currencies.
     * @return Collection<Currency>
     */
    public function all(): Collection;

    /**
     * Insert currencies.
     * @param array<array<string, mixed>> $values
     */
    public function insertOrIgnore(array $values): int;
}
