@extends('layouts/templateAdmin')
@section('title', 'Rekruitasi')
@section('content-title', 'Rekruitasi / Tambah Data Lowongan')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Tambah Data Lowongan</h3>
        </div>
        
        <form class="form-horizontal" action="/admin/job" method="POST" id="create">
            @csrf
        </form>

        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Posisi Lowongan</label>
                <div class="col-sm-10">
                    <input type="text" placeholder="Posisi Lowongan" name="name" form="create"
                        class="form-control @error('name') is-invalid @enderror">
                    @error('name') <div class="text-danger invalid-feedback mt-3">
                        Posisi lowongan tidak boleh kosong.
                        </div> @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Deskripsi Lowongan</label>
                <div class="col-sm-10">
                    <input type="text" placeholder="Deskripsi Lowongan" name="descript" form="create"
                        class="form-control @error('descript') is-invalid @enderror">
                    @error('descript') <div class="text-danger invalid-feedback mt-3">
                        Deskripsi lowongan tidak boleh kosong.
                        </div> @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="demo-textarea-input">Spesifikasi Dibutuhkan</label>
                <div class="col-md-10">
                    <textarea id="require" rows="6" class="form-control @error('required') is-invalid @enderror" placeholder="Spesifikasi Yang Dibutuhkan" name="required" form="create"></textarea>
                    @error('required') <div class="text-danger invalid-feedback mt-3">
                        Spesifikasi yang dibutuhkan tidak boleh kosong.
                        </div> @enderror
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-mint" type="submit" form="create">Tambah</button>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'require' );
    </script>
@endsection