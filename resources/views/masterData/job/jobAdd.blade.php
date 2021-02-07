@extends('layout/templateAdmin')
@section('title', 'Rekruitasi')
@section('content-title', 'Rekruitasi / Tambah Data Lowongan')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
    <div class="panel">
        <div class="panel-body">
            <form class="form-horizontal" action="/admin/job" method="POST">
                @csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Posisi Lowongan</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Posisi Lowongan" name="name"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name') <div class="text-danger invalid-feedback mt-3">
                                Posisi lowongan tidak boleh kosong.
                                </div> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Deskripsi Lowongan</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Deskripsi Lowongan" name="descript"
                                class="form-control @error('descript') is-invalid @enderror">
                            @error('descript') <div class="text-danger invalid-feedback mt-3">
                                Deskripsi lowongan tidak boleh kosong.
                                </div> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="demo-textarea-input">Spesifikasi Dibutuhkan</label>
                        <div class="col-md-10">
                            <textarea id="require" rows="6" class="form-control @error('required') is-invalid @enderror" placeholder="Spesifikasi Yang Dibutuhkan" name="required"></textarea>
                            @error('required') <div class="text-danger invalid-feedback mt-3">
                                Spesifikasi yang dibutuhkan tidak boleh kosong.
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