<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateWorkFromHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::create('work_from_homes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('wfh_date_start');
            $table->date('wfh_date_end');
            $table->integer('days');
            $table->enum('status', ['Diajukan','Pending-Chief','Pending','Diterima-Chief','Diterima','Ditolak','Ditolak-Chief','Cancel']);
            $table->text('needs');
            $table->text('informations');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('master_users')->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('work_from_homes');
    }
}
