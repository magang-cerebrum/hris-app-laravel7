@extends('layouts/templateAdmin')
@section('content-title','Master Data / Divisi / Edit Divisi')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Master Data')
@section('content')
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Form Edit Divisi</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="/admin/division/{{$division->id}}" method="POST">
            @csrf
            @method('put')
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Nama Divisi:
                    </label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Divisi Baru" name="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{$division->name}}">
                        @error('name') <div class="text-danger invalid-feedback mt-3">
                            Nama divisi tidak boleh kosong.
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
