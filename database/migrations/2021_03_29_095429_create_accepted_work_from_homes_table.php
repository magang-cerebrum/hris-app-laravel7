<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcceptedWorkFromHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accepted_work_from_homes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wfh_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('date');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('master_users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('wfh_id')->references('id')->on('work_from_homes')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accepted_work_from_homes');
    }
}
