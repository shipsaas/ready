<?php

namespace SaasReady\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use SaasReady\Database\Factories\DynamicSettingFactory;
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
    use HasFactory;

    protected $table = 'dynamic_settings';

    protected $fillable = [
        'model_id',
        'model_type',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public static ?DynamicSetting $globalSettingShortage = null;

    public function model(): MorphTo
    {
        return $this->morphTo('model');
    }

    public function getSetting(string $key, mixed $fallback = null): mixed
    {
        return data_get($this->settings, $key, $fallback);
    }

    public static function getGlobal(): ?static
    {
        if (config('saas-ready.dynamic-settings.use-shortage-cache-global')) {
            return static::$globalSettingShortage
                ??= static::whereNull('model_id')
                    ->whereNull('model_type')
                    ->first();
        }

        return static::whereNull('model_id')
            ->whereNull('model_type')
            ->first();
    }

    /**
     * @codeCoverageIgnore
     */
    protected static function newFactory(): DynamicSettingFactory
    {
        return DynamicSettingFactory::new();
    }
}
