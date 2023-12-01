<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Auction>
 */
class AuctionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'info' => [
                'color' => $this->faker->colorName,
                'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            ],
            'description' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(100, 10000),
            'start' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'end' => $this->faker->dateTimeBetween('+1 week', '+2 week'),
            'user_id' => 21,
        ];
    }
}
