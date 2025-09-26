<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialAssistance>
 */
class SocialAssistanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'thumbnail' => $this->faker->imageUrl(640, 480, 'business', true),
            'name' => $this->faker->randomElement(['Bantuan Pangan', 'Bantuan Pendidikan', 'Bantuan Kesehatan', 'Bantuan Perumahan']) . ' ' . $this->faker->company(),
            'category' => $this->faker->randomElement(['staple', 'cash', 'subsidized fuel', 'health']),
            'amount' => $this->faker->randomFloat(2, 100000, 10000000),
            'provider' => $this->faker->company(),
            'description' => $this->faker->paragraph(),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}