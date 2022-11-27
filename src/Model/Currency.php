<?php

namespace ArtARTs36\LaravelRuCurrency\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $iso_code
 * @property string $title
 * @property string $symbol
 */
class Currency extends Model
{
    public const FIELD_ID = 'id';
    public const FIELD_ISO_CODE = 'iso_code';
    public const FIELD_TITLE = 'title';
    public const FIELD_SYMBOL = 'symbol';

    public $timestamps = false;

    protected $table = 'money__currencies';

    protected $fillable = [
        self::FIELD_ISO_CODE,
        self::FIELD_TITLE,
        self::FIELD_SYMBOL,
    ];
}
