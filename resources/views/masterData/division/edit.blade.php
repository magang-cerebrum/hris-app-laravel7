@extends('layouts/templateAdmin')
@section('content-title','Master Data / Divisi / Edit Divisi')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Master Data')
@section('content')
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Form Edit Divisi</h3>
    </div>
    
    <form class="form-horizontal" action="/admin/division/{{$division->id}}" method="POST" id="edit">
        @csrf
        @method('put')
    </form>

    <div class="panel-body" style="padding-top: 20px">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Nama Divisi:
            </label>
            <div class="col-sm-10">
                <input type="text" placeholder="Divisi Baru" name="name" form="edit"
                    class="form-control @error('name') is-invalid @enderror" value="{{$division->name}}">
                @error('name') <div class="text-danger invalid-feedback mt-3">
                    Nama divisi tidak boleh kosong.
                </div> @enderror
            </div>
        </div>
    </div>
    <div class="panel-footer text-right">
        <button class="btn btn-mint" type="submit" form="edit">Simpan</button>
    </div>
</div>
@endsection
