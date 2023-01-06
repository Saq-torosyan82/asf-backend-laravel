@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi,</h1>

    <p class="description">
        Borrower Name {{$first_name}} {{$last_name}} has an rejected the term sheet for a {{$dealType}} from Lender {{$lenderName}}.
    </p>

    <p>
        Deal: <a href="{{$linkToDeal}}">(link to the deal + Term Sheet)</a>
    </p>

    <p>Regards,</p>
    <p>SportsFi Notifications</p>
@stop
