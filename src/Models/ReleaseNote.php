<?php

namespace SaasReady\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SaasReady\Database\Factories\ReleaseNoteFactory;
use SaasReady\Traits\EloquentBuilderMixin;
use SaasReady\Traits\HasUuid;

/**
 * @property-read int $id
 * @property string $version
 * @property string $note
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 *
 * @mixin EloquentBuilderMixin
 */
class ReleaseNote extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuid;

    protected $table = 'release_notes';

    protected $fillable = [
        'version',
        'note',
    ];

    /**
     * @codeCoverageIgnore
     */
    protected static function newFactory(): ReleaseNoteFactory
    {
        return ReleaseNoteFactory::new();
    }
}
