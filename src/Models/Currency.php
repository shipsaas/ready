<?php

namespace SaasReady\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SaasReady\Constants\CurrencyCode;
use SaasReady\Traits\EloquentBuilderMixin;
use SaasReady\Traits\HasUuid;

/**
 * @property-read int $id
 * @property string $code
 * @property string $name
 * @property string $symbol
 * @property int $decimals
 * @property string $decimal_separator
 * @property string $thousands_separator
 * @property bool $space_after_symbol
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?Carbon $deleted_at
 *
 * @mixin EloquentBuilderMixin
 */
class Currency extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuid;

    protected $table = 'currencies';

    protected $fillable = [
        'code',
        'iso3_code',
        'name',
    ];

    protected $casts = [
        'code' => CurrencyCode::class,
        'decimals' => 'int',
        'space_after_symbol' => 'bool',
    ];
}
