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
            'code' => $this->faker->randomElement([
                CurrencyCode::VIETNAM_DONG,
                CurrencyCode::UNITED_STATES_DOLLAR,
                CurrencyCode::SINGAPORE_DOLLAR,
            ]),
            'symbol' => '$',
            'name' => 'Currency',
            'decimal_separator' => '.',
            'thousands_separator' => ',',
            'space_after_symbol' => true,
        ];
    }
}
