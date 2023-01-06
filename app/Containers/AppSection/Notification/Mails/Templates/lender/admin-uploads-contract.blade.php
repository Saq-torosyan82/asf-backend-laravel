@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$lenderName}}</h1>

    <p class="description">
        Legal documentations for {{$dealType}} have been uploaded to the platfrom, click the link below to view.
        <br>
        Deal: <a href="{{$linkToDeal}}">Deal link</a>
    </p>
    <p>Regards,</p>
    <p>SportsFi</p>
@stop
