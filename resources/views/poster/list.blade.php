@extends('layouts/templateAdmin')
@section('title', 'Sistem')
@section('content-title', 'Poster')
@section('content-subtitle', 'HRIS '.$company_name)
@section('head')
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <style>
        .table > tbody > tr > td,
        .table > tbody > tr > th, 
        .table > tfoot > tr > td, 
        .table > tfoot > tr > th, 
        .table > thead > tr > td, 
        .table > thead > tr > th{
            vertical-align:middle;
        }
        #image_poster {
            width: 80%;
        }
        @media screen and (max-width: 600px) {
            #input_search{
                margin-top: 15px;
            }
            #image_poster {
                width: 200px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Data Poster Dashboard</h3>
        </div>
        
        <form action="{{ url('/admin/poster')}}" method="POST" id="form-mul-delete">
            @csrf
            @method('delete')
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="row">
                <div class="col-sm-8">
                    <a href="{{url('/admin/poster/add')}}" class="btn btn-primary btn-labeled"
                        data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Tambah Poster Baru">
                        <i class="btn-label fa fa-plus"></i>
                        Tambah Poster
                    </a>
                    <button id="btn-delete" class="btn btn-danger btn-labeled add-tooltip" type="submit" data-toggle="tooltip"
                        data-container="body" data-placement="top" data-original-title="Hapus Poster" onclick="submit_delete()" form="form-mul-delete">
                        <i class="btn-label fa fa-trash"></i>
                        Hapus Poster Terpilih
                    </button>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <input type="text" name="cari-poster" id="cari-poster" class="form-control"
                            placeholder="Cari Poster" onkeyup="search_poster()">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="poster"
                    class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
                    style="width: 100%; " width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 5%">No</th>
                            <th class="text-center" style="width: 6%">
                                All <input type="checkbox" id="check-all">
                            </th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 10%">Aksi</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 20%">Nama Poster</th>
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending">File Poster</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td tabindex="0" class="sorting_1 text-center">{{$loop->iteration}}</td>
                                <td class="text-center">
                                    <input type="checkbox" class="check-item" name="selectid[]" value="{{$row->id}}" form="form-mul-delete">
                                </td>
                                <td class="text-center">
                                    <a href="/admin/poster/{{$row->id}}/edit"
                                        class="btn btn-success btn-icon btn-circle add-tooltip" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Edit Poster" type="button">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td class="text-center">{{$row->name}}</td>
                                <td class="text-center">
                                    <img src="{{ asset('/img/poster/'.$row->file)}}" alt="{{$row->name}}" id="image_poster">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

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
                    cancelButtonText: 'Tidak',
                    width: 600
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
        function search_poster() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("cari-poster");
            filter = input.value.toUpperCase();
            table = document.getElementById("poster");
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