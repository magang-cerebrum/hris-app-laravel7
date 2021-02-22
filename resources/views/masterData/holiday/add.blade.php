@extends('layouts/templateAdmin')
@section('title', 'Hari Libur')
@section('content-title', 'Master Data / Tambah Hari Libur')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
<div class="panel">
    <div class="panel-body">
        <form class="form-horizontal" action="/admin/job" method="POST">
            @csrf
            <div class="panel-body">
                <div class="form-group row" style="margin-bottom: 15px">
                    <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Keterangan Libur</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="Keterangan Libur" name="information"
                            class="form-control @error('information') is-invalid @enderror">
                        @error('information') <div class="text-danger invalid-feedback mt-3">
                            keterangan Libur lowongan tidak boleh kosong.
                            </div> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label" for="hor-inputdivisibaru">Tanggal Mulai</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Tanggal Mulai" name="start"
                            class="form-control @error('start') is-invalid @enderror">
                        @error('start') <div class="text-danger invalid-feedback mt-3">
                            Tanggal Mulai tidak boleh kosong.
                            </div> @enderror
                    </div>
                    <label class="col-md-2 control-label" for="demo-textarea-input">Tanggal Berakhir</label>
                    <div class="col-md-4">
                        <input type="text" placeholder="Tanggal Berakhir" name="end"
                            class="form-control @error('end') is-invalid @enderror">
                        @error('end') <div class="text-danger invalid-feedback mt-3">
                            Tanggal Berakhir tidak boleh kosong.
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