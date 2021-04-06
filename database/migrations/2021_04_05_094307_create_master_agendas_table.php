<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title',100);
            $table->text('description');
            $table->dateTimeTz('start_event');
            $table->dateTimeTz('end_event');
            $table->string('calendar_color',7);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_agendas');
    }
}
