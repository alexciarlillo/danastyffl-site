<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DaNasty FFL') }}</title>

        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
    </head>
    <body>
        <div class="hero-banner"></div>
        <div class="hero-cover"></div>
        
        @include('layouts.header')

        <div class="container content">
            <div class="row mt-2">
                <div class="col-12 col-md-10 offset-md-1">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
