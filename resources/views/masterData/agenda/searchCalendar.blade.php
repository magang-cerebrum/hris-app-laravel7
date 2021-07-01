@extends('layouts/templateAdmin')
@section('title','Agenda Kerja')
@section('content-title','Agenda Kerja / Kalendar Agenda Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <link href="{{asset("plugins/fullcalendar/fullcalendar.min.css")}}" rel="stylesheet">
    <link href="{{asset("plugins/fullcalendar/nifty-skin/fullcalendar-nifty.min.css")}}" rel="stylesheet">
    <link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .fc-left,
        .fc-right{
            display: none;
        }
        #container .fc-event{
            cursor: pointer;
        }
        a.fc-more{
            font-weight: bold;
        }
        tbody {
            color: black;
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-bordered panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">Cari Agenda Kerja</h3>
        </div>

        <form action="{{url('/admin/agenda/calendar')}}" method="POST" id="cari-agenda">
            @csrf
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="row mar-btm">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <div id="pickadate">
                        <div class="input-group date">
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="button" style="z-index: 2"><i class="fa fa-calendar"></i></button>
                            </span>
                            <input type="text" name="periode" placeholder="Cari Agenda Kerja" id="periode" form="cari-agenda"
                                class="form-control" autocomplete="off" readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-danger" id="btn-search" type="submit" form="cari-agenda"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="current_month">
        <div class="panel panel-bordered panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Agenda Kerja Bulan Ini {{current_period('view')}}</h3>
            </div>
            <div class="panel-body">
                @if ($data_calendar->isEmpty())
                    <div class="text-center text-bold text-danger">
                        Tidak ada data agenda ditemukan untuk bulan ini. <br>
                        <a href="{{url('/admin/agenda/add')}}" class="btn btn-warning mar-top">Klik disini untuk menambahkan agenda!</a>
                    </div>
                @else
                    <div id="current_calendar"></div>
                @endif
            </div>
        </div>
    </div>

    <div id="panel-output">

    </div>
@endsection

@section('script')
    <script src="{{asset("plugins/fullcalendar/lib/moment.min.js")}}"></script>
    <script src="{{asset("plugins/fullcalendar/lib/jquery-ui.custom.min.js")}}"></script>
    <script src="{{asset("plugins/fullcalendar/fullcalendar.min.js")}}"></script>
    <script src="{{asset("plugins/fullcalendar/lang/id.js")}}"></script>
    <script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
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
            $('#btn-search').on('click',function () {
                $('.datepicker').hide();
            });
            $('#cari-agenda').on('submit', function (event) {
                event.preventDefault();
                var periode = document.getElementById('periode').value;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }});
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: {periode: periode},
                    success: function (data) {
                        $("#current_month").remove();
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
            $('#current_calendar').fullCalendar({
                height: 575,
                fixedWeekCount: false,
                header:{
                    center: 'title',
                },
                defaultDate: '<?= current_period() ?>01',
                eventLimit: true,
                timeFormat: 'H:mm',
                eventRender: function(eventObj, $el) {
                    $el.popover({
                        title: eventObj.title,
                        content:  new Date(eventObj.start).getUTCHours() + ':' + new Date(eventObj.start).getUTCMinutes() + ' - ' +  new Date(eventObj.end).getUTCHours() + ':' + new Date(eventObj.end).getUTCMinutes()  + ' | ' + eventObj.description,
                        trigger: 'hover',
                        placement: 'top',
                        container: 'body'
                    });
                },
                events: [
                    <?php foreach ($data_calendar as $item) { 
                        $start_date = intval(explode('-',explode(' ',$item->start_event)[0])[2]);                    
                        $interval = date_diff(date_create($item->start_event), date_create($item->end_event))->format('%d');
                        for ($i=$start_date; $i <= ($start_date + $interval); $i++) { ?>
                            <?php
                                $i < 10 ? $pos = 9 : $pos = 8;
                                $start = substr_replace(explode(" ", $item->start_event)[0],$i,$pos,2) . 'T' . explode(" ", $item->start_event)[1];
                                $end = substr_replace(explode(" ", $item->start_event)[0],$i,$pos,2) . 'T' . explode(" ", $item->end_event)[1];
                            ?>
                            {
                                title: '<?= $item->title ?>',
                                description: '<?= $item->description ?>',
                                start: "<?= $start ?>",
                                end: "<?= $end ?>",
                                color: '<?= $item->calendar_color ?>'
                            },
                        <?php } ?>
                    <?php } ?>
                ]
            });
        });
    </script>
@endsection