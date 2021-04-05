<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class InsertDataToMasterLeaveTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_leave_types', function (Blueprint $table) {
            //
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('master_leave_types')->insert([
            [
                'id' => 1,
                'name' => 'Cuti Tahunan',
                'default_day' => 12,
                'status' => 'Aktif'
            ],
            [
                'id' => 2,
                'name' => 'Cuti Melahirkan',
                'default_day' => 60,
                'status' => 'Aktif'
            ],
            [
                'id' => 3,
                'name' => 'Cuti Menikah',
                'default_day' => 3,
                'status' => 'Aktif'
            ]
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
        Schema::table('master_leave_types', function (Blueprint $table) {
            //
        });
    }
}
