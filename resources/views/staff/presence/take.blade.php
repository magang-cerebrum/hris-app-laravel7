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

    <link href="{{ asset('css/login/main.tambah.css')}}" rel="stylesheet">

    <link href="{{asset('css/demo/nifty-demo-icons.min.css')}}" rel="stylesheet">

    <link href="{{ asset('plugins/pace/pace.min.css')}}" rel="stylesheet">
    <script src="{{ asset('plugins/pace/pace.min.js')}}"></script>

</head>
<body>
    <div id="container" class="cls-container">
        <div id="bg-overlay1" class="bg-img"></div>

        <div class="cls-content">
            <div class="cls-content-sm panel">
                <div class="panel-body">
                    <div class="mar-ver pad-btm">
                        <img src="{{ asset('img/title-cerebrum.png')}}" style="width: 30%">
                        <h1 class="h3">Sukses</h1>
                        <p>Human Resource Information System</p>
                    </div>
                    
                    <a href="{{ url('recruitment')}}">
                        <button class="btn btn-primary btn-lg btn-block">Ke Halaman Rekruitasi</button>
                    </a>
                    
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/nifty.min.js')}}"></script>
    
    <script src="{{ asset('plugins/sparkline/jquery.sparkline.min.js')}}"></script>

</body>
</html>