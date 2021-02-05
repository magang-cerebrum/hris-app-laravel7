@extends('layouts/templateAdmin')
@section('content-title','Edit Data Shift')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Edit Shift')
@section('content')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-timepicker/bootstrap-timepicker.min.css")}}" rel="stylesheet">

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title text-bold text-center">Form Edit Shift</h3>
    </div>
    <div class="panel-body">
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
                <div class="panel-footer text-right">
                    <button class="btn btn-mint" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!--Bootstrap Timepicker [ OPTIONAL ]-->
<script src="{{asset("plugins/bootstrap-timepicker/bootstrap-timepicker.min.js")}}"></script>

<script>
    $(document).ready(function () {
        $('#timepicker-edit-shift-masuk').timepicker({
            showSeconds: true,
            secondStep: 15,
            showMeridian: false
        });
    });

    $(document).ready(function () {
        $('#timepicker-edit-shift-keluar').timepicker({
            showSeconds: true,
            secondStep: 15,
            showMeridian: false
        });
    });

</script>
@endsection
