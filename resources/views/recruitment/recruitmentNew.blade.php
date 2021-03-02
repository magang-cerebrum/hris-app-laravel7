<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/title-cerebrum.png')}}">
    <title>HRIS Cerebrum | Rekruitasi</title>

    <link href="{{ url('https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700')}}"" rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/nifty.min.css')}}" rel="stylesheet">

    <link href="{{ asset('css/recruitment/main.tambah.css')}}" rel="stylesheet">

    <link href="{{asset('css/demo/nifty-demo-icons.min.css')}}" rel="stylesheet">

    <link href="{{ asset('plugins/pace/pace.min.css')}}" rel="stylesheet">
    <script src="{{ asset('plugins/pace/pace.min.js')}}"></script>

    <link href="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">

    <style>
        .panel-body {
            padding: 0px;
        }
        .content-head {
            padding-top: 35px;
        }
        .mar-ver, .pad-btm, h1.h3 {
            margin-top: 0;
        }
        svg {
            margin-top: -35px;
        }
        .content-form {
            padding: 0 30px 30px;
        }
        .content_1 {
            background: linear-gradient(181.14deg, #153449 2.81%, #8E8036 85.54%);
        }
    </style>

</head>
<body>
    <div id="container" class="cls-container">
        <div id="bg-overlay1" class="bg-img"></div>

        <div class="cls-content">
            <div class="cls-content-sm panel">
                <div class="panel-body">
                    <div class="content content-head">
                        <div class="mar-ver pad-btm">
                            <h1 class="h3">Rekruitasi PT. Cerebrum Edukanesia</h1>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#153449" fill-opacity="1" d="M0,224L30,224C60,224,120,224,180,197.3C240,171,300,117,360,112C420,107,480,149,540,181.3C600,213,660,235,720,213.3C780,192,840,128,900,133.3C960,139,1020,213,1080,245.3C1140,277,1200,267,1260,218.7C1320,171,1380,85,1410,42.7L1440,0L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z"></path></svg>
                        </div>
                    </div>
                    
                    @if (count($data) == 0)
                        <div class="content">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#fff" fill-opacity="1" d="M0,128L30,144C60,160,120,192,180,197.3C240,203,300,181,360,149.3C420,117,480,75,540,64C600,53,660,75,720,112C780,149,840,203,900,234.7C960,267,1020,277,1080,240C1140,203,1200,117,1260,74.7C1320,32,1380,32,1410,32L1440,32L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z"></path></svg>
                            <div style="text-align: center">
                                <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 200px">
                                <h1 class="h3">Rekruitasi Kerja Belum Tersedia</h1>
                            </div>
                        </div>
                        @else
                        <div class="content_1" style="hheight: 200px">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos, iure obcaecati ad debitis deleniti eum labore odit ipsum doloremque ratione autem officiis quos dolore magnam nam eligendi iusto nisi modi.
                        </div>
                        <div class="content">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#fff" fill-opacity="1" d="M0,128L30,144C60,160,120,192,180,197.3C240,203,300,181,360,149.3C420,117,480,75,540,64C600,53,660,75,720,112C780,149,840,203,900,234.7C960,267,1020,277,1080,240C1140,203,1200,117,1260,74.7C1320,32,1380,32,1410,32L1440,32L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z"></path></svg>
                            <div class="content-form">
                                <form class="panel-body form-horizontal form-padding" action="{{ url('/recruitment/add')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                    
                                    <!--Text Input-->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="demo-text-input">Nama Lengkap</label>
                                        <div class="col-md-9">
                                            <input type="text" id="nama-input" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap" name="name">
                                            {{-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> --}}
                                            @error('name') <div class="text-danger invalid-feedback mt-3">
                                                Nama Lengkap tidak boleh kosong.
                                                </div> @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="demo-text-input">Tempat Lahir</label>
                                        <div class="col-md-9">
                                            <input type="text" id="tempat-input" class="form-control @error('born_in') is-invalid @enderror" placeholder="Tempat Lahir" name="born_in">
                                            {{-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> --}}
                                            @error('born_in') <div class="text-danger invalid-feedback mt-3">
                                                Tempat lahir tidak boleh kosong.
                                                </div> @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="demo-text-input">Tanggal Lahir</label>
                                        <div class="col-md-9">
                                            <input id="tanggal-input" type="text" class="form-control @error('dob') is-invalid @enderror" placeholder="Tanggal Lahir" name="dob" autocomplete="off">
                                            @error('dob') <div class="text-danger invalid-feedback mt-3">
                                                Tanggal lahir tidak boleh kosong.
                                                </div> @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="demo-text-input">Domisili</label>
                                        <div class="col-md-9">
                                            <input id="domisili-input" type="text" class="form-control @error('live_at') is-invalid @enderror" placeholder="Domisili" name="live_at">
                                            @error('live_at') <div class="text-danger invalid-feedback mt-3">
                                                Domisili tidak boleh kosong.
                                                </div> @enderror
                                        </div>
                                    </div>
            
                                    <!--Text Input-->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="demo-text-input">No Telepon WhatsApp</label>
                                        <div class="col-md-9">
                                            <input type="text" id="telfon-input" class="form-control @error('phone_number') is-invalid @enderror" placeholder="No Telepon WhatsApp" name="phone_number">
                                            @error('phone_number') <div class="text-danger invalid-feedback mt-3">
                                                No Telepon whatsApp tidak boleh kosong.
                                                </div> @enderror
                                        </div>
                                    </div>
                    
                                    <!--Email Input-->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="demo-email-input">Email</label>
                                        <div class="col-md-9">
                                            <input type="email" id="email-input" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email">
                                            @error('email') <div class="text-danger invalid-feedback mt-3">
                                                Email tidak boleh kosong.
                                                </div> @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group pad-ver">
                                        <label class="col-md-3 control-label">Jenis Kelamin</label>
                                        <div class="col-md-9">
                                            <div class="radio">
                    
                                                <!-- Inline radio buttons -->
                                                <input id="gender" class="magic-radio" type="radio" name="gender" value="Laki - laki">
                                                <label for="gender">Laki - laki</label>
                    
                                                <input id="gender-2" class="magic-radio" type="radio" name="gender" value="Perempuan">
                                                <label for="gender-2">Perempuan</label>    
                    
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="form-group pad-ver">
                                        <label class="col-md-3 control-label">Pendidikan Terakhir</label>
                                        <div class="col-md-9">
                                            <div class="radio">
                    
                                                <!-- Inline radio buttons -->
                                                <input id="education" class="magic-radio" type="radio" name="last_education" value="SMA/SMK Sederajat">
                                                <label for="education">SMA/SMK Sederajat</label>
                    
                                                <input id="education-2" class="magic-radio" type="radio" name="last_education" value="D3">
                                                <label for="education-2">D3</label>
                    
                                                <input id="education-3" class="magic-radio" type="radio" name="last_education" value="Sarjana">
                                                <label for="education-3">Sarjana</label>
            
                                                <input id="education-4" class="magic-radio" type="radio" name="last_education" value="Magister">
                                                <label for="education-4">Magister</label>
                    
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="form-group pad-ver">
                                        <label class="col-md-3 control-label">Posisi</label>
                                        <div class="col-md-9">
                                            <div class="radio">
                    
                                                <!-- Inline radio buttons -->
                                                @foreach ($data as $item)
                                                    {{-- $id = "position-" .$loop->iteration; --}}
                                                    <input id="position-{{$loop->iteration}}" class="magic-radio" type="radio" name="position" value="{{$item->name}}">
                                                    <label for="position-{{$loop->iteration}}">{{$item->name}}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Input CV</label>
                                        <div class="col-md-9">
                                            <span class="pull-left btn btn-primary btn-file">
                                            Browse... <input type="file" name="file_cv">
                                            </span>
                                        </div>
                                    </div>
            
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Input Portopolio</label>
                                        <div class="col-md-9">
                                            <span class="pull-left btn btn-primary btn-file">
                                            Browse... <input type="file" name="file_portofolio">
                                            </span>
                                        </div>
                                    </div>
            
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                                <div class="col-md-8">
                                                    <input type="submit" class="btn btn-primary btn-lg btn-block">  
                                                </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/nifty.min.js')}}"></script>
    
    <script src="{{ asset('plugins/sparkline/jquery.sparkline.min.js')}}"></script>

    <script src="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#tanggal-input').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true
            });
        })
    </script>
</body>
</html>