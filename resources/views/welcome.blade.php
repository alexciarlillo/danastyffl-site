@extends('layouts.app')

@section('content')
    @if(Auth::check())
        <h1>Logged in As {{ Auth::user() }}</h1>
    @else
        <h1>NOT Logged In</h1>
    @endif
    <div id="app"></div>
@endsection
