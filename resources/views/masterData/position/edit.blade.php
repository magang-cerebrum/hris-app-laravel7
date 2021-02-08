@extends('layouts/templateAdmin')
@section('content-title','Edit Data Jabatan')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Edit Data Jabatan')
@section('content')

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title text-center text-bold">Form Edit Jabatan</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="/admin/position/{{$position->id}}" method="POST">
            @csrf
            @method('put')
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="hor-inputjabatanbaru">Nama Jabatan
                    </label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Jabatan Baru" name="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{$position->name}}">
                        @error('name') <div class="text-danger invalid-feedback mt-3">
                            Nama jabatan tidak boleh kosong.
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