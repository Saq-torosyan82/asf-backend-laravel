@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$first_name}} {{$last_name}}</h1>

    <p class="description">
        You have successfully submitted a deal for approval by SportsFi.
        <br>
        Click to review or amend deal details. <br>
        <a href="{{$linkToDeal}}">Deal link</a>
    </p>

    <p>
        Regards, <br>
        SportsFi Notifications
    </p>
@stop
