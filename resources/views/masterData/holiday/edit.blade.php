@extends('layouts/templateAdmin')
@section('title', 'Edit Hari Libur')
@section('content-title', 'Master Data / Tanggal Merah / Edit Hari Libur')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')
@section('head')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
@endsection

@section('content')
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Form Edit Tanggal Merah</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="/admin/holiday/{{$holiday->id}}" method="POST">
            @csrf
            @method('put')
            <div class="form-group row" style="margin-bottom: 15px">
                <label class="col-sm-2 control-label" for="information">Keterangan Libur</label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Keterangan Libur" name="information"
                        class="form-control @error('information') is-invalid @enderror" value="{{$holiday->information}}">
                    @error('information') <div class="text-danger invalid-feedback mt-3">
                        Keterangan Libur lowongan tidak boleh kosong.
                    </div> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label" for="date">Tanggal</label>
                <div class="col-sm-4">
                    <div id="datepicker-edit-libur">
                        <div class="input-group date">
                            <input type="text" placeholder="Tanggal" name="date"
                                class="form-control @error('date') is-invalid @enderror" value="{{$holiday->date}}">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                        @error('date') <span class="text-danger invalid-feedback mt-3">
                            Tanggal libur tidak boleh sama dengan yang sudah ada.
                        </span> @enderror
                    </div>
                </div>
            </div>
    </div>
    <div class="panel-footer text-right">
        <button class="btn btn-warning" type="submit">Simpan</button>
    </div>
    </form>
</div>
@endsection
@section('script')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
<script>
    $(document).ready(function () {
        $('#datepicker-edit-libur .input-group.date').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true,
            orientation: 'bottom'
        });
    });

</script>
@endsection
