
<form action="/admin/salary/processed" method="POST">
    @csrf
    <button type="submit">Get Salary Data</button>
</form>
<form action="/admin/salary/reset" method="POST">
    @csrf
    <button type="submit">Reset Log Salary</button>
</form>

<div class="panel panel-bordered panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">{{'Daftar Lembur "'.switch_month($month) . ' - ' . $year . '"'}}</h3>
    </div>
    <div class="panel-body">
        <div class="row mar-btm">
            <div class="col-sm-12">
                <form action="{{url('/admin/salary/add')}}" method="get">
                    <input type="hidden" name="month" value="{{$month}}">
                    <input type="hidden" name="year" value="{{$year}}">
                    <button href="{{url('/admin/overtime/add')}}" class="btn btn-primary btn-labeled add-tooltip"
                        data-toggle="tooltip" data-container="body" data-placement="top"
                        data-original-title="Tambah Lembur Baru" type="submit">
                        <i class="btn-label fa fa-plus"></i>
                        Tambah Lembur Baru
                    </button>
                </form>
            </div>
        </div>
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
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td class="text-center">{{$item->user_name}}</td>
                    <td class="text-center">{{$item->month . ' - ' . $item->year}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>