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
                <div class="col-12 col-md-10 offset-md-1">

                    <div class="row">
                        <div class="col-12">
                            <h1 class="title text-center">DaNasty FFL</h1>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <form method="POST" action="/api/login">
                                <div class="form-group">
                                    <label for="username">MFL Username</label>
                                    <input type="text" class="form-control" id="username" name="username">
                                </div>
                                <div class="form-group">
                                    <label for="password">MFL Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>

                                <button type="submit" class="btn btn-secondary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
