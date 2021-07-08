@extends('layouts/templateAdmin')
@section('content-title','Master Data / Divisi / Tambah Divisi')
@section('content-subtitle','HRIS '.$company_name)
@section('title','Master Data')

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Form Tambah Divisi</h3>
        </div>
        
        <form class="form-horizontal" action="/admin/division" method="POST" id="create">
            @csrf
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Nama Divisi
                    Baru:</label>
                <div class="col-sm-10">
                    <input type="text" placeholder="Divisi Baru" name="name" form="create"
                        class="form-control @error('name') is-invalid @enderror">
                    @error('name') <div class="text-danger invalid-feedback mt-3">
                        Nama divisi baru tidak boleh kosong.
                    </div> @enderror
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <a href="{{url('/admin/division')}}" class="btn btn-dark">Kembali ke Data Divisi</a>
            <button class="btn btn-mint" type="submit" form="create">Tambah</button>
        </div>
    </div>
@endsection
