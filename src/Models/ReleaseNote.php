<?php

namespace SaasReady\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SaasReady\Database\Factories\ReleaseNoteFactory;
use SaasReady\Traits\HasUuid;

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
