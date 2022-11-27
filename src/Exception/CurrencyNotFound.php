<?php

namespace ArtARTs36\LaravelRuCurrency\Exception;

use ArtARTs36\LaravelRuCurrency\Contracts\CourseCreatingException;

final class CurrencyNotFound extends \Exception implements CourseCreatingException
{
    public static function make(string $currencyCode): self
    {
        return new self(
            sprintf('Currency with code %s not found', $currencyCode),
        );
    }
}
