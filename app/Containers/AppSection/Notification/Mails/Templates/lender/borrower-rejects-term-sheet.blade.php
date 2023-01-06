@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$lenderName}}</h1>
    <p class="description">
        There has been an update regarding {{$dealType}} please click the link below for more details.
    </p>

    <p>Regards,</p>
    <p>SportsFi Notifications</p>
@stop
