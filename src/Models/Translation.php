<?php

namespace SaasReady\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SaasReady\Database\Factories\TranslationFactory;
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
 * @method static Builder|static filterByKeyword(string $keyword)
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

    public function scopeFilterByKeyword(Builder $builder, string $keyword): Builder
    {
        return $builder->where(function (Builder $builder) use ($keyword) {
            $builder->orWhere('key', 'LIKE', '%' . $keyword . '%')
                ->orWhere('label', 'LIKE', '%' . $keyword . '%')
                ->orWhere('translations', 'LIKE', '%' . $keyword . '%');
        });
    }

    /**
     * @codeCoverageIgnore
     */
    protected static function newFactory(): TranslationFactory
    {
        return TranslationFactory::new();
    }
}
