@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi,</h1>
    <p class="description">Borrower Name {{$first_name}} {{$last_name}} has an submitted a deal for approval.</p>


    <p>Deal: <a href="{{$linkToDeal}}">(link to the deal)</a> </p>

    <p></p>
    <p>
        Regards, <br>
        SportsFi Notifications
    </p>
@stop
