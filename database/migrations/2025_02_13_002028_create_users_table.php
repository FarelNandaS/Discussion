<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("username")->unique();
            $table->string("email")->unique();
            $table->string("password");
            $table->rememberToken();
            $table->string("info")->nullable();
            $table->string("gender")->nullable();
            $table->string("image")->nullable();
<<<<<<< HEAD
            $table->string('role')->default('user');
=======
            $table->enum('role', ['admin', 'user'])->default('user');
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
            $table->timestamps();
        });

        DB::table('users')->insert([
            'username'=>'tahukotak777',
            'email'=>'farel@gmail.com',
            'password'=>Hash::make('thuktk777'),
            'role'=>'admin'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
