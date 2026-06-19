<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
}
