<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HRIS</title>
    <link rel="icon" href="{{ asset('img/'.$company_logo)}}">
    <link href="{{ asset('css/fonts.css')}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/nifty.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/login/main.tambah.css')}}" rel="stylesheet">
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('plugins/pace/pace.min.css')}}" rel="stylesheet">
    <script src="{{ asset('plugins/pace/pace.min.js')}}"></script>
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
                            <input required autocomplete="off" type="text" name="nip" class="form-control" placeholder="NIP" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-lock" title="Password"></i>
                            </span>
                            <input name="password" type="password" class="form-control" placeholder="Password"
                                id="pass-form" autocomplete="off" required>
                            <span onmousedown="mousedownPass();" onmouseup="mouseoutPass();" class="input-group-addon">
                                <i class="fa fa-eye" title="Lihat Password"></i>
                            </span>
                        </div>
                        <input type="hidden" name="remember_me">
                        <div class="message"></div>
                        <div class="invalid-feedback is-invalid" role="alert">
                            <strong>{{ session()->get('error')}}</strong>
                        </div>
                    </div>
                    <div class="checkbox pad-btm text-left">
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Sign In</button>
                </form>
            </div>
        </div>
    </div>
</body>

    @include('sweetalert::alert')
<script>
    function mousedownPass(obj) {
        var obj = document.getElementById('pass-form');
        obj.type = "text";
    }

    function mouseoutPass(obj) {
        var obj = document.getElementById('pass-form');
        obj.type = "password";
    }

    const password = document.querySelector('#pass-form');
    const message = document.querySelector('.message');

    password.addEventListener('keyup', function (e) {
        if (e.getModifierState('CapsLock')) {
            message.textContent = 'Capslock anda menyala';
            message.className = "text-warning fa fa-warning"
        } else {
            message.textContent = '';
            message.className = "message"
        }
    });

</script>
