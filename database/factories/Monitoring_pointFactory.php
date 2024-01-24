<?php

namespace Database\Factories;

use App\Models\Monitoring_point;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class Monitoring_pointFactory extends Factory
{
    protected $model = Monitoring_point::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'location' => fake()->word(),
            'point_type' => fake()->word(),
            'API_link' => fake()->word(),
            'is_custom' => fake()->boolean(),
            'water_level' => fake()->randomFloat(),
            'risk_indicators' => fake()->word(),
            'discharge' => fake()->word(),
            'source' => fake()->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
