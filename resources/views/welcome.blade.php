<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Alimentalos - {{ __('Help us to save ours animals.') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

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

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="https://www.alimentalos.cl/about">About</a>
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Alimentalos
                </div>

                <div class="links body">
                    <a href="https://app.alimentalos.cl/geofences">Geofences</a>
                    <a href="https://app.alimentalos.cl/pets">Pets</a>
                    <a href="https://app.alimentalos.cl/users">Users</a>
                    <a href="https://app.alimentalos.cl/groups">Groups</a>
                    <a href="https://app.alimentalos.cl/photos">Photos</a>
                    <a href="https://app.alimentalos.cl/devices">Devices</a>
                </div>
            </div>
        </div>
    </body>
</html>
