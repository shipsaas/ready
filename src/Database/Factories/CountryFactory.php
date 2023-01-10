<?php

namespace SaasReady\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SaasReady\Constants\CountryCode;
use SaasReady\Models\Country;

class CountryFactory extends Factory
{
    protected $model = Country::class;

    public function definition(): array
    {
        return [
            'code' => collect(CountryCode::cases())->random(),
            'continent' => $this->faker->name(),
            'name' => $this->faker->country(),
            'dial_code' => '+' . $this->faker->numberBetween(1, 999),
        ];
    }
}
