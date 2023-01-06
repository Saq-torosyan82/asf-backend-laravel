@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$first_name}} {{$last_name}}</h1>

    <p class="description">
        Your Term Sheet for {{$dealType}} has been submitted, click the link below to review or amend.
    </p>

    <p>
        Deal: <a href="{{$linkToDeal}}">(link to the deal)</a> </p>
    </p>

    <p>
        Regards, <br>
        SportsFi Notifications
    </p>
@stop


