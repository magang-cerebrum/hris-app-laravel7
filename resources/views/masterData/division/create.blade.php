@extends('layouts/templateAdmin')
@section('content-title','Master Data / Divisi / Tambah Divisi')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Master Data')
@section('content')
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Form Tambah Divisi</h3>
    </div>
    <form class="form-horizontal" action="/admin/division" method="POST">
        @csrf
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Nama Divisi
                    Baru:</label>
                <div class="col-sm-10">
                    <input type="text" placeholder="Divisi Baru" name="name"
                        class="form-control @error('name') is-invalid @enderror">
                    @error('name') <div class="text-danger invalid-feedback mt-3">
                        Nama divisi baru tidak boleh kosong.
                    </div> @enderror
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-mint" type="submit">Tambah</button>
        </div>
    </form>
</div>

@endsection
