<?php

namespace SaasReady\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SaasReady\Constants\LanguageCode;
use SaasReady\Models\Language;

class LanguageFactory extends Factory
{
    protected $model = Language::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->randomElement(LanguageCode::cases()),
            'name' => $this->faker->name(),
        ];
    }
}
