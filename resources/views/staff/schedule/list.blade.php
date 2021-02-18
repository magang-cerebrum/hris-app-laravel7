@extends('layouts/templateStaff')
@section('title','Jadwal Kerja')
@section('content-title','Data Staff / Jadwal Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <style>
        table, h2.h3 {
            color: black;
        }
    </style>
@endsection

@section('content')
    <?php
        function check_name_day($check) {
            switch ($check) {
                case 'Monday': return 'Senin'; break;
                case 'Tuesday': return 'Selasa'; break;
                case 'Wednesday': return 'Rabu'; break;
                case 'Thursday': return 'Kamis'; break;
                case 'Friday': return "Jum'at"; break;
                case 'Saturday': return 'Sabtu'; break;
                case 'Sunday': return 'Minggu'; break;
            }
        }
    ?>
    <div class="panel">
        <div class="panel-body">
            <div class="table-responsive">
                <h1>{{$data_this_month[0]->month}}</h1>
                <table id="schedule-this-month"
                class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                cellspacing="0">
                    @for ($i = 1; $i <= $days; $i++)
                        @if ($i % 7 == 1)
                            <tr>
                        @endif
                        <td id="{{'td-'.$i}}">
                            <?php
                                $data = 'shift_'.$i;
                                $day=$data_this_month[0]->year.'/'.$month.'/'.$i;
                                $name_day = check_name_day(date('l', strtotime($day)));
                            ?>
                            <p>{{$i}} - <span>{{$name_day}}</span></p>
                            <h2 class="h3 text-center {{$data_this_month[0]->$data}}">{{$data_this_month[0]->$data}}</h2>
                        </td>
                        @if ($i % 7 == 0)
                            </tr>
                        @endif
                    @endfor
                </table>

                @if (count($data_next_month) != 0) 
                    <h1>{{$data_next_month[0]->month}}</h1>
                    <table id="schedule-this-month"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed"
                    role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%"
                    cellspacing="0">
                        @for ($i = 1; $i <= 7; $i++)
                            @if ($i % 7 == 1)
                                <tr>
                            @endif
                            <td>
                                <?php
                                    $data = 'shift_'.$i;
                                    $day=$data_next_month[0]->year.'/'.$month.'/'.$i;
                                    $name_day = check_name_day(date('l', strtotime($day)));
                                ?>
                                <p>{{$i}} - <span>{{$name_day}}</span></p>
                                <h2 class="h3 text-center {{$data_next_month[0]->$data}}">{{$data_next_month[0]->$data}}</h2>
                            </td>
                            @if ($i % 7 == 0)
                                </tr>
                            @endif
                        @endfor
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    var data_off = document.getElementsByClassName('Off');
    var data_pagi = document.getElementsByClassName('Pagi');
    var data_siang = document.getElementsByClassName('Siang');
    for (let index = 0; index < data_off.length; index++) {
        var data = data_off[index].parentElement;
        data.style.backgroundColor="rgba(255,0,0,0.75)";
    }
    for (let index = 0; index < data_pagi.length; index++) {
        var data = data_pagi[index].parentElement;
        data.style.backgroundColor="rgba(0,255,0,0.75)";
    }
    for (let index = 0; index < data_siang.length; index++) {
        var data = data_siang[index].parentElement;
        data.style.backgroundColor="rgba(0,0,255,0.75)";
    }
    var this_day = document.getElementById('td-'+new Date().getDate());
    this_day.style.border="solid black 5px";
</script>
@endsection