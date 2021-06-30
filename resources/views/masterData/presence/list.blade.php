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
            <h3 class="panel-title">Data Presensi Staff Bulan  " <span id="periode-title"></span> "</h3>
        </div>

        <form action="/admin/presence/processed" method="POST" id="process">
            @csrf
        </form>
        <form action="/admin/presence/reset" method="POST" id="reset">
            @csrf
        </form>
        
        <div class="panel-body">
            <div class="row">
                <form class="form-inline" action="/admin/presence/filter" method="POST" id="filter">
                    @csrf
                    <div class="form-group">
                        <label for="division" class="control-label"> Divisi : </label>
                        <select class="selectpicker" data-style="btn-primary" id="division" name="division" form="filter">
                            @foreach ($divisions as $item)
                                <option value="{{$item->division_id}}">{{$item->division_name}}</option>
                            @endforeach
                            <option value="all" selected>Semua Divisi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="periode" class="control-label"> Bulan : </label>
                        <div id="pickadate" style="display:inline;">
                            <div class="input-group date">
                                <input type="text" name="periode" placeholder="Filter Bulan Presensi" id="periode" form="filter"
                                    class="form-control" autocomplete="off" readonly>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-info" type="submit" form="filter">Filter</button>
                </form>
                
                <div id='calendar' class="mar-top"></div><br>
                
                <table><tr>
                        <td style="width: 15px;height: 15px;background-color:#2B323A"></td><td class="break"></td><td>: Tidak Hadir</td><td class="break">
                        <td style="width: 15px;height: 15px;background-color:#79AF3A"></td><td class="break"></td><td>: Hadir</td><td class="break">
                        <td style="width: 15px;height: 15px;background-color:#1F897F"></td><td class="break"></td><td>: Absen Masuk</td><td class="break">
                        <td style="width: 15px;height: 15px;background-color:#FF8806"></td><td class="break"></td><td>: Terlambat</td><td class="break">
                        <td style="width: 15px;height: 15px;background-color:#953CA4"></td><td class="break"></td><td>: Terlambat Masuk</td><td class="break">
                        <td style="width: 15px;height: 15px;background-color:#F22314"></td><td class="break"></td><td>: Off</td><td class="break">
                        <td style="width: 15px;height: 15px;background-color:#ED417B"></td><td class="break"></td><td>: Cuti</td><td class="break">
                        <td style="width: 15px;height: 15px;background-color:#290657"></td><td class="break"></td><td>: Sakit</td><td class="break">
                <tr></table>
            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-success" form="process">Get Processed Data</button>
            <button type="submit" class="btn btn-dark" form="reset">Reset Log Presence</button>
        </div>
    </div>
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
            });
            $('#filter').on('submit', function () {
                event.preventDefault();
                var division = $('#division').val();
                var periode = document.getElementById('periode').value;
                console.log(division,periode);
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
                    success: function (response) {
                        $('#calendar').fullCalendar(refetchEvents)
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
            $('#calendar').fullCalendar({
                fixedWeekCount: false,
                header:{
                    left: 'prev,next',
                    center: 'title',
                    right: 'month,basicWeek'
                },
                defaultDate: '<?= $year ?>-<?= $month ?>-01',
                eventLimit: true,
                events: [
                    <?php foreach ($data as $item) { 
                        for ($i=1; $i <= $day; $i++) { ?>
                            <?php 
                                $state = 'day_'.$i;
                                switch ($item->$state) {
                                    case 'Kosong':
                                        $color = '#2B323A';
                                        break;
                                    case 'Hadir':
                                        $color = '#79AF3A';
                                        break;
                                    case 'Telat':
                                        $color = '#FF8806';
                                        break;
                                    case 'Telat Masuk':
                                        $color = '#953CA4';
                                        break;
                                    case 'Absen Masuk':
                                        $color = '#1F897F';
                                        break;
                                    case 'Off':
                                        $color = '#F22314';
                                        break;
                                    case 'Cuti':
                                        $color = '#ED417B';
                                        break;
                                    case 'Sakit':
                                        $color = '#290657';
                                        break;
                                }
                            ?>
                            {
                                title: '<?= $item->user_name ?>',
                                start: "<?= $year ?>-<?= $month ?>-<?= $i / 10 < 1 ? '0'. $i : $i ?>",
                                color: '<?= $color ?>'
                            },
                        <?php } ?>
                    <?php } ?>
                ]
            });
        })
    </script>
@endsection
