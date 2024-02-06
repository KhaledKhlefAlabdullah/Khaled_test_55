<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'name' => fake()->name(),
            'type' => fake()->randomElement(['post', 'news', 'file', 'notification', 'report', 'timeline_event',
                'normal_production_rate', 'extra_production_Rate', 'low_Production_Rate', 'halted_Production',
                'evacuating', 'maintenance', 'relocation', 'entity', 'products', 'materials', 'stations', 'suppliers',
                'waste_disposal_site']),
            'parent_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
