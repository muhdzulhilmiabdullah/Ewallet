<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>xE-wallet</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    
    <style>
        body {
            font-family: 'Lato';
            background: #222831;
            color:#EEEEEE;
            
        }
        .fa-btn {
            margin-right: 6px;
        }
        #videoCam {
         width: 50vh;
         height: 50vh;
         margin-left: 0px;
         border: 3px solid #ccc;
         background: black;
      }
      #startBtn {
         
         width: 120px;
         height: 45px;
         cursor: pointer;
         font-weight: bold;
      }
      #startBtn:hover{
         background-color: #647C90;
         color: red;
      }
      .panel-default>.panel-heading{
        background: #393E46;
        color:#EEEEEE;
        border-color:#393E46;  
        border-radius: 12px; 
      }
      .btn-default{
        color: #EEEEEE;
        background-color: #00ADB5;
        border-color: #393E46;
      }
      .input-group .form-control:last-child, .input-group-addon:last-child, .input-group-btn:first-child>.btn-group:not(:first-child)>.btn, .input-group-btn:first-child>.btn:not(:first-child), .input-group-btn:last-child>.btn, .input-group-btn:last-child>.btn-group>.btn, .input-group-btn:last-child>.dropdown-toggle{        
        background-color: #393E46;
        color:#EEEEEE;
      }
      .input-group-addon:first-child{
        background-color: #393E46;
        color:#EEEEEE;
      }
      .form-control{
        background-color: #393E46;
        color:#EEEEEE;
      }
      .panel-default {
        border-color: #393E46;
        background-color: #393E46;
        border-radius: 12px;
        padding: 2px;
      }
      .panel-body {
        background-color: #393E46;
        color:#EEEEEE;
      }
      .panel>.table-responsive{
        background-color: #393E46;
        color:#EEEEEE;
        margin-bottom: 10px;
      }
      .container-fluid>.navbar-collapse, .container-fluid>.navbar-header, .container>.navbar-collapse, .container>.navbar-header{
        background-color: #393E46;
        color:#EEEEEE;
        
      }
      .navbar-default .navbar-brand{
        color:#EEEEEE;
      }
      .navbar-default{
        color:#EEEEEE;
        border-color: #393E46;
        background-color: #393E46;
      }
      .navbar-default .navbar-nav>li>a{
        color:#EEEEEE;
        border-color: #393E46;
        background-color: #393E46;
      }
      .navbar-default .navbar-nav>.open>a, .navbar-default .navbar-nav>.open>a:focus, .navbar-default .navbar-nav>.open>a:hover{
        color:#EEEEEE;
        border-color: #393E46;
        background-color: #393E46;
      }
      .navbar-nav>li>.dropdown-menu{
        border-color: #393E46;
        background-color: #393E46;
      }
      .dropdown-menu>li>a{
        color:#EEEEEE;
      }
      .navbar-default .navbar-toggle{
        border-color: #393E46;
        color:#EEEEEE;
      }
      .navbar-default .navbar-toggle:focus, .navbar-default .navbar-toggle:hover{
        background-color: #393E46;
        border-color: #393E46;
      }
      .container-fluid>.navbar-collapse, .container-fluid>.navbar-header, .container>.navbar-collapse, .container>.navbar-header{
        border-color: #393E46;
      }
      .navbar-default .navbar-nav .open .dropdown-menu>li>a{
        color:#EEEEEE;
      }
      .panel>.table-responsive:last-child>.table:last-child, .panel>.table:last-child{
        border: 1px solid;
        
      }

      



    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                @if (Auth::guest())
                <a class="navbar-brand" href="{{ url('/') }}">
                    xE-wallet
                </a>
                @else
                <a class="navbar-brand" href="{{ url('/home') }}">
                    xE-wallet
                </a>
                @endif
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <!-- <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                </ul> -->
                

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }}   <span class="caret"></span>

                            <ul class="dropdown-menu" role="menu">
                                @if(Auth::user()->role ==1)
                                <li><a href="{{ url('/allUser') }}"><i class="fa fa-btn fa-sign-out"></i>Settings</a></li>
                                <li><a href="{{ url('/promoCode') }}"><i class="fa fa-btn fa-sign-out"></i>Promo Code</a></li>
                                <li><a href="{{ url('/qrCode') }}"><i class="fa fa-btn fa-sign-out"></i>QR Code</a></li>  
                                @endif
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="{{ URL::asset('src/js/ewallet.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script>
      function openCam(){
         let All_mediaDevices=navigator.mediaDevices
         if (!All_mediaDevices || !All_mediaDevices.getUserMedia) {
            console.log("getUserMedia() not supported.");
            return;
         }
         All_mediaDevices.getUserMedia({
            audio: true,
            video: true
         })
         .then(function(vidStream) {
            var video = document.getElementById('videoCam');
            if ("srcObject" in video) {
               video.srcObject = vidStream;
            } else {
               video.src = window.URL.createObjectURL(vidStream);
            }
            video.onloadedmetadata = function(e) {
               video.play();
            };
         })
         .catch(function(e) {
            console.log(e.name + ": " + e.message);
         });
      }
   </script>

    <footer class="links" align="center" style="margin-top:50px;">
                <p>by Xul &#169</p>
    </footer>
</body>

</html>
