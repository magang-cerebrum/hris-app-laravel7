<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nip');
            $table->string('role');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert([[
            'id'=>1,
            'name'=>'Muhammad Kemal Ilyasa Margana',
            'email'=>'kemal48.ilyasa@gmail.com',
            'role'=>'Admin',
            'nip'=>'69420',
            'password'=>Hash::make('CamelT'),
            
        ],
        [
            'id'=>2,
            'name'=>'Altaiir Joseph Kemalson Margana',
            'email'=>'Aljo@gmail.com',
            'role'=>'Staff',
            'nip'=>'69421',
            'password'=>Hash::make('CamelT'),
            
        ]
        ,
        [
            'id'=>3,
            'name'=>'Ezio Killua Kemalson Margana',
            'email'=>'EzKill@gmail.com',
            'role'=>'Staff',
            'nip'=>'69422',
            'password'=>Hash::make('CamelT'),
            
        ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
