<!DOCTYPE html>
<html
    lang="en"
    style="font-family: Mulish; margin: 0; padding: 0; box-sizing: border-box"
>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>SportsFi Email Template</title>
</head>
<body
    style="
      font-family: Mulish;
      margin: 0;
      box-sizing: border-box;
      background-color: #efefef;
      text-align: center;
      padding: 40px;
    "
>

<img
    id="asf-logo"
    src="{{ url('images/Logo-email.png') }}"
    style="
        font-family: Mulish;
        padding: 0;
        box-sizing: border-box;
        margin: 8px auto 20px;
      "
/>

{{-- Content --}}

<div
    class="container"
    style="
        font-family: Mulish;
        box-sizing: border-box;
        background-color: #ffffff;
        height: auto;
        max-width: 644px;
        padding: 64px 0;
        margin: 0 auto 24px;
        border-radius: 6px;
      "
>
    @yield('content')
</div>

{{-- Footer --}}

<p
    class="copy"
    style="
        padding: 0;
        box-sizing: border-box;
        font-family: Mulish, Roboto, sans-serif;
        font-size: 10px;
        font-weight: 400;
        max-width: 588px;
        margin: 8px auto 0;
        color: #93a0ae;
      "
>
    If the message from All Sports Finance is not addressed to you please,
    delete it.<br
        style="
          font-family: Mulish;
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        "
    />The message was generated automatically. Please do not reply to it.
</p>

<p
    class="copy"
    style="
        padding: 0;
        box-sizing: border-box;
        font-family: Mulish, Roboto, sans-serif;
        font-size: 10px;
        font-weight: 400;
        max-width: 588px;
        margin: 8px auto 0;
        color: #93a0ae;
      "
>
    2020 – 2022 All Sports Finance Ltd. All rights reserved.<br
        style="
          font-family: Mulish;
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        "
    />All Sports Finance Ltd is a company registered in England and Wales (No.
    12739098) at 20–22 Wenlock Road, London. N1 7GU
</p>
</body>
</html>
