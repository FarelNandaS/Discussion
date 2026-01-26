<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            $users = User::role('User')->where('id', '!=', $post->user->id)->get();

            foreach ($users as $user) {
                Comment::create([
                    'id_post' => $post->id,
                    'id_user' => $user->id,
                    'content' => fake()->realText(random_int(10, 50)),
                ]);
            }
        }
    }
}
