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
        Schema::create('i_r_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('faculty_info_id')->constrained()->onDelete('cascade');
            $table->string('project_name');
            $table->string('sponsoring_agency');
            $table->year('sanctioned_year');
            $table->string('duration');
            $table->enum('status', ['Applied', 'Ongoing', 'Completed']);
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_r_projects');
    }
};
