<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->streetName(),
            'image_url' => 'https://picsum.photos/200',
            'target_amount_fils' => fake()->numberBetween(111111111),
            'city_area' => fake()->address(),
            'country_code' => fake()->countryCode(),
            'investment_multiple_fils' => fake()->numberBetween(25, 999900),
        ];
    }
}
