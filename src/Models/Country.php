<?php

namespace SaasReady\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SaasReady\Constants\CountryCode;
use SaasReady\Traits\EloquentBuilderMixin;
use SaasReady\Traits\HasUuid;

/**
 * @property-read int $id
 * @property CountryCode $code
 * @property string $continent
 * @property string $name
 * @property string $dial_code
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?Carbon $deleted_at
 *
 * @mixin EloquentBuilderMixin
 */
class Country extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuid;

    protected $table = 'countries';

    protected $fillable = [
        'code',
        'continent',
        'name',
        'dial_code',
    ];

    protected $casts = [
        'code' => CountryCode::class,
    ];

    public static function findByCode(CountryCode $code): ?static
    {
        return static::whereCode($code)->first();
    }
}
