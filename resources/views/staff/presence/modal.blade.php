<!-- modal input presence -->
<div class="modal fade" id="modal-input-presence" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h5 class="modal-title text-bold text-center">Ambil Kehadiran Kerja</h5>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="/staff/presence/add" method="POST" id="take_presence">
                    @csrf
                    <div class="panel-body text-center" style="padding-top: 0">
                        <input type="hidden" name="user_id" value="{{$id}}">
                        <input type="hidden" name="bool_presence" value="{{$bool_presence}}">
                        <h5 class="h4">{{$name}}</h5>
                        <h5 class="h5">Divisi {{$division}}</h5>
                        <h2 class="h3">
                            {{$bool_presence == 0 ? 'Silahkan mengambil absensi masuk kerja' : ($bool_presence == 1 ? 'Silahkan mengambil absensi pulang kerja' : 'Anda telah mengambil absensi hari ini')}}
                        </h2>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success add-tooltip" type="button" onClick="getLocation()" data-toggle="tooltip" data-container="body" data-placement="top" data-original-title="Ambil Absensi" {{$bool_presence == 2 ? 'disabled     ' : ''}}>Absensi</button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>

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
    });

</script>
<script>
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