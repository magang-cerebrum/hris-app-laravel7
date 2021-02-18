<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateMasterAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::create('master_achievements', function (Blueprint $table) {
            $table->id();
            $table->integer('score');
            $table->string('month');
            $table->integer('year');
            // $table->unsignedBigInteger('achievement_date_id');
            $table->unsignedBigInteger('achievement_user_id')->nullable();
            // $table->foreign('achievement_date_id')->references('id')->on('master_achievement_dates')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('achievement_user_id')->references('id')->on('master_users')->onUpdate('cascade')->onDelete('set null');

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
        Schema::dropIfExists('master_achievements');
    }
}
