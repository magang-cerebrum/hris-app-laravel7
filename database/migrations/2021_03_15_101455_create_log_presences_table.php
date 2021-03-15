<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateLogPresencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::create('log_presences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('date');
            $table->time('time');
            $table->foreign('user_id')->on('master_users')->references('id')->onUpdate('cascade')->onDelete('set null');
        });
        DB::table('log_presences')->insert([
        [
            'id'=>1,
            'user_id'=>1,
            'date'=>'2021/03/15',
            'time'=>'07:00:00'
        ],
        [
            'id'=>2,
            'user_id'=>1,
            'date'=>'2021/03/15',
            'time'=>'17:00:00'
        ],
        [
            'id'=>3,
            'user_id'=>2,
            'date'=>'2021/03/15',
            'time'=>'08:10:00'
        ],
        [
            'id'=>4,
            'user_id'=>2,
            'date'=>'2021/03/15',
            'time'=>'18:30:00'
        ],
        [
            'id'=>5,
            'user_id'=>3,
            'date'=>'2021/03/15',
            'time'=>'08:15:00'
        ],
        [
            'id'=>6,
            'user_id'=>3,
            'date'=>'2021/03/15',
            'time'=>'17:30:00'
        ],
        [
            'id'=>7,
            'user_id'=>4,
            'date'=>'2021/03/15',
            'time'=>'09:15:00'
        ],
        [
            'id'=>8,
            'user_id'=>4,
            'date'=>'2021/03/15',
            'time'=>'17:16:00'
        ],
        [
            'id'=>9,
            'user_id'=>5,
            'date'=>'2021/03/15',
            'time'=>'10:30:00'
        ],
        [
            'id'=>10,
            'user_id'=>5,
            'date'=>'2021/03/15',
            'time'=>'20:00:00'
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
        Schema::dropIfExists('log_presences');
    }
}
