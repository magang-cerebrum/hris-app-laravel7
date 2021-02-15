<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterJobSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_job_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('month', 20);
            $table->string('year', 5);
            $table->unsignedBigInteger('user_id')->nullable();
            for ($x = 1; $x < 32 ; $x++) {
                $table->unsignedBigInteger('shift_id_day_'.$x)->nullable();
            }
            $table->integer('total');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('master_users')->onUpdate('cascade')->onDelete('set null');
            for ($x = 1; $x < 32 ; $x++) {
                $table->foreign('shift_id_day_'.$x)->references('id')->on('master_shifts')->onUpdate('cascade')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_job_schedules');
    }
}
