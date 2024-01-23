<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Contact_us_message;
use App\Models\Message;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Database\Factories\ChatMemberFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(10)->create();
        Page::factory()->count(10)->create();
        Contact_us_message::factory()->count(10)->create();
        Category::factory()->count(10)->create();
        Post::factory()->count(10)->create();
        Chat::factory()->count(10)->create();
        Message::factory()->count(10)->create();

    }
}
