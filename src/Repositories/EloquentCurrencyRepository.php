<?php

namespace ArtARTs36\LaravelRuCurrency\Repositories;

use ArtARTs36\LaravelRuCurrency\Contracts\CurrencyRepository;
use ArtARTs36\LaravelRuCurrency\Models\Currency;
use Illuminate\Support\Collection;

class EloquentCurrencyRepository implements CurrencyRepository
{
    public function mapIdOnIsoCode(): Collection
    {
        return Currency::query()->toBase()->pluck(Currency::FIELD_ISO_CODE, Currency::FIELD_ID);
    }

    public function all(): Collection
    {
        return Currency::all();
    }

    public function insertOrIgnore(array $values): int
    {
        return Currency::query()->insertOrIgnore($values);
    }
}
