<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class checkPresence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'presence:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('master_check_presences')->delete();

        $temp_name_shift = 'shift_'.date('j');
        $data_schedule = DB::table('master_job_schedules')
        ->where('month', switch_month(date('m')))->where('year', date('Y'))->whereNotIn($temp_name_shift, ['Off','Sakit', 'Cuti'])
        ->select(['user_id',$temp_name_shift])
        ->get();

        foreach($data_schedule as $item){
            $work_time;
            $check_shift = DB::table('master_shifts')->select(['name','start_working_time'])->get();
            foreach($check_shift as $item_shift){
                if($item->$temp_name_shift == $item_shift->name){
                    $work_time = $item_shift->start_working_time;
                }
            }
            DB::table('master_check_presences')->insert(['user_id'=>$item->user_id, 'shift'=>$item->$temp_name_shift, 'working_time'=>$work_time]);
        }
    }
}
