@extends('layouts/templateAdmin')
@section('content-title','Master Data / Cari Tipe Potongan dan Tunjangan Gaji')
@section('content-subtitle','HRIS '.$company_name)
@section('title','Tipe Potongan dan Tunjangan Gaji')

@section('head')
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @media screen and (max-width: 600px) {
            #btn-delete {
                margin: 10px 0;
            }
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Hasil Pencarian Tipe Potongan dan Tunjangan Gaji : "{{$search}}"</h3>
        </div>
        
        <form action="{{url('/admin/cuts-allowances/search')}}" method="get" id="result"></form>
        <form action="{{url('/admin/cuts-allowances')}}" method="POST" id="form-mul-delete">
            @csrf
            @method('delete')
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="row mar-btm">
                <div class="col-sm-8">
                    <a href="{{url('/admin/cuts-allowances/add')}}" class="btn btn-primary btn-labeled add-tooltip" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Tambah Tipe Potongan / Tunjangan Gaji Baru">
                        <i class="btn-label fa fa-plus"></i>
                        Tambah Tipe Potongan / Tunjangan Gaji Baru
                    </a>
                    <button id="btn-delete" class="btn btn-danger btn-labeled add-tooltip" type="submit" data-toggle="tooltip"
                        data-container="body" data-placement="top" data-original-title="Hapus Data" onclick="submit_delete()" form="form-mul-delete">
                        <i class="btn-label fa fa-trash"></i>
                        Hapus Data Terpilih
                    </button>
                    @error('selectid') <span style="display:inline;" class="text-danger invalid-feedback mt-3">
                        Maaf, tidak ada data terpilih untuk dihapus.</span> @enderror
                </div>
                <div class="col-sm-4">
                    <div id="pickadate">
                        <div class="input-group date">
                            <input type="text" name="query" placeholder="Cari (nama/tipe/kategori)"
                                class="form-control" autocomplete="off" form="result">
                            <span class="input-group-btn">
                                <button class="btn btn-mint" type="submit" form="result"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="masterdata-cuts-allowances"
                    class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" style="width: 5%">No</th>
                            <th class="text-center" style="width: 6%">
                                All <input type="checkbox" id="check-all">
                            </th>
                            <th class="sorting text-center" style="width: 10%">Aksi</th>
                            <th class="sorting text-center" style="width: 29%">Nama Potongan</th>
                            <th class="sorting text-center" style="width: 20%">Tipe</th>
                            <th class="sorting text-center" style="width: 20%">Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cutallowancetype as $row)
                            <tr>
                                <td tabindex="0" class="sorting_1 text-center">{{($cutallowancetype->currentPage() * 10) - 10 + $loop->iteration}}</td>
                                <td class="text-center">
                                    <input type="checkbox" class="check-item" name="selectid[]" value="{{$row->id}}" form="form-mul-delete">
                                </td>
                                <td class="text-center">
                                    <a href="{{url("/admin/cuts-allowances/$row->id/edit")}}"
                                        class="btn btn-success btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                        data-container="body" data-placement="top" data-original-title="Edit Tipe {{$row->category == 'Potongan' ? 'Potongan' : 'Tunjangan'}} Gaji"
                                        type="button">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @if ($row->status == 'Aktif')
                                        <button class="btn btn-danger btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                            data-container="body" data-placement="top" data-original-title="Nonaktifkan {{$row->category}}"
                                            type="button" onclick="toogle_status({{$row->id}},'{{$row->name}}','{{$row->status}}','{{$row->category}}')">
                                            <i class="pli-close"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-primary btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                            data-container="body" data-placement="top" data-original-title="Aktifkan {{$row->category}}"
                                            type="button" onclick="toogle_status({{$row->id}},'{{$row->name}}','{{$row->status}}','{{$row->category}}')">
                                            <i class="pli-yes"></i>
                                        </button>
                                    @endif
                                </td>
                                <td class="text-center">{{$row->name}}
                                    @if ($row->status == 'Non-Aktif')
                                        <div class="label label-danger">Non-Aktif</div>
                                    @endif
                                </td>
                                <td class="text-center">{{$row->type}}</td>
                                <td class="text-center">{{$row->category}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">{{ $cutallowancetype->withQueryString()->links() }}</div>
            <div class="row">
                <div class="col-sm-12 text-right">
                    <a href="{{url('/admin/cuts-allowances')}}" class="btn btn-warning btn-labeled text-center">Tampilkan Semua Data</a>
                </div>
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
        function submit_delete(){
            event.preventDefault();
            var check = document.querySelector('.check-item:checked');
            if (check != null){
                Swal.fire({
                    width:600,
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
        function toogle_status(id,name,status,category){
            var url = "/admin/cuts-allowances/:id/status".replace(':id', id);
            if (status == 'Aktif') { var word = 'menonaktifkan'}
            else { var word = 'mengaktifkan'}
            Swal.fire({
                width: 600,
                title: 'Konfirmasi Perubahan Status ',
                text: 'Anda yakin ingin ' + word + ' Tipe '+ category + '  "' + name + '"?',
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
                        data: {id : id, name: name, status:status, category:category},
                        success: function(response) {
                            Swal.fire({
                                width: 600,
                                title: 'Berhasil!',
                                text: "Tipe " + response.category + " dengan nama " + response.name + " saat ini berstatus " + response.status,
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
