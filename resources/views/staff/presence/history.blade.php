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
</style>
@endsection

@section('content')
<div class="panel panel-bordered panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Status Absensi</h3>
    </div>
    <div class="panel-body">
        <form action="/staff/presence/search" method="post" id="cari-presensi">
            @csrf
            <label class="col-sm-1 control-label">Tanggal:</label>
            <div id="datepicker-input-cari">
                <div class="col-sm-11">
                    <div class="input-group input-daterange">
                        <input type="text" class="form-control @error('start') is-invalid @enderror"
                            placeholder="Tanggal Mulai" name="start" value="{{old('start')}}" autocomplete="off">
                        <span class="input-group-addon">sampai</span>
                        <input type="text" class="form-control @error('end') is-invalid @enderror"
                            placeholder="Tanggal Berakhir" name="end" value="{{old('end')}}" autocomplete="off">
                    </div>
                </div>
            </div>
    </div>
    <div class="panel-footer text-right">
        <button type="button" class="btn btn-warning float-right" id="input-presence" onClick="presensi()">Absensi</button>
        <button type="submit" class="btn btn-pink float-right">Cari Presensi</button>
    </div>
    </form>
</div>

<div id="panel-output"></div>

@endsection

@section('script')
<!--Bootstrap Timepicker [ OPTIONAL ]-->
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
{{-- Sweetalert 2 --}}
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<script>
    function presensi() {
        var script = document.createElement('script');
        script.type = "text/javascript";
        script.src = "../plugins/webcam/webcam.js";
        var script2 = document.createElement('script');
        script2.type = "text/javascript";
        script2.src = "../plugins/webcam/webcam2.js";

        document.head.appendChild(script);
        document.head.appendChild(script2);
        
        var input = document.createElement('input');
        input.type = "button";
        input.value = "Snap It";
        input.onClick = "take_snapshot()";
        console.log(input);
    }
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
            var check = {!!json_encode($bool_schedule) !!}
            if (check !== null){
                window.location.href = '/staff/presence/take';
                
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

    function getLocation() {
        // Check whether browser supports Geolocation API or not
        if (navigator.geolocation) { // Supported
            // To add PositionOptions
            navigator.geolocation.getCurrentPosition(getPosition);
        } else { // Not supported
            alert("Oops! This browser does not support HTML Geolocation.");
        }
    }
    function getPosition(position) { 
        var position_latitude_1 = -7.055286522681598;
        var position_longitude_1 = 107.56162952882028;
        var position_latitude_2 = position.coords.latitude;
        var position_longitude_2 = position.coords.longitude;
        var jarak = getDistanceFromLatLonInKm(position_latitude_1,position_longitude_1,position_latitude_2,position_longitude_2)
        console.log(jarak);
        if (jarak <= 10000000 ) {
            $('#take_presence').submit();
        }
    }
    
    function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
        var R = 6371; // Radius of the earth in km
        var dLat = deg2rad(lat2-lat1);  // deg2rad below
        var dLon = deg2rad(lon2-lon1); 
        var a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
            Math.sin(dLon/2) * Math.sin(dLon/2)
        ; 
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        var d = R * c; // Distance in km
        return d *1000;
    }
    
    function deg2rad(deg) {
        return deg * (Math.PI/180)
    }
    
    // To add catchError(positionError) function
    function catchError(positionError) {
        switch(positionError.code) {
            case positionError.TIMEOUT:
                alert("The request to get user location has aborted as it has taken too long.");
                break;
            case positionError.POSITION_UNAVAILABLE:
                alert("Location information is not available.");
                break;
            case positionError.PERMISSION_DENIED:
                alert("Permission to share location information has been denied!");
                break;
            default:
                alert("An unknown error occurred.");
        }
    }
    
    </script>
@endsection