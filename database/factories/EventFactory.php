<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'thumbnail' => $this->faker->imageUrl(),
            'name' => $this->faker->randomElement([
                'Community Gathering',
                'Health Workshop',
                'Cultural Festival',
                'Environmental Cleanup',
                'Educational Seminar',
                'Sports Event',
                'Art Exhibition',
                'Music Concert',
                'Food Fair',
                'Charity Run'
            ]),
            'description' => $this->faker->paragraph(),
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'price' => $this->faker->numberBetween(10000, 1000000),
            'is_active' => $this->faker->boolean(), // 80% chance of being true
        ];
    }
}