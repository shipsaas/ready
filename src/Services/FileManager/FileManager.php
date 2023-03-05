<?php

namespace SaasReady\Services\FileManager;

use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SaasReady\Events\File\FileCreated;
use SaasReady\Models\File;

class FileManager
{
    /**
     * Upload the file
     */
    public function upload(UploadOption $uploadOption): ?File
    {
        $driver = $uploadOption->driver ?: Storage::getDefaultDriver();
        $storage = Storage::disk($driver);

        $file = $uploadOption->file;
        $newFileName = $uploadOption->newFileName ?: Str::orderedUuid() . '.' . $file->getExtension();
        $storagePath = $uploadOption->storePath ?: 'files/';

        // upload
        $uploadResult = $storage->putFileAs(
            $storagePath,
            $file,
            $newFileName
        );

        if ($uploadResult === false) {
            return null;
        }

        $file = File::create([
            'category' => $uploadOption->category,
            'model_id' => $uploadOption->source?->getKey(),
            'model_type' => $uploadOption->source?->getMorphClass(),
            'mime_type' => $uploadOption->fileMimeType ?: $file->getType(),
            'path' => $storagePath . $newFileName,
            'filename' => $newFileName,
            'original_filename' => $uploadOption->originalFileName ?: '',
            'size' => $uploadOption->fileSize ?: $file->getSize(),
            'source' => $driver,
        ]);

        Event::dispatch(new FileCreated($file));

        return $file;
    }

    /**
     * Get the URL of the File
     */
    public function getUrl(File $file): ?string
    {
        $disk = $file->getFilesystemDisk();
        if (!$disk->exists($file->path)) {
            return null;
        }

        return $disk->url($file->path);
    }

    /**
     * Get the URL of the File
     *
     * Note: only s3 is supporting this
     */
    public function getTemporaryUrl(File $file, Carbon $expiredAt): ?string
    {
        $disk = $file->getFilesystemDisk();
        if (!$disk->exists($file->path)) {
            return null;
        }

        return $disk->temporaryUrl($file->path, $expiredAt);
    }
}
