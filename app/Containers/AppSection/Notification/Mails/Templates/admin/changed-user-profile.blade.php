@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi,</h1>


    <p class="description">
        Borrower Name {{$first_name}} {{$last_name}} has updated their user Profile. Please review and approve if required
    </p>

    <p>Regards,</p>
    <p>SportsFi Notifications</p>
@stop
