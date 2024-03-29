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

    <link href="{{ asset('css/admin/main.tambah.css')}}" rel="stylesheet">

    <link href="{{ asset('css/icons/premium-solid-icons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/icons/premium-line-icons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('plugins/themify-icons/themify-icons.css')}}" rel="stylesheet">
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
                    <a href="{{ url('admin/dashboard')}}" class="navbar-brand">
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
                            <a href="{{ url('admin/dashboard')}}">
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
                                        <a href="{{ url('admin/profile')}}"><i class="psi-male icon-lg icon-fw"></i> Profile</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('admin/password/')}}"><i class="psi-lock-user icon-lg icon-fw"></i> Ganti Password</a>
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
                                        <span class="label label-danger" style="font-size:9px;">Admin</span>
                                    </div>
                                    <div id="profile-nav" class="collapse list-group bg-trans">
                                        <a href="{{ url('admin/profile')}}" class="list-group-item">
                                            <i class="psi-male icon-lg icon-fw"></i> Profile
                                        </a>
                                        <a href="{{ url('admin/password/')}}" class="list-group-item">
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
						                <a href="{{ url('admin/dashboard')}}">
						                    <i class="psi-home"></i>
						                    <span class="menu-title">Dashboard</span>
						                </a>
						            </li>

						            <!--Menu list item-->
						            <li {{$menu[0] == 'm-agenda' ? 'class=active-sub' : ''}}>
						                <a href="{{ url('admin/agenda/calendar')}}">
						                    <i class="fa fa-calendar"></i>
						                    <span class="menu-title">Agenda Kerja</span>
						                </a>
						            </li>
						
						            <!--Menu list item-->
						            <li {{$menu[0] == 'm-data' ? 'class=active-sub' : ''}}>
						                <a href="{{ url('#')}}">
						                    <i class="fa fa-users"></i>
						                    <span class="menu-title">Data Staff</span>
											<i class="arrow"></i>
						                </a>
						
						                <!--Submenu-->
						                <ul class="collapse {{$menu[0] == 'm-data' ? 'in' : ''}}">
                                            <li {{$menu[1] == 's-data-info' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/data-staff')}}"><i class="fa fa-users"></i>Informasi Staff</a>
                                            </li>
                                            <li {{$menu[1] == 's-data-presensi' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/presence')}}"><i class="psi-checked-user"></i>Presensi</a>
                                            </li>
											<li {{$menu[1] == 's-data-cuti' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/paid-leave')}}"><i class="fa fa-calendar-minus-o"></i>Cuti</a>
                                            </li>
                                            <li {{$menu[1] == 's-data-wfh' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/wfh')}}"><i class="psi-monitor-laptop"></i>Work From Home</a>
                                            </li>
											<li {{$menu[1] == 's-data-gaji' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/salary')}}"><i class="fa fa-money"></i>Gaji</a>
                                            </li>
                                            <li {{$menu[1] == 's-data-lembur' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/overtime')}}"><i class="psi-overtime"></i>Lembur</a>
                                            </li>
                                            <li {{$menu[1] == 's-data-potongan' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/salary-cut')}}"><i class="fa fa-scissors"></i>Potongan Gaji</a>
                                            </li>
                                            <li {{$menu[1] == 's-data-tunjangan' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/salary-allowance')}}"><i class="psi-wallet-2"></i>Tunjangan Gaji</a>
                                            </li>
						                </ul>
						            </li>

                                    <li {{$menu[0] == 'm-jadwal' ? 'class=active-sub' : ''}}>
						                <a href="{{ url('#')}}">
						                    <i class="psi-checked-user"></i>
						                    <span class="menu-title">Jadwal Kerja</span>
											<i class="arrow"></i>
						                </a>
						
						                <!--Submenu-->
						                <ul class="collapse {{$menu[0] == 'm-jadwal' ? 'in' : ''}}">
                                            <li {{$menu[1] == 's-jadwal-daftar' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/schedule')}}"><i class="psi-calendar-4"></i>Daftar Jadwal</a>
                                            </li>
											<li {{$menu[1] == 's-jadwal-tambah' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/schedule/add')}}"><i class="psi-checked-user"></i>Tambah Jadwal</a>
                                            </li>
                                            <li {{$menu[1] == 's-jadwal-edit' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/schedule/edit')}}"><i class="fa fa-pencil-square"></i>Edit Jadwal</a>
                                            </li>
											<li {{$menu[1] == 's-jadwal-copy' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/schedule/copyschedule')}}"><i class="fa fa-copy"></i>Copy Jadwal</a>
                                            </li>
                                        </ul>
						            </li>
                                    
						            <!--Menu list item-->
						            <li {{$menu[0] == 'm-master' ? 'class=active-sub' : ''}}>
						                <a href="{{ url('#')}}">
						                    <i class="fa fa-archive"></i>
                                            <span class="menu-title">Master Data</span>
                                            <i class="arrow"></i>
						                </a>
						
						                <!--Submenu-->
						                <ul class="collapse {{$menu[0] == 'm-master' ? 'in' : ''}}">
                                            <li {{$menu[1] == 's-master-agenda' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/agenda/')}}"><i class="psi-calendar-2"></i>Agenda Kerja</a>
                                            </li>
                                            <li {{$menu[1] == 's-master-cuti' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/paid-leave-type')}}"><i class="psi-calendar-4"></i>Tipe Cuti</a>
                                            </li>
                                            <li {{$menu[1] == 's-master-divisi' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/division')}}"><i class="fa fa-id-card"></i>Divisi</a>
                                            </li>
											<li {{$menu[1] == 's-master-jabatan' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/position')}}"><i class="fa fa-black-tie"></i>Jabatan</a>
                                            </li>
											<li {{$menu[1] == 's-master-shift' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/shift')}}"><i class="psi-clock"></i>Shift</a>
                                            </li>
                                            <li {{$menu[1] == 's-master-libur' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/holiday')}}"><i class="fa fa-calendar-plus-o"></i>Hari Libur</a>
                                            </li>
                                            <li {{$menu[1] == 's-master-ptgaji' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/cuts-allowances')}}"><i class="fa fa-money"></i>Tipe     Potongan dan Tunjangan Gaji</a>
                                            </li>
						                </ul>
                                    </li>

                                    <!--Menu list item-->
                                    <li {{$menu[0] == 'm-pencapaian' ? 'class=active-sub' : ''}}>
                                        <a href="#">
                                            <i class="fa fa-trophy"></i>
                                            <span class="menu-title">Pencapaian</span>
                                            <i class="arrow"></i>
                                        </a>
                                        
                                        <!--Submenu-->
                                        <ul class="collapse {{$menu[0] == 'm-pencapaian' ? 'in' : ''}}">
                                            <li {{$menu[1] == 's-pencapaian-leaderboard' ? 'class=active-link' : ''}}>
                                                <a href="/admin/achievement"><i class="fa fa-cubes"></i>Leaderboard</a>
                                            </li>
                                            <li {{$menu[1] == 's-pencapaian-penilaian' ? 'class=active-link' : ''}}>
                                                <a href="/admin/achievement/scoring"><i class="fa fa-sliders"></i>Penilaian</a>
                                            </li>
                                            <li {{$menu[1] == 's-pencapaian-eom' ? 'class=active-link' : ''}}>
                                                <a href="/admin/achievement/eom"><i class="ti-crown" style="color: gold"></i>Karyawan Terbaik</a>
                                            </li>
                                            <li {{$menu[1] == 's-pencapaian-grafik' ? 'class=active-link' : ''}}>
                                                <a href="/admin/achievement/charts"><i class="fa fa-bar-chart"></i>Grafik Nilai</a>
                                            </li>
                                        </ul>
                
                                    </li>
                                    
                                    <!--Menu list item-->
						            <li {{$menu[0] == 'm-rekruitasi' ? 'class=active-sub' : ''}}>
						                <a href="{{ url('#')}}">
						                    <i class="fa fa-handshake-o"></i>
                                            <span class="menu-title">Rekruitasi</span>
                                            <i class="arrow"></i>
                                        </a>

                                        <!--Submenu-->
						                <ul class="collapse {{$menu[0] == 'm-rekruitasi' ? 'in' : ''}}">
                                            <li {{$menu[1] == 's-rekruitasi-lowongan' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/job')}}"><i class="psi-idea-2"></i>Lowongan Tersedia</a>
                                            </li>
                                            <li {{$menu[1] == 's-rekruitasi-daftar' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/recruitment')}}"><i class="fa fa-handshake-o"></i>Daftar Rekruitasi</a>
                                            </li>
						                </ul>
                                    </li>
                                    
                                    <!--Menu list item-->
						            <li {{$menu[0] == 'm-sistem' ? 'class=active-sub' : ''}}>
						                <a href="{{ url('#')}}">
						                    <i class="psi-gear"></i>
                                            <span class="menu-title">Sistem</span>
                                            <i class="arrow"></i>
						                </a>
						
						                <!--Submenu-->
						                <ul class="collapse {{$menu[0] == 'm-sistem' ? 'in' : ''}}">
                                            <li {{$menu[1] == 's-sistem-poster' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/poster')}}"><i class="fa fa-university"></i>Poster</a>
                                            </li>
                                            <li {{$menu[1] == 's-sistem-tiketing' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/ticketing')}}"><i class="psi-support"></i>Ticketing</a>
                                            </li>
											<li {{$menu[1] == 's-sistem-log' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/log')}}"><i class="psi-paperclip"></i>Log</a>
                                            </li>
											<li {{$menu[1] == 's-sistem-setting' ? 'class=active-link' : ''}}>
                                                <a href="{{ url('admin/setting')}}"><i class="fa fa-cog"></i>Pengaturan</a>
                                            </li>
						                </ul>
                                    </li>
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
                        var urlnya = "{{url('/admin/foto')}}";
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