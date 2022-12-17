<?php

namespace SaasReady\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use SaasReady\Contracts\EventSourcingContract;
use SaasReady\Traits\EloquentBuilderMixin;
use SaasReady\Traits\HasUuid;

/**
 * @property-read int $id
 * @property int $model_id
 * @property string $model_type
 * @property string $name
 * @property string $category
 * @property array $properties
 * @property int $user_id
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 *
 * @property-read Model $model
 * @property-read ?Model $user
 *
 * @mixin EloquentBuilderMixin
 */
class Event extends Model
{
    use HasFactory;
    use HasUuid;

    protected $table = 'events';

    protected $fillable = [
        'name',
        'user_id',
        'model_id',
        'model_type',
        'category',
        'properties',
    ];

    protected $casts = [
        'user_id' => 'int',
        'properties' => 'array',
    ];

    /**
     * An Event belongsTo a model
     */
    public function model(): MorphTo
    {
        return $this->morphTo('model');
    }

    /**
     * An Event belongs to a User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            config('saas-ready.event-sourcing.user-model'),
            'user_id'
        );
    }

    /**
     * Quickly create a new instance from Contract
     */
    public static function createFromContract(EventSourcingContract $contractor): Event
    {
        $baseModel = $contractor->getModel();

        return Event::create([
            'name' => class_basename($contractor),
            'category' => $contractor->getCategory(),
            'properties' => $contractor->getEventProperties(),
            'model_id' => $baseModel->getKey(),
            'model_type' => $baseModel->getMorphClass(),
            'user_id' => $contractor->getUser()?->getKey(),
        ]);
    }
}
