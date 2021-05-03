@extends('layouts/templateStaff')
@section('title', 'Dashboard Staff')
@section('content-title', 'Selamat Datang Di Aplikasi HRIS')
@section('content-subtitle', '(Human Resource Information System)')
@section('head')
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
<link href="{{asset("css/slider/slide.css")}}" rel="stylesheet">
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

    #first .pos-rel {
        background-color: #fedb37;
        /* height: 250px; */
    }

    #second .pos-rel {
        background-color: #e6e8e9
    }

    #third .pos-rel p {
        color: white
    }

    #third .pos-rel {

        background-color: #b1560f;
    }

    @keyframes shine {
        10% {
            opacity: 1;
            top: -0%;
            left: -25%;
            transition-property: left, top, opacity;
            transition-duration: 0.7s, 0.7s, 0.15s;
            transition-timing-function: linear;
        }

        100% {
            opacity: 0;
            top: -0%;
            left: -10%;
            transition-property: left, top, opacity;
        }
    }

    #second .pos-rel:after {
        content: "";
        position: absolute;
        top: 0%;
        left: -210%;
        width: 200%;
        height: 100%;
        opacity: 0;


        animation: shine 2s linear infinite;
        animation-fill-mode: forwards;
        background: rgba(255, 255, 255, 0.13);
        background: linear-gradient(to right,
                rgba(255, 255, 255, 0.13) 0%,
                rgba(255, 255, 255, 0.13) 77%,
                rgba(255, 255, 255, 0.5) 95%,
                rgba(255, 255, 255, 0.0) 100%);
    }

    #second .pos-rel:active:after {
        opacity: 0;
    }

    #first .pos-rel:after {
        content: "";
        position: absolute;
        top: 0%;
        left: -210%;
        width: 188%;
        height: 100%;
        opacity: 0;
        animation: shine 2s linear infinite;
        animation-fill-mode: forwards;
        background: rgba(255, 255, 255, 0.13);
        background: linear-gradient(to right,
                rgba(255, 255, 255, 0.13) 0%,
                rgba(255, 255, 255, 0.13) 77%,
                rgba(255, 255, 255, 0.5) 92%,
                rgba(255, 255, 255, 0.0) 100%);
    }

    #first .pos-rel:active:after {
        opacity: 0;
    }

    #third .pos-rel:after {
        content: "";
        position: absolute;
        top: 0%;
        left: -210%;
        width: 188%;
        height: 100%;
        opacity: 0;
        animation: shine 2s linear infinite;
        animation-fill-mode: forwards;
        background: rgba(255, 255, 255, 0.13);
        background: linear-gradient(to right,
                rgba(255, 255, 255, 0.13) 0%,
                rgba(255, 255, 255, 0.13) 77%,
                rgba(255, 255, 255, 0.5) 92%,
                rgba(255, 255, 255, 0.0) 100%);
    }

    #third .pos-rel:active:after {
        opacity: 0;
    }

    #first .ribbon span {
        background: #fedb37;
        color: black;
    }

    #first .ribbon span::before {
        content: "";
        position: absolute;
        left: 0px;
        top: 100%;
        z-index: -1;
        border-left: 2px solid #fedb37;
        border-right: 3px solid transparent;
        border-bottom: 3px solid transparent;
        border-top: 3px solid #fedb37;
    }

    #first .ribbon span::after {
        content: "";
        position: absolute;
        right: 0px;
        top: 100%;
        z-index: -1;
        border-left: 3px solid transparent;
        border-right: 3px solid #fedb37;
        border-bottom: 3px solid transparent;
        border-top: 3px solid #fedb37;
    }

    #second .ribbon span {
        background: #e6e8e9;
        color: black;
    }

    #second .ribbon span::before {
        content: "";
        position: absolute;
        left: 0px;
        top: 100%;
        z-index: -1;
        border-left: 2px solid #e6e8e9;
        border-right: 3px solid transparent;
        border-bottom: 3px solid transparent;
        border-top: 3px solid #e6e8e9;
    }

    #second .ribbon span::after {
        content: "";
        position: absolute;
        right: 0px;
        top: 100%;
        z-index: -1;
        border-left: 3px solid transparent;
        border-right: 3px solid #e6e8e9;
        border-bottom: 3px solid transparent;
        border-top: 3px solid #e6e8e9;
    }

    #third .ribbon span {
        background: #b1560f;
        color: black;
    }

    #third .ribbon span::before {
        content: "";
        position: absolute;
        left: 0px;
        top: 100%;
        z-index: -1;
        border-left: 2px solid #b1560f;
        border-right: 3px solid transparent;
        border-bottom: 3px solid transparent;
        border-top: 3px solid #b1560f;
    }

    #third .ribbon span::after {
        content: "";
        position: absolute;
        right: 0px;
        top: 100%;
        z-index: -1;
        border-left: 3px solid transparent;
        border-right: 3px solid #b1560f;
        border-bottom: 3px solid transparent;
        border-top: 3px solid #b1560f;
    }

    .fc-left,
    .fc-right {
        visibility: hidden;
    }

    #container .fc-event {
        cursor: pointer;
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

<div class="row mt-5">
    {{-- Charts Performa --}}
    <div class="col-md-6" id="grafikPerforma">
        <div class="panel panel-bordered panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Grafik Performa "{{$name}}"
                    
                    @if ($monthDecidePerformance->isEmpty())
                    @else
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
                        @else <option value="{{$item->year}}">{{$item->year}}</option>
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
                    @if ($monthDecideAchievement->isEmpty())
                    @else
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
        <div class="panel panel-bordered panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Top Scored Performance  
                    @if ($monthDecidePerformance->isEmpty())
                    @else
                    <span>({{switch_month($monthDecidePerformance[0]->month) . ' - ' .$monthDecidePerformance[0]->year}})</span>
                    @endif
                    <sup><i class="fa fa-info" title="Score Performa Adalah Score Yang Diberikan Langsung Oleh Chief Divisi"></i></sup>
                </h3>
            </div>
            <div class="panel-body" style="min-height: 403px">
                @if ($monthDecidePerformance->isEmpty())

                @else
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
        <div class="panel panel-bordered panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Top Scored Achievement
                    @if ($monthDecideAchievement->isEmpty())
                    @else
                    <span>({{switch_month($monthDecideAchievement[0]->month) . ' - ' .$monthDecideAchievement[0]->year}})</span>

                    @endif
                    <sup><i class="fa fa-info" title="Score Achievement Adalah Score Yang Diberikan Langsung Oleh HRD"></i></sup>
                </h3>
            </div>
            <div class="panel-body" style="min-height: 403px">
                @if ($monthDecideAchievement->isEmpty())

                @else
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
        @if ($eom)
            <div class="panel panel-success panel-colorful">    
                <div class="pad-all">
                    <div class="media">
                        <div class="media-left" style="width: 30%;">
                            <img class="img-lg img-circle img-responsive"
                            src="{{asset('img/profile-photos/'.$eom->photo)}}"
                            alt="Profile Picture">
                        </div>
                        <div class="media-body" style="padding-top: 7px">
                            <h3 class="h4" style="color: #fff">Staff Of The Month</h3>
                            <span class="text-lg text-semibold">{{$eom->name}}</span>
                            <p>Division : {{$eom->division}}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        @if ($staff_late)
            <div class="panel panel-danger panel-colorful">    
                <div class="pad-all">
                    <div class="media">
                        <div class="media-left" style="width: 30%;">
                            <img class="img-lg img-circle img-responsive"
                            src="{{asset('img/profile-photos/'.$staff_late->photo)}}"
                            alt="Profile Picture">
                        </div>
                        <div class="media-body" style="padding-top: 7px">
                            <h3 class="h4" style="color: #fff">Staff Paling Telat</h3>
                            <span class="text-lg text-semibold">{{$staff_late->name}}</span>
                            <p>Division : {{$staff_late->division}}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection

@section('script')
<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
<script>
    $(".flash-mess").fadeTo(2000, 500).slideUp(500, function () {
        $(".flash-mess").slideUp(500);
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
        
    // console.log(dataPerformance)
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
