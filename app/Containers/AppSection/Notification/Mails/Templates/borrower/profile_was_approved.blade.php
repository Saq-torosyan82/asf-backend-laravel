@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">You are verified</h1>
    <p class="description">
        Click to proceed  to the dashboard  and join your company.<br>
        To log in on different device, open this email on there.
    </p>
    <a class="login" href="{{$autologin_url}}">Start</a>
    <p class="valid">Valid for 1 hour.</p>
@stop
