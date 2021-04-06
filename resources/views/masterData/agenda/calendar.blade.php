<link href="{{asset("plugins/fullcalendar/fullcalendar.min.css")}}" rel="stylesheet">
<link href="{{asset("plugins/fullcalendar/nifty-skin/fullcalendar-nifty.min.css")}}" rel="stylesheet">
<style>
    .fc-left,
    .fc-right{
        visibility: hidden;
    }
    #container .fc-event{
        cursor: pointer;
    }
    a.fc-more{
        font-weight: bold;
    }
</style>
<div class="panel panel-bordered panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">{{'Agenda Kerja Bulan '.switch_month(explode("-", $periode)[1]).' - '.explode("-", $periode)[0]}} </h3>
    </div>
    <div class="panel-body">
        <div id='calendar'></div><br>

    </div>
</div>

<script src="{{asset("plugins/fullcalendar/lib/moment.min.js")}}"></script>
<script src="{{asset("plugins/fullcalendar/lib/jquery-ui.custom.min.js")}}"></script>
<script src="{{asset("plugins/fullcalendar/fullcalendar.min.js")}}"></script>
<script src="{{asset("plugins/fullcalendar/lang/id.js")}}"></script>
<script>
    $(document).ready(function () {
        $('#calendar').fullCalendar({
            height: 575,
            fixedWeekCount: false,
            header:{
                center: 'title',
            },
            defaultDate: '<?= $year ?>-<?= $month ?>-01',
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
                <?php foreach ($data as $item) { 
                    $start_date = intval(explode('-',explode(' ',$item->start_event)[0])[2]);
                    $interval = date_diff(date_create($item->start_event), date_create($item->end_event))->format('%d');
                    for ($i=$start_date; $i <= ($start_date + $interval); $i++) { ?>
                        <?php 
                            $start = substr_replace(explode(" ", $item->start_event)[0],$i,9,2) . 'T' . explode(" ", $item->start_event)[1];
                            $end = substr_replace(explode(" ", $item->start_event)[0],$i,9,2) . 'T' . explode(" ", $item->end_event)[1];
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
    })
</script>