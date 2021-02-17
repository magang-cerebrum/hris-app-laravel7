<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class InsertDataToMasterJobRecruitments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_job_recruitments', function (Blueprint $table) {
            //
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('master_job_recruitments')->insert([
            [
                'id' => 1,
                'name' => 'IT',
                'descript' => 'Berpengalaman di bidang Front-End dengan framework selama setahun atau lebih.',
                'required' => 'Beragama Islam. Memiliki keinginan untuk belajar lebih. Menguasai framework VueJS akan lebih disenangi.'
            ],
            [
                'id' => 2,
                'name' => 'Quality Control',
                'descript' => 'Paham cara menilai pengembangan aplikasi.',
                'required' => 'Beragama Islam. Memiliki keinginan untuk belajar lebih. Berpengalaman di bidang QC sebelumnya selama 2 tahun atau lebih akan lebih disenangi.'
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
        Schema::table('master_job_recruitments', function (Blueprint $table) {
            //
        });
    }
}
