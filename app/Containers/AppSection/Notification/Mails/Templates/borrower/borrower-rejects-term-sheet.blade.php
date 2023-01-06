@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$first_name}} {{$last_name}}</h1>

    <p class="description">
        You have rejected the term sheet issued by the Lender {{$lenderName}} for the {{$dealType}}.
    </p>

    <p>
        Click the link to view details. <br>
        <a href="{{$linkToDeal}}">Deal link</a>
    </p>

    <p>Regards,</p>
    <p>SportsFi Notifications</p>
@stop
