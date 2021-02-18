@extends('layouts/templateAdmin')
@section('content-title','Data Staff / Penghargaan / Tambah Tanggal')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Tambah Tanggal')
@section('content')
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title text-center text-bold">Form Tambah Tanggal Achievement</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="{{ route('datestore') }}" method="POST">
            @csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Bulan :</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Bulan" name="month"
                            class="form-control @error('name') is-invalid @enderror">
                            
                    </div>
                    <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Tahun :</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Tahun" name="year"
                            class="form-control @error('name') is-invalid @enderror">
                            
                    </div>
                    <input type="hidden" name="status_scored" value="empty">
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-mint" type="submit">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection