<?php

namespace SaasReady\Events\ReleaseNote;

use Illuminate\Queue\SerializesModels;
use SaasReady\Models\ReleaseNote;

class ReleaseNoteDeleted
{
    use SerializesModels;

    public function __construct(public ReleaseNote $releaseNote)
    {
    }
}
