<div class="panel panel-bordered panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">{{'Daftar Lembur "'.switch_month($month) . ' - ' . $year . '"'}}</h3>
    </div>
    <div class="panel-body">
        <table id="presensi-result" class="table table-striped table-bordered no-footer dtr-inline collapsed"
            role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
            <thead>
                <tr role="row">
                    @if ($data[0] == null)
                    <th class="text-center" tabindex="0" colspan="6">Ma'af, tidak ada data lembur ditemukan!</th>
                    @else
                    <th class="sorting_asc text-center" tabindex="0">No</th>
                    <th class="sorting_asc text-center">Nama</th>
                    <th class="sorting_asc text-center">Bulan - Tahun</th>
                    <th class="sorting text-center">Lama Lembur</th>
                    <th class="sorting text-center">Upah Lembur</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td class="text-center">{{$item->user_name}}</td>
                    <td class="text-center">{{$item->month . ' - ' . $item->year}}</td>
                    <td class="text-center">{{$item->hour . ' jam'}}</td>
                    <td class="text-center">{{rupiah($item->payment)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
