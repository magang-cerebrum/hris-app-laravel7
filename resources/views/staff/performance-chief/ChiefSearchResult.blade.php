
<div class="panel panel-bordered panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">{{'Leaderboard Performa Bulan '.$data[0]->month.' - '.$data[0]->year}}</h3>
    </div>
    <div class="panel-body">
        <table id="presensi-result"
            class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
            aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
            <thead>
                <tr role="row">
                    @if ($data[0] == null)
                        <th class="text-center" tabindex="0" colspan="6">Ma'af, tidak ada data performa ditemukan!</th>
                    @else
                        <th class="sorting_asc text-center" tabindex="0">No</th>
                        <th class="sorting_asc text-center">Nama</th>
                        <th class="sorting text-center">Score</th>
                        <th class="sorting text-center">Bulan</th>
                        <th class="sorting text-center">Tahun</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($data as $dataItems)
                    <tr>
                        <td tabindex="0" class="sorting_1 text-center">{{$loop->iteration}}</td><td class="text-center">{{$dataItems->name}}</td>
                        <td class="text-center">{{$dataItems->performance_score}}</td>
                        <td class="text-center">{{$dataItems->month}}</td>
                        <td class="text-center">{{$dataItems->year}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>