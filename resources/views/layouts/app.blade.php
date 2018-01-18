<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    @if (!Auth::guest())
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.0.0-9/css/ionicons.min.css">
        <link rel="stylesheet" href="/quickstart/public/style/adminLte/AdminLTE.min.css">
        <link rel="stylesheet" href="/quickstart/public/style/adminLte/skins/_all-skins.min.css">
        <link rel="stylesheet" href="/quickstart/public/style/morris.css">
        <link rel="stylesheet" href="/quickstart/public/style/jquery-jvectormap.css">
        <link rel="stylesheet" href="/quickstart/public/style/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="/quickstart/public/style/daterangepicker.css">
        <link rel="stylesheet" href="/quickstart/public/style/bootstrap3-wysihtml5.min.css">
      @endif
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
        .form-control {
            margin-bottom: 10px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
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
                <a class="navbar-brand" href="{{ url('/') }}">
                    Laravel
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                    @if (!Auth::guest() && Auth::user()->email == "admin@gmail.com")
                      <li><a href="{{ url('/tasks') }}">Admin Quizes</a></li>
                      <li><a href="{{ url('/users') }}">Admin Users</a></li>
                      <li><a href="{{ url('/scores') }}">Admin Scores</a></li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    @if (!Auth::guest())

      <script src="/quickstart/public/js/bootstrap.min.js"></script>
      <!-- Morris.js charts -->
      <script src="/quickstart/public/js/raphael.min.js"></script>
      <script src="/quickstart/public/js/morris.min.js"></script>
      <!-- Sparkline -->
      <script src="/quickstart/public/js/jquery.sparkline.min.js"></script>
      <!-- jvectormap -->
      <script src="/quickstart/public/js/jquery-jvectormap-1.2.2.min.js"></script>
      <script src="/quickstart/public/js/jquery-jvectormap-world-mill-en.js"></script>
      <!-- jQuery Knob Chart -->
      <script src="/quickstart/public/js/jquery.knob.min.js"></script>
      <!-- daterangepicker -->
      <script src="/quickstart/public/js/moment.min.js"></script>
      <script src="/quickstart/public/js/daterangepicker.js"></script>
      <!-- datepicker -->
      <script src="/quickstart/public/js/bootstrap-datepicker.min.js"></script>
      <!-- Bootstrap WYSIHTML5 -->
      <script src="/quickstart/public/js/bootstrap3-wysihtml5.all.min.js"></script>
      <!-- Slimscroll -->
      <script src="/quickstart/public/js/slimscroll.js"></script>
      <!-- FastClick -->
      <script src="/quickstart/public/js/fastclick.js"></script>
      <!-- AdminLTE App -->
      <script src="/quickstart/public/js/adminLte/adminlte.min.js"></script>
      <script src="/quickstart/public/js/adminLte/pages/dashboard.js"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="/quickstart/public/js/adminLte/demo.js"></script>



    @endif
    <script src="http://localhost/quickstart/public/js/jquery.hotkeys.js"></script>
    <script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
    <script src="http://localhost/quickstart/public/js/google-code-prettify/prettify.js"></script>
    <link href="http://localhost/quickstart/public/style/index.css" rel="stylesheet">
    <script src="http://localhost/quickstart/public/js/bootstrap-wysiwyg.js"></script>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <!-- JavaScripts -->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->

    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
