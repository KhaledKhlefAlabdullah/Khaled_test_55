<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'page_id' => Page::factory(),
            'category_id' => Category::factory(),
            'title' => fake()->sentence,
            
            'body' => fake()->paragraph,
            'media_url' => fake()->imageUrl, // Replace with the appropriate method for your media URL generation
            'media_type' => fake()->randomElement(['image', 'video', 'file']),
            'is_priority' => fake()->boolean,
            'priority_count' => fake()->numberBetween(1, 100),
            'is_general_news' => fake()->boolean,
            'is_publish' => fake()->boolean,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
