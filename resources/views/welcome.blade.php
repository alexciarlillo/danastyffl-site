<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DaNasty FFL</title>
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    </head>
    <body>
        <div class="container">
            <div class="row mt-2">
                <div class="col-10 offset-1">

                    <div class="row">
                        <div class="col-12">
                            <h1 class="title display-2 text-center">DaNasty FFL</h1>
                        </div>
                    </div>

                    <div class="row mt-4 mb-4">
                        <div class="col-4 offset-4">
                            <a class="btn btn-secondary btn-block" href="https://{{ config('mfl.league_host') }}/2017/home/{{ config('mfl.league_id')}}">Go to MFL</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row mt-2">
                <div class="col-10 offset-1">
                    <div id="app"></div>
                </div>
            </div>
        </div>
    </body>
    <script src="{{ mix('/js/app.js') }}"></script>
</html>
