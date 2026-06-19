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
        Schema::create('faculty_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name_of_faculty');
            $table->string('department');
            $table->string('college');
            $table->string('total_credit_hour');
            $table->string('number_of_irp');
            $table->string('irp_amount');
            $table->string('number_of_erp');
            $table->string('erp_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculty_infos');
    }
};
