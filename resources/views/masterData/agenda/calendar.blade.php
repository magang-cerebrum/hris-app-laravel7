<link href="{{asset("plugins/fullcalendar/fullcalendar.min.css")}}" rel="stylesheet">
<link href="{{asset("plugins/fullcalendar/nifty-skin/fullcalendar-nifty.min.css")}}" rel="stylesheet">
<style>
    #container .fc-event{
        cursor: pointer;
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
            fixedWeekCount: false,
            header:{
                left: 'prev,next',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: '<?= $year ?>-<?= $month ?>-01',
            eventLimit: true,
            eventRender: function(eventObj, $el) {
                $el.popover({
                    title: eventObj.title,
                    content: eventObj.description,
                    trigger: 'hover',
                    placement: 'top',
                    container: 'body'
                });
            },
            events: [
                <?php foreach ($data as $item) { 
                    
                    for ($i=1; $i <= 1; $i++) { ?>
                        <?php 
                            $start = explode(" ", $item->start_event)[0] . 'T' . explode(" ", $item->start_event)[1];
                            $end = explode(" ", $item->end_event)[0] . 'T' . explode(" ", $item->end_event)[1];
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