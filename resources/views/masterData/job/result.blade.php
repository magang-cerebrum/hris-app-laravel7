@extends('layouts/templateAdmin')
@section('title', 'Rekruitasi')
@section('content-title', 'Rekruitasi / Lowongan Tersedia')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')
@section('head')
{{-- Sweetalert 2 --}}
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Daftar Lowongan Tersedia</h3>
    </div>
    <div class="panel-body">
        <div class="row mar-btm" style="margin-top:-60px">
            <div class="col-sm-4">
                <form action="{{url('/admin/job/search')}}" method="get"
                    style="position: relative;right:-710px;bottom:-48px">
                    <div class="input-group">
                        <input type="text" name="query" placeholder="Cari Lowongan (Posisi / Deskripsi / Persyaratan)"
                            class="form-control" autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-mint" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mar-btm">
            <div class="col-sm-2 mar-rgt">
                <a href="{{url('/admin/job/add')}}" class="btn btn-primary btn-labeled add-tooltip"
                    data-toggle="tooltip" data-container="body" data-placement="top"
                    data-original-title="Tambah Lowongan Baru">
                    <i class="btn-label fa fa-plus"></i>
                    Tambah Lowongan
                </a>
            </div>
            @if (count($dataJob) == 0)
        </div>
        <div class="text-center">
            <h1 class="h3">Data Kosong / Data Tidak Ditemukan</h1>
            <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 250px">
        </div>
        @else
        <div class="col-sm-2">
            <form action="{{ url('/admin/job/delete')}}" method="POST" style="display: inline" id="form-mul-delete">
                @method('delete')
                @csrf
                <button id="btn-delete" class="btn btn-danger btn-labeled add-tooltip" type="submit"
                    data-toggle="tooltip" data-container="body" data-placement="top"
                    data-original-title="Hapus Lowongan" onclick="submit_delete()">
                    <i class="btn-label fa fa-trash"></i>
                    Hapus Data Terpilih
                </button>
        </div>
    </div>
        <div class="table-responsive">
            <table id="masterdata-job" class="table table-striped table-bordered no-footer dtr-inline collapsed"
                role="grid" aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                <thead>
                    <tr role="row">
                        <th class="sorting text-center" tabindex="0" style="width: 5%">No</th>
                        <th class="sorting text-center" tabindex="0" style="width: 6%">All <input type="checkbox"
                                id="master">
                        </th>
                        <th class="sorting text-center" tabindex="0">Nama Posisi</th>
                        <th class="sorting text-center" tabindex="0">Deskripsi</th>
                        <th class="sorting text-center" tabindex="0">Persyaratan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataJob as $item)
                    <tr>
                        <td class="sorting text-center" tabindex="0">{{($dataJob->currentPage() * 5) - 5 + $loop->iteration}}</td>
                        <td class="text-center"><input type="checkbox" class="sub_chk" name="check[]"
                                value="{{$item->id}}">
                        </td>
                        <td class="text-center">{{$item->name}}</td>
                        <td class="text-center">{{$item->descript}}</td>
                        <td>{!!$item->required!!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </form>
        </div>
        <div class="text-center">{{ $dataJob->withQueryString()->links() }}</div>
        <div class="row">
            <div class="col-sm-12 text-right">
                <a href="{{url('/admin/salary-cut')}}" class="btn btn-warning btn-labeled text-center">Tampilkan Semua Potongan Gaji</a>
            </div>
        </div>
        @endif
    </div>
    <!--===================================================-->
    <!-- End Striped Table -->
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
