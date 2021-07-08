@extends('layouts/templateAdmin')
@section('title', 'Rekruitasi')
@section('content-title', 'Rekruitasi / Daftar Rekruitasi')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <style>
        @media screen and (max-width: 600px) {
            #btn_search{
                margin-bottom: 10px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Daftar Rekruitasi</h3>
        </div>

        <form action="{{url('/admin/recruitment/search')}}" method="get" id="search"></form>
        <form action="{{ url('/admin/recruitment/delete')}}" method="POST" id="form-mul-delete">
            @method('delete')
            @csrf
        </form>

        <div class="panel-body" style="padding-top: 20px">
            @if (count($data) == 0)
                <div class="text-center">
                    <h1 class="h3">Data Kosong / Data Tidak Ditemukan</h1>
                    <img src="{{ asset('img/'.$company_logo)}}" style="width: 250px">
                </div>
            @else
                <div class="row" id="btn_search">
                    <div class="col-sm-8">
                        <button id="btn-delete" class="btn btn-danger btn-labeled add-tooltip" style="margin-bottom: 10px"
                            type="submit" data-toggle="tooltip" data-container="body" data-placement="top"
                            data-original-title="Hapus Data Pelamar" onclick="submit_delete()" form="form-mul-delete">
                            <i class="btn-label fa fa-trash"></i>
                            Hapus Data Terpilih
                        </button>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" name="query" placeholder="Cari Pelamar (Nama / Posisi / Pendidikan)"
                                class="form-control" autocomplete="off" form="search">
                            <span class="input-group-btn">
                                <button class="btn btn-mint" type="submit" form="search"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="masterdata-recruitment" class="table table-striped table-bordered no-footer dtr-inline collapsed"
                        role="grid" aria-describedby="demo-dt-basic_info" style="width: 98%;" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="sorting text-center" tabindex="0" style="width: 4%">No</th>
                                <th class="sorting text-center" tabindex="0" style="width: 5%">All <input type="checkbox"  id="master"></th>
                                <th class="sorting text-center" tabindex="0">Nama Lengkap</th>
                                <th class="sorting text-center" tabindex="0">Tempat Tanggal Lahir</th>
                                <th class="sorting text-center" tabindex="0">Domisili</th>
                                <th class="sorting text-center" tabindex="0">No Telfon</th>
                                <th class="sorting text-center" tabindex="0">Email</th>
                                <th class="sorting text-center" tabindex="0">Jenis Kelamin</th>
                                <th class="sorting text-center" tabindex="0">Pendidikan Terakhir</th>
                                <th class="sorting text-center" tabindex="0">Posisi</th>
                                <th class="sorting text-center" tabindex="0" style="width: 10%">File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr class="sorting text-center" tabindex="0">
                                    <td class="sorting text-center" tabindex="0">{{$data->currentpage() * 10 - 10 + $loop->iteration}}
                                    </td>
                                    <td class="text-center"><input type="checkbox" class="sub_chk" name="check[]"
                                        value="{{$item->id}}" form="form-mul-delete"></td>
                                    <td class="text-center">{{$item->name}}</td>
                                    <td class="text-center">{{$item->dob}}</td>
                                    <td class="text-center">{{$item->address}}</td>
                                    <td class="text-center">{{$item->phone_number}}</td>
                                    <td class="text-center">{{$item->email}}</td>
                                    <td class="text-center">{{$item->gender}}</td>
                                    <td class="text-center">{{$item->last_education}}</td>
                                    <td class="text-center">{{$item->position}}</td>
                                    <td class="text-center">
                                        <a href="{{ asset('/upload_recruitment/cv_upload/'.$item->file_cv)}}" target="blank">
                                            <button type="button" class="btn btn-pink btn-icon btn-circle add-tooltip"
                                                data-toggle="tooltip" data-container="body" data-placement="top"
                                                data-original-title="Buka CV">
                                                <i class="fa fa-file icon-lg"></i>
                                            </button>
                                        </a>
                                        <a href="{{ asset('/upload_recruitment/portofolio_upload/'.$item->file_portofolio)}}"
                                            target="blank">
                                            <button type="button" class="btn btn-pink btn-icon btn-circle add-tooltip"
                                                data-toggle="tooltip" data-container="body" data-placement="top"
                                                data-original-title="Buka Portofolio">
                                                <i class="fa fa-file-pdf-o"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">{{ $data->links() }}</div>
                <div class="col-sm-12 text-right">
                    <a href="{{url('/admin/recruitment')}}" class="btn btn-warning btn-labeled text-center">Tampilkan Semua Pelamar</a>
                </div>
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
    </script>
@endsection
