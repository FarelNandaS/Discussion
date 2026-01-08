<?php

namespace Database\Seeders;

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
        $content = Post::inRandomOrder()->first();
        $users = User::role('User')->where('id', "!=", $content->user->id)->get();

        foreach ($users as $user) {
            Report::create([
                'reporter_id'=>$user->id,
                'reported_id'=>$content->user->id,
                'reportable_type'=>$content->getMorphClass(),
                'reportable_id'=>$content->id,
                'reason_type'=>Arr::random($reason_type),
                'message'=>fake()->realText(100),
                'weight'=>10
            ]);
        }
    }
}
