@extends('layouts/templateAdmin')
@section('content-title','Tambah Tipe Cuti')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Tambah Tipe Cuti')
@section('content')
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title text-center text-bold">Form Tambah Data Tipe Cuti</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="/admin/paid-leave-type" method="POST">
            @csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Tambah Tipe Cuti Baru:</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Nama Tipe Cuti" name="name"
                            class="form-control @error('name') is-invalid @enderror">
                            
                        @error('name') <div class="text-danger invalid-feedback mt-3">
                            Nama Tipe Cuti baru tidak boleh kosong.
                        </div> @enderror
                    </div>
                    <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Jumlah Hari Cuti:</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Jumlah Hari Cuti" name="default_day"
                            class="form-control @error('name') is-invalid @enderror">
                            
                        @error('name') <div class="text-danger invalid-feedback mt-3">
                            Nama Tipe Cuti baru tidak boleh kosong.
                        </div> @enderror
                    </div>
                    
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-mint" type="submit">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
