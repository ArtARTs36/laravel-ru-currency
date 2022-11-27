<?php

namespace ArtARTs36\LaravelRuCurrency\Tests\Integration;

use ArtARTs36\LaravelRuCurrency\Model\Currency;
use ArtARTs36\LaravelRuCurrency\Repository\EloquentCurrencyRepository;
use ArtARTs36\LaravelRuCurrency\Tests\Feature\TestCase;

final class EloquentCurrencyRepositoryTest extends TestCase
{
    public function providerForTestMapIdOnIsoCode(): array
    {
        return [
            [
                [
                    [
                        Currency::FIELD_ID => 1,
                        Currency::FIELD_ISO_CODE => 'code1',
                        Currency::FIELD_TITLE => 'title1',
                        Currency::FIELD_SYMBOL => 'a',
                    ],
                    [
                        Currency::FIELD_ID => 2,
                        Currency::FIELD_ISO_CODE => 'code2',
                        Currency::FIELD_TITLE => 'title2',
                        Currency::FIELD_SYMBOL => 'b',
                    ],
                ],
                [
                    'code1' => 1,
                    'code2' => 2,
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestMapIdOnIsoCode
     * @param array<array<string, mixed>> $data
     * @param array<string, string> $expected
     */
    public function testMapIdOnIsoCode(array $data, array $expected): void
    {
        Currency::query()->insert($data);

        $repo = $this->makeRepo();

        self::assertEquals($expected, $repo->mapIdOnIsoCode()->all());
    }

    private function makeRepo(): EloquentCurrencyRepository
    {
        return new EloquentCurrencyRepository();
    }
}
