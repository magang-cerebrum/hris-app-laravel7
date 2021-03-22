@extends('layouts/templateAdmin')
@section('title', 'Master Data / Hari Libur')
@section('content-title', 'Master Data / Daftar Hari Libur')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')
@section('head')
{{-- Sweetalert 2 --}}
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
<!--Bootstrap Datepicker [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
@endsection
@section('content')
<div class="panel  panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Daftar Hari Libur</h3>
    </div>
    <div class="panel-body">
        <div class="row mar-btm" style="margin-top:-60px">
            <div class="col-sm-4">
                <form action="{{url('/admin/holiday/search')}}" method="get"
                    style="position: relative;right:-710px;bottom:-48px">
                    <div id="pickadate">
                        <div class="input-group date">
                            <span class="input-group-btn">
                                <button class="btn btn-mint" type="button" style="z-index: 2"><i
                                        class="fa fa-calendar"></i></button>
                            </span>
                            <input type="text" name="query" placeholder="Cari Hari Libur (bulan / nama libur)"
                                class="form-control" autocomplete="off">
                            <span class="input-group-btn">
                                <button class="btn btn-mint" type="submit"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
        <div class="table-responsive">
            <table id="masterdata-holiday" class="table table-striped table-bordered no-footer dtr-inline collapsed"
                style="width: 100%;" width="100%">
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
                        <td class="sorting text-center" tabindex="0">
                            {{($data->currentPage() * 10) - 10 + $loop->iteration}}</td>
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
            <div class="text-center">{{ $data->withQueryString()->links() }}</div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-right">
                <a href="{{url('/admin/holiday')}}" class="btn btn-warning btn-labeled text-center">Tampilkan Semua Hari Libur</a>
            </div>
        </div>
    </div>
    <!--===================================================-->
    <!-- End Striped Table -->
</div>
@endsection
@section('script')
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<!--Bootstrap Datepicker [ OPTIONAL ]-->
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#pickadate .input-group.date').datepicker({
            format: 'mm/yyyy',
            autoclose: true,
            minViewMode: 'months',
            maxViewMode: 'years',
            startView: 'months',
            orientation: 'bottom',
            forceParse: false,
        });
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
</script>
@endsection
