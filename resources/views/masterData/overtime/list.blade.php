<div class="panel panel-bordered panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">{{'Daftar Lembur "'.switch_month($month) . ' - ' . $year . '"'}}</h3>
    </div>

    <form action="{{url('/admin/overtime/add')}}" method="get" id="search"></form>

    <div class="panel-body" style="padding-top: 20px">
        <div class="row mar-btm">
            <div class="col-sm-12">
                <input type="hidden" name="month" value="{{$month}}" form="search">
                <input type="hidden" name="year" value="{{$year}}" form="search">
                <button href="{{url('/admin/overtime/add')}}" class="btn btn-primary btn-labeled add-tooltip"
                    data-toggle="tooltip" data-container="body" data-placement="top"
                    data-original-title="Tambah Lembur Baru" type="submit" form="search">
                    <i class="btn-label fa fa-plus"></i>
                    Tambah Lembur Baru
                </button>
            </div>
        </div>
        @if(!$data->isEmpty())
            <div class="table-responsive">
                <table id="overtime-result" class="table table-striped table-bordered no-footer dtr-inline collapsed"
                    role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            @if ($data[0] == null)
                            <th class="text-center" tabindex="0" colspan="6">Ma'af, tidak ada data lembur ditemukan!</th>
                            @else
                            <th class="sorting_asc text-center" tabindex="0">No</th>
                            <th class="sorting_asc text-center">Nama</th>
                            <th class="sorting_asc text-center">Periode</th>
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
        @else
            <div class="text-center text-danger text-bold">Ma'af, tidak ada data lembur ditemukan untuk periode {{switch_month($month) . ' - ' . $year}}</div>
        @endif
    </div>
</div>
