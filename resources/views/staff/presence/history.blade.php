@extends('layouts/templateStaff')
@section('title', 'Presensi')
@section('content-title', 'Presensi')
@section('content-subtitle', 'HRIS ' . $company_name)

@section('head')
    <link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <style>
        #btn-search {
            margin-top: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-bordered panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Status Absensi</h3>
        </div>
        
        <form action="/staff/presence/search" method="post" id="cari-presensi">
            @csrf
        </form>
        
        <div class="panel-body" style="padding-top: 20px">
                <label class="col-sm-1 control-label">Tanggal:</label>
                <div id="datepicker-input-cari">
                    <div class="col-sm-11">
                        <div class="input-group input-daterange">
                            <input type="text" class="form-control @error('start') is-invalid @enderror"
                                placeholder="Tanggal Mulai" name="start" value="{{old('start')}}" autocomplete="off" form="cari-presensi" onchange="toToday()">
                            <span class="input-group-addon">sampai</span>
                            <input type="text" class="form-control @error('end') is-invalid @enderror"
                                placeholder="Tanggal Berakhir" id="end" name="end" value="{{old('end')}}" autocomplete="off" form="cari-presensi">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-pink float-right" form="cari-presensi" id="btn-search">Cari Presensi</button>
        </div>
        <div class="panel-footer text-right">
            <button type="button" class="btn btn-warning float-right" id="input-presence" onClick="presensi()">Absensi {{$bool_presence == 0 ? 'Masuk' : ($bool_presence == 1 ? 'Pulang' : '')}}</button>
        </div>
    </div>

    <div id="panel-output"></div>

@endsection

@section('script')
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#cari-presensi').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                success: function (data) {
                    $("#panel-output").html(data);
                },
                error: function (jXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Error!',
                        text: "Mohon isi dulu form dengan benar...",
                        icon: 'error',
                    });
                }
            });
        });
        $('#datepicker-input-cari .input-daterange').datepicker({
            format: 'yyyy/mm/dd',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true,
            endDate: '0d'
        });
        $('#input-presence').on('click',function () {
            var presence = {!!json_encode($bool_presence) !!}
            var check = {!!json_encode($bool_schedule) !!}
            if (check !== null){
                if (check != 'Off' && check != 'Cuti' && check != 'Sakit') {
                    if (presence != 2) {
                        window.location.href = '/staff/presence/take';
                    } else {
                        Swal.fire({
                            width: 600,
                            title: 'Error!',
                            text: "Anda sudah mengambil absensi hari ini!",
                            icon: 'error'
                        });
                    }
                } else {
                    Swal.fire({
                        width: 600,
                        title: 'Error!',
                        text: "Anda Tidak Perlu Melakukan Absensi Hari Ini Karena Anda Sedang " + check + " !",
                        icon: 'error'
                    }); 
                }
                
            } else {
                Swal.fire({
                    width: 600,
                    title: 'Error!',
                    text: "Anda belum memiliki jadwal untuk absensi! Silahkan hubungi Chief untuk meminta jadwal!",
                    icon: 'error'
                });
            }
        });
    });

    function toToday(){
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '/' + mm + '/' +  dd;
        document.getElementById('end').value = today;
    }
</script>
@endsection