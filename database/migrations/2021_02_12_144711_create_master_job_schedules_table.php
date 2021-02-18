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
            for ($i = 1; $i < 32; $i++) {
                $table->string('shift_'.$i, 25)->nullable();
            }
            $table->integer('total_hour');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('master_users')->onUpdate('cascade')->onDelete('set null');
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
