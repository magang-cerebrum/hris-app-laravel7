@extends('layouts/templateAdmin')
@section('title','Jadwal Kerja')
@section('content-title','Jadwal Kerja / Daftar Jadwal Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('head')
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
<style>
    tbody {
        color: black;
    }
</style>
@endsection
@section('content')

<div class="panel panel-bordered panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">Daftar Jadwal Kerja</h3>
    </div>
    <div class="panel-body">
        <form action="/admin/schedule/search" method="post" id="schedule-search">
            @csrf
            {{-- <label class="col-sm-1 control-label">Bulan:</label> --}}
            <div id="datepicker-input-cari">
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon">Bulan :</span>
                        
                        <select class="selectpicker" data-style="btn-info" 
                        style="width: 100%" 
                        id="filter-bulan"  name="month">
                            <option value=" "></option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="juli">juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                        <span class="input-group-addon">Tahun :</span>
                        <input type="text" class="form-control @error('year') is-invalid @enderror"
                            placeholder="Tahun" name="year" value="{{old('year')}}"  autocomplete="off">
                    </div>
                    {{-- @error('start') <div class="text-danger invalid-feedback mt-3">Mohon isi
                        tanggal mulai.</div> @enderror
                    @error('end') <div class="text-danger invalid-feedback mt-3">Mohon isi
                    tanggal akhir.</div> @enderror --}}
                </div>
            </div>
    </div>
    <div class="panel-footer text-right">
        {{-- <a href="/staff/presence/test" class="btn btn-warning float-right">Toogle presensi</a> --}}
        <button type="submit" class="btn btn-success float-right" >Cari Jadwal Kerja</button>
    </div>
    </form>
</div>

<div id="panel-output">

</div>
@endsection


@section('script')
<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
<script>
    
        
    $(document).ready(function () {
        $('#schedule-search').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                // data: {  _token : <?php Session::token() ?>},
                data: $(this).serialize(),
                success: function (data) {
                    $("#panel-output").html(data);
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });
    });
</script>
@endsection