@extends('layouts/templateAdmin')
@section('content-title','Master Data / Jabatan')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Masterdata Jabatan')
@section('content')

<div class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                @if (session('status'))
                <div class="alert alert-info alert-dismissable">
                    <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                    {{session('status')}}
                </div>
                @endif
                <div class="row">
                    <div class="col-sm-2">
                        <a href="{{url('/admin/position/add')}}" class="btn btn-primary btn-labeled"
                            style="margin-bottom:15px" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Tambah Data Jabatan Baru">
                            <i class="btn-label fa fa-plus"></i>
                            Tambah Jabatan
                        </a>
                    </div>
                    <div class="col-sm-2">
                        <form action="/admin/position" method="POST" id="form-mul-delete">
                            @csrf
                            @method('delete')
                            <button id="btn-delete" class="btn btn-danger btn-labeled add-tooltip" type="submit" data-toggle="tooltip"
                                data-container="body" data-placement="top" data-original-title="Hapus Data">
                                <i class="btn-label fa fa-trash"></i>
                                Hapus Data Terpilih
                            </button>
                    </div>
                    <div class="col-sm-5"></div>
                    <div class="col-sm-3 hidden">
                        <div class="form-group float-right">
                            {{-- <input type="text" name="cari-jabatan" id="cari-jabatan" class="form-control"
                                placeholder="Cari Jabatan" /> --}}
                        </div>
                    </div>
                </div>
                <table id="masterdata-position"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 5%">No</th>
                            <th class="text-center" style="width: 6%">
                                All <input type="checkbox" id="check-all">
                            </th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 10%">Aksi</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending">Nama Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($position as $row)
                        <tr>
                            <td tabindex="0" class="sorting_1 text-center">{{(($position->currentPage() * 5) - 5) + $loop->iteration}}</td>
                            <td class="text-center">
                                <input type="checkbox" class="check-item" name="selectid[]" value="{{$row->id}}">
                            </td>
                            <td class="text-center">
                                <a href="/admin/position/{{$row->id}}/edit"
                                    class="btn btn-success btn-icon btn-circle add-tooltip" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Edit Jabatan" type="button">
                                    <i class="fa fa-edit"></i>
                                </a>
                            <td class="text-center">{{$row->name}}</td>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
                <div class="row">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2">
                        <ul class="pagination">
                            {{ $position->links() }}
                        </ul>
                    </div>
                    <div class="col-sm-5"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#check-all").click(function () {
            if ($(this).is(":checked"))
                $(".check-item").prop("checked",true);
            else
                $(".check-item").prop("checked",false);
        });

        $("#btn-delete").click(function () {
            var confirm = window.confirm(
            "Apakah Anda yakin ingin menghapus data-data ini?");
            if (confirm) $("#form-mul-delete").submit()
        });
    });
</script>
@endsection
