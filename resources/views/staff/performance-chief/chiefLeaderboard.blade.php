@extends('layouts/templateStaff')
@section('title','Performa Divisi')
@section('content-title','Performa Divisi / Leaderboard')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="panel panel-bordered panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">LeaderBoard Performa</h3>
        </div>
        <div class="panel-body">
            <div class="row mar-btm" >
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <form action="{{url('/staff/performance/search')}}" method="POST" id="cari-performa">
                        @csrf
                        <div id="pickadate">
                            <div class="input-group date">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" style="z-index: 2"><i
                                            class="fa fa-calendar"></i></button>
                                </span>
                                <input type="text" name="query" placeholder="Cari Leaderboard" id="query"
                                    class="form-control" autocomplete="off" readonly>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" id="btn-search" type="submit"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
    </div>
    @if($dataCM->isEmpty())
    <p class="h4 text-uppercase text-bold text-center" id="data-exist" hidden >Data Pada Periode ini Sudah Diinput</p>
    @endif
    <div id="panel-output"></div>
@endsection


@section('script')
    <script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
    <script>
          setTimeout(function(){
            
            var date = new Date()
            var month =  ("0" + (date.getMonth() + 1)).slice(-2)
            var year = date.getFullYear()
            periode = month + '/' +year
            document.getElementById('query').value = periode
            console.log(periode)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                    });
            $.ajax({
                    url: '/staff/performance/search',
                    type: "POST",
                    data: {query:periode},
                    success: function (data) {
                        // console.log(data)
                        $("#panel-output").html(data);
                    },
                    error: function (jXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error!',
                            text: "Tidak ada data Performa untuk bulan dan tahun terpilih",
                            icon: 'error',
                            width: 600
                        }).then(() => {
                            Swal.fire({
                                width: 600,
                                title: 'Apakah anda ingin menambahkan nilai Performa?',
                                icon: 'info',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya',
                                cancelButtonText: 'Tidak'
                            }).then((result) => {
                                if (result.value == true) {
                                    window.location.href = "/staff/achievement/scoring";
                                } else {
                                    return false;
                                }} 
                            );
                        });
                    }
                });
        },1000)   
            
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
            $('#cari-performa').on('submit', function (event) {
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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function (data) {
                        $("#panel-output").html(data);
                    },
                    error: function (jXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: errorThrown,
                            text: "Tidak ada data performa untuk bulan dan tahun terpilih",
                            icon: 'error',
                            width: 600
                        }).then(() => {
                            Swal.fire({
                                width: 600,
                                title: 'Apakah anda ingin menambahkan nilai performa divisi?',
                                icon: 'info',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya',
                                cancelButtonText: 'Tidak'
                            }).then((result) => {
                                if (result.value == true) {
                                    window.location.href = "/staff/performance/scoring";
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