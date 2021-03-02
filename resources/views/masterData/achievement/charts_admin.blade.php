@extends('layouts/templateAdmin')
<<<<<<< HEAD
@section('title','Sistem / Sistem Achievement')
@section('content-title','Achievement Charts')
=======
@section('title','Achievement')
@section('content-title','Penghargaan / Achievement Charts')
>>>>>>> 09125fd36d2d637ff5448dc176bca71e3b45cc7e
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
<style>
    #charts-achievement {
        width: 100%;
        height: 400px;
    }
</style>
@endsection
@section('content')
<<<<<<< HEAD
<div id="charts-achievement"></div>
@section('script')
    <script>
        
        $(document).ready(function(){
            for(var i =0; i< "{{$count}}"; i++){
                var score = "{{$data[" + i
                // var lengkp = "]}}";
                // var res = score.concat(lengkp)
            console.log(score)
            
                
            } 
            var pageviews = [[2,score],[3,90],[4,20]];
=======
{{-- {{dd(Auth::user())}} --}}
<div class="panel panel-bordered panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">{{'Grafik " Dummy Staff " tahun '.$data[0]->year}}</h3>
    </div>
    <div class="panel-body">
        <div id="charts-achievement">
        </div>
    </div>
</div>

@section('script')
    <script>
        
        var data = {!! json_encode($data) !!}
        // for(var i = 0; i< "{{$count}}"; i++){
        //     console.log(data[i]);
        //     var pageviews = [[i,data[i].score]];
        // }
        var pageviews = [
            [1, data[0] ?  data[0].score : 0],
            [2, data[1] ?  data[1].score : 0],
            [3, data[2] ?  data[2].score : 0],
            [4, data[3] ?  data[3].score : 0],
            [5, data[4] ?  data[4].score : 0],
            [6, data[5] ?  data[5].score : 0],
            [7, data[6] ?  data[6].score : 0],
            [8, data[7] ?  data[7].score : 0],
            [9, data[8] ?  data[8].score : 0],
            [10, data[9] ?  data[9].score : 0],
            [11, data[10] ?  data[10].score : 0],
            [12, data[11] ?  data[11].score : 0]
        ];
        // console.log(data[2] ? "yes" :"no")
        
        //  for(var i=0;i<"{{$count}}";i++){
             
        //  } 
        $(document).ready(function(){
          
             // var pageviews = [[2,$data->score],[3,90],[4,20]];
>>>>>>> 09125fd36d2d637ff5448dc176bca71e3b45cc7e
     $.plot('#charts-achievement', [
        {
            label: 'Charts Achievement',
            data: pageviews,
            lines: {
                show: true,
                lineWidth: 2,
                fill: false
            },
            points: {
                show: true,
<<<<<<< HEAD
                radius: 4
=======
                radius: 4,
                // symbol : "square"
>>>>>>> 09125fd36d2d637ff5448dc176bca71e3b45cc7e
            }
            },
        ], {
        series: {
            lines: {
                show: true
            },
            points: {
<<<<<<< HEAD
                show: true
=======
                show: true,
                // symbol:"square"
>>>>>>> 09125fd36d2d637ff5448dc176bca71e3b45cc7e
            },
            shadowSize: 0 // Drawing is faster without shadows
        },
        colors: ['#bf0404', '#177bbb'],
        legend: {
            show: true,
            position: 'nw',
            margin: [15, 0]
        },
        grid: {
            borderWidth: 0,
            hoverable: true,
            clickable: true
        },
        yaxis: {
            ticks: 9,
<<<<<<< HEAD
=======
            min : 0,
            max : 100,
>>>>>>> 09125fd36d2d637ff5448dc176bca71e3b45cc7e
            tickColor: 'rgba(0,0,0,.1)'
        },
        xaxis: {
            ticks: [[1,' January'], [2,'February'], [3,'Maret'], [4,'April'], [5,'Mei'], [6,'Juni'], [7,'July'], [8,'Agustus'], [9,'September'], [10,'Oktober'], [11,'November'], [12,'Desember']],
            tickColor: 'transparent'
        },
        tooltip: {
            show: true,
            content: 'x: %x, y: %y'
        }
    });
        });
    </script>
@endsection
@endsection
