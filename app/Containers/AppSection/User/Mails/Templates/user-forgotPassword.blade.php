@extends('ship::layouts.main')
@section('content')
    <h1
        class="heading"
        style="
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          font-family: Mulish, Roboto, sans-serif;
          margin-bottom: 14px;
          font-size: 22px;
          font-weight: bolder;
          color: #253242;
        "
    >
        Reset password
    </h1>

    <img
        id="asf-logo"
        src="{{ url('images/key.png') }}"
        style="
          font-family: Mulish;
          padding: 0;
          box-sizing: border-box;
          margin: 8px auto 20px;
        "
    />

    <p
        class="description"
        style="
          margin: 0;
          box-sizing: border-box;
          font-family: Mulish, Roboto, sans-serif;
          font-size: 16px;
          font-weight: 400;
          margin-bottom: 30px;
          padding: 0 20px;
          color: #253242;
        "
    >
        Please click on the link to reset your password: <a
            href="{{$main_url}}/{{$reseturl}}?email={{$email}}&token={{$token}}">{{$main_url}}/{{$reseturl}}
            ?email={{$email}}&token={{$token}}</a>.
    </p>


@stop

