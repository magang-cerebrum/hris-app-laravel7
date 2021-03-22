<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMasterSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::create('master_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('month', 20);
            $table->string('year', 5);
            $table->integer('total_default_hour')->nullable();
            $table->string('total_work_time',25)->nullable();
            $table->string('total_late_time',25)->nullable();
            $table->bigInteger('total_fine')->nullable();
            $table->bigInteger('default_salary')->nullable();
            $table->bigInteger('total_salary_cut')->nullable();
            $table->bigInteger('total_salary_allowance')->nullable();
            $table->bigInteger('total_salary')->nullable();
            $table->string('file_salary', 25)->nullable();
            $table->string('status', 10)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('master_users')->onUpdate('cascade')->onDelete('set null');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_salaries');
    }
}
