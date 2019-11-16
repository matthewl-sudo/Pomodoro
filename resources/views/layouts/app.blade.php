<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/f5a250744a.js" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css"/> -->

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Pomodoro') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ ucfirst(Auth::user()->name) }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/js/timer.js"></script>

    <script>
    // var tf;
    // var start;
    // var length;
    // var end;
    // var x;
    // var now;
    // var remaining;
    // var minutes;
    // var seconds;
    // var d;
    // var i;
    // var left;
    // var right;
    // var line=[];
    // var slice;
    // var pauseTime;
    // var pauseLength;
    //
    // //show default value when page is loaded
    // $(document).ready(function (){
    //     tf = 25;
    // $('#display').html('25:00');});
    //
    //
    // function display () {
    //         $('#display').empty().html(tf + ':00');
    // }
    //
    // //user to add mins
    // $('#more').on('click',function() {
    //     tf = tf + 1 ;
    //     display();
    // });
    //
    // //user to minus mins
    // $('#less').on('click',function() {
    //     if (tf > 1) {
    //         tf = tf - 1;
    //         display();
    //     }
    // });
    //
    //
    // // Update the count down every 1 second
    // function a () {
    //     x = setInterval(function () {
    //         // Get the time when the user clicks
    //         now = $.now();
    //         // Find the distance between now and the count down time
    //         remaining = end - now;
    //         // Time calculations for days, hours, minutes and seconds
    //         minutes = Math.floor((remaining % (1000 * 60 * 60)) / (1000 * 60));
    //         seconds = Math.round((remaining % (1000 * 60)) / 1000);
    //         // Display the result in the element with id="demo"
    //         if (seconds == 60) {
    //             document.getElementById("display").innerHTML = "1:00";
    //         }
    //         else if (seconds < 10) {
    //             document.getElementById("display").innerHTML = minutes + ":0" + seconds;
    //         }
    //         else document.getElementById("display").innerHTML = minutes + ":" + seconds;
    //         // If the count down is finished, write some text
    //         if (remaining < 0) {
    //             clearInterval(x);
    //             document.getElementById("display").innerHTML = "END";
    //         }
    //         //to animate the pie
    //         d = 360 / length;
    //         i = length - remaining;
    //         right = -90 + d * i;
    //         left = -90 + d * i - 180;
    //         //rotates the red, shows blue on the right
    //         if (right < 90) {
    //             line = ['linear-gradient(' + right + 'deg, #ffaed2 50%, transparent 50%)',
    //                 'linear-gradient(-90deg, #5795ee 50%, transparent 50%)'];
    //         }
    //         //rotates the blue, shows blue on both sides
    //         else {
    //             line = ['linear-gradient(' + left + 'deg, #5795ee 50%, transparent 50%)',
    //                 'linear-gradient(-90deg, #5795ee 50%, transparent 50%)'];
    //         }
    //
    //         //to update the class of the pie
    //         slice = $('#timer').css({
    //             'background-image': line.join(',')
    //         });
    //
    //     }, 1000);
    //
    // }
    //
    // //user to start or resume
    // $('#go').on('click', function () {
    //
    // //to start
    //     if (isNaN(pauseTime)) {
    //         start = $.now();
    //         length = tf * 60 * 1000;
    //         end = start + length;
    //         a();
    //     }
    //
    // //to resume
    //     else {
    //         start = $.now();
    //         end = start + pauseLength;
    //         a();
    //     }
    //
    // });
    //
    // //user to pause
    // $('#pause').on('click', function () {
    //     pauseTime = $.now();
    //     pauseLength = end - pauseTime;
    //     clearInterval(x);
    //
    // });
    //
    // //user to reset
    // $('#reset').on('click',function() {
    //     clearInterval(x);
    //     slice = $('#timer').css({
    //         'background-image': 'linear-gradient(-90deg, #ffaed2 50%, transparent 50%)'
    //     });
    //     tf = 25;
    //     display();
    //     pauseTime = NaN;
    // });
    // </script>
</body>
</html>
