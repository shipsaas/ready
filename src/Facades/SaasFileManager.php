<?php

namespace SaasReady\Facades;

use Illuminate\Support\Facades\Facade;
use SaasReady\Models\File;
use SaasReady\Services\FileManager\FileManager;
use SaasReady\Services\FileManager\UploadOption;

/**
 * @method static File|null upload(UploadOption $uploadOption)
 * @method static string|null getUrl(File $file)
 * @method static string|null getTemporaryUrl(File $file)
 */
class SaasFileManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FileManager::class;
    }
}
