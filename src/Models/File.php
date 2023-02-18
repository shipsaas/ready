<?php

namespace SaasReady\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use SaasReady\Database\Factories\FileFactory;
use SaasReady\Traits\EloquentBuilderMixin;
use SaasReady\Traits\HasUuid;

/**
 * @property-read int $id
 * @property-read string $uuid
 * @property ?string $model_type
 * @property ?int $model_id
 * @property ?string $category
 * @property string $filename
 * @property string $original_filename
 * @property string $path
 * @property string $mime_type
 * @property int $size
 * @property string $source
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?Carbon $deleted_at
 *
 * @property-read ?Model $model
 *
 * @mixin EloquentBuilderMixin
 */
class File extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuid;

    protected $table = 'files';

    protected $fillable = [
        'model_id',
        'model_type',
        'category',
        'filename',
        'original_filename',
        'size',
        'path',
        'mime_type',
        'source',
    ];

    protected $casts = [
        'size' => 'int',
        'model_id' => 'int',
    ];

    public function model(): MorphTo
    {
        return $this->morphTo('model');
    }

    /**
     * @codeCoverageIgnore
     */
    protected static function newFactory(): FileFactory
    {
        return FileFactory::new();
    }
}
