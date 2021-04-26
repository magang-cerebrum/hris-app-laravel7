@extends('layouts/templateStaff')
@section('title', 'Presensi')
@section('content-title', 'Presensi')
@section('content-subtitle', 'HRIS PT. Cerebrum Edukanesia Nusantara')
@section('head')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
{{-- Sweetalert 2 --}}
<link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">
{{-- webcam --}}
{{-- <script type="text/javascript" src="{{asset('plugins/webcam/webcam.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/webcam/webcam2.js')}}"></script> --}}
<style type="text/css">
    .container {
        display:inline-block;width:320px;
    }
    #Cam {
        background:rgb(255,255,215);
    }
    #Prev {
        background:rgb(255,255,155);
    }
    #Saved {
        background:rgb(255,255,55);
    }
    @media screen and (min-width: 600px) {
        #panel_head_2 {
            display: none;
        }
    }
    @media screen and (max-width: 600px) {
        #panel_heading {
            height: 65px !important;
        }
        #panel_head_1 {
            display: none;
        }
        #panel_head_2 {
            position: relative;
            top: -20px;
        }
    }
</style>
@endsection

@section('content')
<div class="panel panel-bordered panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Status Absensi</h3>
    </div>
    
    <form action="/staff/presence/search" method="post" id="cari-presensi">
        @csrf
    </form>
    
    <div class="panel-body" style="padding-top: 20px">
            <label class="col-sm-1 control-label">Tanggal:</label>
            <div id="datepicker-input-cari">
                <div class="col-sm-11">
                    <div class="input-group input-daterange">
                        <input type="text" class="form-control @error('start') is-invalid @enderror"
                            placeholder="Tanggal Mulai" name="start" value="{{old('start')}}" autocomplete="off" form="cari-presensi">
                        <span class="input-group-addon">sampai</span>
                        <input type="text" class="form-control @error('end') is-invalid @enderror"
                            placeholder="Tanggal Berakhir" name="end" value="{{old('end')}}" autocomplete="off" form="cari-presensi">
                    </div>
                </div>
            </div>
    </div>
    <div class="panel-footer text-right">
        <button type="button" class="btn btn-warning float-right" id="input-presence" onClick="presensi()">Absensi</button>
        <button type="submit" class="btn btn-pink float-right" form="cari-presensi">Cari Presensi</button>
    </div>
</div>

<div id="panel-output"></div>

@endsection

@section('script')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
{{-- Sweetalert 2 --}}
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#cari-presensi').on('submit', function (event) {
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
                        title: errorThrown,
                        text: "Mohon isi dulu form dengan benar...",
                        icon: 'error',
                    });
                }
            });
        });
        $('#datepicker-input-cari .input-daterange').datepicker({
            format: 'yyyy/mm/dd',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true,
            endDate: '0d'
        });
        $('#input-presence').on('click',function () {
            var presence = {!!json_encode($bool_presence) !!}
            var check = {!!json_encode($bool_schedule) !!}
            if (check !== null){
                if (check != 'Off' && check != 'Cuti' && check != 'Sakit') {
                    if (presence != 2) {
                        window.location.href = '/staff/presence/take';
                    } else {
                        Swal.fire({
                            width: 600,
                            title: 'Error!',
                            text: "Anda sudah mengambil absensi hari ini!",
                            icon: 'error'
                        });
                    }
                } else {
                    Swal.fire({
                        width: 600,
                        title: 'Error!',
                        text: "Anda Tidak Perlu Melakukan Absensi Hari Ini Karena Anda Sedang " + check + " !",
                        icon: 'error'
                    }); 
                }
                
            } else {
                Swal.fire({
                    width: 600,
                    title: 'Error!',
                    text: "Anda belum memiliki jadwal untuk absensi! Silahkan hubungi Chief untuk meminta jadwal!",
                    icon: 'error'
                });
            }
        });
    });
    </script>
@endsection