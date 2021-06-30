@extends('layouts/templateAdmin')
@section('content-title','Master Data / Data Staff / Presensi')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Presensi')

@section('head')
    <link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
    <link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
    <link href="{{asset("plugins/fullcalendar/fullcalendar.min.css")}}" rel="stylesheet">
    <link href="{{asset("plugins/fullcalendar/nifty-skin/fullcalendar-nifty.min.css")}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .fc-time,.fc-left,.fc-right
        {display : none;}
        td.break{width: 10px; height: 10px;}
    </style>
@endsection

@section('content')
    <div class="panel panel-bordered panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">Data Presensi Staff </h3>
        </div>

        <form action="/admin/presence/processed" method="POST" id="process">
            @csrf
        </form>
        <form action="/admin/presence/reset" method="POST" id="reset">
            @csrf
        </form>
        <form action="/admin/presence/filter" method="POST" id="filter">
            @csrf
        </form>
        
        <div class="panel-body">
            <div class="row">
                <label class="col-sm-1 control-label" for="pickadate">Periode : </label>
                <div class="col-sm-3">
                    <div id="pickadate">
                        <div class="input-group date">
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="button" style="z-index: 2"><i class="fa fa-calendar"></i></button>
                            </span>
                            <input type="text" name="periode" placeholder="Masukan Tanggal untuk mencari Presensi" class="form-control"
                                autocomplete="off" id="periode" form="filter" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1"></div>
                <label class="col-sm-1 control-label" for="division">Divisi : </label>
                <div class="col-sm-3">
                    <select class="selectpicker" data-style="btn-info" id="division" form="filter">
                        <option value="all">Semua Divisi</option>
                        @foreach ($divisions as $division)
                            <option value="{{$division->division_id}}">{{$division->division_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-1"><input type="submit" value="Lihat Presensi" class="btn btn-dark" id="btn-search" form="filter"></div>
            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-success" form="process">Get Processed Data</button>
            <button type="submit" class="btn btn-dark" form="reset">Reset Log Presence</button>
        </div>
    </div>

    <div id="panel-output"></div>
@endsection

@section('script')
    <script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
    <script src="{{asset("plugins/fullcalendar/lib/moment.min.js")}}"></script>
    <script src="{{asset("plugins/fullcalendar/lib/jquery-ui.custom.min.js")}}"></script>
    <script src="{{asset("plugins/fullcalendar/fullcalendar.min.js")}}"></script>
    <script src="{{asset("plugins/fullcalendar/lang/id.js")}}"></script>
    <script>
        $(document).ready(function () {
            $('#pickadate .input-group.date').datepicker({
                format: 'yyyy-mm',
                autoclose: true,
                minViewMode: 'months',
                maxViewMode: 'years',
                startView: 'months',
                orientation: 'bottom',
                forceParse: false,
                endDate: '0day'
            });
            $('#filter').on('submit', function () {
                event.preventDefault();
                var division = $('#division').val();
                var periode = document.getElementById('periode').value;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }});
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: {
                        periode: periode,
                        division: division
                    },
                    success: function (data) {
                        $("#panel-output").html(data);
                    },
                    error: function (jXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error!',
                            text: "Isi form terlebih dahulu!",
                            icon: 'error',
                            width: 600
                        });
                    }
                });
            });
        })
    </script>
@endsection
