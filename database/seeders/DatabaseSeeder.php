<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)
            ->create();

        $posts = Post::factory(200)
            ->has(Comment::factory(15)->recycle($users))
            ->recycle($users)
            ->create();

        User::factory()
            ->has(Post::factory()->count(5))
            ->has(Comment::factory()->recycle($posts)->count(10))
            ->create([
                'name' => 'Admin User',
                'email' => 'admin@user.com',
            ]);
    }
}
