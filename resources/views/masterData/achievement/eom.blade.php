@extends('layouts/templateAdmin')
@section('title','Pencapaian')
@section('content-title','Pencapaian / Karyawan Terbaik')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
<style>
    .hiddenRow {
        padding: 0 !important;
    }

</style>
@endsection
@section('content')

<div class="panel panel-bordered panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">Pemilihan Karyawan Terbaik</h3>
    </div>
    <div class="panel-body">
        <form action="{{url('/admin/achievement/eom')}}" method="POST" id="search-eom">
            @csrf
        </form>
        <div id="pickadate">
            <div class="input-group date">
                <span class="input-group-btn">
                    <button class="btn btn-danger" type="button" style="z-index: 2"><i class="fa fa-calendar"></i></button>
                </span>
                <input type="text" name="periode" placeholder="Cari Data Pencapaian Karyawan" id="periode"
                    class="form-control" autocomplete="off" form="search-eom" readonly>
                <span class="input-group-btn">
                    <button class="btn btn-danger" id="btn-search" type="submit" form="search-eom"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </div>
    </div>
</div>
<div id="panel-output"></div>
@endsection

@section('script')
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
<script src="{{asset("js/helpers.js")}}"></script>
<script>
 setTimeout(function(){
            
            var date = new Date()
            var month =  ("0" + (date.getMonth() + 1)).slice(-2)
            var year = date.getFullYear()
            periode = month + '/' +year
            document.getElementById('periode').value = periode
            console.log(periode)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                    });
            $.ajax({
                    url: '/admin/achievement/eom',
                    type: "POST",
                    data: {periode:periode},
                    success: function (data) {
                        // console.log(data)
                        $("#panel-output").html(data);
                    },
                    // error: function (jXHR, textStatus, errorThrown) {
                    //     Swal.fire({
                    //         title: 'Error!',
                    //         text: "Tidak ada data achievement untuk bulan dan tahun terpilih",
                    //         icon: 'error',
                    //         width: 600
                    //     }).then(() => {
                    //         Swal.fire({
                    //             width: 600,
                    //             title: 'Apakah anda ingin menambahkan nilai achievement?',
                    //             icon: 'info',
                    //             showCancelButton: true,
                    //             confirmButtonColor: '#3085d6',
                    //             cancelButtonColor: '#d33',
                    //             confirmButtonText: 'Ya',
                    //             cancelButtonText: 'Tidak'
                    //         }).then((result) => {
                    //             if (result.value == true) {
                    //                 window.location.href = "/admin/achievement/scoring";
                    //             } else {
                    //                 return false;
                    //             }} 
                    //         );
                    //     });
                    // }
                });
        },1000)   


    
    $('#pickadate .input-group.date').datepicker({
        format: 'mm/yyyy',
        autoclose: true,
        minViewMode: 'months',
        maxViewMode: 'years',
        startView: 'months',
        orientation: 'bottom',
        forceParse: false,
        startDate: '-1m',
        endDate: '0d'
    });

    $(document).ready(function () {
        $('#btn-search').on('click', function () {
            $('.datepicker').hide();
        });

        $('#search-eom').on('submit', function (event) {
                event.preventDefault();
                var periode = document.getElementById('periode').value;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }});
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: {periode: periode},
                    success: function (data) {
                        $("#panel-output").html(data);
                        
                    },
                    error: function (jXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error!',
                            text: "Isi form terlebih dahulu!",
                            icon: 'error',
                            width: 600
                        });
                    }
                });
            });
    });
</script>

@endsection
