<?php

namespace SaasReady\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use SaasReady\Traits\EloquentBuilderMixin;
use SaasReady\Traits\HasUuid;

/**
 * @property-read int $id
 * @property int $model_id
 * @property string $model_type
 * @property array $settings
 *
 * @property-read ?Model $model
 *
 * @mixin EloquentBuilderMixin
 */
class DynamicSetting extends Model
{
    use HasUuid;

    protected $table = 'dynamic_settings';

    protected $fillable = [
        'model_id',
        'model_type',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function model(): MorphTo
    {
        return $this->morphTo('model');
    }

    public function getSetting(string $key, mixed $fallback = null): mixed
    {
        return $this->settings[$key] ?? $fallback;
    }

    public static function getGlobal(): ?static
    {
        return static::whereNull('model_id')
            ->whereNull('model_id')
            ->first();
    }
}
