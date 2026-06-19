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
        Schema::create('student_quiz_repos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shared_id')->nullable();
            $table->string('quiz_category');
            $table->text('quiz_description');
            $table->integer('duration');
            $table->bigInteger('added_by');
            $table->bigInteger('location');
            $table->string('status')->nullable();
            $table->boolean('dropdown');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_quiz_repos');
    }
};
