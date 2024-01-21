<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->uuid,
            'user_id' => function () {
                return fake(User::class)->create()->id;
            },
            'title' => fake()->sentence,
            'type' => fake()->word,
            'description' => fake()->paragraph,
            'phone_number' => fake()->phoneNumber,
            'location' => fake()->address,
            'start_time' => fake()->dateTimeThisYear,
            'end_time' => fake()->dateTimeThisYear,
        ];
    }
}
