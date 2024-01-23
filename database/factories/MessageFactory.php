<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition(): array
    {
        return [
            'message' => fake()->word(),
            'media_URL' => fake()->word(),
            'message_type' => fake()->randomElement(['text', 'image', 'video']),
            'is_read' => fake()->boolean(),
            'is_edite' => fake()->boolean(),
            'is_starred' => fake()->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => Carbon::now(),

            'sender_id' => User::factory(),
            'receiver_id' => User::factory(),
            'chat_id' => Chat::factory(),
        ];
    }
}
