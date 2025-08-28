<?php

namespace Database\Seeders;

use App\Models\user;
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
            'Moderator',
        ];

        foreach ($roles as $role) {
            Role::create(['name'=>$role]);

            $user = user::create([
                'username'=>$role,
                'email'=>$role . '@example.test',
                'password'=>Hash::make('password'),
            ]);

            $user->assignRole($role);
        }
    }
}
