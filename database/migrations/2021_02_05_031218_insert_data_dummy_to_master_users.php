<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class InsertDataDummyToMasterUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_users', function (Blueprint $table) {
            //
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('master_users')->insert([
            [
                'id' => 1,
                'nip' => 123,
                'name' => 'Dummy Admin',
                'dob' => '2000/02/20',
                'live_at' => 'Uranus',
                'phone_number' => '1234567890',
                'gender' => 'Laki-laki',
                'email' => 'admin@dummy.com',
                'password' => Hash::make('cerebrum'),
                'profile_photo' => 'defaultL.jpg',
                'employee_status' => 'Tetap',
                'employee_type' => 'Fulltime',
                'status' => 'Aktif',
                'start_work_date' => '2021/01/01',
                'yearly_leave_remaining' => 12,
                'division_id' => 6,
                'position_id' => 3,
                'role_id' => 1
            ],
            [
                'id' => 2,
                'nip' => 456,
                'name' => 'Dummy Staff',
                'dob' => '2000/12/20',
                'live_at' => 'Saturnus',
                'phone_number' => '0987654321',
                'gender' => 'Perempuan',
                'email' => 'staff@dummy.com',
                'password' => Hash::make('cerebrum'),
                'profile_photo' => 'defaultP.png',
                'employee_status' => 'Tetap',
                'employee_type' => 'Fulltime',
                'status' => 'Aktif',
                'start_work_date' => '2021/01/01',
                'yearly_leave_remaining' => 12,
                'division_id' => 1,
                'position_id' => 4,
                'role_id' => 2
            ],
            [
                'id' => 3,
                'nip' => 789,
                'name' => 'Test Dummy',
                'dob' => '2000/12/20',
                'live_at' => 'Venus',
                'phone_number' => '0987654321',
                'gender' => 'Laki-laki',
                'email' => 'olaf@dummy.com',
                'password' => Hash::make('cerebrum'),
                'profile_photo' => 'defaultL.jpg',
                'employee_status' => 'Tetap',
                'employee_type' => 'Fulltime',
                'status' => 'Aktif',
                'start_work_date' => '2021/01/01',
                'yearly_leave_remaining' => 12,
                'division_id' => 1,
                'position_id' => 4,
                'role_id' => 2
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
        Schema::table('master_users', function (Blueprint $table) {
            //
        });
    }
}
