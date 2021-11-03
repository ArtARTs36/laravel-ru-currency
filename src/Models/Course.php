<?php

namespace ArtARTs36\LaravelRuCurrency\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property \DateTimeInterface $actual_at
 * @property Currency $fromCurrency
 * @property int $from_currency_id
 * @property Currency $toCurrency
 * @property int $to_currency_id
 * @property float $value
 * @property int $nominal
 */
class Course extends Model
{
    public const FIELD_ID = 'id';
    public const FIELD_FROM_CURRENCY_ID = 'from_currency_id';
    public const FIELD_TO_CURRENCY_ID = 'to_currency_id';
    public const FIELD_ACTUAL_AT = 'actual_at';
    public const FIELD_VALUE = 'value';
    public const FIELD_NOMINAL = 'nominal';

    public $timestamps = false;

    protected $fillable = [
        self::FIELD_FROM_CURRENCY_ID,
        self::FIELD_TO_CURRENCY_ID,
        self::FIELD_ACTUAL_AT,
        self::FIELD_VALUE,
        self::FIELD_NOMINAL,
    ];

    protected $dates = [
        self::FIELD_ACTUAL_AT,
    ];

    public function fromCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function toCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}