

@extends('ship::layouts.main')
@section('content')
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

    <h3
        class="heading"
        style="
          padding: 0;
          box-sizing: border-box;
          font-family: Mulish, Roboto, sans-serif;
          margin: 25px 0 10px;
          font-size: 18px;
          color: #253242;
        "
    >
        Hi, {{$email}}
    </h3>
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
        Click to log in on this device.<br
            style="
            font-family: Mulish;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
          "
        />To Log in on a differnt device, open this email on there.
    </p>
    <a
        class="login"
        href="{{$autologin_url}}"
        style="
          margin: 0;
          box-sizing: border-box;
          font-family: Mulish, Roboto, sans-serif;
          color: #ffffff;
          background-color: #369eba;
          padding: 17px 78px;
          border-radius: 4px;
          font-size: 14px;
          font-weight: 700;
          display: inline-block;
          margin-bottom: 15px;
          cursor: pointer;
        "
    >Log me in</a
    >
    <p
        class="valid"
        style="
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          font-family: Mulish, Roboto, sans-serif;
          font-size: 14px;
          font-weight: 300;
        "
    >
        Valid for 1 hour.
    </p>

@stop
