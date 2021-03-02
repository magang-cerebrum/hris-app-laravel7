<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class InsertDataToMasterDivisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_divisions', function (Blueprint $table) {
            //
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('master_divisions')->insert([
            [
                'id' => 1,
                'name' => 'Devtech'
            ],
            [
                'id' => 2,
                'name' => 'Operation'
            ],
            [
                'id' => 3,
                'name' => 'Quality Control'
            ],
            [
                'id' => 4,
                'name' => 'Academic'
            ],
            [
                'id' => 5,
                'name' => 'Sales'
            ],
            [
                'id' => 6,
                'name' => 'Marketing'
            ],
            [
                'id' => 7,
                'name' => 'One Ring'
            ],
            
            ]);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_divisions', function (Blueprint $table) {
            //
        });
    }
}
