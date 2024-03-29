<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/'.$company_logo)}}">
    <title>HRIS Cerebrum | Rekruitasi</title>

    <link href="{{ asset('css/fonts.css')}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/nifty.min.css')}}" rel="stylesheet">

    <link href="{{ asset('css/recruitment/main.tambah.css')}}" rel="stylesheet">

    <link href="{{asset('css/demo/nifty-demo-icons.min.css')}}" rel="stylesheet">

    <link href="{{ asset('plugins/pace/pace.min.css')}}" rel="stylesheet">
    <script src="{{ asset('plugins/pace/pace.min.js')}}"></script>

    <link href="{{ asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">

</head>
<body>
    <div id="container" class="cls-container">
        <div id="bg-overlay1" class="bg-img"></div>

        <div class="cls-content">
            <div class="cls-content-sm panel">
                <div class="panel-body">
                    <div class="mar-ver pad-btm">
                        <h1 class="h3">Rekruitasi PT. Cerebrum Edukanesia Nusantara</h1>
                    </div>
                    @if (count($data) == 0)
                        <div style="text-align: center">
                            <img src="{{ asset('img/'.$company_logo)}}" style="width: 200px">
                            <h1 class="h3">Rekruitasi Kerja Belum Tersedia</h1>
                        </div>
                        @else
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
                                    <input id="domisili-input" type="text" class="form-control @error('address') is-invalid @enderror" placeholder="Domisili" name="address">
                                    @error('address') <div class="text-danger invalid-feedback mt-3">
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
                                <label class="col-md-3 control-label">File CV</label>
                                <div class="col-md-9">
                                    <span class="pull-left btn btn-primary btn-file">
                                    Browse... <input type="file" name="file_cv">
                                    </span>
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label class="col-md-3 control-label">File Portofolio</label>
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
                                            <input value="Kirim Lamaran" type="submit" class="btn btn-primary btn-lg btn-block" disabled>  
                                        </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/nifty.min.js')}}"></script>
    
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