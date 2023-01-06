@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Hi, {{$name}}</h1>
    <p class="description">
        Amount: {{$amount}} <br>
        Date: {{$date}} <br>
        Deal Date: {{$deal_date}} <br>
    </p>
@stop

