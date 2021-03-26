@extends('layouts/templateAdmin')
@section('title', 'Sistem')
@section('content-title', 'Poster / Tambah Data Poster')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Tambah Poster Dashboard</h3>
        </div>
        <form class="form-horizontal" action="{{ url('/admin/poster/add')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="hor-inputposterbaru">Nama Poster:</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Nama Poster Baru" name="name"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name') <div class="text-danger invalid-feedback mt-3">
                            Nama poster baru tidak boleh kosong.
                        </div> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Input Poster:</label>
                    <div class="col-sm-10">
                        <span class="pull-left btn btn-primary btn-file">
                        Browse... <input type="file" name="file">
                        </span>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                <button class="btn btn-mint" type="submit">Tambah</button>
            </div>
        </form>
    </div>
@endsection