@extends('layouts/templateAdmin')
@section('content-title','Master Data / Shift')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Masterdata Waktu Shift')
@section('content')
@section('head')
{{-- Sweetalert 2 --}}
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
@endsection
<div class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-2">
                        <a href="{{url('/admin/shift/add')}}" class="btn btn-primary btn-labeled add-tooltip"
                            style="margin-bottom:15px" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Tambah Data Shift Baru">
                            <i class="btn-label fa fa-plus"></i>
                            Tambah Shift
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <form action="/admin/shift" method="POST" id="form-mul-delete">
                            @csrf
                            @method('delete')
                            <button id="btn-delete" class="btn btn-danger btn-labeled add-tooltip" type="submit"
                                data-toggle="tooltip" data-container="body" data-placement="top"
                                data-original-title="Hapus Data" onclick="submit_delete()">
                                <i class="btn-label fa fa-trash"></i>
                                Hapus Data Terpilih
                            </button>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group float-right">
                            <input type="text" name="cari-shift" id="cari-shift" class="form-control"
                                placeholder="Cari Shift" onkeyup="search_shift()">
                        </div>
                    </div>
                </div>
                <table id="masterdata-shift"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="dt-basic" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 5%">
                                No</th>
                            <th class="text-center"  style="width: 6%">
                                All <input type="checkbox" id="check-all">
                            </th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Action" style="width: 10%">Aksi</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Nama Shift</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Jam masuk: activate to sort column ascending">Jam Masuk</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Jam Kerja: activate to sort column ascending">Jam Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shift as $row)
                        <tr>
                            <td tabindex="0" class="sorting_1 text-center">{{(($shift->currentPage() * 5) - 5) + $loop->iteration}}</td>
                                <td class="text-center">
                                    <input type="checkbox" class="check-item" name="selectid[]" value="{{$row->id}}">
                                </td>
                                <td class="text-center">
                                    <a href="/admin/shift/{{$row->id}}/edit"
                                        class="btn btn-success btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                        data-container="body" data-placement="top" data-original-title="Edit Waktu Shift"
                                        type="button">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            <td class="text-center">{{$row->name}}</td>
                            <td class="text-center">{{$row->start_working_time}}</td>
                            <td class="text-center">{{$row->end_working_time}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </form>
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10 text-center">
                        <ul class="pagination">
                            {{ $shift->links() }}
                        </ul>
                    </div>
                    <div class="col-sm-1"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $("#check-all").click(function () {
            if ($(this).is(":checked"))
                $(".check-item").prop("checked", true);
            else
                $(".check-item").prop("checked", false);
        });
    });

    // Sweetalert 2
    function submit_delete(){
        event.preventDefault();
        var check = document.querySelector('.check-item:checked');
        if (check != null){
            Swal.fire({
                title: 'Anda yakin ingin menghapus data terpilih?',
                text: "Data yang sudah di hapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Tidak'
                }
            ).then((result) => {
                if (result.value == true) {
                    $("#form-mul-delete").submit();
                }}
            );
        } else {
            Swal.fire({
                title: 'Sepertinya ada kesalahan...',
                text: "Tidak ada data yang dipilih untuk dihapus!",
                icon: 'error',
            })
        }
    }

    // live search
    function search_shift() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari-shift");
        filter = input.value.toUpperCase();
        table = document.getElementById("masterdata-shift");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            for (j = 3; j < 6; j++ ){
                    td = tr[i].getElementsByTagName("td")[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        break;
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    }
</script>
@endsection
@endsection
