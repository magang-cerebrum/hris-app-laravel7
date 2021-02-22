<div class="panel panel-bordered panel-dark">
    <div class="panel-heading">
        <h3 class="panel-title">Hasil Pencarian Presensi</h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table id="presensi-result"
                class="table table-striped table-responsive table-bordered no-footer dtr-inline collapsed" role="grid"
                aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                <thead>
                    <tr role="row">
                        @if ($data[0] == null)
                        <th class="text-center" tabindex="0" colspan="6">Ma'af, tidak ada data presensi ditemukan!</th>
                        @else
                        <th class="sorting_asc text-center" tabindex="0">No</th>
                        <th class="sorting_asc text-center">Tanggal</th>
                        <th class="sorting text-center">Waktu Masuk</th>
                        <th class="sorting text-center">Waktu Keluar</th>
                        <th class="sorting text-center">Waktu Sehari</th>
                        <th class="sorting text-center">Waktu Telat</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                    <tr>
                        <td tabindex="0" class="sorting_1 text-center">{{(($data->currentPage() * 5) - 5) + $loop->iteration}}</td>
                        <td class="text-center">{{$row->presence_date}}</td>
                        <td class="text-center">{{$row->in_time}}</td>
                        <td class="text-center">{{$row->out_time}}</td>
                        <td class="text-center">{{$row->inaday_time}}</td>
                        <td class="text-center">{{$row->late_time}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>