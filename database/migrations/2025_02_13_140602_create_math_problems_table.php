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
        Schema::create('math_problems', function (Blueprint $table) {
            $table->id();
        $table->string('grade_level');
        $table->string('topic');
        $table->text('question');
        $table->json('answers'); // Store multiple answers
        $table->string('correct_answer');
        $table->integer('solve_count')->default(0);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('math_problems');
    }
};
