<div class="panel panel-bordered panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">{{'Jadwal Kerja Bulan '.$data[0]->month.' - '.$data[0]->year}} </h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table id="masterdata-schedule"
                class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed" role="grid"
                aria-describedby="demo-dt-basic_info" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="sorting align-middle" tabindex="0" rowspan="2">No</th>
                        <th class="sorting text-center" tabindex="0" rowspan="2">Aksi</th>
                        <th class="sorting text-center" tabindex="0" rowspan="2">Bulan</th>
                        <th class="sorting text-center" tabindex="0" rowspan="2">Tahun</th>
                        <th class="sorting text-center" tabindex="0" rowspan="2">NIP</th>
                        <th class="sorting text-center" tabindex="0" rowspan="2">Nama</th>
                        <th class="sorting text-center" tabindex="0" colspan="{{$count_day}}">Tanggal</th>
                        <th class="sorting text-center" tabindex="0" rowspan="2">Total Jam</th>
                    </tr>
                    <tr>
                        @for ($i = 1; $i <= $count_day; $i++) <th class="sorting text-center" tabindex="0">{{$i}}</th>
                            @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr class="sorting text-center" tabindex="0">
                        <td class="sorting text-center" tabindex="0">{{$loop->iteration}}</td>
                        <td class="text-center">Aksi</td>
                        <td class="text-center">{{$item->month}}</td>
                        <td class="text-center">{{$item->year}}</td>
                        <td class="text-center">{{$item->user_nip}}</td>
                        <td class="text-center">{{$item->user_name}}</td>
                        @for ($i = 1; $i <= $count_day; $i++)
                            <?php
                                $shift_name = 'shift_'.$i;
                            ?>
                            <td class="text-center {{$item->$shift_name}}">{{$item->$shift_name}}</td>
                        @endfor
                        <td class="text-center">{{$item->total_hour}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>


<script>
    var data_off = document.getElementsByClassName('Off');
    var data_pagi = document.getElementsByClassName('Pagi');
    var data_siang = document.getElementsByClassName('Siang');
    for (let index = 0; index < data_off.length; index++) {
        data_off[index].style.backgroundColor = "rgba(255,0,0,0.75)";
    }
    for (let index = 0; index < data_pagi.length; index++) {
        data_pagi[index].style.backgroundColor = "rgba(0,255,0,0.75)";
    }
    for (let index = 0; index < data_siang.length; index++) {
        data_siang[index].style.backgroundColor = "rgba(0,0,255,0.75)";
    }

</script>

