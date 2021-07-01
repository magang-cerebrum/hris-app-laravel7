<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/title-cerebrum.png')}}">
    <title>HRIS Cerebrum | Rekruitasi</title>

    <link href="{{ asset('css/fonts.css')}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/nifty.min.css')}}" rel="stylesheet">

    <link href="{{ asset('plugins/pace/pace.min.css')}}" rel="stylesheet">
    <script src="{{ asset('plugins/pace/pace.min.js')}}"></script>
    {{-- Sweetalert 2 --}}
    <link href="{{ asset('css/sweetalert2.min.css')}}" rel="stylesheet">

    <script type="text/javascript" src="{{asset('plugins/webcam/webcam.js')}}"></script>
    <style>
        #bg-overlay1 {
            background-image: url('../../img/background/bg-img.jpg');
        }
        .cls-content {
            padding-top: 5vh;
        }
        .cls-content .cls-content-lg {
            text-align: center;
        }
        .container {
            display:inline-block;
            width:350px;
            padding-top: 3px;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        #Cam {
            background:rgb(255,255,155);
        }
        #my_camera {
            margin: auto;
        }
        @media screen and (max-width: 600px) {
            .cls-content .cls-content-lg {
                width: 98%;
            }
            .panel-body {
                padding: 15px 0 25px;
            }
            #Cam {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div id="container" class="cls-container">
        <div id="bg-overlay1" class="bg-img"></div>

        <form class="form-horizontal" action="/staff/presence/add" method="POST" id="take_presence">
            @csrf
        </form>
        
        <div class="cls-content">
            <div class="cls-content-lg panel">
                <div class="panel-body">
                    <input type="hidden" name="user_id" value="{{$id}}" form="take_presence">
                    <input type="hidden" name="bool_presence" value="{{$bool_presence}}" form="take_presence">
                    <input type="hidden" name="image" id="image_presence" form="take_presence">
                    <div class="mar-ver pad-btm">
                        <img src="{{ asset('img/profile-photos/'.$profile_photo)}}" class="img-circle img-lg">
                        <h1 class="h3">{{$name}}</h1>
                        <p>Division : {{$division}}</p>
                        <h2 class="h3">
                            {{$bool_presence == 0 ? 'Silahkan mengambil absensi masuk kerja' : 'Silahkan mengambil absensi pulang kerja'}}
                        </h2>
                        <div class="container" id="Cam"><b>Webcam Preview...</b>
                            <div id="my_camera"></div>
                        </div>
                        <div>
                            <button class="btn btn-success add-tooltip" type="button" onClick="getLocation()" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Ambil Absensi" form="take_presence">Absensi</button>
                            <a href="{{url ('/staff/presence')}}">
                                <button type="button" class="btn btn-dark">Kembali</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/nifty.min.js')}}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
    
    <script>
        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                document.getElementById('image_presence').value = data_uri;
            });
        }
        function ShowCam(){
            Webcam.set({
                width: 263,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 100
            });
            Webcam.attach('#my_camera');
        }
        window.onload= ShowCam;

        function getLocation() {
            console.log('get location');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getPosition);
            } else {
                alert("Oops! This browser does not support HTML Geolocation.");
            }
        }
        function getPosition(position) {
            var position_latitude_1 = -7.055286522681598;
            var position_longitude_1 = 107.56162952882028;
            var position_latitude_2 = position.coords.latitude;
            var position_longitude_2 = position.coords.longitude;
            var jarak = getDistanceFromLatLonInKm(position_latitude_1,position_longitude_1,position_latitude_2,position_longitude_2);
            var shift = {!!json_encode($shift) !!};
            var check_presen = {!!json_encode($bool_presence) !!};
            if (shift == 'WFH') {
                take_snapshot()
                $('#take_presence').submit();
            }
            else {
                if (jarak <= 100000 ) {
                    take_snapshot()
                    $('#take_presence').submit();
                }
                else {
                    Swal.fire({
                        width: 600,
                        title: 'Error!',
                        text: "Anda Berada Diluar Kantor, Jarak Anda Sejauh " + jarak + " m !",
                        icon: 'error'
                    }); 
                }
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
            return d * 1000;
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

</body>
</html>