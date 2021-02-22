@extends('layouts/templateAdmin')
@section('title', 'Hari Libur')
@section('content-title', 'Master Data / Daftar Hari Libur')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')
@section('head')
{{-- Sweetalert 2 --}}
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="panel">
    <div class="panel-body">
        <div class="table-responsive">
            <div class="row">
                <div class="col-sm-12" style="margin-bottom:15px">
                    <a href="{{url('/admin/holiday/add')}}" class="btn btn-primary btn-labeled">
                        <i class="btn-label fa fa-plus"></i>
                        Tambah Hari Libur
                    </a>
                    <form action="/admin/holiday" method="POST" id="form-mul-delete" style="display:inline">
                        @csrf
                        @method('delete')
                        <button id="btn-delete" class="btn btn-danger btn-labeled add-tooltip" type="submit"
                            data-toggle="tooltip" data-container="body" data-placement="top"
                            data-original-title="Hapus Hari Libur Terpilih" onclick="submit_delete()">
                            <i class="btn-label fa fa-trash"></i>
                            Hapus Data Terpilih
                        </button>
                </div>
            </div>
            <table id="masterdata-holiday" class="table table-striped table-bordered no-footer dtr-inline collapsed"
                role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                <thead>
                    <tr role="row">
                        <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                        <th class="text-center" style="width: 6%;">All <input type="checkbox" id="check-all"></th>
                        <th class="sorting text-center" tabindex="0" style="width: 10%">Aksi</th>
                        <th class="sorting text-center">Keterangan</th>
                        <th class="sorting text-center">Tanggal Libur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td class="sorting text-center" tabindex="0">{{$loop->iteration}}</td>
                        <td class="text-center">
                            <input type="checkbox" class="check-item @error('selectid') is-invalid @enderror"
                                name="selectid[]" value="{{$item->id}}">
                        </td>
                        <td class="text-center">
                            <a href="/admin/holiday/{{$item->id}}/edit"
                                class="btn btn-sm btn-success btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                data-container="body" data-placement="top" data-original-title="Edit Hari Libur"
                                type="button">
                                <i class="fa fa-pencil-square"></i>
                            </a>
                        </td>
                        <td class="text-center">{{$item->information}}</td>
                        <td class="text-center">{{indonesian_date($item->date)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
        </div>
    </div>
    <!--===================================================-->
    <!-- End Striped Table -->
</div>
@endsection
@section('script')
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // check all
        $("#check-all").click(function () {
            if ($(this).is(":checked"))
                $(".check-item").prop("checked", true);
            else
                $(".check-item").prop("checked", false);
        });
    });
    // Sweetalert 2
    function submit_delete() {
        event.preventDefault();
        var check = document.querySelector('.check-item:checked');
        if (check != null) {
            Swal.fire({
                title: 'Anda yakin ingin menghapus data terpilih?',
                text: "Data yang sudah di hapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value == true) {
                    $("#form-mul-delete").submit();
                }
            });
        } else {
            Swal.fire({
                title: 'Sepertinya ada kesalahan...',
                text: "Tidak ada data yang dipilih untuk dihapus!",
                icon: 'error',
            })
        }
    }

    // live search
    function search_staff() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari-staff");
        filter = input.value.toUpperCase();
        table = document.getElementById("masterdata-staff");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            for (j = 3; j < 6; j++) {
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
