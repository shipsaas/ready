<?php

namespace SaasReady\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SaasReady\Models\Currency;
use SaasReady\Models\File;

class FileFactory extends Factory
{
    protected $model = File::class;

    public function definition(): array
    {
        return [
            'model_id' => fn () => Currency::factory()->create(),
            'model_type' => Currency::class,
            'category' => $this->faker->creditCardType(),
            'filename' => $this->faker->userName() . $this->faker->fileExtension(),
            'original_filename' => $this->faker->userName() . $this->faker->fileExtension(),
            'size' => random_int(1000, 999999),
            'path' => $this->faker->filePath(),
            'mime_type' => $this->faker->mimeType(),
            'source' => 'test',
        ];
    }
}
