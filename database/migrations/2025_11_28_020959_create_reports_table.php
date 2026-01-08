<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->onUpdate('cascade');
            $table->foreignId('reported_id')->constrained('users')->onUpdate('cascade');
            $table->morphs('reportable');
            $table->enum('reason_type', ['hate_speech', 'harassment', 'misinformation', 'other']);
            $table->longText('message')->nullable();
            $table->integer('weight');
            $table->enum('status', ['pending', 'dismiss', 'actiond'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
