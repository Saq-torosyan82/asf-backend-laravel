@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$first_name}} {{$last_name}}</h1>

    <p class="description">
        Lender {{implode(', ', $lenderNames)}} has accepted the {{$dealType}} and issued the term sheet.
    </p>

    <p>
        Deal: <a href="{{$linkToDeal}}">(link to the deal)</a> </p>
    </p>

    <p>
        Regards, <br>
        SportsFi Notifications
    </p>
@stop
