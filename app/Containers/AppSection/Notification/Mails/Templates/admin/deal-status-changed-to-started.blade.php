@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, admin</h1>
    <p>Context: deal status changed to started</p>
    <p>Recipient: Admin</p>
    <p>Variables:</p>
    <p>
    <li>Email: {{$email}}</li>
    <li>First name: {{$first_name}}</li>
    <li>Last name: {{$last_name}}</li>
    </p>
    <p class="description">
        Note: other variables can be added depending on the mail content
    </p>
@stop
