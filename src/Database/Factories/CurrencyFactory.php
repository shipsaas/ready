<?php

namespace SaasReady\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SaasReady\Constants\CurrencyCode;
use SaasReady\Models\Currency;

class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->randomElement(CurrencyCode::cases()),
            'symbol' => '$',
            'name' => $this->faker->name(),
            'decimal_separator' => '.',
            'thousands_separator' => ',',
            'space_after_symbol' => true,
        ];
    }
}
