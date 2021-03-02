<?php
use Illuminate\Support\Facades\DB;

function indonesian_date($waktu,$jam = false){

    $split = explode(' ',$waktu);
    $tanggal = explode('-',$split[0]);
    
    switch($tanggal[1]){
        case '01':$bulan = 'Januari'; break;
        case '02':$bulan = 'Februari'; break;
        case '03':$bulan = 'Maret'; break;
        case '04':$bulan = 'April'; break;
        case '05':$bulan = 'Mei'; break;
        case '06':$bulan = 'Juni'; break;
        case '07':$bulan = 'Juli'; break;
        case '08':$bulan = 'Agustus'; break;
        case '09':$bulan = 'September'; break;
        case '10':$bulan = 'Oktober'; break;
        case '11':$bulan = 'November'; break;
        case '12':$bulan = 'Desember'; break;
    }

    if(!$jam) {
        $join = $tanggal[2] . ' ' . $bulan . ' ' . $tanggal[0];
    } else {
        $join = $tanggal[2] . ' ' . $bulan . ' ' . $tanggal[0] . ' | ' . $split[1];
    }

    return $join;
}

function check_hour_shift($check) {
    $data_shift = DB::table('master_shifts')->get();
    foreach ($data_shift as $item_shift) {
        if ($check == $item_shift->name) {
            return $item_shift->total_hour;
        }
    }
}

function switch_month($value, $initial = true) {
    if($initial) {
        switch ($value) {
            case '01': return 'Januari'; break;
            case '02': return 'Februari'; break;
            case '03': return 'Maret'; break;
            case '04': return 'April'; break;
            case '05': return 'Mei'; break;
            case '06': return 'Juni'; break;
            case '07': return 'Juli'; break;
            case '08': return 'Agustus'; break;
            case '09': return 'September'; break;
            case '10': return 'Oktober'; break;
            case '11': return 'November'; break;
            case '12': return 'Desember'; break;
        }
    }
    else {
        switch ($value) {
            case 'Januari': return '01'; break;
            case 'Februari': return '02'; break;
            case 'Maret': return '03'; break;
            case 'April': return '04'; break;
            case 'Mei': return '05'; break;
            case 'Juni': return '06'; break;
            case 'Juli': return '07'; break;
            case 'Agustus': return '08'; break;
            case 'September': return '09'; break;
            case 'Oktober': return '10'; break;
            case 'November': return '11'; break;
            case 'Desember': return '12'; break;
        }
    }
}

function division_schedule($position_id){
    switch ($position_id) {
        case 3:
            return [1,2,3,4,5,6,7,8];
            break;
        case 4:
            return [1];
            break;
        case 5:
            return [2,3,4];
            break;
        case 6:
            return [5,6];
            break;
        case 7:
            return [2];
            break;
        case 8:
            return [3];
            break;
        case 9:
            return [4];
            break;
        case 10:
            return [5];
            break;
        
    }

    
}