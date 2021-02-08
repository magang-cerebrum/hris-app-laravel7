<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HRIS</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/nifty.min.css" rel="stylesheet">

    <link href="css/login/main.tambah.css" rel="stylesheet">

    <link href="{{asset('css/demo/nifty-demo-icons.min.css')}}" rel="stylesheet">

    <link href="plugins/pace/pace.min.css" rel="stylesheet">
    <script src="plugins/pace/pace.min.js"></script>

</head>
<body>
    <div id="bg-overlay1" class="bg-img"></div>
    <div class="cls-content">
        <div class="cls-content-sm panel">
            <div class="panel-body">
                <div class="mar-ver pad-btm">
                    <h1 class="h3">Login</h1>
                    <p>Human Resource Information System Login Pages</p>
                </div>
                <form method='POST' action="{{route('login')}}">
                    @csrf
                    <div class="form-group">
                        <input required type="text" name="nip" class="form-control" placeholder="NIP or Email" autofocus>
                        @error('nip')
                                <div class="invalid-feedback is-invalid" role="alert">
                                    <strong>Error : {{ session()->get('error')}}</strong>
                                </div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <input name="password" type="password" class="form-control" placeholder="Password" required>
                        @error('password')
                        <div class="invalid-feedback is-invalid" role="alert">
                            <strong>Error : {{ session()->get('error')}}</strong>
                        </div>
                    @enderror
                    </div>
           
                    <div class="checkbox pad-btm text-left">
                        <input id="demo-form-checkbox" class="magic-checkbox" type="checkbox" name="remember">
                        <label for="demo-form-checkbox">Remember me</label>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Sign In</button>
                </form>
            </div>
            {{-- {{dd(Auth::check())}} --}}
            {{-- {{dd(MasterUser::all()->password)}} --}}
            {{-- <p>{{dd(Auth::logout())}}</p> --}}
        </div>
    </div>
</body>