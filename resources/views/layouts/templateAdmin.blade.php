<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/title-cerebrum.png')}}">
    <title>HRIS Cerebrum | @yield('title')</title>

    <link href="{{ url('https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700')}}"" rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/nifty.min.css')}}" rel="stylesheet">

    <link href="{{ asset('css/admin/main.tambah.css')}}" rel="stylesheet">

    <link href="{{ asset('css/demo/nifty-demo-icons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    <link href="{{ asset('plugins/pace/pace.min.css')}}" rel="stylesheet">
    <script src="{{ asset('plugins/pace/pace.min.js')}}"></script>
    <script src="{{ asset('js/jquery.min.js')}}"></script>

    <link rel="stylesheet" href="{{asset('plugins/noUiSlider/nouislider.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/noUiSlider/nouislider.min.css')}}">
    <script href="{{asset('plugins/noUiSlider/nouislider.js')}}"></script>
    <script href="{{asset('plugins/noUiSlider/nouislider.min.js')}}"></script>

    @yield('head')
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
                        <img src="{{ asset('img/logo-cerebrum.png')}}" alt="Cerebrum Logo" class="brand-icon">
                        <div class="brand-title">
                            <span class="brand-text">PT. Cerebrum Edukanesia</span>
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
                                <i class="demo-pli-list-view"></i>
                            </a>
                        </li>
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <!--End Navigation toogle button-->



                        <!--Search-->
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <li>
                            <div class="custom-search-form">
                                <label class="btn btn-trans" for="search-input" data-toggle="collapse" data-target="#nav-searchbox">
                                    <i class="demo-psi-magnifi-glass"></i>
                                </label>
                                <form>
                                    <div class="search-container collapse" id="nav-searchbox">
                                        <input id="search-input" type="text" class="form-control" placeholder="Pencarian...">
                                    </div>
                                </form>
                            </div>
                        </li>
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <!--End Search-->

                    </ul>
                    <ul class="nav navbar-top-links">


                        <!--Mega dropdown-->
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <li class="mega-dropdown">
                            <a href="{{ url('admin/dashboard')}}">
                                <i class="demo-psi-layout-grid"></i>
                            </a>
                        </li>
                        <!--User dropdown-->
                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                        <li id="dropdown-user" class="dropdown">
                            <a href="{{ url('#')}}" data-toggle="dropdown" class="dropdown-toggle text-right">
                                <span class="ic-user pull-right">
                                    <i class="demo-psi-male"></i>
                                </span>
                            </a>


                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right panel-default">
                                <ul class="head-list">
                                    <li>
                                        <a href="{{ url('admin/profile')}}"><i class="demo-psi-male icon-lg icon-fw"></i> Profile</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('admin/password/'.$id)}}"><i class="demo-psi-lock-user icon-lg icon-fw"></i> Ganti Password</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('logout')}}"><i class="demo-psi-unlock icon-lg icon-fw"></i> Logout</a>
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
                                        <div class="pad-btm">
                                            <img class="img-circle img-md" src="{{ asset('img/profile-photos/'.$profile_photo)}}" alt="Profile Picture">
                                        </div>
                                        <a href="{{ url('#profile-nav')}}" class="box-block" data-toggle="collapse" aria-expanded="false">
                                            <span class="pull-right dropdown-toggle">
                                                <i class="dropdown-caret"></i>
                                            </span>
                                            <p class="mnp-name">{{$name}}</p>
                                            <span class="mnp-desc">{{$email}}</span>
                                        </a>
                                    </div>
                                    <div id="profile-nav" class="collapse list-group bg-trans">
                                        <a href="{{ url('admin/profile')}}" class="list-group-item">
                                            <i class="demo-psi-male icon-lg icon-fw"></i> Profile
                                        </a>
                                        <a href="{{ url('admin/password/'.$id)}}" class="list-group-item">
                                            <i class="demo-psi-lock-user icon-lg icon-fw"></i> Ganti Password
                                        </a>
                                        <a href="{{ url('logout')}}" class="list-group-item">
                                            <i class="demo-psi-unlock icon-lg icon-fw"></i> Logout
                                        </a>
                                    </div>
                                </div>

                                <ul id="mainnav-menu" class="list-group">
						
						            <!--Category name-->
						            <li class="list-header">Navigation</li>
						
						            <!--Menu list item-->
						            <li>
						                <a href="{{ url('admin/dashboard')}}">
						                    <i class="demo-psi-home"></i>
						                    <span class="menu-title">Dashboard</span>
						                </a>
						            </li>
						
						            <!--Menu list item-->
						            <li>
						                <a href="{{ url('#')}}">
						                    <i class="fa fa-users"></i>
						                    <span class="menu-title">Data Staff</span>
											<i class="arrow"></i>
						                </a>
						
						                <!--Submenu-->
						                <ul class="collapse">
                                            <li><a href="{{ url('admin/data-staff')}}"><i class="fa fa-users"></i>Data</a></li>
<<<<<<< HEAD
=======
                                            {{-- <li class="list-divider"></li> --}}
>>>>>>> eff406381b4917a28f59429dd3a900be8c280fdb
											<li><a href="{{ url('admin/schedule')}}"><i class="demo-psi-checked-user"></i>Jadwal Kerja</a></li>
                                            <li><a href="{{ url('admin/presence')}}"><i class="demo-psi-checked-user"></i>Presensi</a></li>
											<li><a href="{{ url('admin/paid-leave')}}"><i class="fa fa-calendar-minus-o"></i>Cuti</a></li>
											<li><a href="{{ url('admin/salary')}}"><i class="fa fa-money"></i>Gaji</a></li>
						                </ul>
						            </li>
                                    
						            <!--Menu list item-->
						            <li>
						                <a href="{{ url('#')}}">
						                    <i class="fa fa-archive"></i>
                                            <span class="menu-title">Master Data</span>
                                            <i class="arrow"></i>
						                </a>
						
						                <!--Submenu-->
						                <ul class="collapse">
                                            <li><a href="{{ url('admin/paid-leave-type')}}"><i class="demo-psi-calendar-4"></i>Tipe Cuti</a></li>
                                            <li><a href="{{ url('admin/division')}}"><i class="fa fa-id-card"></i>Divisi</a></li>
											<li><a href="{{ url('admin/position')}}"><i class="fa fa-black-tie"></i>Jabatan</a></li>
											<li><a href="{{ url('admin/shift')}}"><i class="demo-psi-clock"></i>Shift</a></li>
						                </ul>
                                    </li>

                                    <!--Menu list item-->
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-trophy"></i>
                                            <span class="menu-title">Penghargaan</span>
                                            <i class="arrow"></i>
                                        </a>
                                        
                                        <!--Submenu-->
                                        <ul class="collapse">
                                            <li><a href="/admin/achievement"><i class="fa fa-cubes"></i>Leaderboard</a></li>
                                            <li><a href="/admin/achievement/scoring"><i class="fa fa-sliders"></i>Scoring</a></li>
                                        </ul>
                
                                    </li>
                                    
                                    <!--Menu list item-->
						            <li>
						                <a href="{{ url('#')}}">
						                    <i class="fa fa-handshake-o"></i>
                                            <span class="menu-title">Rekruitasi</span>
                                            <i class="arrow"></i>
                                        </a>

                                        <!--Submenu-->
						                <ul class="collapse">
                                            <li><a href="{{ url('admin/job')}}"><i class="demo-psi-idea-2"></i>Lowongan Tersedia</a></li>
                                            <li><a href="{{ url('admin/recruitment')}}"><i class="fa fa-handshake-o"></i>Daftar Rekruitasi</a></li>
						                </ul>
                                    </li>
                                    
                                    <!--Menu list item-->
						            <li>
						                <a href="{{ url('#')}}">
						                    <i class="demo-psi-gear"></i>
                                            <span class="menu-title">Sistem</span>
                                            <i class="arrow"></i>
						                </a>
						
						                <!--Submenu-->
						                <ul class="collapse">
                                            <li><a href="{{ url('admin/ticketing')}}"><i class="demo-psi-support"></i>Daftar Ticketing</a></li>
											<li><a href="{{ url('admin/log')}}"><i class="demo-psi-paperclip"></i>Log Sistem Aplikasi</a></li>
						                </ul>
                                    </li>
                                </ul>
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

            <p class="pad-lft">&#0169; 2021 PT. Cerebrum Edukanesia</p>

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

    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/nifty.min.js')}}"></script>

    <script src="{{ asset('plugins/flot-charts/jquery.flot.min.js')}}"></script>
	<script src="{{ asset('plugins/flot-charts/jquery.flot.resize.min.js')}}"></script>
    <script src="{{ asset('plugins/flot-charts/jquery.flot.tooltip.min.js')}}"></script>
    
    <script src="{{ asset('plugins/sparkline/jquery.sparkline.min.js')}}"></script>

    @yield('script')
    
</body>
</html>