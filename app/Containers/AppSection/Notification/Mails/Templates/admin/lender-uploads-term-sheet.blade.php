@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi,</h1>

    <p class="description">
        Lender {{implode(', ', $lenderNames)}} has accepted and uploaded the term sheet for a {{$dealType}} from the Borrower Name {{$first_name}} {{$last_name}}.
    </p>

    <p>
        Deal: <a href="{{$linkToDeal}}">(link to the deal)</a> </p>
    </p>

    <p>
        Regards, <br>
        SportsFi Notifications
    </p>
@stop


