<?php

namespace ArtARTs36\LaravelRuCurrency\Repositories;

use ArtARTs36\LaravelRuCurrency\Contracts\CurrencyRepository;
use ArtARTs36\LaravelRuCurrency\Models\Currency;
use Illuminate\Support\Collection;

class EloquentCurrencyRepository implements CurrencyRepository
{
    public function pluck(string $key, string $value): Collection
    {
        return Currency::query()->toBase()->pluck($value, $key);
    }

    public function all(): Collection
    {
        return Currency::all();
    }
}
