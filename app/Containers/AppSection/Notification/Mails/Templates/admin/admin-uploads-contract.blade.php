@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi,</h1>

    <p>SportsFi admin uploads Contract</p>

    <p class="description">
        You have successfully uploaded the legal documentation for {{$dealType}} for the {{$first_name}} {{$last_name}}.
        <br>
        Deal: <a href="{{$linkToDeal}}">Deal link</a>
    </p>

    <p>Regards,</p>
    <p>SportsFi Notifications</p>
@stop
