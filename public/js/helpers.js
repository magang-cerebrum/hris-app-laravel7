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