<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCutAllowanceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_cut_allowance_types', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->enum('type',['Semua','Perorangan']);
            $table->enum('category',['Potongan','Tunjangan']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_cut_allowance_types');
    }
}
