@extends('layouts/templateAdmin')
@section('title', 'Tambah Hari Libur')
@section('content-title', 'Master Data / Tambah Hari Libur')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')
@section('head')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
@endsection

@section('content')
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Form Input Tanggal Merah</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="/admin/holiday" method="POST">
            @csrf
            <div class="form-group row" style="margin-bottom: 15px">
                <label class="col-sm-2 control-label" for="information">Keterangan Libur</label>
                <div class="col-sm-10">
                    <input type="text" placeholder="Keterangan Libur" name="information"
                        class="form-control @error('information') is-invalid @enderror">
                    @error('information') <div class="text-danger invalid-feedback mt-3">
                        Keterangan Libur lowongan tidak boleh kosong.
                    </div> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="start">Tanggal</label>
                <div id="datepicker-input-libur">
                    <div class="col-sm-10">
                        <div class="input-group input-daterange">
                            <input type="text" class="form-control @error('start') is-invalid @enderror"
                                placeholder="Tanggal Mulai" name="start" value="{{old('start')}}" autocomplete="off">
                            <span class="input-group-addon">sampai</span>
                            <input type="text" class="form-control @error('end') is-invalid @enderror"
                                placeholder="Tanggal Akhir" name="end" value="{{old('end')}}" autocomplete="off">
                        </div>
                        @error('start') <div class="text-danger invalid-feedback mt-3">Mohon isi
                            tanggal mulai.</div> @enderror
                        @error('end') <div class="text-danger invalid-feedback mt-3">Mohon isi
                            tanggal akhir.</div> @enderror
                    </div>
                </div>
            </div>
    </div>
    <div class="panel-footer text-right">
        <button class="btn btn-warning" type="submit">Tambah</button>
    </div>
    </form>
</div>
@endsection
@section('script')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
<script>
    $(document).ready(function () {
        $('#datepicker-input-libur .input-daterange').datepicker({
            format: 'yyyy/mm/dd',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
    });

</script>
@endsection
