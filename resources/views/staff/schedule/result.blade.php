<link href="{{asset("plugins/fullcalendar/fullcalendar.min.css")}}" rel="stylesheet">
<link href="{{asset("plugins/fullcalendar/nifty-skin/fullcalendar-nifty.min.css")}}" rel="stylesheet">
<style>
    .fc-time{display : none;}
    td#green{background-color: #8bc34a; width: 20px; height: 20px;}
    td#blue{background-color: #00bcd4; width: 20px; height: 20px;}
    td#red{background-color: #ef5350; width: 20px; height: 20px;}
    td#yellow{background-color: #FFA726; width: 20px; height: 20px;}
    td.break{width: 10px; height: 10px;}
</style>

<div class="panel panel-bordered panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">{{'Jadwal Kerja Divisi Bulan '.switch_month($month).' - '.$year}} </h3>
    </div>
    <div class="panel-body">
        <div id='calendar'></div><br>
        <table><tr><td id="green"></td><td class="break"></td><td>: Shift Pagi</td><td class="break"></td><td id="blue"></td><td class="break"></td><td>: Shift Siang</td><td class="break"></td><td id="red"></td><td class="break"></td><td>: Off/Libur</td><td class="break"></td><td id="yellow"></td><td class="break"></td><td>: Cuti</td></tr></table>
    </div>
</div>

<script src="{{asset("plugins/fullcalendar/lib/moment.min.js")}}"></script>
<script src="{{asset("plugins/fullcalendar/lib/jquery-ui.custom.min.js")}}"></script>
<script src="{{asset("plugins/fullcalendar/fullcalendar.min.js")}}"></script>
<script src="{{asset("plugins/fullcalendar/lang/id.js")}}"></script>
<script>
    $(document).ready(function () {
        $('#calendar').fullCalendar({
            fixedWeekCount: false,
            header:{
                left: 'prev,next',
                center: 'title',
                right: 'month,basicWeek'
            },
            defaultDate: '<?= $year ?>-<?= $month ?>-01',
            eventLimit: true, // allow "more" link when too many events
            events: [
                <?php foreach ($data as $item) { 
                    for ($i=1; $i <= $day; $i++) { ?>
                        <?php 
                            $shift = 'shift_'.$i;
                        if($item->$shift == 'Pagi') $color = 'success';
                        elseif($item->$shift == 'Siang') $color = 'info';
                        elseif($item->$shift == 'Cuti') $color = 'warning';
                        else $color = 'danger';
                        ?>
                        {
                            title: '<?= $item->user_name ?>',
                            start: "<?= $year ?>-<?= $month ?>-<?= $i / 10 < 1 ? '0'. $i : $i ?>",
                            className: '<?= $color ?>'
                        },
                    <?php } ?>
                <?php } ?>
            ]
        });
    })
</script>