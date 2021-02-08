
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link href="{{ url('https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700')}}"" rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/nifty.min.css')}}" rel="stylesheet">

    <link href="{{ asset('css/admin/main.tambah.css')}}" rel="stylesheet">

    <link href="{{ asset('css/demo/nifty-demo-icons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    <link href="{{ asset('plugins/pace/pace.min.css')}}" rel="stylesheet">
    <script src="{{ asset('plugins/pace/pace.min.js')}}"></script>
    <script src="{{ asset('js/jquery.min.js')}}"></script>

</head>
<body>
    {{-- <div id="bg-overlay1" class="bg-img"></div>
    <div class="cls-content"> --}}
        
    <div id="bg-overlay1" class="bg-img"></div>
    <div class="cls-content">
        <div class="cls-content-sm panel">
            <div class="panel-body">
                
                @if (Request::is('admin/password/*'))
                    
                <div class="mar-ver pad-btm">
                    <h1 class="h3">Admin Change Password</h1>
                    <p>Human Resource Information System Change Password Pages</p>
                </div>
                <form action="/admin/password/{{$pass->id}}/saved" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                       Password Lama : <input type="password" name="oldpassword" class="form-control" placeholder="Old Password" autofocus>
                    </div>
                    @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                    @endif
                    <div class="form-group">
                       Password Baru : <input name="newpassword" type="password" class="form-control" placeholder="New Password">
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Sign In</button>
                 </form>
                @elseif (Request::is('staff/password/*'))
                <div class="mar-ver pad-btm">
                    <h1 class="h3">Staff Change Password</h1>
                    <p>Human Resource Information System Change Password Pages</p>
                </div>
                <form action="/staff/password/{{$pass->id}}/saved" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                       Password Lama : <input type="password" name="oldpassword" class="form-control" placeholder="Old Password" autofocus>
                    </div>
                    @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                    @endif
                    <div class="form-group">
                       Password Baru : <input name="newpassword" type="password" class="form-control" placeholder="New Password">
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Sign In</button>

                </form>
                @endif
            </div>
    
        </div>
    </div>
</div>
</body>
</html>


{{-- 
<form action="/staff/password/{{$pass->id}}/saved" method="post">
    @csrf
    @method('put')
    <input class="" type="password" name="oldpassword" id="" placeholder="Password Lama">
    <input type="password" name="newpassword" id="">
   <button value="submit">Submit</button>
</form> --}}