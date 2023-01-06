@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Dear {{$name}}</h1>
    <p>Admin rejected financial documents for {{$sheet}}</p>
    <p>Reason of rejection: {{$reason}}</p>

@stop
