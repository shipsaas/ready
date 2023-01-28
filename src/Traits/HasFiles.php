<?php

namespace SaasReady\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use SaasReady\Models\File;

/**
 * @note Please use this trait just for Eloquent Models
 *
 * @property-read File[]|Collection $files
 * @property-read ?File $latestFile
 */
trait HasFiles
{
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'model');
    }

    public function latestFile(): MorphOne
    {
        return $this->morphOne(File::class, 'model')
            ->latest();
    }
}
