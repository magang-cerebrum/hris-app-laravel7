<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddGenderColumnToMasterUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_users', function (Blueprint $table) {
            $table->enum('gender',['Laki-laki','Perempuan'])->after('phone_number');
        });
        DB::table('master_users')->where('id','=',1)->update(['gender' => 'Laki-laki']);
        DB::table('master_users')->where('id','=',2)->update(['gender' => 'Perempuan']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_users', function (Blueprint $table) {
            //
        });
    }
}
