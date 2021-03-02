<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>HRIS</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/nifty.min.css" rel="stylesheet">

    <link href="css/login/main.tambah.css" rel="stylesheet">
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    {{-- <link href="{{asset('css/demo/nifty-demo-icons.min.css')}}" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="{{asset(style.css)}}"> --}}
    <link href="plugins/pace/pace.min.css" rel="stylesheet">
    <script src="plugins/pace/pace.min.js"></script>
    <style>
        input::-ms-reveal,
      input::-ms-clear {
        display: none;
      }
    </style>
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
                        <div class="input-group">
                         <span class="input-group-addon">
                            <i class="fa fa-drivers-license-o" title="NIP"></i>
                         </span>
                        <input required type="text" name="nip" class="form-control" placeholder="NIP" autofocus>
                        </div>
                                {{-- <div class="invalid-feedback is-invalid" role="alert">
                                    <strong>{{ session()->get('errornip')}}</strong>
                                </div> --}}
                            
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-lock" title="Password"></i>
                             </span>
                            <input name="password" type="password" class="form-control" placeholder="Password" id="pass-form" required> 
                        <span onmousedown="mousedownPass();" onmouseup="mouseoutPass();" class="input-group-addon">
                            <i class="fa fa-eye" title="Lihat Password"></i>
                        </span>
                        </div>
                        <div class="invalid-feedback is-invalid" role="alert">
                            <strong>{{ session()->get('error')}}</strong>
                        </div>
                        
                        
                    </div>
                    
                    <div class="checkbox pad-btm text-left">
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
{{-- @section('script') --}}
    <script>
        function mousedownPass(obj) {
  var obj = document.getElementById('pass-form');
  obj.type = "text";
}
function mouseoutPass(obj) {
  var obj = document.getElementById('pass-form');
  obj.type = "password";
}
    // console.log("Hello world")
    </script>
{{-- @endsection --}}