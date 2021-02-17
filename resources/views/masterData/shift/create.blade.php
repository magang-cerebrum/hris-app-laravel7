@extends('layouts/templateAdmin')
@section('content-title','Master Data / Shift / Tambah Data Shift')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Tambah Shift')
@section('content')
@section('head')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-timepicker/bootstrap-timepicker.min.css")}}" rel="stylesheet">
@endsection

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title text-center text-bold">Form Tambah Shift</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="/admin/shift" method="POST">
            @csrf
            <div class="panel-body">
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Nama Shift
                            Baru:</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Nama Shift Baru" name="name"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name') <div class="text-danger invalid-feedback mt-3">
                                Nama shift baru tidak boleh kosong.
                            </div> @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Jam Masuk:</label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <input id="timepicker-input-shift-masuk" type="text" class="form-control"
                                    name="start_working_time">
                                <span class="input-group-addon"><i class="ti-timer"></i></span>
                            </div>
                        </div>
                        <label class="col-sm-2 control-label">Jam Keluar:</label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <input id="timepicker-input-shift-keluar" type="text" class="form-control"
                                    name="end_working_time">
                                <span class="input-group-addon"><i class="ti-timer"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-mint" type="submit">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>
@section('script')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<script src="{{asset("plugins/bootstrap-timepicker/bootstrap-timepicker.min.js")}}"></script>
<script>
    $(document).ready(function () {
        $('#timepicker-input-shift-masuk').timepicker({
            showSeconds: true,
            secondStep: 15,
            showMeridian: false
        });
    });

    $(document).ready(function () {
        $('#timepicker-input-shift-keluar').timepicker({
            showSeconds: true,
            secondStep: 15,
            showMeridian: false
        });
    });

</script>
@endsection
@endsection
