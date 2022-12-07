<?php

namespace SaasReady\Traits;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property-read string $uuid
 * @mixin Model
 */
trait HasUuid
{
    /**
     * Boot trait
     */
    protected static function bootHasUuid(): void
    {
        static::creating(static::getCreatingUuidHandler(...));
    }

    /**
     * Create a unique reference code when a Model is in the creating boot event
     */
    protected static function getCreatingUuidHandler(Model $model): void
    {
        if (empty($model->uuid)) {
            $model->uuid = (string) Str::orderedUuid();
        }
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Fetch Model by Uuid
     */
    public static function findByUuid(?string $uuid): ?static
    {
        return self::where('uuid', $uuid)->first();
    }
}
