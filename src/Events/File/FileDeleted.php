<?php

namespace SaasReady\Events\File;

use Illuminate\Queue\SerializesModels;

class FileDeleted
{
    use SerializesModels;

    public function __construct(public string $fileUuid)
    {
    }
}
