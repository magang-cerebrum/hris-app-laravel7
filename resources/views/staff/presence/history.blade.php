@extends('layouts/templateStaff')
@section('title', 'Presensi')
@section('content-title', 'Presensi')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')
<<<<<<< HEAD
@section('head')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
@endsection
=======

>>>>>>> 88e7c0cb817b5e8ea291dddea60c6857174128cd

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
                            placeholder="Tanggal Mulai" name="start" value="{{old('start')}}"  autocomplete="off">
                        <span class="input-group-addon">sampai</span>
                        <input type="text" class="form-control @error('end') is-invalid @enderror"
                            placeholder="Tanggal Berakhir" name="end" value="{{old('end')}}"  autocomplete="off">
                    </div>
                    @error('start') <div class="text-danger invalid-feedback mt-3">Mohon isi
                        tanggal mulai.</div> @enderror
                    @error('end') <div class="text-danger invalid-feedback mt-3">Mohon isi
                    tanggal akhir.</div> @enderror
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
                    alert(errorThrown);
                }
            });
        });
        $('#datepicker-input-cari .input-daterange').datepicker({
            format: 'yyyy/mm/dd',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
    });

</script>
@endsection
