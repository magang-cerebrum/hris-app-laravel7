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
                'abbreviation' => 'CEO',
                'name' => 'Chief Executive Officer',
                'status' => 'Aktif'
            ],
            [
                'id' => 2,
                'abbreviation' => 'President',
                'name' => 'President',
                'status' => 'Aktif'
            ],
            [
                'id' => 3,
                'abbreviation' => 'CDO',
                'name' => 'Chief Development Officer',
                'status' => 'Aktif'
            ],
            [
                'id' => 4,
                'abbreviation' => 'CTO',
                'name' => 'Chief Techonology Officer',
                'status' => 'Aktif'
            ],
            [
                'id' => 5,
                'abbreviation' => 'CPO',
                'name' => 'Chief Production Officer',
                'status' => 'Aktif'
            ],
            [
                'id' => 6,
                'abbreviation' => 'CBO',
                'name' => 'Chief Business Officer',
                'status' => 'Aktif'
            ],
            [
                'id' => 7,
                'abbreviation' => 'COO',
                'name' => 'Chief Operation Officer',
                'status' => 'Aktif'
            ],
            [
                'id' => 8,
                'abbreviation' => 'QC',
                'name' => 'Quality Control',
                'status' => 'Aktif'
            ],
            [
                'id' => 9,
                'abbreviation' => 'CAO',
                'name' => 'Chief Academic Officer',
                'status' => 'Aktif'
            ],
            [
                'id' => 10,
                'abbreviation' => 'CSO',
                'name' => 'Chief Sales Officer',
                'status' => 'Aktif'
            ],
            [
                'id' => 11,
                'abbreviation' => 'Staff',
                'name' => 'Staff',
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
        Schema::table('master_positions', function (Blueprint $table) {
            //
        });
    }
}
