@extends('layouts/templateAdmin')
@section('content-title','Master Data / Shift')
@section('content-subtitle','HRIS '.$company_name)
@section('title','Master Data')

@section('head')
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #btn_display {
            display: inline;
        }
        @media screen and (max-width: 600px) {
            #btn-delete {
                margin: 10px 0;
            }
            #btn_display {
                display: block;
            }
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Daftar Shift</h3>
        </div>

        <form action="/admin/shift" method="POST" id="form-mul-delete">
            @csrf
            @method('delete')
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="row">
                <div class="col-sm-8">
                    <div id="btn_display">
                        <a href="{{url('/admin/shift/add')}}" class="btn btn-primary btn-labeled add-tooltip"
                            data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Tambah Data Shift Baru">
                            <i class="btn-label fa fa-plus"></i>
                            Tambah Shift
                        </a>
                    <div id="btn_display">
                    </div>
                        <button id="btn-delete" class="btn btn-danger btn-labeled add-tooltip" type="submit"
                            data-toggle="tooltip" data-container="body" data-placement="top"
                            data-original-title="Hapus Data" onclick="submit_delete()" form="form-mul-delete">
                            <i class="btn-label fa fa-trash"></i>
                            Hapus Data Terpilih
                        </button>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group float-right">
                        <input type="text" name="cari-shift" id="cari-shift" class="form-control"
                            placeholder="Cari Shift" onkeyup="search_shift()" form="form-mul-delete">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="masterdata-shift"
                    class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
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
                            <th class="sorting text-center" tabindex="0" aria-controls="dt-basic" rowspan="1"
                            colspan="1" aria-label="Jam Kerja: activate to sort column ascending">Jam Sehari</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shift as $row)
                            <tr>
                                <td tabindex="0" class="sorting_1 text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">
                                        @if(in_array($loop->iteration,range(1,4)))
                                        @else
                                            <input type="checkbox" class="check-item" name="selectid[]" value="{{$row->id}}" form="form-mul-delete">
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="/admin/shift/{{$row->id}}/edit"
                                            class="btn btn-success btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                            data-container="body" data-placement="top" data-original-title="Edit Waktu Shift"
                                            type="button">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @if(in_array($loop->iteration,range(1,4)))
                                        @else
                                            @if ($row->status == 'Aktif')
                                                <button class="btn btn-danger btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                                    data-container="body" data-placement="top" data-original-title="Nonaktifkan Shift"
                                                    type="button" onclick="toogle_status({{$row->id}},'{{$row->name}}','{{$row->status}}')">
                                                    <i class="pli-close"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-primary btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                                    data-container="body" data-placement="top" data-original-title="Aktifkan Shift"
                                                    type="button" onclick="toogle_status({{$row->id}},'{{$row->name}}','{{$row->status}}')">
                                                    <i class="pli-yes"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                <td class="text-center">{{$row->name}} 
                                    @if ($row->status == 'Non-Aktif')
                                        <div class="label label-danger">Non-Aktif</div>
                                    @endif
                                </td>
                                <td class="text-center">{{$row->start_working_time}}</td>
                                <td class="text-center">{{$row->end_working_time}}</td>
                                <td class="text-center">{{$row->total_hour}} jam</td>
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
                for (j = 3; j < 7; j++ ){
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
    
        function toogle_status(id,name,status){
            var url = "/admin/shift/:id/status".replace(':id', id);
            if (status == 'Aktif') { var word = 'menonaktifkan'}
            else { var word = 'mengaktifkan'}
            Swal.fire({
                width: 600,
                title: 'Konfirmasi Perubahan Status ',
                text: 'Anda yakin ingin ' + word + ' Shift "'+ name + '"?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {id : id, name: name, status:status},
                        success: function(response) {
                            Swal.fire({
                                width: 600,
                                title: 'Berhasil!',
                                text: "Shift dengan nama " + response.name + " saat ini berstatus " + response.status,
                                icon: 'success',
                                timer: 2000
                            });
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        },
                        error: function (jXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: errorThrown,
                            text: "Penggantian status gagal!",
                            icon: 'error',
                            width: 600
                        });
                    }
                    });
                } else {
                    return false;
                }} 
            );
        }
    </script>
@endsection
