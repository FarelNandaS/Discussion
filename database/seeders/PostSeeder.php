<?php

namespace Database\Seeders;

use App\Models\post;
use App\Models\Tag;
use App\Models\user;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = user::role('User')->get();
        $tags = Tag::all();

        // 1. Pastikan setiap tag punya minimal satu post
        // Kita buat satu post untuk setiap tag yang ada
        foreach ($tags as $tag) {
            $post = post::create([
                'id_user' => $users->random()->id,
                'title' => fake()->realText(100),
                'content' => fake()->realText(500),
            ]);

            // Hubungkan tag saat ini ke post ini
            $post->tags()->attach($tag->id);

            // Opsional: tambah 1-2 tag acak tambahan agar satu post punya > 1 tag
            $additionalTags = $tags->where('id', '!=', $tag->id)->random(rand(1, 2));
            $post->tags()->attach($additionalTags);
        }

        // 2. Lanjutkan seeder sisa post milik user (seperti kode awal Anda)
        foreach ($users as $user) {
            for ($i = 0; $i < 2; $i++) { // kita buat 2 post tambahan per user
                $post = post::create([
                    'id_user' => $user->id,
                    'title' => fake()->realText(100),
                    'content' => fake()->realText(500),
                ]);

                // Berikan 1-3 tag acak untuk setiap post
                $randomTags = $tags->random(rand(1, 5))->pluck('id');
                $post->tags()->attach($randomTags);
            }
        }
    }
}
