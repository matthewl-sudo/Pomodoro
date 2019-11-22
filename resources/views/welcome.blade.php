<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pomodoro</title>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://kit.fontawesome.com/f5a250744a.js" crossorigin="anonymous"></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            div{
                color: white;
                text-align: center;
                position: relative ;
                top: 20%;
            }
            .right-side{
                border-radius: 60px;
                position: absolute;
                right: 20%;
                top:20%;
            }
        h1, h2, h3, h4, ul, img, p{
            text-align: center;
            position: relative ;
            top: 25%;
            color: black;
            }
            a{
                color:black;
            }
        </style>
    </head>
    <body>
        <header class="row row-height">
            <div class="col-md-6 vcenter order-md-12 " id="">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}"></a>
                    @else
                        <a class="btn btn-outline-danger float-right d-none d-lg-block m-2" id="login" href="{{ route('login') }}">Login</a><br>
                    @endauth
                @endif
                <h2>Join Pomodoro 🍅 Today!(Name Pending)</h2>
                <h2>Stay Focused and get 💩 Done! </h2>
                    <h4></h4>
                @if (Route::has('login'))
                <ul class="center">
                    @auth
                        <a href="{{ url('/home') }}">You Are Already Logged In. Click Here</a>
                    @else
                    <li class="btn btn-success col-6 mb-4" id="signup">
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                        @if (Route::has('register'))
                    <li class="btn btn-danger col-6" id="signup" >
                            <a href="{{ route('register') }}">Sign Up</a>
                    </li>
                        @endif
                    @endauth
                </ul>
                @endif
            </div>
            <div class="col-md-6 vcenter order-md-1" id="">
                <div class="">
                    <h2>Pomodoro</h2>
                    <h4> poh/moh/DOH/roh Translation:Tomatoes Origin:Italian</h4>

                    <p>"The Pomodoro Technique is a time management method developed
                        by Francesco Cirillo in the late 1980s. The technique uses a
                        timer to break down work into intervals, traditionally 25 minutes in length."
                    </p>
                    <h4> Inspired by the wildly popular "Forest App" by Seekrtech <br> and by the PHP artisan inspire command</h4>
                    <h2><b>Features Include...</b></h2>
                    <h3>Competetive atmospere with your peers.<br> Displaying Levels & LeaderBoards</h3>
                    <h3>Generating Inspirational Quotes to keep you inspired.</h3>
                    <h3>Work/Reward Design Aspect (Coming Soon)</h3>
                    <h3>Possibly Spotify Integration (Also Coming Soon)</h3>
                </div>
            </div>
        </header>
    </body>
</html>
