@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$lenderName}}</h1>

    <p class="description">
        {{$first_name}} {{$last_name}} has accepted your term sheet for {{$dealType}}, click the link below for more details.
        <br>
        <a href="{{$linkToDeal}}">Deal link</a>
    </p>

    <p>Regards,</p>
    <p>SportsFi Notifications</p>
@stop
