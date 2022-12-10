<?php

namespace SaasReady\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SaasReady\Constants\LanguageCode;
use SaasReady\Traits\EloquentBuilderMixin;
use SaasReady\Traits\HasUuid;

/**
 * @property-read int $id
 * @property LanguageCode $code
 * @property string $name
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?Carbon $deleted_at
 *
 * @mixin EloquentBuilderMixin
 */
class Language extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuid;

    protected $table = 'languages';

    protected $fillable = [
        'code',
        'name',
    ];

    protected $casts = [
        'code' => LanguageCode::class,
    ];

    public static function findByCode(LanguageCode $code): ?static
    {
        return static::whereCode($code)->first();
    }
}
