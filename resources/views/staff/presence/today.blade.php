@extends('layouts/templateStaff')
@section('title', 'Presensi')
@section('content-title', 'Presensi')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')

@section('content')
    <div class="panel panel-bordered panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Status Absensi Hari Ini</h3>
        </div>
        <div class="panel-body">
            <div class="row form-horizontal form-group">                
                <label class="col-sm-2 control-label" for="name">Nama Lengkap:</label>
                <div class="col-sm-3">
                    <input type="text" id="name" class="form-control" value="{{$name}}" name="name" style="margin-bottom: 10px" disabled>
                </div>
                <div class="col-sm-1"></div>
                <label class="col-sm-2 control-label" for="in_time">Waktu Masuk:</label>
                <div class="col-sm-3">
                    <input type="text" id="in_time" class="form-control" value="{{$presence->in_time}}" name="in_time" style="margin-bottom: 10px" disabled>
                </div>
            </div>
            <div class="row form-horizontal form-group">
                <label class="col-sm-2 control-label" for="name">Tanggal:</label>
                <div class="col-sm-3">
                    <input type="text" id="name" class="form-control" value="{{date('l, d F Y')}}" name="name" disabled>
                </div>
                <div class="col-sm-1"></div>
                <label class="col-sm-2 control-label" for="out_time">Waktu Keluar:</label>
                <div class="col-sm-3">
                    <input type="text" id="out_time" class="form-control" value="{{$presence->out_time}}" name="out_time" style="margin-bottom: 10px" disabled>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <a href="/staff/presence/test" class="btn btn-pink float-right">Toogle presensi</a>
        </div>
    </div>
@endsection