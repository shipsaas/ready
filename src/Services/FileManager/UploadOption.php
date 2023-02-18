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
    public ?string $fileMimeType = null;

    /**
     * Desired path to store the file
     *
     * @example user/$user->id/avatar/
     */
    public string $storePath = 'files/';

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

    /**
     * Category name of the file.
     */
    public string $category = 'file';

    /**
     * Custom driver of the file.
     *
     * By default, it will use the default driver from ENV
     */
    public ?string $driver = null;

    /**
     * Create the upload option from UploadedFile
     */
    public static function prepareFromUploadedFile(UploadedFile $uploadedFile): self
    {
        $option = new self();
        $option->file = $uploadedFile->getFileInfo();
        $option->fileMimeType = $uploadedFile->getClientMimeType();

        return $option;
    }

    /**
     * Create the upload option from a specific file in your server/machine
     */
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
