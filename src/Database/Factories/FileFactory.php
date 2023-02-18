<?php

namespace SaasReady\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use SaasReady\Models\Currency;
use SaasReady\Models\File;

class FileFactory extends Factory
{
    protected $model = File::class;

    public function definition(): array
    {
        $fakeFile = UploadedFile::fake()
            ->create($this->faker->slug() . '.txt');

        return [
            'model_id' => fn () => Currency::factory()->create(),
            'model_type' => Currency::class,
            'category' => $this->faker->creditCardType(),
            'filename' => $fakeFile->getBasename(),
            'original_filename' => $fakeFile->getBasename(),
            'path' => $fakeFile->path(),
            'size' => $fakeFile->getSize(),
            'mime_type' => 'text/plain',
            'source' => 'local',
        ];
    }
}
