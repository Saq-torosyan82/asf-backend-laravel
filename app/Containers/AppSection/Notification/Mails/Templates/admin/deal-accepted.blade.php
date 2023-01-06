@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi,</h1>

    <p class="description">
        You have approved a deal submitted by Borrower Name {{$first_name}} {{$last_name}} for Lenders review. <br>
        Deal: <a href="{{$linkToDeal}}">(link to the deal)</a>
    </p>

    <p>
        Regards, <br>
        SportsFi Notifications
    </p>
@stop
