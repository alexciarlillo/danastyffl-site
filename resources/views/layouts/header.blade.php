<div class="container header">
    <div class="row">
        <div class="col-12 col-md-10 offset-md-1">

            <nav class="navbar navbar-light navbar-toggleable-sm">
                <div class="collapse navbar-collapse">
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse">
                        <div class="navbar-text">
                            @if(Auth::check())
                                <h1>{{ Auth::user()->getTeamName() }}</h1>
                            @endif
                        </div>

                        <div class="navbar-nav ml-auto">
                            <li class="nav-item mr-1">
                                @if(Auth::check())
                                    <a class="nav-link btn btn-secondary" href="{{ URL::route('logout') }}">Logout</a>
                                @else
                                    <a class="nav-link btn btn-secondary" href="{{ URL::route('login') }}">Login</a>
                                @endif
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-secondary" href="https://{{ config('mfl.league_host') }}/2017/home/{{ config('mfl.league_id')}}">Go to MFL</a>
                            </li>
                        </div>
                    </div>

                </div>
            </nav>

            <div class="row">
                <div class="col-12">
                    <h1 class="title text-center">DaNasty FFL</h1>
                </div>
            </div>
        </div>
    </div>
</div>
