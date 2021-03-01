
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/title-cerebrum.png')}}">
    
    <title>Reset Password</title>
    <link href="{{ url('https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700')}}"" rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/nifty.min.css')}}" rel="stylesheet">

    <link href="{{ asset('css/login/main.tambah.css')}}" rel="stylesheet">
    <script src="{{ asset('js/jquery.min.js')}}"></script>

    <link href="{{ asset('css/demo/nifty-demo-icons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
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
                
                @if (Request::is('admin/password'))
                    
                <div class="mar-ver pad-btm">
                    <h1 class="h3">Admin Change Password </h1><i class="fa fa-info-circle" title="Gunakan CTRL + SPACE untuk melihat password atau bisa klik pada logo gembok"></i>
                    <p>Human Resource Information System Change Password Pages</p>
                </div>
                <form action="/admin/password/saved" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="id" value="{{$id}}">
                    <div class="form-group">
                        Password Lama : 
                        <div class="input-group">
                        <input id="pass-form2" type="password" name="oldpassword" class="form-control" placeholder="Password Lama" autofocus>
                        <span class="input-group-addon" onmousedown="mousedownolPass();" onmouseup="mouseoutolPass();">
                            <i class="fa fa-lock" title="Password"></i>
                         </span>
                        </div>
                    </div>
                    @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                    @endif
                    <div class="form-group"> 
                        Password Baru : 
                        <div class="input-group">
                        <input id="pass-form" name="newpassword" type="password" class="form-control @error('newpassword') is-invalid @enderror" placeholder="Password Baru">
                        <span class="input-group-addon" onmousedown="mousedownnewPass();" onmouseup="mouseoutnewPass();">
                         <i class="fa fa-lock" title="Password"></i>
                         </span>
                        </div>
                     </div>
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
                 </form>
                @elseif (Request::is('staff/password'))
                <div class="mar-ver pad-btm">
                    <h1 class="h3">Staff Change Password</h1><i class="fa fa-info-circle" title="Gunakan CTRL + SPACE untuk melihat password atau bisa klik pada logo gembok"></i>
                    <p>Human Resource Information System Change Password Pages</p>
                </div>
                <form action="/staff/password/saved" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="id" value="{{$id}}">
                    <div class="form-group">
                        Password Lama : 
                        <div class="input-group">
                        <input id="pass-form2" type="password" name="oldpassword" class="form-control" placeholder="Password Lama" autofocus>
                        <span class="input-group-addon">
                            <i class="fa fa-lock" title="Password"></i>
                         </span>
                        </div>
                    </div>
                    @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                    @endif
                    <div class="form-group"> 
                       Password Baru : 
                       <div class="input-group">
                       <input id="pass-form" name="newpassword" type="password" class="form-control @error('newpassword') is-invalid @enderror" placeholder="Password Baru">
                       <span class="input-group-addon">
                        <i class="fa fa-lock" title="Password"></i>
                        </span>
                       </div>
                    </div>
                    
                    {{-- @if (session()->has('error2'))
                    <div class="alert alert-danger">
                        {{ session()->get('error2') }}
                    </div>
                    @endif
                     --}}

                    <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>

                </form>
                @endif
            </div>
    
        </div>
    </div>
</div>
</body>
<script>

function mousedownnewPass(obj) {
  var obj = document.getElementById('pass-form');
  obj.type = "text";
}
function mouseoutnewPass(obj) {
  var obj = document.getElementById('pass-form');
  obj.type = "password";
}

function mousedownolPass(obj) {
  var obj = document.getElementById('pass-form2');
  obj.type = "text";
}
function mouseoutolPass(obj) {
  var obj = document.getElementById('pass-form2');
  obj.type = "password";
}

  function KeyPress(e) {
        var evtobj = window.event? event : e
        var obj = document.getElementById('pass-form');
        var obj2 = document.getElementById('pass-form2')
        
      if (evtobj.keyCode == 32 && evtobj.ctrlKey) obj.type = "text" , obj2.type="text";
      else obj.type = "password" , obj2.type="password";
    };

 document.onkeydown =  KeyPress;

</script>
</html>


