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
        Schema::create('quiz_answer10s', function (Blueprint $table) {
            $table->id();
            $table->string('quiz_id');
            $table->string('quest_no');
            $table->string('quest_img')->nullable();
            $table->string('question');
            $table->string('optiona');
            $table->string('optionb');
            $table->string('optionc');
            $table->string('optiond');
            $table->string('user_ans')->nullable();
            $table->string('correct_ans');
            $table->bigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_answer10s');
    }
};
