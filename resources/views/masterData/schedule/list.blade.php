@extends('layouts/templateAdmin')
@section('title','Jadwal Kerja')
@section('content-title','Jadwal Kerja / Daftar Jadwal Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('head')
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
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

    <form action="{{url('/admin/schedule/search')}}" method="POST" id="schedule-search" class="form-horizontal">
        @csrf    
        <div class="panel-body">
            <div class="row">
                <label class="col-sm-1 control-label" for="pickadate">Periode : </label>
                <div class="col-sm-3">
                    <div id="pickadate">
                        <div class="input-group date">
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="button" style="z-index: 2"><i class="fa fa-calendar"></i></button>
                            </span>
                            <input type="text" name="query" placeholder="Masukan Tanggal untuk mencari Jadwal" class="form-control"
                                autocomplete="off" id="query" form="schedule-search" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1"></div>
                <label class="col-sm-1 control-label" for="filter">Divisi : </label>
                <div class="col-sm-3">
                    <select class="selectpicker" data-style="btn-info" id="filter">
                        <option value="Semua Divisi">Semua Divisi</option>
                        @foreach ($data_division as $division)
                        <option value="{{$division->name}}">{{$division->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-1"><input type="submit" value="Lihat Jadwal" class="btn btn-dark" id="btn-search"></div>
            </div>
        </div>
    </form>
</div>

<div id="panel-output">

</div>
@endsection
@section('script')
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<script>
    
        
    $(document).ready(function () {
        $('#pickadate .input-group.date').datepicker({
            format: 'mm/yyyy',
            autoclose: true,
            minViewMode: 'months',
            maxViewMode: 'years',
            startView: 'months',
            orientation: 'bottom',
            forceParse: false,
        });
        $('#filter').selectpicker({
            dropupAuto: false
        });
        $('#schedule-search').on('submit', function (event) {
            event.preventDefault();
            var periode = document.getElementById('query').value;
            var division = $('#filter').find(":selected").text();
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }});
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: {periode: periode,division: division},
                success: function (data) {
                    $("#panel-output").html(data);
                },
                error: function (jXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: errorThrown,
                        text: "Mohon isi dulu form!",
                        icon: 'error',
                        width: 600
                    });
                }
            });
        });
    });
</script>
@endsection