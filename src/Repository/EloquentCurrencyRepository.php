<?php

namespace ArtARTs36\LaravelRuCurrency\Repository;

use ArtARTs36\LaravelRuCurrency\Contracts\CurrencyRepository;
use ArtARTs36\LaravelRuCurrency\Model\Currency;
use Illuminate\Support\Collection;

class EloquentCurrencyRepository implements CurrencyRepository
{
    public function mapIdOnIsoCode(): Collection
    {
        return Currency::query()->toBase()->pluck(Currency::FIELD_ID, Currency::FIELD_ISO_CODE);
    }

    public function all(): Collection
    {
        return Currency::all();
    }

    public function insert(array $values): void
    {
        Currency::query()->insert($values);
    }
}
