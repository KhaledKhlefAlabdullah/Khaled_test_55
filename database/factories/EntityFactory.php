<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Entity;
use App\Models\Stakeholder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EntityFactory extends Factory
{
    protected $model = Entity::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            
            'public_id' => fake()->word(),
            'phone_number' => fake()->phoneNumber(),
            'location' => fake()->word(),
            'from' => fake()->word(),
            'to' => fake()->word(),
            'usage' => fake()->word(),
            'quantity' => fake()->boolean(),
            'is_available' => fake()->boolean(),
            'available_quantity' => fake()->boolean(),
            'note' => fake()->word(),
            'description' => fake()->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'stakeholder_id' => Stakeholder::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
