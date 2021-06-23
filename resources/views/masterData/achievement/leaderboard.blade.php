@extends('layouts/templateAdmin')
@section('title','Pencapaian')
@section('content-title','Pencapaian / Leaderboard')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="panel panel-bordered panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">LeaderBoard Achievement</h3>
        </div>

        <form action="{{url('/admin/achievement/search')}}" method="POST" id="cari-achievement">@csrf</form>

        <div class="panel-body" style="padding-top: 20px">
            <div class="row mar-btm" >
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <div id="pickadate">
                        <div class="input-group date">
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="button" style="z-index: 2"><i
                                        class="fa fa-calendar"></i></button>
                            </span>
                            <input type="text" name="query" placeholder="Cari Leaderboard" form="cari-achievement" id="query"
                                class="form-control" autocomplete="off" readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-danger" id="btn-search" type="submit" form="cari-achievement"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="panel-output"></div>
@endsection


@section('script')
    <script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
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
            $('#btn-search').on('click',function () {
                $('.datepicker').hide();
            });
            $('#cari-achievement').on('submit', function (event) {
                if ($('#query').val() == '') {
                    console.log($('#query').val())
                    Swal.fire({
                        title: 'Error!',
                        text: "Mohon pilih periode terlebih dahulu!",
                        icon: 'error',
                        width: 600
                    });
                    return false;
                }
                event.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function (data) {
                        $("#panel-output").html(data);
                    },
                    error: function (jXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error!',
                            text: "Tidak ada data achievement untuk bulan dan tahun terpilih",
                            icon: 'error',
                            width: 600
                        }).then(() => {
                            Swal.fire({
                                width: 600,
                                title: 'Apakah anda ingin menambahkan nilai achievement?',
                                icon: 'info',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya',
                                cancelButtonText: 'Tidak'
                            }).then((result) => {
                                if (result.value == true) {
                                    window.location.href = "/admin/achievement/scoring";
                                } else {
                                    return false;
                                }} 
                            );
                        });
                    }
                });
            });
        });
    </script>
@endsection