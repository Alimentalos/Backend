<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Alimentalos - {{ __('Help us to save ours animals.') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script src="https://kit.fontawesome.com/c0a3e57ca3.js" crossorigin="anonymous"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 20px;
                top: 30px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 60px;
            }

            .body {
                margin-top: 100px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
            }

            .fal, .fab {
                font-size: 20px;
                margin-right: 10px;
                margin-left: 5px;
                padding-top: 10px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .body > a {
                border-radius: 5px;
                border: 1px solid #cccccc;
                padding: 15px 7px 10px 7px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="https://github.com/alimentalos"><i class="fab fa-github"></i> {{ __('GitHub') }}</a>
                    <a href="{{ url('/about') }}"><i class="fal fa-book-alt"></i> About</a>
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}"><i class="fal fa-sign-in"></i> Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"><i class="fal fa-user-plus"></i> Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Alimentalos
                </div>

                <div class="links body">
                    <a href="https://app.alimentalos.cl/geofences"><i class="fal fa-draw-polygon"></i> Geofences</a>
                    <a href="https://app.alimentalos.cl/pets"><i class="fal fa-paw"></i> Pets</a>
                    <a href="https://app.alimentalos.cl/users"><i class="fal fa-users"></i> Users</a>
                    <a href="https://app.alimentalos.cl/groups"><i class="fal fa-users-class"></i> Groups</a>
                    <a href="https://app.alimentalos.cl/photos"><i class="fal fa-image-polaroid"></i> Photos</a>
                    <a href="https://app.alimentalos.cl/devices"><i class="fal fa-mobile"></i> Devices</a>
                </div>
            </div>
        </div>
    </body>
</html>
