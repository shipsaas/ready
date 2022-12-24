<?php

namespace SaasReady\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SaasReady\Constants\LanguageCode;
use SaasReady\Models\Translation;

class TranslationFactory extends Factory
{
    protected $model = Translation::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->uuid(),
            'label' => $this->faker->company(),
            'translations' => [
                LanguageCode::ENGLISH->value => $this->faker->realText(10),
            ],
        ];
    }
}
