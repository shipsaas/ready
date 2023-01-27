<?php

namespace SaasReady\Events\ReleaseNote;

use Illuminate\Queue\SerializesModels;
use SaasReady\Models\ReleaseNote;

class ReleaseNoteCreated
{
    use SerializesModels;

    public function __construct(public ReleaseNote $releaseNote)
    {
    }
}
