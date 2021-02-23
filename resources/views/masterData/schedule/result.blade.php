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
                        <th class="sorting text-center" tabindex="0" colspan="31">Tanggal</th>
                        <th class="sorting text-center" tabindex="0" rowspan="2">Total Jam</th>
                    </tr>
                    <tr>
                        @for ($i = 1; $i < 32; $i++) <th class="sorting text-center" tabindex="0">{{$i}}</th>
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
                        <td class="text-center {{$item->shift_1}}">{{$item->shift_1}}</td>
                        <td class="text-center {{$item->shift_2}}">{{$item->shift_2}}</td>
                        <td class="text-center {{$item->shift_3}}">{{$item->shift_3}}</td>
                        <td class="text-center {{$item->shift_4}}">{{$item->shift_4}}</td>
                        <td class="text-center {{$item->shift_5}}">{{$item->shift_5}}</td>
                        <td class="text-center {{$item->shift_6}}">{{$item->shift_6}}</td>
                        <td class="text-center {{$item->shift_7}}">{{$item->shift_7}}</td>
                        <td class="text-center {{$item->shift_8}}">{{$item->shift_8}}</td>
                        <td class="text-center {{$item->shift_9}}">{{$item->shift_9}}</td>
                        <td class="text-center {{$item->shift_10}}">{{$item->shift_10}}</td>
                        <td class="text-center {{$item->shift_11}}">{{$item->shift_11}}</td>
                        <td class="text-center {{$item->shift_12}}">{{$item->shift_12}}</td>
                        <td class="text-center {{$item->shift_13}}">{{$item->shift_13}}</td>
                        <td class="text-center {{$item->shift_14}}">{{$item->shift_14}}</td>
                        <td class="text-center {{$item->shift_15}}">{{$item->shift_15}}</td>
                        <td class="text-center {{$item->shift_16}}">{{$item->shift_16}}</td>
                        <td class="text-center {{$item->shift_17}}">{{$item->shift_17}}</td>
                        <td class="text-center {{$item->shift_18}}">{{$item->shift_18}}</td>
                        <td class="text-center {{$item->shift_19}}">{{$item->shift_19}}</td>
                        <td class="text-center {{$item->shift_20}}">{{$item->shift_20}}</td>
                        <td class="text-center {{$item->shift_21}}">{{$item->shift_21}}</td>
                        <td class="text-center {{$item->shift_22}}">{{$item->shift_22}}</td>
                        <td class="text-center {{$item->shift_23}}">{{$item->shift_23}}</td>
                        <td class="text-center {{$item->shift_24}}">{{$item->shift_24}}</td>
                        <td class="text-center {{$item->shift_25}}">{{$item->shift_25}}</td>
                        <td class="text-center {{$item->shift_26}}">{{$item->shift_26}}</td>
                        <td class="text-center {{$item->shift_27}}">{{$item->shift_27}}</td>
                        <td class="text-center {{$item->shift_28}}">{{$item->shift_28}}</td>
                        <td class="text-center {{$item->shift_29}}">{{$item->shift_29}}</td>
                        <td class="text-center {{$item->shift_30}}">{{$item->shift_30}}</td>
                        <td class="text-center {{$item->shift_31}}">{{$item->shift_31}}</td>
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

