@extends('layouts/templateAdmin')
@section('content-title','Master Data / Tipe Cuti / Tambah Tipe Cuti')
@section('content-subtitle','HRIS '.$company_name)
@section('title','Master Data')

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Form Tambah Data Tipe Cuti</h3>
        </div>
        
        <form action="/admin/paid-leave-type" method="POST" id="create">
            @csrf
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Tambah Tipe Cuti Baru:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Nama Tipe Cuti" name="name" form="create"
                            class="form-control @error('name') is-invalid @enderror">
                            
                        @error('name') <div class="text-danger invalid-feedback mt-3">
                            Nama Tipe Cuti baru tidak boleh kosong.
                        </div> @enderror
                    </div>
                    <label class="col-sm-2 control-label" for="default_day">Jumlah Hari Cuti:</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Jumlah Hari Cuti" name="default_day" form="create"
                            class="form-control @error('default_day') is-invalid @enderror">
                        @error('name') <div class="text-danger invalid-feedback mt-3">
                            Jumlah Hari Cuti tidak boleh kosong.
                        </div> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <a href="{{url('/admin/paid-leave-type')}}" class="btn btn-dark">Kembali ke Data Tipe Cuti</a>
            <button class="btn btn-mint" type="submit" form="create">Tambah</button>
        </div>
    </div>
@endsection
