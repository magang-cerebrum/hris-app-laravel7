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
                'name' => 'Chief Executive Officer'
            ],
            [
                'id' => 2,
                'abbreviation' => 'President',
                'name' => 'President'
            ],
            [
                'id' => 3,
                'abbreviation' => 'CDO',
                'name' => 'Chief Data Officer'
            ],
            [
                'id' => 4,
                'abbreviation' => 'CTO',
                'name' => 'Chief Techonology Officer'
            ],
            [
                'id' => 5,
                'abbreviation' => 'CPO',
                'name' => 'Chief Production Officer'
            ],
            [
                'id' => 6,
                'abbreviation' => 'CBO',
                'name' => 'Chief Business Officer'
            ],
            [
                'id' => 7,
                'abbreviation' => 'COO',
                'name' => 'Chief Operating Officer'
            ],
            [
                'id' => 8,
                'abbreviation' => 'QC',
                'name' => 'Quality Control'
            ],
            [
                'id' => 9,
                'abbreviation' => 'CAO',
                'name' => 'Chief Administrative Officer'
            ],
            [
                'id' => 10,
                'abbreviation' => 'CSO',
                'name' => 'Chief Security Officer'
            ],
            [
                'id' => 11,
                'abbreviation' => 'Head',
                'name' => 'Head of'
            ],
            [
                'id' => 12,
                'abbreviation' => 'Staff',
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
