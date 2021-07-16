@extends('layouts/templateStaff')
@section('title', 'Dashboard Staff')
@section('content-title', 'Selamat Datang Di Aplikasi HRIS')
@section('content-subtitle', '(Human Resource Information System)')
@section('head')
<link href="{{asset("plugins/fullcalendar/fullcalendar.min.css")}}" rel="stylesheet">
<link href="{{asset("plugins/fullcalendar/nifty-skin/fullcalendar-nifty.min.css")}}" rel="stylesheet">
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
<link href="{{asset("css/slider/slide.css")}}" rel="stylesheet">
<link href="{{asset("plugins/themify-icons/themify-icons.css")}}" rel="stylesheet">

<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    #staff-charts-performance {
        width: 100%;
        height: 270px;
    }

    #staff-charts-achievement {
        width: 100%;
        height: 270px;
    }

    #charts {
        position: relative;
    }

    #years {
        position: absolute;
        right: 4px;
        top: 4px;
    }

    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
        width: 80px;
    }

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

    
</style>
@endsection
@section('content')
@if (count($data_poster) > 0)
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-carousel">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @foreach ($data_poster as $item_poster)
                        <li data-target="#myCarousel" data-slide-to="{{$loop->iteration}}"
                            class="{{$loop->iteration  == 1 ? "active" : ""}}"></li>
                        @endforeach
                    </ol>

                    <!-- deklarasi carousel -->
                    <div class="carousel-inner" role="listbox">
                        @foreach ($data_poster as $item_poster)
                        <div class="item {{$loop->iteration  == 1 ? "active" : ""}}">
                            <img src="{{ asset('img/poster/'.$item_poster->file)}}" alt="{{$item_poster->name}}">
                        </div>
                        @endforeach
                    </div>

                    <!-- membuat panah next dan previous -->
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                        <span class="fa fa-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                        <span class="fa fa-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row mh-byrow">
    <div class="col-md-6">
        <div class="panel panel-warning panel-colorful media middle pad-all">
            <div class="media-left">
                <div class="pad-hor">
                    <i class="pli-fingerprint icon-3x"></i>
                </div>
            </div>
            <div class="media-body">
                <p class="text-2x mar-no text-semibold">
                    @if ($bool_presence == 0)
                        Belum Absen Masuk
                    @elseif ($bool_presence == 1)
                        Belum Absen Pulang
                    @else
                        Sudah Absen
                    @endif
                </p>
                <p class="mar-no">{{$schedule ? 'Shift anda hari ini '.$schedule : 'Anda Belum Mempunyai Jadwal'}}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-purple panel-colorful media middle pad-all">
            <div class="media-left">
                <div class="pad-hor">
                    <i class="pli-fingerprint icon-3x"></i>
                </div>
            </div>
            <div class="media-body">
                <p class="text-2x mar-no text-semibold">{{$paid_leave_user}}</p>
                <p class="mar-no">Sisa Cuti Tahunan Anda</p>
            </div>
        </div>
    </div>
</div>

@if (Auth::user()->position_id != 11)
    <div class="row mh-byrow">
        <div class="col-md-4">
            <div class="panel panel-dark panel-colorful media middle pad-all">
                <div class="media-left">
                    <div class="pad-hor">
                        <i class="pli-fingerprint icon-3x"></i>
                    </div>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">{{count($data_presence)}}</p>
                    <p class="mar-no">Presensi Staff Belum Di Cek</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary panel-colorful media middle pad-all">
                <div class="media-left">
                    <div class="pad-hor">
                        <i class="pli-male-female icon-3x"></i>
                    </div>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">{{count($data_paid_leave)}}</p>
                    <p class="mar-no">Pengajuan Cuti Staff</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-mint panel-colorful media middle pad-all">
                <div class="media-left">
                    <div class="pad-hor">
                        <i class="pli-monitor-2 icon-3x"></i>
                    </div>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">{{count($data_wfh)}}</p>
                    <p class="mar-no">Pengajuan WFH Staff</p>
                </div>
            </div>
        </div>
    </div>
@endif
@if (!$data_agenda->isEmpty())
    <div class="panel panel-bordered panel-primary">
        <div class="panel-heading">
            <div class="panel-control">
                <button class="btn btn-default" data-panel="minmax"><i class="psi-chevron-up"></i></button>
            </div>
            <h3 class="panel-title">Agenda Kerja Bulan Ini {{current_period('view')}}</h3>
        </div>
        <div class="collapse in">
            <div class="panel-body">
                @if ($data_agenda->isEmpty())
                    <div class="text-center text-bold text-danger">
                        Tidak ada data agenda ditemukan untuk bulan ini. <br>
                        <a href="{{url('/admin/agenda/add')}}" class="btn btn-warning mar-top">Klik disini untuk menambahkan agenda!</a>
                    </div>
                @else
                    <div id="current_agenda"></div>
                @endif
            </div>
        </div>
    </div>
@endif
<div class="row mt-5 mh-byrow">
    {{-- Charts Performa --}}
    <div class="col-md-6" id="grafikPerforma">
        <div class="panel panel-bordered panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Grafik Performa "{{$name}}"
                    @if (count($monthDecidePerformance)!=0)
                        <span id="textvalperf">Tahun {{$monthDecidePerformance[0]->year}}</span> 
                    @endif
                </h3>
            </div>
            <div class="panel-body" id="charts">
                <div id="years">
                    <select name="select" id="year-finder-performance" class="selectpicker" data-style="btn-primary"
                        onchange="showChangePerformanceYear()">
                        @foreach ($year_list_performance as $item)
                            @if ($item->year == $current_year)
                                <option value="{{$item->year}}" selected>{{$item->year}}</option>
                            @else 
                                <option value="{{$item->year}}">{{$item->year}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div id="staff-charts-performance"></div>
                <br>
                <div id="eom_message">
                    <p id="text_eom_0" class="text-danger"></p>
                    <p id="total_score_performance" class="text-info">Total Score : {{$all_score_performance}}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Achievement --}}
    <div class="col-md-6">
        <div class="panel panel-bordered panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Grafik Achievement "{{$name}}"
                    @if (count($monthDecideAchievement)!=0)
                        <span id="textvalperf">Tahun {{$monthDecideAchievement[0]->year}}</span> 
                    @endif
                </h3>
            </div>
            <div class="panel-body" id="charts">
                <div id="years">
                    <select name="select" id="year-finder-achievement" class="selectpicker" data-style="btn-primary"
                        onchange="showChangeAchievementYear()">
                        @foreach ($year_list_achievement as $item)
                        @if ($item->year == $current_year)
                        <option value="{{$item->year}}" selected>{{$item->year}}</option>
                        @else <option value="{{$item->year}}">{{$item->year}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div id="staff-charts-achievement"></div>
                <br>
                <div id="eom_message">
                    <p id="text_eom_0" class="text-danger"></p>
                    <p id="total_score_achievement" class="text-info">Total Score : {{$all_score_achievements}}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-10">
    <div class="col-md-4">
        <div class="mh-box panel panel-bordered panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Top Scored Performance 
                    @if (count($monthDecidePerformance)!=0)
                        <span>({{switch_month($monthDecidePerformance[0]->month) . ' - ' .$monthDecidePerformance[0]->year}})</span>
                        <span data-toggle="modal" data-target="#modal-detail-top-scored" style="cursor: pointer"
                        data-performance="{{$monthDecidePerformance}}" id="modal-performance">
                            <i class="ti-cup add-tooltip" data-original-title="Detailed Top Scored"></i>
                        </span>
                    @endif
                    <sup><i class="fa fa-info" title="Score Performa Adalah Score Yang Diberikan Langsung Oleh Chief Divisi"></i></sup>
                </h3>
            </div>
            <div class="panel-body" style="min-height: 383px; padding-top: 20px; padding-bottom: 20px">
                @if ($monthDecidePerformance)
                    <div class="row">
                        <div class="col-sm-1 col-md-1"></div>
                        @foreach ($monthDecidePerformance->take(3) as $mdpItem)
                            @if ($loop->iteration == 1)
                                <div class="panel panel-warning panel-colorful">
                                    <div class="pad-all">
                                        <div class="media">
                                            <div class="media-left" style="width: 30%;">
                                                <img class="img-md img-circle img-responsive"
                                                    src="{{asset('img/profile-photos/'.$mdpItem->profile_photo)}}"
                                                    alt="Profile Picture">
                                            </div>
                                            <div class="media-body pad-top">
                                                <span class="text-lg text-semibold">{{$mdpItem->name}} #{{$loop->iteration}}</span>
                                                <p>Score : {{$mdpItem->performance_score}}/100</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($loop->iteration == 2)
                                <div class="panel panel-secondary panel-colorful">
                                    <div class="pad-all">
                                        <div class="media">
                                            <div class="media-left" style="width: 30%;">
                                                <img class="img-md img-circle img-responsive"
                                                    src="{{asset('img/profile-photos/'.$mdpItem->profile_photo)}}"
                                                    alt="Profile Picture">
                                            </div>
                                            <div class="media-body pad-top">
                                                <span class="text-lg text-semibold">{{$mdpItem->name}} #{{$loop->iteration}}</span>
                                                <p>Score : {{$mdpItem->performance_score}}/100</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="panel panel-brown panel-colorful">
                                    <div class="pad-all">
                                        <div class="media">
                                            <div class="media-left" style="width: 30%;">
                                                <img class="img-md img-circle img-responsive"
                                                    src="{{asset('img/profile-photos/'.$mdpItem->profile_photo)}}"
                                                    alt="Profile Picture">
                                            </div>
                                            <div class="media-body pad-top">
                                                <span class="text-lg text-semibold">{{$mdpItem->name}} #{{$loop->iteration}}</span>
                                                <p>Score : {{$mdpItem->performance_score}}/100</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mh-box panel panel-bordered panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Top Scored Achievement
                    @if (count($monthDecideAchievement)!=0)
                        <span>({{switch_month($monthDecideAchievement[0]->month) . ' - ' .$monthDecideAchievement[0]->year}})</span>
                        <span data-toggle="modal" data-target="#modal-detail-top-scored" style="cursor: pointer"
                            data-achievement="{{$monthDecideAchievement}}" id="modal-achievement">
                            <i class="ti-cup add-tooltip" data-original-title="Detailed Top Scored Achievement"></i>
                        </span>
                    @endif
                    <sup><i class="fa fa-info" title="Score Achievement Adalah Score Yang Diberikan Langsung Oleh HRD"></i></sup>
                </h3>
            </div>
            <div class="panel-body" style=" padding-top: 20px; padding-bottom: 20px">
                @if ($monthDecideAchievement)
                    <div class="row">
                        <div class="col-sm-1 col-md-1"></div>
                        @foreach ($monthDecideAchievement->take(3) as $mdaItem)
                            @if ($loop->iteration == 1)
                                <div class="panel panel-warning panel-colorful">
                                    <div class="pad-all">
                                        <div class="media">
                                            <div class="media-left" style="width: 30%;">
                                                <img class="img-md img-circle img-responsive"
                                                    src="{{asset('img/profile-photos/'.$mdaItem->profile_photo)}}"
                                                    alt="Profile Picture">
                                            </div>
                                            <div class="media-body pad-top">
                                                <span class="text-lg text-semibold">{{$mdaItem->name}} #{{$loop->iteration}}</span>
                                                <p>Score : {{$mdaItem->score}}/100</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($loop->iteration == 2)
                                <div class="panel panel-secondary panel-colorful">
                                    <div class="pad-all">
                                        <div class="media">
                                            <div class="media-left" style="width: 30%;">
                                                <img class="img-md img-circle img-responsive"
                                                    src="{{asset('img/profile-photos/'.$mdaItem->profile_photo)}}"
                                                    alt="Profile Picture">
                                            </div>
                                            <div class="media-body pad-top">
                                                <span class="text-lg text-semibold">{{$mdaItem->name}} #{{$loop->iteration}}</span>
                                                <p>Score : {{$mdaItem->score}}/100</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="panel panel-brown panel-colorful">
                                    <div class="pad-all">
                                        <div class="media">
                                            <div class="media-left" style="width: 30%;">
                                                <img class="img-md img-circle img-responsive"
                                                    src="{{asset('img/profile-photos/'.$mdaItem->profile_photo)}}"
                                                    alt="Profile Picture">
                                            </div>
                                            <div class="media-body pad-top">
                                                <span class="text-lg text-semibold">{{$mdaItem->name}} #{{$loop->iteration}}</span>
                                                <p>Score : {{$mdaItem->score}}/100</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div id="mh-target" class="panel" style="background: transparent !important">
            {{-- <div class="panel-body"> --}}
                <div class="panel panel-success panel-colorful">    
                    <div class="pad-all">
                        <div class="media">
                            <div class="media-left" style="width: 20%; min-width: 115px">
                                @if ($eom)
                                    <img class="img-lg img-circle img-responsive"
                                        src="{{asset('img/profile-photos/'.$eom->photo)}}"
                                        alt="Profile Picture">
                                @else
                                    <img class="img-lg img-circle img-responsive"
                                        src="{{asset('img/'.$company_logo)}}"
                                        alt="Profile Picture">
                                @endif
                            </div>
                            <div class="media-body" style="padding-top: 7px">
                                <h3 class="h5" style="color: #fff">{{'Staff Of The Month'.($eom ? ' Periode '.switch_month($eom->month).' - '.$eom->year : '')}}</h3>
                                @if ($eom)
                                    <span class="text-lg text-semibold">{{$eom->name}}</span>
                                    <p>Division : {{$eom->division}}</p>
                                @else
                                    <span class="text-lg text-semibold">Data Belum Tersedia</span>
                                    <p>PT. Cerebrum Edukanesia Nusantara</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-info panel-colorful">    
                    <div class="pad-all">
                        <div class="media">
                            <div class="media-left" style="width: 20%; min-width: 115px">
                                @if ($staff_min_late)
                                    <img class="img-lg img-circle img-responsive"
                                    src="{{asset('img/profile-photos/'.$staff_min_late->photo)}}"
                                    alt="Profile Picture">
                                @else
                                    <img class="img-lg img-circle img-responsive"
                                    src="{{asset('img/'.$company_logo)}}"
                                    alt="Profile Picture">
                                @endif
                            </div>
                            <div class="media-body" style="padding-top: 7px">
                                <h3 class="h5" style="color: #fff">{{'Staff Jarang Telat'.($staff_min_late ? ' Periode '.switch_month($staff_min_late->month).' - '.$staff_min_late->year : '')}}</h3>
                                @if ($staff_min_late)
                                    <span class="text-lg text-semibold">{{$staff_min_late->name}}</span>
                                    <p>Division : {{$staff_min_late->division}}</p>
                                @else
                                    <span class="text-lg text-semibold">Data Belum Tersedia</span>
                                    <p>PT. Cerebrum Edukanesia Nusantara</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="panel panel-danger panel-colorful">    
                    <div class="pad-all">
                        <div class="media">
                            <div class="media-left" style="width: 20%; min-width: 115px">
                                @if ($staff_late)
                                    <img class="img-lg img-circle img-responsive"
                                    src="{{asset('img/profile-photos/'.$staff_late->photo)}}"
                                    alt="Profile Picture">
                                @else
                                    <img class="img-lg img-circle img-responsive"
                                    src="{{asset('img/'.$company_logo)}}"
                                    alt="Profile Picture">
                                @endif
                            </div>
                            <div class="media-body" style="padding-top: 7px">
                                <h3 class="h5" style="color: #fff">{{'Staff Paling Telat'.($staff_late ? ' Periode '.switch_month($staff_late->month).' - '.$staff_late->year : '')}}</h3>
                                @if ($staff_late)
                                    <span class="text-lg text-semibold">{{$staff_late->name}}</span>
                                    <p>Division : {{$staff_late->division}}</p>
                                @else
                                    <span class="text-lg text-semibold">Data Belum Tersedia</span>
                                    <p>PT. Cerebrum Edukanesia Nusantara</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
        </div>
    </div>
</div>

@section('script')
<script src="{{asset("plugins/fullcalendar/lib/moment.min.js")}}"></script>
<script src="{{asset("plugins/fullcalendar/lib/jquery-ui.custom.min.js")}}"></script>
<script src="{{asset("plugins/fullcalendar/fullcalendar.min.js")}}"></script>
<script src="{{asset("plugins/fullcalendar/lang/id.js")}}"></script>
<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
<script src="{{asset('plugins/jquery-match-height/jquery-match-height.min.js')}}"></script>
<script>
    setTimeout(function () {
        $('#current_agenda').fullCalendar({
            height: 525,
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
                <?php foreach ($data_agenda as $item) { 
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
    },1000);
    $(document).on('nifty.ready', function () {
        $('.mh-byrow').each(function() {
            $(this).find('.panel').matchHeight({
                byRow: true
            });
        });
        $('.mh-box').matchHeight({
            target: $('#mh-target')
        });
            
    });

    function showChangePerformanceYear() {
        $('#year-finder-performance').on('change', function (e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            document.getElementById("textvalperf").innerText = valueSelected;
        });
    }

    function showChangeAchievementYear() {
        $('#year-finder-achievement').on('change', function (e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            document.getElementById("textvalach").innerText = valueSelected;
        });
    }

    var dataPerformance = {!!json_encode($scorePerformance)!!}
        
    var pageviewsPerformance = [
        [1, dataPerformance[0] ? dataPerformance[0] : 0],
        [2, dataPerformance[1] ? dataPerformance[1] : 0],
        [3, dataPerformance[2] ? dataPerformance[2] : 0],
        [4, dataPerformance[3] ? dataPerformance[3] : 0],
        [5, dataPerformance[4] ? dataPerformance[4] : 0],
        [6, dataPerformance[5] ? dataPerformance[5] : 0],
        [7, dataPerformance[6] ? dataPerformance[6] : 0],
        [8, dataPerformance[7] ? dataPerformance[7] : 0],
        [9, dataPerformance[8] ? dataPerformance[8] : 0],
        [10, dataPerformance[9] ? dataPerformance[9] : 0],
        [11, dataPerformance[10] ? dataPerformance[10] : 0],
        [12, dataPerformance[11] ? dataPerformance[11] : 0]
    ];

    var dataAchievement = {!!json_encode($scoreAchievement)!!}
        
    var pageviewsAchievement = [
        [1, dataAchievement[0] ? dataAchievement[0] : 0],
        [2, dataAchievement[1] ? dataAchievement[1] : 0],
        [3, dataAchievement[2] ? dataAchievement[2] : 0],
        [4, dataAchievement[3] ? dataAchievement[3] : 0],
        [5, dataAchievement[4] ? dataAchievement[4] : 0],
        [6, dataAchievement[5] ? dataAchievement[5] : 0],
        [7, dataAchievement[6] ? dataAchievement[6] : 0],
        [8, dataAchievement[7] ? dataAchievement[7] : 0],
        [9, dataAchievement[8] ? dataAchievement[8] : 0],
        [10, dataAchievement[9] ? dataAchievement[9] : 0],
        [11, dataAchievement[10] ? dataAchievement[10] : 0],
        [12, dataAchievement[11] ? dataAchievement[11] : 0]
    ];

    $(document).ready(function () {
        $.plot('#staff-charts-performance', [{
                data: pageviewsPerformance,
                lines: {
                    show: true,
                    lineWidth: 0,
                    fill: true,
                    fillColor: {
                        colors: ["#05032D", "#27257C", {
                            opacity: 0.7
                        }, {
                            opacity: 2
                        }]
                    }
                },
                points: {
                    show: true,
                    radius: 2,
                    fillColor: '#ffffffff'
                    // symbol : "square"
                },
            },


        ], {
            series: {
                lines: {
                    show: false
                },
                points: {
                    show: true,
                    fillColor: '#f5bc00'
                    // symbol:"square"
                },
                shadowSize: 0 // Drawing is faster without shadows
            },
            colors: ['#05032D'],

            grid: {
                borderWidth: 0,
                hoverable: true,
                clickable: true
            },
            yaxis: {
                ticks: 9,
                min: 0,
                max: 100,
                tickColor: 'rgba(0,0,0,.1)',
                // tickDecimals: 1,
            },
            xaxis: {

                ticks: [
                    [1, 'Jan'],
                    [2, 'Feb'],
                    [3, 'Mar'],
                    [4, 'Apr'],
                    [5, 'Mei'],
                    [6, 'Jun'],
                    [7, 'Jul'],
                    [8, 'Agu'],
                    [9, 'Sep'],
                    [10, 'Okt'],
                    [11, 'Nov'],
                    [12, 'Des']
                ],
                tickColor: 'transparent',
                tickSize: 14,
            },
            tooltip: {
                show: true,
                content: 'Bulan: %x, Score: %y.1'
            }
        });

        $.plot('#staff-charts-achievement', [{
                data: pageviewsAchievement,
                lines: {
                    show: true,
                    lineWidth: 0,
                    fill: true,
                    fillColor: {
                        colors: ["#05032D", "#27257C", {
                            opacity: 0.7
                        }, {
                            opacity: 2
                        }]
                    }
                },
                points: {
                    show: true,
                    radius: 2,
                    fillColor: '#ffffffff'
                    // symbol : "square"
                },
            },


        ], {
            series: {
                lines: {
                    show: false
                },
                points: {
                    show: true,
                    fillColor: '#f5bc00'
                    // symbol:"square"
                },
                shadowSize: 0 // Drawing is faster without shadows
            },
            colors: ['#05032D'],

            grid: {
                borderWidth: 0,
                hoverable: true,
                clickable: true
            },
            yaxis: {
                ticks: 9,
                min: 0,
                max: 100,
                tickColor: 'rgba(0,0,0,.1)',
                // tickDecimals: 1,
            },
            xaxis: {

                ticks: [
                    [1, 'Jan'],
                    [2, 'Feb'],
                    [3, 'Mar'],
                    [4, 'Apr'],
                    [5, 'Mei'],
                    [6, 'Jun'],
                    [7, 'Jul'],
                    [8, 'Agu'],
                    [9, 'Sep'],
                    [10, 'Okt'],
                    [11, 'Nov'],
                    [12, 'Des']
                ],
                tickColor: 'transparent',
                tickSize: 14,
            },
            tooltip: {
                show: true,
                content: 'Bulan: %x, Score: %y.1'
            }
        });

        $('#modal-performance').on('click', function () {
            var performance = $(this).data('performance')
            for (let i = 0; i < performance.length; i++) {
                var p_rank = {};
                var p_name = {};
                var p_score = {};

                p_rank['p_rank_' + i] = i + 1;
                p_name['p_name_' + i] = performance[i].name;
                p_score['p_score_' + i] = performance[i].performance_score;

                $('#p_rank_' + i).text(p_rank['p_rank_' + i]);
                $('#p_name_' + i).text(p_name['p_name_' + i]);
                $('#p_score_' + i).text(p_score['p_score_' + i]);
                $('#type-modal').text('Performance');
                $('#table-performance').removeClass('hidden')
                $('#table-achievement').addClass('hidden')
            }
        });

        $('#modal-achievement').on('click', function () {
            var achievement = $(this).data('achievement')
            for (let i = 0; i < achievement.length; i++) {
                var a_rank = {};
                var a_name = {};
                var a_score = {};

                a_rank['a_rank_' + i] = i + 1;
                a_name['a_name_' + i] = achievement[i].name;
                a_score['a_score_' + i] = achievement[i].score;

                $('#a_rank_' + i).text(a_rank['a_rank_' + i]);
                $('#a_name_' + i).text(a_name['a_name_' + i]);
                $('#a_score_' + i).text(a_score['a_score_' + i]);
                $('#type-modal').text('Achievement');
                $('#table-performance').addClass('hidden')
                $('#table-achievement').removeClass('hidden')
                
            }
        });

    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#year-finder-performance').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        var url_ = "{{route('ajxperf')}}";
        // console.log(valueSelected);
        $.ajax({
            type: "GET",
            data: {
                year: valueSelected
            },
            url: url_,
            dataType: 'json',
            success: function (response) {

                console.log(response)
                var pageviews = [
                    [1, response.performance_score[0] ? response.performance_score[0] : 0],
                    [2, response.performance_score[1] ? response.performance_score[1] : 0],
                    [3, response.performance_score[2] ? response.performance_score[2] : 0],
                    [4, response.performance_score[3] ? response.performance_score[3] : 0],
                    [5, response.performance_score[4] ? response.performance_score[4] : 0],
                    [6, response.performance_score[5] ? response.performance_score[5] : 0],
                    [7, response.performance_score[6] ? response.performance_score[6] : 0],
                    [8, response.performance_score[7] ? response.performance_score[7] : 0],
                    [9, response.performance_score[8] ? response.performance_score[8] : 0],
                    [10, response.performance_score[9] ? response.performance_score[9] : 0],
                    [11, response.performance_score[10] ? response.performance_score[10] : 0],
                    [12, response.performance_score[11] ? response.performance_score[11] : 0]
                ];

                document.getElementById('total_score_performance').innerHTML = "Total Score : " +response.all_score

                $(document).ready(function () {
                    $.plot('#staff-charts-performance', [{
                            data: pageviews,
                            lines: {
                                show: true,
                                lineWidth: 0,
                                fill: true,
                                fillColor: {
                                    colors: ["#05032D", "#27257C", {
                                        opacity: 0.7
                                    }, {
                                        opacity: 2
                                    }]
                                }
                            },
                            points: {
                                show: true,
                                radius: 2,
                                fillColor: '#ffffffff'
                                // symbol : "square"
                            },
                        },


                    ], {
                        series: {
                            lines: {
                                show: false
                            },
                            points: {
                                show: true,
                                fillColor: '#f5bc00'
                                // symbol:"square"
                            },
                            shadowSize: 0 // Drawing is faster without shadows
                        },
                        colors: ['#05032D'],

                        grid: {
                            borderWidth: 0,
                            hoverable: true,
                            clickable: true
                        },
                        yaxis: {
                            ticks: 9,
                            min: 0,
                            max: 100,
                            tickColor: 'rgba(0,0,0,.1)',
                            // tickDecimals: 1,
                        },
                        xaxis: {

                            ticks: [
                                [1, 'Jan'],
                                [2, 'Feb'],
                                [3, 'Mar'],
                                [4, 'Apr'],
                                [5, 'Mei'],
                                [6, 'Jun'],
                                [7, 'Jul'],
                                [8, 'Agu'],
                                [9, 'Sep'],
                                [10, 'Okt'],
                                [11, 'Nov'],
                                [12, 'Des']
                            ],
                            tickColor: 'transparent',
                            tickSize: 14,
                        },
                        tooltip: {
                            show: true,
                            content: 'Bulan: %x, Score: %y.1'
                        }
                    });
                });

            },
            error: function (jXHR, textStatus, errorThrown) {
                console.log(jXHR, textStatus, errorThrown)
            }
        })
    })


    $('#year-finder-achievement').on('change', function (e) {
        var optionSelectedach = $("option:selected", this);
        var valueSelectedach = this.value;
        // console.log(valueSelectedach)
        var url_ = "{{route('ajxach')}}";
        $.ajax({
            type: "GET",
            data: {
                yearach: valueSelectedach
            },
            url: url_,
            dataType: 'json',
            success: function (response) {


                var pageviews = [
                    [1, response.scoreAch[0] ? response.scoreAch[0] : 0],
                    [2, response.scoreAch[1] ? response.scoreAch[1] : 0],
                    [3, response.scoreAch[2] ? response.scoreAch[2] : 0],
                    [4, response.scoreAch[3] ? response.scoreAch[3] : 0],
                    [5, response.scoreAch[4] ? response.scoreAch[4] : 0],
                    [6, response.scoreAch[5] ? response.scoreAch[5] : 0],
                    [7, response.scoreAch[6] ? response.scoreAch[6] : 0],
                    [8, response.scoreAch[7] ? response.scoreAch[7] : 0],
                    [9, response.scoreAch[8] ? response.scoreAch[8] : 0],
                    [10, response.scoreAch[9] ? response.scoreAch[9] : 0],
                    [11, response.scoreAch[10] ? response.scoreAch[10] : 0],
                    [12, response.scoreAch[11] ? response.scoreAch[11] : 0]
                ];

                document.getElementById('total_score_achievement').innerHTML = "Total Score : " +
                    response.all_score

                $(document).ready(function () {
                    $.plot('#staff-charts-achievement', [{
                            data: pageviews,
                            lines: {
                                show: true,
                                lineWidth: 0,
                                fill: true,
                                fillColor: {
                                    colors: ["#05032D", "#27257C", {
                                        opacity: 0.7
                                    }, {
                                        opacity: 2
                                    }]
                                }
                            },
                            points: {
                                show: true,
                                radius: 2,
                                fillColor: '#ffffffff'
                                // symbol : "square"
                            },
                        },


                    ], {
                        series: {
                            lines: {
                                show: false
                            },
                            points: {
                                show: true,
                                fillColor: '#f5bc00'
                                // symbol:"square"
                            },
                            shadowSize: 0 // Drawing is faster without shadows
                        },
                        colors: ['#05032D'],

                        grid: {
                            borderWidth: 0,
                            hoverable: true,
                            clickable: true
                        },
                        yaxis: {
                            ticks: 9,
                            min: 0,
                            max: 100,
                            tickColor: 'rgba(0,0,0,.1)',
                            // tickDecimals: 1,
                        },
                        xaxis: {

                            ticks: [
                                [1, 'Jan'],
                                [2, 'Feb'],
                                [3, 'Mar'],
                                [4, 'Apr'],
                                [5, 'Mei'],
                                [6, 'Jun'],
                                [7, 'Jul'],
                                [8, 'Agu'],
                                [9, 'Sep'],
                                [10, 'Okt'],
                                [11, 'Nov'],
                                [12, 'Des']
                            ],
                            tickColor: 'transparent',
                            tickSize: 14,
                        },
                        tooltip: {
                            show: true,
                            content: 'Bulan: %x, Score: %y.1'
                        }
                    });
                });

            },
            error: function (jXHR, textStatus, errorThrown) {
                console.log(errorThrown)
            }
        })
    })

</script>
@endsection

@include('dashboard/modalTopScored')
@endsection
