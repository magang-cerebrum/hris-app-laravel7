@extends('layouts/templateAdmin')
@section('content-title','Master Data / Shift / Edit Data Shift')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Master Data')
@section('content')
@section('head')
<link href="{{asset("plugins/bootstrap-timepicker/bootstrap-timepicker.min.css")}}" rel="stylesheet">
@endsection

<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Form Edit Shift</h3>
    </div>
    <form class="form-horizontal" action="/admin/shift/{{$shift->id}}" method="POST">
        @csrf
        @method('put')
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="hor-editshift">Nama Shift
                </label>
                <div class="col-sm-10">
                    <input type="text" placeholder="Nama Shift" name="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{$shift->name}}">
                    @error('name') <div class="text-danger invalid-feedback mt-3">
                        Nama shift tidak boleh kosong.
                    </div> @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">Jam Masuk:</label>
                    <div class="col-sm-4">
                        <div class="input-group date">
                            <input id="timepicker-edit-shift-masuk" type="text" class="form-control"
                                name="start_working_time" value="{{$shift->start_working_time}}">
                            <span class="input-group-addon"><i class="ti-timer"></i></span>
                        </div>
                    </div>
                    <label class="col-sm-2 control-label">Jam Keluar:</label>
                    <div class="col-sm-4">
                        <div class="input-group date">
                            <input id="timepicker-edit-shift-keluar" type="text" class="form-control"
                                name="end_working_time" value="{{$shift->end_working_time}}">
                            <span class="input-group-addon"><i class="ti-timer"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">Warna Kalendar:</label>
                    <div class="col-sm-4">
                        <input type="color" class="form-control" name="calendar_color">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-mint" type="submit">Simpan</button>
        </div>
    </form>
</div>
@section('script')
<script src="{{asset("plugins/bootstrap-timepicker/bootstrap-timepicker.min.js")}}"></script>
<script>
    $(document).ready(function () {
        $('#timepicker-edit-shift-masuk').timepicker({
            showMeridian: false
        });
        $('#timepicker-edit-shift-keluar').timepicker({
            showMeridian: false
        });
        $('#timepicker-edit-shift-masuk').change(function (){
            var get = document.getElementById('timepicker-edit-shift-masuk').value;
            document.getElementById('timepicker-edit-shift-masuk').value = get + ':00';
        });
        $('#timepicker-edit-shift-keluar').change(function (){
            var get = document.getElementById('timepicker-edit-shift-keluar').value;
            document.getElementById('timepicker-edit-shift-keluar').value = get + ':00';
        });
    });
</script>
@endsection
@endsection
