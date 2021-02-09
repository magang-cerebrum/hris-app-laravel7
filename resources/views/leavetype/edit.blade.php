@extends('layouts/templateAdmin')
@section('content-title','Edit Tipe Cuti')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Edit Tipe Cuti')
@section('content')
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title text-center text-bold">Form Edit Tipe Cuti</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="/admin/paid-leave-type/{{$cuti->id}}" method="POST">
            @csrf
            @method('put')
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Nama Tipe Cuti:
                    </label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Divisi Baru" name="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{$cuti->name}}">
                        @error('name') <div class="text-danger invalid-feedback mt-3">
                            Nama Cuti tidak boleh kosong.
                        </div> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Jumlah Hari Cuti:
                    </label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Divisi Baru" name="default_day"
                            class="form-control @error('name') is-invalid @enderror" value="{{$cuti->default_day}}">
                        @error('name') <div class="text-danger invalid-feedback mt-3">
                            Jumlah Hari Cuti Tidak Boleh Kosong
                        </div> @enderror
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-mint" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
