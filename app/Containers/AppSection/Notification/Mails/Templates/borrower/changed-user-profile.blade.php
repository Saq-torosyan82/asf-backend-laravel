@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$first_name}} {{$last_name}}</h1>

    <p class="description">
        A change has been made to your profile, please click the link below for more details.
        <br>
        <a href="{{$linkToProfile}}">Profile</a>
    </p>

    <p>Regards,</p>
    <p>SportsFi</p>
@stop
