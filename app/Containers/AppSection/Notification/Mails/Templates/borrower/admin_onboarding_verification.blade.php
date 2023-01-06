@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">User needs verification</h1>
    <p class="description">
        A new user wants to get an access to the company dashboard <br><br>

        Email: {{$email}} <br>
        First name: {{$firstName}} <br>
        Last name: {{$lastName}} <br>
        User type: {{$userType}} <br>
        Organisation name: {{$organisationName}} <br>
        Company registration number: {{$registrationNumber}} <br>
        Office number: {{$officeNumber}} <br>
        Phone number: {{$phoneNumber}} <br>
    </p>

    <a class="login" href="{{$autologin_url}}">Log me in</a>
    <p class="valid">Valid for 1 hour.</p>

    <p class="buttons">
        <a href="{{$approve}}" class="button">Verify the user</a>
        <a href="{{$reject}}" class="button">Decline the user</a>
    </p>
@stop
