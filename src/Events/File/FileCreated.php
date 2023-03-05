<?php

namespace SaasReady\Events\File;

use Illuminate\Queue\SerializesModels;
use SaasReady\Models\File;

class FileCreated
{
    use SerializesModels;

    public function __construct(public File $file)
    {
    }
}
