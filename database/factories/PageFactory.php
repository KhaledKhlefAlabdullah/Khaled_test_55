<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'id' => Str::uuid(),
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'type' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'phone_number' => $this->faker->phoneNumber,
            'location' => $this->faker->address,
            'start_time' => $this->faker->date,
            'end_time' => $this->faker->date,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
