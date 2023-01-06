@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$email}}</h1>
    <p class="description">
        Admin needs to check your data  and verify your profile.<br>
        Once you are admitted , you will receive a verification email.
    </p>
@stop
