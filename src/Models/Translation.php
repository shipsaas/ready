<?php

namespace SaasReady\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SaasReady\Traits\EloquentBuilderMixin;
use SaasReady\Traits\HasUuid;

/**
 * @property-read int $id
 * @property string $key
 * @property string $label
 * @property array $translations eg: ['en' => 'Seth Phat', 'vi' => 'Phat Tran']
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?Carbon $deleted_at
 *
 * @mixin EloquentBuilderMixin
 */
class Translation extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuid;

    protected $table = 'translations';

    protected $fillable = [
        'key',
        'label',
        'translations',
    ];

    protected $casts = [
        'translations' => 'array',
    ];

    public static function findByKey(string $key, array $columns = ['*']): ?static
    {
        return static::where('key', $key)->first($columns);
    }
}
