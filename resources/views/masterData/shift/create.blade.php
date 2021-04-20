@extends('layouts/templateAdmin')
@section('content-title','Master Data / Shift / Tambah Data Shift')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Master Data')
@section('content')
@section('head')
<link href="{{asset("plugins/bootstrap-timepicker/bootstrap-timepicker.min.css")}}" rel="stylesheet">
@endsection

<div class="panel  panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Form Tambah Shift</h3>
    </div>
    
    <form class="form-horizontal" action="/admin/shift" method="POST" id="form_create">
        @csrf
    </form>

    <div class="panel-body">
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label">Nama Shift
                    Baru:</label>
                <div class="col-sm-10">
                    <input type="text" placeholder="Nama Shift Baru" name="name" form="form_create"
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
                            name="start_working_time" form="form_create">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    </div>
                </div>
                <label class="col-sm-2 control-label">Jam Keluar:</label>
                <div class="col-sm-4">
                    <div class="input-group date">
                        <input id="timepicker-input-shift-keluar" type="text" class="form-control"
                            name="end_working_time" form="form_create">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label">Warna Kalendar:</label>
                <div class="col-sm-4">
                    <input type="color" class="form-control" name="calendar_color" form="form_create">
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer text-right">
        <button class="btn btn-mint" type="submit" form="form_create">Tambah</button>
    </div>
</div>
@section('script')
<script src="{{asset("plugins/bootstrap-timepicker/bootstrap-timepicker.min.js")}}"></script>
<script>
    $(document).ready(function () {
        $('#timepicker-input-shift-masuk').timepicker({
            showMeridian: false
        });
        $('#timepicker-input-shift-keluar').timepicker({
            showMeridian: false
        });
        $('#timepicker-input-shift-masuk').change(function (){
            var get = document.getElementById('timepicker-input-shift-masuk').value;
            document.getElementById('timepicker-input-shift-masuk').value = get + ':00';
        });
        $('#timepicker-input-shift-keluar').change(function (){
            var get = document.getElementById('timepicker-input-shift-keluar').value;
            document.getElementById('timepicker-input-shift-keluar').value = get + ':00';
        });
    });

</script>
@endsection
@endsection
