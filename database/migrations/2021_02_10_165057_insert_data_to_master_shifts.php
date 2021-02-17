<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class InsertDataToMasterShifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_shifts', function (Blueprint $table) {
            //
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('master_shifts')->insert([
            [
                'id' => 1,
                'name' => 'Off',
                'start_working_time' => '00:00:00',
                'end_working_time' => '00:00:00',
                'total_hour' => 0
            ],
            [
                'id' => 2,
                'name' => 'Pagi',
                'start_working_time' => '08:00:00',
                'end_working_time' => '17:00:00',
                'total_hour' => 9
            ],
            [
                'id' => 3,
                'name' => 'Siang',
                'start_working_time' => '13:00:00',
                'end_working_time' => '21:00:00',
                'total_hour' => 8
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
        Schema::table('master_shifts', function (Blueprint $table) {
            //
        });
    }
}
