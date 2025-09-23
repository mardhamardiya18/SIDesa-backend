<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HeadOfFamily>
 */
class HeadOfFamilyFactory extends Factory
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
            'profile_picture' => fake()->imageUrl(),
            'identity_number' => fake()->unique()->numerify('###########'),
            'gender' => fake()->randomElement(['male', 'female']),
            'date_of_birth' => fake()->date(),
            'phone_number' => fake()->phoneNumber(),
            'occupation' => fake()->jobTitle(),
            'marital_status' => fake()->randomElement(['single', 'married']),
        ];
    }
}
