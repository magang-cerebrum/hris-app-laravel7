@extends('layouts/templateAdmin')
@section('content-title','Master Data / Tipe Cuti / Edit Tipe Cuti')
@section('content-subtitle','HRIS '.$company_name)
@section('title','Master Data')

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Form Edit Tipe Cuti</h3>
        </div>
        
        <form action="/admin/paid-leave-type/{{$cuti->id}}" method="POST" id="edit">
            @csrf
            @method('put')
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Nama Tipe Cuti:
                    </label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Divisi Baru" name="name" form="edit"
                            class="form-control @error('name') is-invalid @enderror" value="{{$cuti->name}}">
                        @error('name') <div class="text-danger invalid-feedback mt-3">
                            Nama Cuti tidak boleh kosong.
                        </div> @enderror
                    </div>
                    <label class="col-sm-2 control-label" for="default_day">Jumlah Hari Cuti:
                    </label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Divisi Baru" name="default_day" form="edit"
                            class="form-control @error('default_day') is-invalid @enderror"
                            value="{{$cuti->default_day}}">
                        @error('default_day') <div class="text-danger invalid-feedback mt-3">
                            Jumlah Hari Cuti tidak boleh kosong.
                        </div> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <a href="{{url('/admin/paid-leave-type')}}" class="btn btn-dark">Kembali ke Data Tipe Cuti</a>
            <button class="btn btn-mint" type="submit" form="edit">Tambah</button>
        </div>
    </div>
@endsection
