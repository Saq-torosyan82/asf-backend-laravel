@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi,</h1>
    <p class="description">
        Lender {{$lenderName}} has executed the legal documentation for the {{$dealType}} from the Borrower Name {{$first_name}} {{$last_name}}
        <br>
        Deal: <a href="{{$linkToDeal}}">Deal link</a>
    </p>

    <p>Regards,</p>
    <p>SportsFi Notifications</p>
@stop
