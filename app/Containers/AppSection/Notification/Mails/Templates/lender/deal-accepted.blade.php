@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$lender_full_name}}</h1>
    <p class="description">
        A deal matching your criteria has been listed on the platform, please click the link below to view more details.
    </p>
    <p>
        <a href="{{$linkToDeal}}">Deal Link</a>
    </p>
    <p>
        Regards, <br>
        SportsFi Notifications
    </p>
@stop
