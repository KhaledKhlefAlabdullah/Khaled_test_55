<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FileFactory extends Factory
{
    protected $model = File::class;

    public function definition(): array
    {
        return [
            'file_type' => $this->faker->word(),
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'version' => $this->faker->word(),
            'media_URL' => $this->faker->word(),
            'media_type' => $this->faker->word(),
            'update_frequency' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
