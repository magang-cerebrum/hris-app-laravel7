@extends('layouts/templateStaff')
@section('title', 'Dashboard Staff')
@section('content-title', 'Selamat Datang Di Aplikasi HRIS')
@section('content-subtitle', '(Human Resource Information System)')
@section('head')
<link href="{{asset("plugins/bootstrap-select/bootstrap-select.min.css")}}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    #staff-charts {
        width: 100%;
        height: 400px;
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
</style>
@endsection
@section('content')

    <div class="row mt-10">
        <div class="col-md-4">
            <div class="panel panel-warning panel-colorful media middle pad-all">
                <div class="media-left">
                    <div class="pad-hor">
                        <i class="demo-pli-checked-user icon-3x"></i>
                    </div>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">241</p>
                    <p class="mar-no">Staff Akhtif</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info panel-colorful media middle pad-all">
                <div class="media-left">
                    <div class="pad-hor">
                        <i class="demo-pli-remove-user icon-3x"></i>
                    </div>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">241</p>
                    <p class="mar-no">Staff Non-Aktif</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-mint panel-colorful media middle pad-all">
                <div class="media-left">
                    <div class="pad-hor">
                        <i class="demo-pli-clock icon-3x"></i>
                    </div>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">241</p>
                    <p class="mar-no">Staff Hadir</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-10" style="padding: 0 10px">
        <div class="col-md-11">
            <div class="panel panel-bordered panel-primary">
                <div class="panel-heading">
                    {{-- <i class="fa"></i> --}}
                    <h3 class="panel-title">Grafik "{{$name}}" Tahun 
                        <span id="textval">{{$current_year}}</span>
                    </h3>
                </div>
                    <div class="panel-body" id="charts">
                        <div id="years">
                        <select name="select" id="year-finder" class="selectpicker" data-style="btn-primary" onchange="showChange()">
                            @foreach ($year_list as $item)
                                @if ($item->year == $current_year)
                                <option value="{{$item->year}}" selected>{{$item->year}}</option> 
                                @else <option value="{{$item->year}}">{{$item->year}}</option>
                                @endif
                            @endforeach
                        </select>
                        <i class="fa fa-trophy"></i>
                        </div>
                        <div id="staff-charts"></div>
                    </div>
            </div>
            {{-- <div class="table-responsive">
                <table id="masterdata-division"
                class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting text-center" tabindex="0">No</th>
                            <th class="sorting text-center" tabindex="0">Nama Staff</th>
                            <th class="sorting text-center" tabindex="0">Divisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataJob as $item)
                            <tr>
                                <td class="sorting text-center" tabindex="0">1</td>
                                <td class="text-center">Data Entry</td>
                                <td class="text-center">Dummy</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> --}}
        </div>
        <div class="col-md-1"></div>
        
    </div>
@section('script')
<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
<script>
    function showChange(){
        $('#year-finder').on('change',function(e){
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        document.getElementById("textval").innerText = valueSelected;
        });
    }

    var data = {!! json_encode($score) !!}
        var pageviews = [
            [1, data[0] ?  data[0] : 0],
            [2, data[1] ?  data[1] : 0],
            [3, data[2] ?  data[2] : 0],
            [4, data[3] ?  data[3] : 0],
            [5, data[4] ?  data[4] : 0],
            [6, data[5] ?  data[5] : 0],
            [7, data[6] ?  data[6] : 0],
            [8, data[7] ?  data[7] : 0],
            [9, data[8] ?  data[8] : 0],
            [10, data[9] ?  data[9] : 0],
            [11, data[10] ?  data[10] : 0],
            [12, data[11] ?  data[11] : 0]
        ];
        // console.log(pageviews)
        $(document).ready(function(){
            $.plot('#staff-charts', [
        {
            data: pageviews,
            lines: {
                show: true,
                lineWidth: 0,
                fill: true,
                fillColor: {
                    colors: ["#05032D", "#27257C",{
                        opacity: 0.7
                    }, {
                        opacity: 2
                    }]
                }
            },
            points: {
                show: true,
                radius: 2,
                fillColor : '#ffffffff'
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
                fillColor : '#f5bc00'
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
            min : 0,
            max : 100,
            tickColor: 'rgba(0,0,0,.1)'
        },
        xaxis: {

            ticks: [[1,' January'], [2,'February'], [3,'Maret'], [4,'April'], [5,'Mei'], [6,'Juni'], [7,'July'], [8,'Agustus'], [9,'September'], [10,'Oktober'], [11,'November'], [12,'Desember']],
            tickColor: 'transparent',
            tickSize : 14,
        },
        tooltip: {
            show: true,
            content: 'Bulan: %x, Score: %y'
        }
    });
        });
        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

        $('#year-finder').on('change',function(e){
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            var url_="{{route('ajx')}}";
            $.ajax({
                type:"PUT",
                data:{year:valueSelected},
                url:url_,
                dataType:'json',
                success:function(response){
                    var pageviews = [
                    [1, response.score[0] ?  response.score[0] : 0],
                    [2, response.score[1] ?  response.score[1] : 0],
                    [3, response.score[2] ?  response.score[2] : 0],
                    [4, response.score[3] ?  response.score[3] : 0],
                    [5, response.score[4] ?  response.score[4] : 0],
                    [6, response.score[5] ?  response.score[5] : 0],
                    [7, response.score[6] ?  response.score[6] : 0],
                    [8, response.score[7] ?  response.score[7] : 0],
                    [9, response.score[8] ?  response.score[8] : 0],
                    [10, response.score[9] ?  response.score[9] : 0],
                    [11, response.score[10] ?  response.score[10] : 0],
                    [12, response.score[11] ?  response.score[11] : 0]
                ];
                // console.log(response);
                $(document).ready(function(){
            $.plot('#staff-charts', [
        {
            data: pageviews,
            lines: {
                show: true,
                lineWidth: 0,
                fill: true,
                fillColor: {
                    colors: ["#05032D", "#27257C",{
                        opacity: 0.7
                    }, {
                        opacity: 2
                    }]
                }
            },
            points: {
                show: true,
                radius: 2,
                fillColor : '#ffffffff'
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
                fillColor : '#f5bc00'
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
            min : 0,
            max : 100,
            tickColor: 'rgba(0,0,0,.1)'
        },
        xaxis: {

            ticks: [[1,' January'], [2,'February'], [3,'Maret'], [4,'April'], [5,'Mei'], [6,'Juni'], [7,'July'], [8,'Agustus'], [9,'September'], [10,'Oktober'], [11,'November'], [12,'Desember']],
            tickColor: 'transparent',
            tickSize : 14,
        },
        tooltip: {
            show: true,
            content: 'Bulan: %x, Score: %y'
        }
    });
        });
                    // console.log(pageviews)
                    // console.log(response.data)
                    // console.log(response.year)
                    
                },
                error : function(jXHR, textStatus, errorThrown){
                    console.log(errorThrown)
                }
            })
        })
</script>
@endsection
@endsection