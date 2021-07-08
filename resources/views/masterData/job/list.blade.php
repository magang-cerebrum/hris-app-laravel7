@extends('layouts/templateAdmin')
@section('title', 'Rekruitasi')
@section('content-title', 'Rekruitasi / Lowongan Tersedia')
@section('content-subtitle','HRIS '.$company_name)

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
        @media screen and (max-width: 600px){
            #btn-delete {
                margin-bottom: 10px;
                margin-top: 10px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Daftar Lowongan Tersedia</h3>
        </div>
        
        <form action="{{url('/admin/job/search')}}" method="get" id="search"></form>
        <form action="{{ url('/admin/job/delete')}}" method="POST" id="form-mul-delete">
            @method('delete')
            @csrf
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="row mar-btm">
                <div class="col-sm-8">
                    <a href="{{url('/admin/job/add')}}" class="btn btn-primary btn-labeled add-tooltip"
                        data-toggle="tooltip" data-container="body" data-placement="top"
                        data-original-title="Tambah Lowongan Baru">
                        <i class="btn-label fa fa-plus"></i>
                        Tambah Lowongan
                    </a>
                    @if (count($dataJob) != 0)
                        <button id="btn-delete" class="btn btn-danger btn-labeled add-tooltip" type="submit"
                            data-toggle="tooltip" data-container="body" data-placement="top"
                            data-original-title="Hapus Lowongan" onclick="submit_delete()" form="form-mul-delete">
                            <i class="btn-label fa fa-trash"></i>
                            Hapus Data Terpilih
                        </button>
                    @else
                        <div id="btn-delete"></div>
                    @endif
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" name="query" placeholder="Cari Lowongan (Posisi / Deskripsi / Persyaratan)"
                            class="form-control" autocomplete="off" form="search">
                        <span class="input-group-btn">
                            <button class="btn btn-mint" type="submit" form="search"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            @if (count($dataJob) == 0)
                <div class="text-center">
                    <h1 class="h3">Data Kosong / Data Tidak Ditemukan</h1>
                    <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 250px">
                </div>
            @else
                <div class="table-responsive">
                    <table id="masterdata-job" class="table table-striped table-bordered no-footer dtr-inline collapsed"
                        role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                        <thead>
                            <tr role="row">
                                <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                                <th class="sorting text-center" tabindex="0" style="width: 6%">All <input type="checkbox" id="master"></th>
                                <th class="sorting text-center" tabindex="0" style="width: 10%">Aksi</th>
                                <th class="sorting text-center" tabindex="0">Nama Posisi</th>
                                <th class="sorting text-center" tabindex="0">Deskripsi</th>
                                <th class="sorting text-center" tabindex="0">Persyaratan</th>
                                <th class="sorting text-center" tabindex="0">Status Lowongan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataJob as $item)
                                <tr>
                                    <td class="sorting text-center" tabindex="0">{{($dataJob->currentPage() * 5) - 5 + $loop->iteration}}</td>
                                    <td class="text-center"><input type="checkbox" class="sub_chk" name="check[]"
                                        value="{{$item->id}}" form="form-mul-delete">
                                    </td>
                                    <td class="text-center">
                                        <a href="/admin/job/{{$item->id}}/edit"
                                            class="btn btn-success btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                            data-container="body" data-placement="top" data-original-title="Edit Lowongan"
                                            type="button">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @if ($item->status == 'Aktif')
                                            <button class="btn btn-danger btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                                data-container="body" data-placement="top" data-original-title="Nonaktifkan Lowongan"
                                                type="button" onclick="toogle_status({{$item->id}},'{{$item->name}}','{{$item->status}}')">
                                                <i class="pli-close"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-primary btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                                data-container="body" data-placement="top" data-original-title="Aktifkan Lowongan"
                                                type="button" onclick="toogle_status({{$item->id}},'{{$item->name}}','{{$item->status}}')">
                                                <i class="pli-yes"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td class="text-center">{{$item->name}}</td>
                                    <td class="text-center">{{$item->descript}}</td>
                                    <td>{!!$item->required!!}</td>
                                    <td class="text-center">{{$item->status}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">{{ $dataJob->links() }}</div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#master').on('click', function (e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked', false);
                }
            });
        });

        // Sweetalert 2
        function submit_delete() {
            event.preventDefault();
            var check = document.querySelector('.sub_chk:checked');
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

        function toogle_status(id,name,status){
            var url = "/admin/job/:id/status".replace(':id', id);
            if (status == 'Aktif') { var word = 'menonaktifkan'}
            else { var word = 'mengaktifkan'}
            Swal.fire({
                width: 600,
                title: 'Konfirmasi Perubahan Status ',
                text: 'Anda yakin ingin ' + word + ' Lowongan "'+ name + '"?',
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
                                text: "Lowongan dengan nama " + response.name + " saat ini berstatus " + response.status,
                                icon: 'success',
                                timer: 2000
                            });
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
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
