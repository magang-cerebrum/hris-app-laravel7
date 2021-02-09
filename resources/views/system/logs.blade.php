@extends('layouts/templateAdmin')
@section('title','Sistem / Sistem Log HRIS')
@section('content-title','Laporan Log HRIS')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title text-center text-bold">Laporan Log Sistem HRIS</h3>
    </div>
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
                        <form action="/admin/log" method="post" id="form-mul-delete">
                            @csrf
                            @method('delete')
                            <button id="btn-delete" class="btn btn-danger" type="submit" style="margin-bottom : 10px;">Hapus Data Terpilih</button>
                    </div>
                    <div class="col-sm-7"></div>
                    <div class="col-sm-3 hidden">
                        <div class="form-group float-right">
                            {{-- <input type="text" name="cari-divisi" id="cari-divisi" class="form-control"
                                placeholder="Cari Divisi" /> --}}
                        </div>
                    </div>
                </div>
                <table id="masterdata-division"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending">
                                No</th>
                                <th class="text-center">
                                    All <input type="checkbox" id="check-all">
                                </th>
                            <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Aktifitas</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Waktu Terekam </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr>
                            <td tabindex="0" class="sorting_1 text-center">{{(($data->currentPage() * 10) - 10) + $loop->iteration}}</td>
                            <td class="text-center">
                            <input type="checkbox" name="selectid[]" value="{{$row->id}}" class="check-item">    
                            </td>
                            <td class="text-center">{{$row->description}}</td>
                            <td class="text-center">{{$row->created_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </form>
            <div class="row">
                <div class="col-sm-5"></div>
                <div class="col-sm-2">
                    <ul class="pagination">
                        {{ $data->links() }}
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
