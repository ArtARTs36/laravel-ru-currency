<?php

namespace ArtARTs36\LaravelRuCurrency\Database\Seeders;

use ArtARTs36\CbrCourseFinder\Data\CurrencyCode;
use ArtARTs36\LaravelRuCurrency\Model\Currency;
use Illuminate\Database\Seeder;

class RuCurrencySeeder extends Seeder
{
    public function run(): void
    {
        Currency::query()->insert([
            [
                Currency::FIELD_ISO_CODE => CurrencyCode::ISO_RUB,
                Currency::FIELD_TITLE => 'Российский рубль',
                Currency::FIELD_SYMBOL => '₽',
            ],
            [
                Currency::FIELD_ISO_CODE => CurrencyCode::ISO_EUR,
                Currency::FIELD_TITLE => 'Евро',
                Currency::FIELD_SYMBOL => '€',
            ],
            [
                Currency::FIELD_ISO_CODE => CurrencyCode::ISO_USD,
                Currency::FIELD_TITLE => 'Доллар США',
                Currency::FIELD_SYMBOL => '$',
            ],
            [
                Currency::FIELD_ISO_CODE => CurrencyCode::ISO_KZT,
                Currency::FIELD_TITLE => 'Казахстанский тенге',
                Currency::FIELD_SYMBOL => '₸',
            ],
            [
                Currency::FIELD_ISO_CODE => CurrencyCode::ISO_UAH,
                Currency::FIELD_TITLE => 'Украинская гривна',
                Currency::FIELD_SYMBOL => '₴',
            ],
            [
                Currency::FIELD_ISO_CODE => CurrencyCode::ISO_BYN,
                Currency::FIELD_TITLE => 'Белорусский рубль',
                Currency::FIELD_SYMBOL => 'Br',
            ]
        ]);
    }
}
