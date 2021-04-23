<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateMasterPerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::create('master_performances', function (Blueprint $table) {
            $table->id();
            $table->double('performance_score');
            $table->string('month');
            $table->integer('year');
            $table->unsignedBigInteger('division_id')->nullable();
            // $table->unsignedBigInteger('achievement_date_id');
            $table->unsignedBigInteger('user_id')->nullable();
            // $table->foreign('achievement_date_id')->references('id')->on('master_achievement_dates')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('master_users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('division_id')->references('id')->on('master_divisions')->onUpdate('cascade')->onDelete('set null');
    });
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_performances');
    }
}
