function format_rupiah(salary){
    var	number_string = salary.toString(),
        sisa 	= number_string.length % 3,
        rupiah 	= number_string.substr(0, sisa),
        ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
            
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    var hasil = 'Rp. ' + rupiah;
    return hasil;
}

function indonesian_date(waktu){

    var split = waktu.split('-');
    var bulan = 0;
    switch(split[1]){
        case '01': bulan = 'Januari'; break;
        case '02': bulan = 'Februari'; break;
        case '03': bulan = 'Maret'; break;
        case '04': bulan = 'April'; break;
        case '05': bulan = 'Mei'; break;
        case '06': bulan = 'Juni'; break;
        case '07': bulan = 'Juli'; break;
        case '08': bulan = 'Agustus'; break;
        case '09': bulan = 'September'; break;
        case '10': bulan = 'Oktober'; break;
        case '11': bulan = 'November'; break;
        case '12': bulan = 'Desember'; break;
    }
    if(waktu !== '') {
        var join = split[2] + ' ' + bulan + ' ' + split[0];
    } else{
        var join = '-';
    }
    return join;
}

function periodic(time) {
    var split = time.split('/');
    var month = 0;
    switch(split[0]){
        case '01': month = 'Januari'; break;
        case '02': month = 'Februari'; break;
        case '03': month = 'Maret'; break;
        case '04': month = 'April'; break;
        case '05': month = 'Mei'; break;
        case '06': month = 'Juni'; break;
        case '07': month = 'Juli'; break;
        case '08': month = 'Agustus'; break;
        case '09': month = 'September'; break;
        case '10': month = 'Oktober'; break;
        case '11': month = 'November'; break;
        case '12': month = 'Desember'; break;
    }
    return month + ' - ' + split[1];
}

function switch_month(month){
    switch(month){
        case '01': month = 'Januari'; break;
        case '02': month = 'Februari'; break;
        case '03': month = 'Maret'; break;
        case '04': month = 'April'; break;
        case '05': month = 'Mei'; break;
        case '06': month = 'Juni'; break;
        case '07': month = 'Juli'; break;
        case '08': month = 'Agustus'; break;
        case '09': month = 'September'; break;
        case '10': month = 'Oktober'; break;
        case '11': month = 'November'; break;
        case '12': month = 'Desember'; break;
    }
    
    return month;
}