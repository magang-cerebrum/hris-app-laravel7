<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('value');
        });
        DB::table('settings')->insert([
            [
                'id' => 1,
                'name' => 'Nama Perusahaan',
                'value' => 'PT. Cerebrum Edukasia Nusantara'
            ],
            [
                'id' => 2,
                'name' => 'Logo Perusahaan',
                'value' => 'logo-cerebrum.png'
            ],
            [
                'id' => 3,
                'name' => 'Tanggal Gajian',
                'value' => '05'
            ],
            [
                'id' => 4,
                'name' => 'Latitude Kantor',
                'value' => '-7.055286522681598'
            ],
            [
                'id' => 5,
                'name' => 'Longitude Kantor',
                'value' => '107.56162952882028'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
