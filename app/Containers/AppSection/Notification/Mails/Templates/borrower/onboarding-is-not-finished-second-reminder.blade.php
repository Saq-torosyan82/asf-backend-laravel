@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$email}}</h1>
    <p class="description">
        You have not completed the onboarding process.  <br>
        Click to log in on this device to continue.
    </p>
    <a class="login" href="{{$autologin_url}}">Log me in</a>
    <p class="valid">Valid for 1 hour.</p>
@stop
