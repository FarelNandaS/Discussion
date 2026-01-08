<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'User',
            'Admin',
            // 'Moderator',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role, 'guard_name' => 'web',]);

            $user = User::create([
                'username' => $role,
                'email' => $role . '@example.test',
                'password' => Hash::make('password'),
            ]);

            UserDetail::create([
                'user_id' => $user->id,
                'trust_score' => 100,
            ]);

            UserSetting::create([
                'user_id' => $user->id,
            ]);

            $user->assignRole($role);
        }

        for ($i = 0; $i < 9; $i++) {
            $name = fake()->name();

            $user = User::create([
                'username'=>$name,
                'email'=>$name . '@example.test',
                'password'=>Hash::make('password'),
            ]);

            UserDetail::create([
                'user_id'=>$user->id,
                'trust_score'=>100,
            ]);

            UserSetting::create([
                'user_id'=>$user->id
            ]);

            $user->assignRole('User');
        }
    }
}
