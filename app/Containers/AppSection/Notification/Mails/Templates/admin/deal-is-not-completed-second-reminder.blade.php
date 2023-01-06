@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$email}}</h1>
    <p class="description">
        Borrower Name {{$firstName}} {{$lastName}} has an unsubmitted deal. <br>
        Deal: <a href="{{$linkToDeal}}">(link to the deal)</a>
    </p>
    <p>Regards,</p>
    <p>SportsFi Notifications</p>

@stop
