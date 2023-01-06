@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$lenderName}}</h1>

    <p class="description">

        {{$first_name}} {{$last_name}} has executed the legal documentation for {{$dealType}}, click the link below to view.

        <br>
        Deal: <a href="{{$linkToDeal}}">Deal link</a>
    </p>

    <p>Regards,</p>
    <p>SportsFi</p>
@stop
