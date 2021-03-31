@extends('layouts/templateAdmin')
@section('content-title','Data Staff / Potongan Gaji')
@section('title','Potongan Gaji')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('head')
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
@endsection
@section('content')
<div class="panel panel-danger panel-bordered">
    <div class="panel-heading">
        <h3 class="panel-title">Daftar Potongan Gaji</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="row mar-btm" style="margin-top:-60px">
                    <div class="col-sm-4">
                        <form action="{{url('/admin/salary-cut/search')}}" method="get"
                            style="position: relative;right:-710px;bottom:-48px">
                            <div id="pickadate">
                                <div class="input-group date">
                                    <span class="input-group-btn">
                                        <button class="btn btn-mint" type="button" style="z-index: 2">
                                            <i class="fa fa-calendar"></i></button>
                                    </span>
                                    <input type="text" name="query" placeholder="Cari (bulan/staff/potongan/nominal)"
                                        class="form-control" autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn btn-mint" type="submit"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mar-btm">
                    <div class="col-sm-8">
                        <a href="{{url('/admin/salary-cut/add')}}" class="btn btn-primary btn-labeled add-tooltip" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Tambah Potongan Gaji Baru">
                            <i class="btn-label fa fa-plus"></i>
                            Tambah Potongan Gaji Baru
                        </a>
                    
                        <form action="{{url('/admin/salary-cut')}}" method="POST" id="form-mul-delete" style="display:inline;">
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
                </div>
                <div class="table-responsive">
                    <table id="masterdata-salary-cut"
                        class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
                        aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc text-center" style="width: 5%">No</th>
                                <th class="text-center" style="width: 6%">
                                    All <input type="checkbox" id="check-all">
                                </th>
                                <th class="sorting text-center"style="width: 10%">Aksi</th>
                                <th class="sorting text-center">Nama Potongan</th>
                                <th class="sorting text-center">Nominal</th>
                                <th class="sorting text-center" style="width: 10%">Tipe</th>
                                <th class="sorting text-center" style="width: 15%">Periode</th>
                                <th class="sorting text-center">Staff Terkait</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salarycut as $row)
                            <tr>
                                <td tabindex="0" class="sorting_1 text-center"> {{($salarycut->currentPage() * 10) - 10 + $loop->iteration}}</td>
                                <td class="text-center">
                                    <input type="checkbox" class="check-item" name="selectid[]" value="{{$row->id}}">
                                </td>
                                <td class="text-center">
                                    <a href="{{url("/admin/salary-cut/$row->id/edit")}}"
                                        class="btn btn-success btn-icon btn-circle add-tooltip" data-toggle="tooltip"
                                        data-container="body" data-placement="top" data-original-title="Edit Potongan Gaji"
                                        type="button">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td class="text-center">{{$row->information}}</td>
                                <td class="text-center">{{rupiah($row->nominal)}}</td>
                                <td class="text-center">{{$row->type}}</td>
                                <td class="text-center">{{$row->month}} - {{$row->year}}</td>
                                <td class="text-center">{{$row->user_name ? $row->user_name : '-'}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </form>
                <div class="text-center">{{ $salarycut->links() }}</div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<!--Bootstrap Datepicker [ OPTIONAL ]-->
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
<script>
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

</script>
@endsection
@endsection
