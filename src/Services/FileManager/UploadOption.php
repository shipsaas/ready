<?php

namespace SaasReady\Services\FileManager;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use RuntimeException;
use SplFileInfo;

final class UploadOption
{
    /**
     * The file that will be uploaded to storage disk
     */
    public SplFileInfo $file;

    /**
     * Desired path to store the file
     *
     * @example user/$user->id/avatar/
     */
    public string $storePath = '';

    /**
     * New filename after uploaded
     *
     * By default, auto generate by Ready
     */
    public ?string $newFileName = null;

    /**
     * Source model of the File
     */
    public ?Model $source = null;

    public static function prepareFromUploadedFile(UploadedFile $uploadedFile): self
    {
        $option = new self();
        $option->file = $uploadedFile->getFileInfo();

        return $option;
    }

    public static function prepareFromPath(string $filePath): self
    {
        $option = new self();
        $option->file = new SplFileInfo($filePath);

        if (!$option->file->isReadable()) {
            throw new RuntimeException("The file $filePath is not readable. Cannot process further.");
        }

        return $option;
    }
}
