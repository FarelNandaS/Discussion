<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reason_type = ['hate_speech', 'harassment', 'misinformation', 'other'];
        $contents = Post::where('id_user', 1)->get();

        foreach ($contents as $content) {
            $users = User::role('User')->where('id', "!=", $content->user->id)->get();

            foreach ($users as $user) {
                Report::create([
                    'reporter_id' => $user->id,
                    'reported_id' => $content->user->id,
                    'reportable_type' => $content->getMorphClass(),
                    'reportable_id' => $content->id,
                    'reason_type' => Arr::random($reason_type),
                    'message' => fake()->realText(100),
                    'weight' => 10
                ]);
            }
        }

        $comment = Comment::where('id_user', 1)->inRandomOrder()->first();
        $users = User::role('User')->where('id', '!=', $comment->user->id)->get();

        foreach ($users as $user) {
            Report::create([
                'reporter_id' => $user->id,
                'reported_id' => $comment->user->id,
                'reportable_type' => $comment->getMorphClass(),
                'reportable_id' => $comment->id,
                'reason_type' => Arr::random($reason_type),
                'message' => fake()->realText(100),
                'weight' => 10
            ]);
        }
    }
}
