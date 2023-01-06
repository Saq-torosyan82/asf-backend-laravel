@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Dear {{$full_name}}</h1>
    <p>You received new message from {{$sender}}</p>
@stop
