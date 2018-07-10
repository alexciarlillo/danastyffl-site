@extends('layouts.app')

@section('content')
    <div class="container login">
            <div class="row mt-2">
                <div class="col-12 col-md-10 offset-md-1">

                    <div class="row">
                        <div class="col-12">
                            <h1 class="title text-center">DaNasty FFL</h1>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <form method="POST" action="/login">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="username">MFL Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">MFL Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-secondary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
