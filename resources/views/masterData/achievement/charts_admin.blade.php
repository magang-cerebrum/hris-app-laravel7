@extends('layouts/templateAdmin')
@section('title','Sistem / Sistem Achievement')
@section('content-title','Achievement Charts')
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
                radius: 4
            }
            },
        ], {
        series: {
            lines: {
                show: true
            },
            points: {
                show: true
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
