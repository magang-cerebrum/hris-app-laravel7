<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/'.$company_logo)}}">
    <title>HRIS Cerebrum | @yield('title')</title>

    <link href="{{ asset('css/fonts.css')}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/nifty.min.css')}}" rel="stylesheet">

    <link href="{{ asset('css/staff/main.tambah.css')}}" rel="stylesheet">

    <link href="{{ asset('css/icons/premium-solid-icons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/icons/premium-line-icons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    <link href="{{ asset('plugins/pace/pace.min.css')}}" rel="stylesheet">
    <script src="{{ asset('plugins/pace/pace.min.js')}}"></script>
    <script src="{{ asset('js/jquery.min.js')}}"></script>

    <link href="{{ asset('plugins/cropper/dropzone.min.css')}}" rel="stylesheet">
    <link href="{{ asset('plugins/cropper/cropper.min.css')}}" rel="stylesheet">
    <script src="{{ asset('plugins/cropper/dropzone.min.js')}}"></script>
    <script src="{{ asset('plugins/cropper/cropper.min.js')}}"></script>
    
    @yield('head')

    <style>
        .clean-menu {
            /* border: 1px solid black; */
            height: 80px;
        }
    </style>
</head>
<body>
    @include('sweetalert::alert')
    <div id="container" class="effect aside-float aside-bright mainnav-lg">
        
        <!--NAVBAR-->
        <!--===================================================-->
        <header id="navbar">
            <div id="navbar-container" class="boxed">

                <!--Brand logo & name-->
                <!--================================-->
                <div class="navbar-header">
                    <a href="{{ url('staff/dashboard')}}" class="navbar-brand">
                        <img src="{{ asset('img/'.$company_logo)}}" alt="Cerebrum Logo" class="brand-icon">
                        <div class="brand-title">
                            <span class="brand-text">{{ $company_name}}</span>
                        </div>
                    </a>
                </div>
                <!--================================-->
                <!--End brand logo & name-->


                <!--Navbar Dropdown-->
                <!--================================-->
                <div class="navbar-content">
                    <ul class="nav navbar-top-links">

                        <!--Navigation toogle button-->
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <li class="tgl-menu-btn">
                            <a class="mainnav-toggle" href="{{ url('#')}}">
                                <i class="pli-list-view"></i>
                            </a>
                        </li>
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <!--End Navigation toogle button-->

                    </ul>
                    <ul class="nav navbar-top-links">


                        <!--Mega dropdown-->
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <li class="mega-dropdown">
                            <a href="{{ url('staff/dashboard')}}">
                                <i class="psi-layout-grid"></i>
                            </a>
                        </li>
                        <!--User dropdown-->
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <li id="dropdown-user" class="dropdown">
                            <a href="{{ url('#')}}" data-toggle="dropdown" class="dropdown-toggle text-right">
                                <span class="ic-user pull-right">
                                    <i class="psi-male"></i>
                                </span>
                            </a>


                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right panel-default">
                                <ul class="head-list">
                                    <li>
                                        <a href="{{ url('staff/profile')}}"><i class="psi-male icon-lg icon-fw"></i> Profile</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('staff/password/')}}"><i class="psi-lock-user icon-lg icon-fw"></i> Ganti Password</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('logout')}}"><i class="psi-unlock icon-lg icon-fw"></i> Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <!--End user dropdown-->
 
                    </ul>
                </div>
                <!--================================-->
                <!--End Navbar Dropdown-->
            </div>
        </header>
        <!--===================================================-->
        <!--END NAVBAR-->
        

        <!--Page content-->
        <!--===================================================-->
        <div class="boxed">
            <!--CONTENT CONTAINER-->
            <!--===================================================-->
            <div id="content-container">
                <div id="page-head">
                    <div class="pad-all text-center">
                        <h3>@yield('content-title')</h3>
                        <p>@yield('content-subtitle')</p>
                    </div>
                </div>

                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
                    @yield('content')
                </div>
                <!--===================================================-->
                <!--End page content-->
            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->

            <!--MAIN NAVIGATION-->
            <!--===================================================-->
                <nav id="mainnav-container">
                    <div id="mainnav">

                        <!--Menu-->
                        <!--================================-->
                        <div id="mainnav-menu-wrap">
                            <div class="nano">
                                <div class="nano-content">

                                    <!--Profile Widget-->
                                    <!--================================-->
                                    <div id="mainnav-profile" class="mainnav-profile">
                                        <div class="profile-wrap text-center">
                                            <div class="pad-btm image-area">
                                                <form method="POST">
                                                    @csrf
                                                    <label for="upload_image" id="overlay-img">
                                                        <img id='uploaded_image' class="img-circle img-md img-responsive img-border" src="{{ asset('img/profile-photos/'.$profile_photo)}}" alt="Profile Picture">
                                                        <div class="overlay">
                                                            <div class="text_change"><i class="fa fa-camera icon-fw"></i></div>
                                                        </div>
                                                        <input type="file" name="image" class="image" id="upload_image" style="display:none" />
                                                    </label>
                                                </form>
                                            </div>
                                            <a href="{{ url('#profile-nav')}}" class="box-block" data-toggle="collapse" aria-expanded="false">
                                                <span class="pull-right dropdown-toggle">
                                                    <i class="dropdown-caret"></i>
                                                </span>
                                                <p class="mnp-name">{{$name}}</p>
                                                <span class="mnp-desc">{{$email}}</span>
                                            </a>
                                            @if (Auth::user()->position_id != 11) 
                                            <span class="label label-mint" style="font-size:9px;">Chief</span>
                                            @endif
                                            <span class="label label-primary" style="font-size:9px;">Staff</span>
                                        </div>
                                        <div id="profile-nav" class="collapse list-group bg-trans">
                                            <a href="{{ url('staff/profile')}}" class="list-group-item">
                                                <i class="psi-male icon-lg icon-fw"></i> Profile
                                            </a>
                                            <a href="{{ url('staff/password/')}}" class="list-group-item">
                                                <i class="psi-lock-user icon-lg icon-fw"></i> Ganti Password
                                            </a>
                                            <a href="{{ url('logout')}}" class="list-group-item">
                                                <i class="psi-unlock icon-lg icon-fw"></i> Logout
                                            </a>
                                        </div>
                                    </div>

                                    <ul id="mainnav-menu" class="list-group">
                            
                                        <!--Category name-->
                                        <li class="list-header">Navigation</li>
                            
                                        <!--Menu list item-->
                                        <li {{$menu[0] == 'm-dashboard' ? 'class=active-sub' : ''}}>
                                            <a href="{{ url('staff/dashboard')}}">
                                                <i class="psi-home"></i>
                                                <span class="menu-title">Dashboard</span>
                                            </a>
                                        </li>
                            
                                        <!--Menu list item-->
                                        <li {{$menu[0] == 'm-presensi' ? 'class=active-sub' : ''}}>
                                            <a href="{{ url('staff/presence')}}">
                                                <i class="psi-checked-user"></i>
                                                <span class="menu-title">Presensi</span>
                                            </a>
                                        </li>

                                        <!--Menu list item-->
                                        <li {{$menu[0] == 'm-jadwal' ? 'class=active-sub' : ''}}>
                                            <a href="{{ url('staff/schedule')}}">
                                                <i class="fa fa-calendar-check-o"></i>
                                                <span class="menu-title">Jadwal Kerja</span>
                                            </a>
                                        </li>
                                       
                                        <!--Menu list item-->
                                        <li {{$menu[0] == 'm-cuti' ? 'class=active-sub' : ''}}>
                                            <a href="{{ url('#')}}">
                                                <i class="fa fa-calendar-minus-o"></i>
                                                <span class="menu-title">Cuti</span>
                                                <i class="arrow"></i>
                                            </a>

                                            <!--Submenu-->
                                            <ul class="collapse {{$menu[0] == 'm-cuti' ? 'in' : ''}}">
                                                <li {{$menu[1] == 's-cuti-pengajuan' ? 'class=active-link' : ''}}>
                                                    <a href="{{ url('staff/paid-leave')}}"><i class="fa fa-calendar-minus-o"></i>Pengajuan Cuti</a>
                                                </li>
                                                <li {{$menu[1] == 's-cuti-riwayat' ? 'class=active-link' : ''}}>
                                                    <a href="{{ url('staff/paid-leave/history')}}"><i class="fa fa-history"></i>Riwayat Cuti</a>
                                                </li>
                                            </ul>
                                        </li>

                                        <!--Menu list item-->
                                        <li {{$menu[0] == 'm-wfh' ? 'class=active-sub' : ''}}>
                                            <a href="{{ url('#')}}">
                                                <i class="psi-monitor-laptop"></i>
                                                <span class="menu-title">Work From Home</span>
                                                <i class="arrow"></i>
                                            </a>

                                            <!--Submenu-->
                                            <ul class="collapse {{$menu[0] == 'm-wfh' ? 'in' : ''}}">
                                                <li {{$menu[1] == 's-wfh-pengajuan' ? 'class=active-link' : ''}}>
                                                    <a href="{{ url('staff/wfh')}}"><i class="psi-monitor-laptop"></i>Pengajuan WFH</a>
                                                </li>
                                                <li {{$menu[1] == 's-wfh-riwayat' ? 'class=active-link' : ''}}>
                                                    <a href="{{ url('staff/wfh/history')}}"><i class="fa fa-history"></i>Riwayat WFH</a>
                                                </li>
                                            </ul>
                                        </li>
                                        
                                        <!--Menu list item-->
                                        <li {{$menu[0] == 'm-gaji' ? 'class=active-sub' : ''}}>
                                            <a href="{{ url('staff/salary')}}">
                                                <i class="fa fa-money"></i>
                                                <span class="menu-title">Gaji</span>
                                            </a>
                                        </li>                                       
                                        
                                        <!--Menu list item-->
                                        <li {{$menu[0] == 'm-tiketing' ? 'class=active-sub' : ''}}>
                                            <a href="{{ url('staff/ticketing')}}">
                                                <i class="psi-support"></i>
                                                <span class="menu-title">Ticketing</span>
                                            </a>
                                        </li>

                                        @if (Auth::user()->position_id != 11)
                                        <!--Category name-->
                                        <li class="list-header">Division</li>

                                        <li {{$menu[0] == 'm-d-data' ? 'class=active-sub' : ''}}>
                                            <a href="{{ url('staff/data-staff')}}">
                                                <i class="fa fa-users"></i>
                                                <span class="menu-title">Data Staff Divisi</span>
                                            </a>
                                        </li>

                                        <li {{$menu[0] == 'm-d-jadwal' ? 'class=active-sub' : ''}}>
                                            <a href="{{ url('#')}}">
                                                <i class="fa fa-calendar-o"></i>
                                                <span class="menu-title">Jadwal Kerja Divisi</span>
                                                <i class="arrow"></i>
                                            </a>

                                            <!--Submenu-->
                                            <ul class="collapse {{$menu[0] == 'm-d-jadwal' ? 'in' : ''}}">
                                                <li {{$menu[1] == 's-d-jadwal-tambah' ? 'class=active-link' : ''}}>
                                                    <a href="{{ url('staff/schedule/add')}}"><i class="fa fa-calendar-plus-o"></i>Tambah Jadwal</a>
                                                </li>
                                                <li {{$menu[1] == 's-d-jadwal-daftar' ? 'class=active-link' : ''}}>
                                                    <a href="{{ url('staff/schedule/division')}}"><i class="psi-calendar-4"></i>Lihat Jadwal Divisi</a>
                                                </li>
                                                <li {{$menu[1] == 's-d-jadwal-edit' ? 'class=active-link' : ''}}>
                                                    <a href="{{ url('staff/schedule/edit')}}"><i class="fa fa-pencil-square"></i>Edit Jadwal</a>
                                                </li>
											    <li {{$menu[1] == 's-d-jadwal-copy' ? 'class=active-link' : ''}}>
                                                    <a href="{{ url('staff/schedule/copyschedule')}}"><i class="fa fa-copy"></i>Copy Jadwal</a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li {{$menu[0] == 'm-d-presensi' ? 'class=active-sub' : ''}}>
                                            <a href="{{ url('staff/presence/division')}}">
                                                <i class="fa fa-clock-o"></i>
                                                <span class="menu-title">Presensi Divisi</span>
                                            </a>
                                        </li>

                                        <li {{$menu[0] == 'm-d-cuti' ? 'class=active-sub' : ''}}>
                                            <a href="{{ url('staff/paid-leave/division')}}">
                                                <i class="fa fa-user-md"></i>
                                                <span class="menu-title">Cuti Anggota Divisi</span>
                                            </a>
                                        </li>

                                        <li {{$menu[0] == 'm-d-wfh' ? 'class=active-sub' : ''}}>
                                            <a href="{{ url('staff/wfh/division')}}">
                                                <i class="psi-monitor-2"></i>
                                                <span class="menu-title">WFH Anggota Divisi</span>
                                            </a>
                                        </li>

                                        <li {{$menu[0] == 'm-d-performa' ? 'class=active-sub' : ''}}>
                                            <a href="#">
                                                <i class="fa fa-trophy"></i>
                                                <span class="menu-title">Performa Divisi</span>
                                                <i class="arrow"></i>
                                            </a>
                                            
                                            <!--Submenu-->
                                            <ul class="collapse {{$menu[0] == 'm-d-performa' ? 'in' : ''}}">
                                                <li {{$menu[1] == 's-d-performa-leaderboard' ? 'class=active-link' : ''}}>
                                                    <a href="/staff/performance"><i class="fa fa-cubes"></i>Leaderboard</a>
                                                </li>
                                                <li {{$menu[1] == 's-d-performa-penilaian' ? 'class=active-link' : ''}}>
                                                    <a href="/staff/performance/scoring"><i class="fa fa-sliders"></i>Penilaian</a>
                                                </li>
                                                <li {{$menu[1] == 's-d-performa-grafik' ? 'class=active-link' : ''}}>
                                                    <a href="/staff/performance/charts"><i class="fa fa-bar-chart"></i>Grafik Nilai</a>
                                                </li>                                
                                            </ul>
                    
                                        </li>
                                        @endif
                                    </ul>
                                    <div class="clean-menu"></div>
                                </div>
                            </div>
                        </div>
                        <!--================================-->
                        <!--End menu-->

                    </div>
                </nav>
            <!--===================================================-->
            <!--END MAIN NAVIGATION-->
        </div>
        

        <!-- FOOTER -->
        <!--===================================================-->
        <footer id="footer">

            <p class="pad-lft">&#0169; 2021 {{ $company_name }}</p>

        </footer>
        <!--===================================================-->
        <!-- END FOOTER -->


        <!-- SCROLL PAGE BUTTON -->
        <!--===================================================-->
        <button class="scroll-top btn">
            <i class="pci-chevron chevron-up"></i>
        </button>
        <!--===================================================-->
    </div>
    <!--===================================================-->
    <!-- END OF CONTAINER -->

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Image Before Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img src="" id="sample_image" />
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="crop" class="btn btn-primary">Crop</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/nifty.min.js')}}"></script>

    <script src="{{ asset('plugins/flot-charts/jquery.flot.min.js')}}"></script>
	<script src="{{ asset('plugins/flot-charts/jquery.flot.resize.min.js')}}"></script>
    <script src="{{ asset('plugins/flot-charts/jquery.flot.tooltip.min.js')}}"></script>
    
    <script>
        $(document).ready(function(){

            var $modal = $('#modal');
            var image = document.getElementById('sample_image');
            var cropper;
            $('#upload_image').change(function(event){
                var files = event.target.files;
        
                var done = function(url){
                    image.src = url;
                    $modal.modal('show');
                };
        
                if(files && files.length > 0)
                {
                    reader = new FileReader();
                    reader.onload = function(event)
                    {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                }
            });
        
            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 2,
                    preview:'.preview'
                });
            }).on('hidden.bs.modal', function(){
                cropper.destroy();
                cropper = null;
            });
        
            $('#crop').click(function(){
                canvas = cropper.getCroppedCanvas({
                    width:400,
                    height:400
                });
        
                canvas.toBlob(function(blob){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function(){
                        var base64data = reader.result;
                        var urlnya = "{{url('/staff/foto')}}";
                        $.ajax({
                            url:urlnya,
                            method:'POST',
                            data:{image:base64data},
                            success:function(data)
                            {
                                var url_pathname = window.location.href;
                                window.location = url_pathname;
                                $modal.modal('hide');
                            }
                        });
                    };
                });
            });
            
        });
    </script>

    @yield('script')

</body>
</html>