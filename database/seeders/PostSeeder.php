<?php

namespace Database\Seeders;

use App\Models\post;
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

        foreach ($users as $user) {
            for ($i=0; $i < 3; $i++) { 
                post::create([
                    'id_user'=>$user->id,
                    'title'=>fake()->realText(100),
                    'post'=>fake()->realText(500),
                ]);
            }
        }
    }
}
