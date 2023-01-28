<?php

namespace SaasReady\Services\FileManager;

use Illuminate\Filesystem\FilesystemManager;
use SaasReady\Models\File;

class FileManager
{
    public function __construct(private FilesystemManager $filesystemManager)
    {
    }

    /**
     * Upload the file
     *
     * @codeCoverageIgnore (WIP)
     */
    public function upload(UploadOption $uploadOption): ?File
    {
        // TODO: implements
        return null;
    }

    /**
     * Get the URL of the File
     *
     * @codeCoverageIgnore (WIP)
     */
    public function preview(File $file): ?string
    {
        return null;
    }
}
