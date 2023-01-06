@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$firstName}} {{$lastName}}</h1>
    <p class="description">
        You have an unsubmitted deal. Click to log in on this device to continue with this deal.
    </p>
    <a class="login" href="{{$autologin_url}}">Log me in</a>
    <p class="valid">Valid for 1 hour.</p>

    <p>Regards,</p>
    <p>SportsFi Notifications</p>
@stop
