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
                'name' => 'Devtech',
                'status' => 'Aktif'
            ],
            [
                'id' => 2,
                'name' => 'Operation',
                'status' => 'Aktif'
            ],
            [
                'id' => 3,
                'name' => 'Quality Control',
                'status' => 'Aktif'
            ],
            [
                'id' => 4,
                'name' => 'Academic',
                'status' => 'Aktif'
            ],
            [
                'id' => 5,
                'name' => 'Sales',
                'status' => 'Aktif'
            ],
            [
                'id' => 6,
                'name' => 'Marketing',
                'status' => 'Aktif'
            ],
            [
                'id' => 7,
                'name' => 'One Ring',
                'status' => 'Aktif'
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
