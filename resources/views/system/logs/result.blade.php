@extends('layouts/templateAdmin')
@section('title','Sistem')
@section('content-title','Sistem / Log Aplikasi HRIS')
@section('content-subtitle','HRIS '.$company_name)

@section('head')
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
    <style>
        @media screen and (max-width: 600px) {
            #pickadate {
                margin-top: 10px;
            }
            #show_all {
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-danger panel-bordered">
        <div class="panel-heading">
            <h3 class="panel-title">Log Aplikasi HRIS</h3>
        </div>
        
        <form action="{{url('/admin/log/search')}}" method="get" id="form_search"></form>
        <form action="/admin/log" method="post" id="form-mul-delete">
            @csrf
            @method('delete')
        </form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="row mar-btm">
                <div class="col-sm-7">   
                    <button id="btn-delete" class="btn btn-danger btn-labeled add-tooltip" type="submit"
                        data-toggle="tooltip" data-container="body" data-placement="top"
                        data-original-title="Hapus Data" onclick="submit_delete()" form="form-mul-delete">
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
                                <button class="btn btn-mint" type="button" style="z-index: 2">
                                    <i class="fa fa-calendar"></i></button>
                            </span>
                            <input type="text" name="query" placeholder="Cari (bulan/aktivitas)"
                                class="form-control" autocomplete="off" form="form_search">
                            <span class="input-group-btn">
                                <button class="btn btn-mint" type="submit" form="form_search" id="btn-search"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table id="masterdata-log"
                        class="table table-striped table-bordered no-footer dtr-inline collapsed" role="grid"
                        aria-describedby="demo-dt-basic_info" style="width: 100%;" width="100%" cellspacing="0">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="demo-dt-basic"
                                    rowspan="1" colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending">
                                    No</th>
                                <th class="text-center">
                                    All <input type="checkbox" id="check-all">
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending">Aktivitas</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="demo-dt-basic" rowspan="1"
                                    colspan="1" aria-label="Position: activate to sort column ascending">Waktu Tercatat
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr>
                                <td tabindex="0" class="sorting_1 text-center">{{(($data->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                <td class="text-center">
                                    <input type="checkbox" name="selectid[]" value="{{$row->id}}" class="check-item" form="form-mul-delete">
                                </td>
                                <td class="text-center">{{$row->description}}</td>
                                <td class="text-center">{{indonesian_date($row->created_at,true)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">{{ $data->withQueryString()->links() }}</div>
            </div>
            <div class="row mar-btm">
                <div class="col-sm-12 text-right">
                    <a href="{{url('/admin/log')}}" class="btn btn-warning btn-labeled text-center">Tampilkan Semua Log</a>
                </div>
            </div>
        </div>
    </div>
@endsection

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
                endDate: '0',
            });
            $('#btn-search').on('click',function () {
                $('.datepicker').hide();
            });
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
