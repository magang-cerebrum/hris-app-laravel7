<link href="{{asset("plugins/fullcalendar/fullcalendar.min.css")}}" rel="stylesheet">
<link href="{{asset("plugins/fullcalendar/nifty-skin/fullcalendar-nifty.min.css")}}" rel="stylesheet">
<style>
    .fc-time,.fc-left,.fc-right
    {display : none;}
    td.break{width: 10px; height: 10px;}
</style>

<div class="panel panel-bordered panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">{{'Data Presensi Bulan '.switch_month($month).' - '.$year . '| Divisi : ' . ($division === null ? 'Semua Divisi' : $division->name)}} </h3>
    </div>
    <div class="panel-body" style="padding-top: 20px">
        @if (empty($data))
            <div class="text-center text-bold text-danger">
                Tidak ada data presensi ditemukan untuk bulan ini. <br>
                Hal ini terjadi karena belum ada jadwal yang dibuat untuk staff pada bulan ini. <br>
                <a href="{{url('/admin/schedule/add')}}" class="btn btn-warning mar-top">Klik untuk menambahkan jadwal kerja!</a>
            </div>
        @else
            <div id='calendar'></div><br>
            <table><tr>
                <td style="width: 15px;height: 15px;background-color:#2B323A"></td><td class="break"></td><td>: Tidak Hadir</td><td class="break">
                <td style="width: 15px;height: 15px;background-color:#79AF3A"></td><td class="break"></td><td>: Hadir</td><td class="break">
                <td style="width: 15px;height: 15px;background-color:#1F897F"></td><td class="break"></td><td>: Absen Masuk</td><td class="break">
                <td style="width: 15px;height: 15px;background-color:#FF8806"></td><td class="break"></td><td>: Terlambat</td><td class="break">
                <td style="width: 15px;height: 15px;background-color:#953CA4"></td><td class="break"></td><td>: Terlambat Masuk</td><td class="break">
                <td style="width: 15px;height: 15px;background-color:#F22314"></td><td class="break"></td><td>: Off</td><td class="break">
                <td style="width: 15px;height: 15px;background-color:#ED417B"></td><td class="break"></td><td>: Cuti</td><td class="break">
                <td style="width: 15px;height: 15px;background-color:#290657"></td><td class="break"></td><td>: Sakit</td><td class="break">
            <tr></table>
        @endif
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
            eventLimit: true,
            events: [
                <?php foreach ($data as $item) { 
                    for ($i=1; $i <= $day; $i++) { ?>
                        <?php 
                            $state = 'day_'.$i;
                            switch ($item->$state) {
                                case 'Kosong':
                                    $color = '#2B323A';
                                    break;
                                case 'Hadir':
                                    $color = '#79AF3A';
                                    break;
                                case 'Telat':
                                    $color = '#FF8806';
                                    break;
                                case 'Telat Masuk':
                                    $color = '#953CA4';
                                    break;
                                case 'Absen Masuk':
                                    $color = '#1F897F';
                                    break;
                                case 'Off':
                                    $color = '#F22314';
                                    break;
                                case 'Cuti':
                                    $color = '#ED417B';
                                    break;
                                case 'Sakit':
                                    $color = '#290657';
                                    break;
                            }
                        ?>
                        {
                            title: '<?= $item->user_name ?>',
                            start: "<?= $year ?>-<?= $month ?>-<?= $i / 10 < 1 ? '0'. $i : $i ?>",
                            color: '<?= $color ?>'
                        },
                    <?php } ?>
                <?php } ?>
            ]
        });
    })
</script>