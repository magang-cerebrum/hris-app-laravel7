@extends('layouts/templateStaff')
@section('title','Jadwal Kerja')
@section('content-title','Jadwal Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <link href="{{asset("plugins/fullcalendar/fullcalendar.min.css")}}" rel="stylesheet">
    <link href="{{asset("plugins/fullcalendar/nifty-skin/fullcalendar-nifty.min.css")}}" rel="stylesheet">
    <style>
        .fc-time{display : none;}
        .fc-toolbar{display: none;}
        .fc-event{height: 60px;}
        .fc-content{text-align: center;padding-top: 22px}
        td#green{background-color: #8bc34a; width: 20px; height: 20px;}
        td#blue{background-color: #00bcd4; width: 20px; height: 20px;}
        td#red{background-color: #ef5350; width: 20px; height: 20px;}
        td.break{width: 10px; height: 10px;}
    </style>
@endsection

@section('content')
    
    <div class="panel panel-bordered panel-primary">
        <div class="panel-heading">
            @foreach ($data_this_month as $item)
                <h3 class="panel-title">{{'Jadwal Kerja Bulan '.$item->month.' - '.$item->year}}</h3>
            @endforeach
        </div>
        <div class="panel-body">
            <div id='calendar-this-month'></div><br>
            <table><tr><td id="green"></td><td class="break"></td><td>: Shift Pagi</td><td class="break"></td><td id="blue"></td><td class="break"></td><td>: Shift Siang</td><td class="break"></td><td id="red"></td><td class="break"></td><td>: Off/Libur/Cuti</td></tr></table>
        </div>

        @if (count($data_next_month) != 0) 
            <div class="panel-heading">
                @foreach ($data_next_month as $item)
                <h3 class="panel-title">{{'Jadwal Kerja Bulan '.$item->month.' - '.$item->year}}</h3>
                @endforeach
            </div>
            <div class="panel-body">
                <div id='calendar-next-month'></div><br>
                <table id="legend-next"><tr><td id="green"></td><td class="break"></td><td>: Shift Pagi</td><td class="break"></td><td id="blue"></td><td class="break"></td><td>: Shift Siang</td><td class="break"></td><td id="red"></td><td class="break"></td><td>: Off/Libur/Cuti</td></tr></table>
            </div>
        @endif
    </div>
@endsection

@section('script')

<script src="{{asset("plugins/fullcalendar/lib/moment.min.js")}}"></script>
<script src="{{asset("plugins/fullcalendar/lib/jquery-ui.custom.min.js")}}"></script>
<script src="{{asset("plugins/fullcalendar/fullcalendar.min.js")}}"></script>
<script src="{{asset("plugins/fullcalendar/lang/id.js")}}"></script>

<script>
    $(document).ready(function () {
        $('#calendar-this-month').fullCalendar({
            contentHeight:500,
            fixedWeekCount: false,
            header:{
                left: 'prev,next',
                center: 'title',
                right: 'month,basicWeek'
            },
            <?php foreach ($data_this_month as $item){ ?>
                    defaultDate: '<?= $item->year ?>-<?= switch_month($item->month,false) ?>-01',
                <?php } ?>
            eventLimit: true,
            events: [
                <?php foreach ($data_this_month as $item) { 
                    for ($i=1; $i <= $day; $i++) { ?>
                        <?php 
                            $shift = 'shift_'.$i;
                        if($item->$shift == 'Pagi') $color = 'success';
                        elseif($item->$shift == 'Siang') $color = 'info';
                        else $color = 'danger';
                        ?>
                        {
                            title: '<?= $item->user_name ?>',
                            start: "<?= $data_this_month[0]->year ?>-<?= switch_month($data_this_month[0]->month,false) ?>-<?= $i / 10 < 1 ? '0'. $i : $i ?>",
                            className: '<?= $color ?>'
                        },
                    <?php } ?>
                <?php } ?>
            ]
        });
        $('#calendar-next-month').fullCalendar({
                defaultView:'basicWeek',
                contentHeight: 103,
                <?php foreach ($data_next_month as $item){ ?>
                    defaultDate: '<?= $item->year ?>-<?= switch_month($item->month,false) ?>-01',
                <?php } ?>
                eventLimit: true,
                events: [
                    <?php foreach ($data_next_month as $item) { 
                        for ($i=1; $i <= 7; $i++) { ?>
                            <?php 
                                $shift = 'shift_'.$i;
                            if($item->$shift == 'Pagi') $color = 'success';
                            elseif($item->$shift == 'Siang') $color = 'info';
                            else $color = 'danger';
                            ?>
                            {
                                title: '<?= $item->user_name ?>',
                                start: "<?= $data_next_month[0]->year ?>-<?= switch_month($data_next_month[0]->month,false) ?>-<?= $i / 10 < 1 ? '0'. $i : $i ?>",
                                className: '<?= $color ?>'
                            },
                        <?php } ?>
                    <?php } ?>
                ]
            });
    })
</script>
@endsection