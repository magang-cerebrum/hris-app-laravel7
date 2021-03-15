@extends('layouts/templateStaff')
@section('title', 'Presensi')
@section('content-title', 'Presensi')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')
@section('head')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
{{-- Sweetalert 2 --}}
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="panel panel-bordered panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Status Absensi</h3>
    </div>
    <div class="panel-body">
        <form action="/staff/presence/search" method="post" id="cari-presensi">
            @csrf
            <label class="col-sm-1 control-label">Tanggal:</label>
            <div id="datepicker-input-cari">
                <div class="col-sm-11">
                    <div class="input-group input-daterange">
                        <input type="text" class="form-control @error('start') is-invalid @enderror"
                            placeholder="Tanggal Mulai" name="start" value="{{old('start')}}" autocomplete="off">
                        <span class="input-group-addon">sampai</span>
                        <input type="text" class="form-control @error('end') is-invalid @enderror"
                            placeholder="Tanggal Berakhir" name="end" value="{{old('end')}}" autocomplete="off">
                    </div>
                </div>
            </div>
    </div>
    <div class="panel-footer text-right">
        <a href="/staff/presence/test" class="btn btn-warning float-right">Toogle presensi</a>
        <button type="submit" class="btn btn-pink float-right">Cari Presensi</button>
    </div>
    </form>
</div>

<div id="panel-output">

</div>
@endsection
@section('script')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
{{-- Sweetalert 2 --}}
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
                        title: errorThrown,
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
    });

</script>
@endsection
