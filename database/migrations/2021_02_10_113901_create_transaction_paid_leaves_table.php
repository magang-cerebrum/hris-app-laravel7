<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTransactionPaidLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::create('transaction_paid_leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('paid_leave_date_start');
            $table->date('paid_leave_date_end');
            $table->integer('days');
            $table->enum('status', ['Diajukan','Pending-Chief','Pending-HRD','Diterima-Chief','Diterima', 'Ditolak','Cancel']);
            $table->unsignedBigInteger('paid_leave_type_id')->nullable();
            $table->text('needs');
            $table->text('informations');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('master_users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('paid_leave_type_id')->references('id')->on('master_leave_types')->onUpdate('cascade')->onDelete('set null');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_paid_leaves');
    }
}
