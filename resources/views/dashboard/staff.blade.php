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

                 
        #first .pos-rel{
            background-color: #fedb37;
            /* height: 250px; */
        }
        #second .pos-rel{
          background-color: #e6e8e9  
        }
        
        #third .pos-rel p{
            color: white
        }
        #third .pos-rel{

        background-color: #b1560f;
        }
        
@keyframes shine{
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
  /* transform: rotate(30deg); */

animation: shine 2s linear  infinite;
animation-fill-mode: forwards;      
background: rgba(255, 255, 255, 0.13);
background: linear-gradient(
    to right, 
    rgba(255, 255, 255, 0.13) 0%,
    rgba(255, 255, 255, 0.13) 77%,
    rgba(255, 255, 255, 0.5) 95%,
    rgba(255, 255, 255, 0.0) 100%
  );
}



/* Active state */

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
    background: linear-gradient(
    to right, 
    rgba(255, 255, 255, 0.13) 0%,
    rgba(255, 255, 255, 0.13) 77%,
    rgba(255, 255, 255, 0.5) 92%,
    rgba(255, 255, 255, 0.0) 100%
  );
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
    background: linear-gradient(
    to right, 
    rgba(255, 255, 255, 0.13) 0%,
    rgba(255, 255, 255, 0.13) 77%,
    rgba(255, 255, 255, 0.5) 92%,
    rgba(255, 255, 255, 0.0) 100%
  );
}

#third .pos-rel:active:after {
  opacity: 0;
} 

#first .ribbon span {
    background: #fedb37;
    color: black;
}
#first .ribbon span::before{
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

#first .ribbon span::after{
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
#second .ribbon span::before{
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

#second .ribbon span::after{
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
#third .ribbon span::before{
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

#third .ribbon span::after{
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
</style>
@endsection
@section('content')


    <div class="row mt-10">
        <div class="col-md-12">
            @if (session('status'))
                <div class="flash-mess alert-success alert alert-dismissable">
                    {{session('status')}}
                    <button class="close" data-dismiss="alert">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            @endif
            <div class="panel panel-bordered panel-primary">
                <div class="panel-heading">
                    {{-- <i class="fa"></i> --}}
                        
                        <h3 class="panel-title">Grafik "{{$name}}" Tahun  
                            
                        <span id="textval">{{$current_year}}</span> @if ($sum_of_eom == 0)
                        <i></i>
                    @else <i class="fa fa-trophy" id="eom_i_test" style="color:gold" title="Anda mendapatkan Employee of the month pada tahun ini"></i>
                    @endif
                </h3>
            </div>
            <div class="panel-body" id="charts">
                <div id="years">
                    <select name="select" id="year-finder" class="selectpicker" data-style="btn-primary"
                        onchange="showChange()">
                        @foreach ($year_list as $item)
                        @if ($item->year == $current_year)
                        <option value="{{$item->year}}" selected>{{$item->year}}</option>
                        @else <option value="{{$item->year}}">{{$item->year}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div id="staff-charts"></div>
                <br>
                <div id="eom_message">
                    <p id="text_eom_0" class="text-danger"></p>
                    @if ($sum_of_eom == 0)
                    <p class="text-danger">Anda Belum mendapatkan Employee of the Month pada Tahun ini</p>
                    <p id="total_score" class="text-info">Total Score : {{$all_score}}</p>
                    @else
                    <p id="total_score" class="text-info">Total Score : {{$all_score}}</p>
                    <p id="text_eom" class="text-success">Jumlah Employee of the month yang anda dapatkan adalah
                        {{$sum_of_eom}} yaitu bulan
                        @foreach ($month_of_eom as $item)
                        @if ($loop->last)
                        {{$item}}
                        @else {{$item}},&nbsp;
                        @endif
                        @endforeach
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if ($last_month->isEmpty() && $current_month->isEmpty())

@else
<div class="row mt-10">
    <div class="col-md-12">
        @if ($count_current_month_ach == 0)
        <div class="panel panel-bordered panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Top Scored Employee ({{$last_month_name}} {{$rankLM}})</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-1 col-md-1"></div>
                    <div class="col-sm-4 col-md-3">
                        <div id="second">
                            <div class="panel pos-rel">
                                <div class="ribbon"><span>#2</span></div>
                                <div class="pad-all text-center">
                                    <img alt="Profile Picture" class="img-lg img-circle mar-ver"
                                        src="{{asset('img/profile-photos/'.$last_month[1]->profile_photo)}}">
                                    <p class="text-lg text-semibold mar-no text-main">{{$last_month[1]->name}}</p>
                                    <p class="text-sm">{{$last_month[1]->division_name}}</p>
                                    <p class="text-sm">Score : {{$last_month[1]->score}}</p>
                                </div>
                            </div>
                        </div>
                        <!---------------------------------->
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div id="first">
                            <div class="panel pos-rel">
                                <div class="ribbon"><span>#1</span></div>
                                <div class="pad-all text-center">
                                    <img alt="Profile Picture" class="img-lg img-circle mar-ver"
                                        src="{{asset('img/profile-photos/'.$last_month[0]->profile_photo)}}">
                                    <p class="text-lg text-semibold mar-no text-main">{{$last_month[0]->name}}</p>
                                    <p class="text-sm">{{$last_month[0]->division_name}}</p>
                                    <p class="text-sm">Score : {{$last_month[0]->score}}</p>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <div id="third">
                            <div class="panel pos-rel">
                                <div class="ribbon"><span>#3</span></div>
                                <div class="pad-all text-center">
                                    <img alt="Profile Picture" class="img-lg img-circle mar-ver"
                                        src="{{asset('img/profile-photos/'.$last_month[2]->profile_photo)}}">
                                    <p class="text-lg text-semibold mar-no text-main">{{$last_month[2]->name}}</p>
                                    <p class="text-sm">{{$last_month[2]->division_name}}</p>
                                    <p class="text-sm">Score : {{$last_month[2]->score}}</p>
                                </div>
                            </div>
                        </div>
                        <!---------------------------------->
                    </div>
                    <div class="col-sm-1 col-md-1"></div>
                </div>
                <div class="pos row" id="pot">
                    @if ($rankLM == 1 || $rankLM == 2 || $rankLM ==3)
                    <p></p>
                    @else
                    @foreach ($user_lm as $item)
                    <div class="col-sm-2 col-md-2"></div>
                    <div class="col-sm-8 col-md-8">
                        <div class="panel panel-primary panel-colorful ">
                            <div class="pad-all">
                                <div class="media">
                                    <div class="media-left">
                                        <img alt="Profile Picture" class="img-md img-circle"
                                            src="{{asset('img/profile-photos/'.$item->profile_photo)}}">
                                    </div>
                                    <div class="media-body pad-top">
                                        <span class="text-lg text-semibold">{{$item->name}}</span> <span
                                            class="text-lg text-right">#{{$rankLM}}</span>
                                        <p class="text-sm">Score : {{$item->score}}/100</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2"></div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        @else
        <div class="panel panel-bordered panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Top Scored Employee ({{$current_month_name}})</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-1 col-md-1"></div>
                    <div class="col-sm-4 col-md-3">
                        <div id="second">
                            <div class="panel pos-rel">
                                <div class="ribbon"><span title="Top 2">#2</span></div>
                                <div class="pad-all text-center">
                                    <img alt="Profile Picture" class="img-lg img-circle mar-ver"
                                        src="{{asset('img/profile-photos/'.$current_month[1]->profile_photo)}}">
                                    <p class="text-lg text-semibold mar-no text-main">{{$current_month[1]->name}}</p>
                                    <p class="text-sm">{{$current_month[1]->division_name}}</p>
                                    <p class="text-sm">Score : {{$current_month[1]->score}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div id="first">
                            <div class="panel pos-rel">
                                <div class="ribbon"><span title="Top 1">#1</span></div>
                                <div class="pad-all text-center">
                                    <img alt="Profile Picture" class="img-lg img-circle mar-ver"
                                        src="{{asset('img/profile-photos/'.$current_month[0]->profile_photo)}}">
                                    <p class="text-lg text-semibold mar-no text-main">{{$current_month[0]->name}}</p>
                                    <p class="text-sm">{{$current_month[0]->division_name}}</p>
                                    <p class="text-sm">Score : {{$current_month[0]->score}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <div id="third">
                            <div class="panel pos-rel">
                                <div class="ribbon"><span title="Top 3">#3</span></div>
                                <div class="pad-all text-center">
                                    <img alt="Profile Picture" class="img-lg img-circle mar-ver"
                                        src="{{asset('img/profile-photos/'.$current_month[2]->profile_photo)}}">
                                    <p class="text-lg text-semibold mar-no text-main">{{$current_month[2]->name}}</p>
                                    <p class="text-sm">{{$current_month[2]->division_name}}</p>
                                    <p class="text-sm">Score : {{$current_month[2]->score}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1 col-md-1"></div>
                </div>
                <div class="pos" id="pot">
                    @if ($rankCM == 1 || $rankCM == 2 || $rankCM ==3)
                    <p></p>
                    @else
                    <div class="panel panel-success panel-colorful">
                        <div class="pad-all">
                            <div class="media">
                                <div class="media-left" style="width: 8%">
                                    <img class="img-md img-circle img-responsive" src="{{asset('img/profile-photos/'.Auth::user()->profile_photo)}}" alt="Profile Picture">
                                </div>
                                <div class="media-body pad-top">
                                    <span class="text-lg text-semibold">{{Auth::user()->name}} #{{$rankCM}}</span> 
                                    @foreach ($user_cm as $item)
                                    <p>Score : {{$item->score}}/100</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endif
@endsection
@section('script')
<script src="{{asset("plugins/bootstrap-select/bootstrap-select.min.js")}}"></script>
<script>
    $(".flash-mess").fadeTo(2000, 500).slideUp(500, function(){
    $(".flash-mess").slideUp(500);
});

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

            ticks: [[1,' Januari'], [2,'Februari'], [3,'Maret'], [4,'April'], [5,'Mei'], [6,'Juni'], [7,'Juli'], [8,'Agustus'], [9,'September'], [10,'Oktober'], [11,'November'], [12,'Desember']],
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
                type:"GET",
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
                if(response.sum_of_eom == 0){
                    document.getElementById('text_eom_0').innerHTML = "Anda Belum mendapatkan Employee of the Month pada Tahun ini";
                    document.getElementById('text_eom').innerHTML = " ";
                    document.getElementById('eom_i_test').className = " "
                }
                else {
                    document.getElementById('text_eom_0').innerHTML =" "
                    document.getElementById('eom_i_test').className = "fa fa-trophy"
                    document.getElementById('total_score').innerHTML = "Total Score : "+response.all_score; 
                    document.getElementById('text_eom').innerHTML = "Jumlah Employee of the month yang anda dapatkan adalah " +response.sum_of_eom+ " yaitu bulan " + response.month_of_eom;
                }
                console.log(response);
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