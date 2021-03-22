<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateMasterPresencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::create('master_presences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('presence_date');
            $table->timeTz('in_time')->nullable();
            $table->timeTz('out_time')->nullable();
            $table->timeTz('inaday_time')->nullable();
            $table->timeTz('late_time')->nullable();
            $table->bigInteger('fine')->nullable();
            $table->string('shift_name',10)->nullable();
            $table->timeTz('shift_default_hour')->nullable();
            $table->boolean('status')->default(false);
            
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
        Schema::dropIfExists('master_presences');
    }
}
