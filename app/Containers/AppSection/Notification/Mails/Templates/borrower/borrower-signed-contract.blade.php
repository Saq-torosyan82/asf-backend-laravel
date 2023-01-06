@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$first_name}} {{$last_name}}</h1>

    <p class="description">
        Your executed legal documents for {{$dealType}} have been uploaded, click the link below to view.
        <br>
        Deal: <a href="{{$linkToDeal}}">Deal link</a>
    </p>

    <p>Regards,</p>
    <p>SportsFi</p>
@stop
