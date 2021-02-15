@extends('layouts/templateAdmin')
@section('content-title','Master Data / Divisi')
@section('title','Masterdata Divisi')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
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
                        <a href="{{url('/admin/division/add')}}" class="btn btn-primary btn-labeled add-tooltip" style="margin-bottom:15px" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Tambah Data Divisi Baru">
                            <i class="btn-label fa fa-plus"></i>
                            Tambah Divisi
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <form action="/admin/division" method="POST" id="form-mul-delete">
                            @csrf
                            @method('delete')
                            <button id="btn-delete" class="btn btn-danger btn-labeled add-tooltip" type="submit" data-toggle="tooltip"
                                data-container="body" data-placement="top" data-original-title="Hapus Data" onclick="submit_delete()">
                                <i class="btn-label fa fa-trash"></i>
                                Hapus Data Terpilih
                            </button>
                            @error('selectid') <span style="display:inline;" class="text-danger invalid-feedback mt-3">
                                Maaf, tidak ada data terpilih untuk dihapus.</span> @enderror
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group float-right">
                            <input type="text" id="cari-divisi" class="form-control"
                                placeholder="Cari Divisi" onkeyup="search_division()">
                        </div>
                    </div>
                </div>
                <table id="masterdata-divisi"
                    class="table table-striped table-bordered dataTable no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 5%">No</th>
                            <th class="text-center" style="width: 6%">
                                All <input type="checkbox" id="check-all">
                            </th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending" style="width: 10%">Aksi</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                                colspan="1" aria-label="Position: activate to sort column ascending">Nama Divisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($division as $row)
                        <tr>
                            <td tabindex="0" class="sorting_1 text-center">{{(($division->currentPage() * 5) - 5) + $loop->iteration}}</td>
                            <td class="text-center">
                                <input type="checkbox" class="check-item" name="selectid[]" value="{{$row->id}}">
                            </td>
                            <td class="text-center">
                                <a href="/admin/division/{{$row->id}}/edit"
                                    class="btn btn-success btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                    data-container="body" data-placement="top" data-original-title="Edit Divisi"
                                    type="button">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">{{$row->name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </form>
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10 text-center">
                        <ul class="pagination">
                            {{ $division->links() }}
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
                $(".check-item").prop("checked",true);
            else
                $(".check-item").prop("checked",false);
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
    function search_division() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari-divisi");
        filter = input.value.toUpperCase();
        table = document.getElementById("masterdata-divisi");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            for (j = 3; j < 4; j++ ){
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
