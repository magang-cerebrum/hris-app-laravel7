@extends('layouts/templateAdmin')
@section('content-title','Master Data / Jabatan / Edit Data Jabatan')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Master Data')

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Form Edit Jabatan</h3>
        </div>
        
        <form action="/admin/position/{{$position->id}}" method="POST" id="edit">
            @csrf
            @method('put')
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="hor-inputjabatanbaru">Nama Jabatan
                    </label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Jabatan Baru" name="name" form="edit"
                            class="form-control @error('name') is-invalid @enderror" value="{{$position->name}}">
                        @error('name') <div class="text-danger invalid-feedback mt-3">
                            Nama jabatan tidak boleh kosong.
                        </div> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-mint" type="submit" form="edit">Simpan</button>
        </div>
    </div>
@endsection