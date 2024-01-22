<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'name' => fake()->name(),
            'type' => fake()->randomElement(['Post', 'News', 'File', 'Notification', 'Report', 'Timeline_event', 'entity']),
            'parent_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
