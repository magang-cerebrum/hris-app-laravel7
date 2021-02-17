<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class InsertDataToMasterPositions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_positions', function (Blueprint $table) {
            //
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('master_positions')->insert([
            [
                'id' => 1,
                'name' => 'CEO'
            ],
            [
                'id' => 2,
                'name' => 'President'
            ],
            [
                'id' => 3,
                'name' => 'CDO'
            ],
            [
                'id' => 4,
                'name' => 'CTO'
            ],
            [
                'id' => 5,
                'name' => 'CPO'
            ],
            [
                'id' => 6,
                'name' => 'CBO'
            ],
            [
                'id' => 7,
                'name' => 'COO'
            ],
            [
                'id' => 8,
                'name' => 'Quality Control'
            ],
            [
                'id' => 9,
                'name' => 'CAO'
            ],
            [
                'id' => 10,
                'name' => 'CSO'
            ],
            [
                'id' => 11,
                'name' => 'Head of'
            ],
            [
                'id' => 12,
                'name' => 'Staff'
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
        Schema::table('master_positions', function (Blueprint $table) {
            //
        });
    }
}
