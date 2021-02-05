<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterRecruitmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_recruitments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('dob', 100);
            $table->string('live_at', 200);
            $table->string('phone_number', 13);
            $table->string('email', 60);
            $table->enum('gender', ['Laki - laki', 'Perempuan']);
            $table->enum('last_education', ['SMA/SMK Sederajat', 'D3', 'Sarjana', 'Magister']);
            $table->string('position', 50);
            $table->string('file_cv', 50);
            $table->string('file_portofolio', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_recruitments');
    }
}
