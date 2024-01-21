<?php

namespace Database\Factories;

use App\Models\Contact_us_message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class Contact_us_messageFactory extends Factory
{
    protected $model = Contact_us_message::class;

    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'user_id' => User::factory(),
            'message' => fake()->text(),
            'is_read' => fake()->boolean(),
        ];
    }
}
