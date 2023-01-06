@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi,</h1>
    
    <p class="description">
        You have rejected the deal documents provided by the Borrower Name {{$first_name}} {{$last_name}}. <br>
        Please provide support if needed. <br>
        Deal: (link to the deal)
    </p>

    <p>
        Regards, <br>
        SportsFi Notifications
    </p>
@stop
