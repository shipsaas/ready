<?php

namespace SaasReady\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SaasReady\Models\ReleaseNote;

class ReleaseNoteFactory extends Factory
{
    protected $model = ReleaseNote::class;

    public function definition(): array
    {
        return [
            'version' => $this->faker->semver(),
            'note' => $this->faker->text(),
        ];
    }
}
