<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToFacultyInfosTable extends Migration
{
    public function up()
    {
        Schema::table('faculty_infos', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
            $table->dropColumn('total_credit_hour');
            $table->dropColumn('number_of_irp');
            $table->dropColumn('irp_amount');
            $table->dropColumn('number_of_erp');
            $table->dropColumn('erp_amount');
        });
    }

    public function down()
    {
        Schema::table('faculty_infos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->string('total_credit_hour');
            $table->string('number_of_irp');
            $table->string('irp_amount');
            $table->string('number_of_erp');
            $table->string('erp_amount');
        });
    }
}