@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$first_name}} {{$last_name}}</h1>

    <p class="description">
        SportsFi has approved {{$dealType}} submitted by you. The deal is now available for prospective Lenders to review and issue term sheet.
    </p>

    <p>
        Click to view Deal. <br>
        <a href="{{$linkToDeal}}">Deal Link</a>
    </p>

    <p>
        Regards, <br>
        SportsFi Notifications
    </p>
@stop
