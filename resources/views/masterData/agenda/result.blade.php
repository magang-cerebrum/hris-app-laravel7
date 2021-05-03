@extends('layouts/templateAdmin')
@section('content-title','Master Data / Agenda Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Agenda Kerja')

@section('head')
    <link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @media screen and (max-width: 600px) {
            #btn-delete {
                margin-top: 10px;
                margin-bottom: 10px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Hasil Pencarian Agenda Kerja : "{{$search}}"</h3>
        </div>

        <form action="{{url('/admin/agenda/search')}}" method="get" id="search_agenda"></form>
        <form action="{{url('/admin/agenda')}}" method="POST" id="form-mul-delete">
            @csrf
            @method('delete')
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="row mar-btm">
                <div class="col-sm-8">
                    <a href="{{url('/admin/agenda/add')}}" class="btn btn-primary btn-labeled add-tooltip" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Tambah Tipe Potongan / Tunjangan Gaji Baru">
                        <i class="btn-label fa fa-plus"></i>
                        Tambah Agenda Kerja Baru
                    </a>
                    <button id="btn-delete" class="btn btn-danger btn-labeled add-tooltip" type="submit" data-toggle="tooltip" form="form-mul-delete"
                        data-container="body" data-placement="top" data-original-title="Hapus Data" onclick="submit_delete()">
                        <i class="btn-label fa fa-trash"></i>
                        Hapus Data Terpilih
                    </button>
                    @error('selectid') <span style="display:inline;" class="text-danger invalid-feedback mt-3">
                        Maaf, tidak ada data terpilih untuk dihapus.</span> @enderror
                </div>
                <div class="col-sm-4">
                    <div id="pickadate">
                        <div class="input-group date">
                            <span class="input-group-btn">
                                <button class="btn btn-mint" type="button" style="z-index: 2"><i class="fa fa-calendar"></i></button>
                            </span>
                            <input type="text" name="query" placeholder="Cari (nama/deskripsi/tanggal kegiatan)"
                                class="form-control" autocomplete="off" form="search_agenda">
                            <span class="input-group-btn">
                                <button class="btn btn-mint" id="btn-search" type="submit" form="search_agenda"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="masterdata-agenda"
                    class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
                    aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-center" style="width: 5%">No</th>
                            <th class="text-center" style="width: 6%">
                                All <input type="checkbox" id="check-all">
                            </th>
                            <th class="sorting text-center" style="width: 5%">Aksi</th>
                            <th class="sorting text-center" style="width: 18%">Nama Kegiatan</th>
                            <th class="sorting text-center" style="width: 28%">Deskripsi Kegiatan</th>
                            <th class="sorting text-center" style="width: 14%">Waktu Mulai</th>
                            <th class="sorting text-center" style="width: 14%">Waktu Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agenda as $row)
                            <tr>
                                <td tabindex="0" class="sorting_1 text-center">{{($agenda->currentPage() * 10) - 10 + $loop->iteration}}</td>
                                <td class="text-center">
                                    <input type="checkbox" class="check-item" name="selectid[]" value="{{$row->id}}" form="form-mul-delete">
                                </td>
                                <td class="text-center">
                                    <a href="{{url("/admin/agenda/$row->id/edit")}}"
                                        class="btn btn-success btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                        data-container="body" data-placement="top" data-original-title="Edit Kegiatan"
                                        type="button">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    
                                </td>
                                <td class="text-center">{{ $row->title }}</td>
                                <td class="text-center">{{ $row->description }}</td>
                                <td class="text-center">{{ indonesian_date($row->start_event,true)}}</td>
                                <td class="text-center">{{ indonesian_date($row->end_event,true)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">{{ $agenda->withQueryString()->links() }}</div>
            <div class="row">
                <div class="col-sm-12 text-right">
                    <a href="{{url('/admin/agenda')}}" class="btn btn-warning btn-labeled text-center">Tampilkan Semua Kegiatan</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#check-all").click(function () {
                if ($(this).is(":checked"))
                    $(".check-item").prop("checked",true);
                else
                    $(".check-item").prop("checked",false);
            });
            $('#pickadate .input-group.date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                orientation: 'bottom',
                forceParse: false,
            });
            $('#btn-search').on('click',function () {
                $('.datepicker').hide();
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
    </script>
@endsection
