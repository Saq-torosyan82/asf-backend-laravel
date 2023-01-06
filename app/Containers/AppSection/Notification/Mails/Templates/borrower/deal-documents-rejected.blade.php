@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$first_name}} {{$last_name}}</h1>
    <p class="description">
        SportsFi has reviewed and rejected the deal documents submitted by you. Kindly contact SportsFi support for further details.
        <br>

        Click to review Deal. <a href="{{$linkToDeal}}">Deal link</a>
    </p>

    <p>
        Regards, <br>
        SportsFi Notifications
    </p>
@stop
