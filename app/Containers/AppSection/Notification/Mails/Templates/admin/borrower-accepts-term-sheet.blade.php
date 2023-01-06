@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi,</h1>

    <p class="description">
        Borrower Name {{$first_name}} {{$last_name}} has an accepted the Term sheet submitted by the Lender {{$lenderName}} for {{$dealType}}.
    </p>
    <p>
        Deal: <a href="{{$linkToDeal}}">Deal link</a>
    </p>

    <p>Regards,</p>
    <p>SportsFi Notifications</p>
@stop
