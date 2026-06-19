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
        Schema::create('student_question_repos', function (Blueprint $table) {
            $table->id();
            $table->integer('quiz_id');
            $table->string('question');
            $table->string('quest_img')->nullable();
            $table->string('optiona');
            $table->string('optionb');
            $table->string('optionc')->nullable();
            $table->string('optiond')->nullable();
            $table->string('correct_ans');
            $table->string('description')->nullable();
            $table->bigInteger('added_by');
            $table->bigInteger('location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_question_repos');
    }
};
