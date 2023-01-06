@extends('ship::layouts.main')

@section('content')
    <h1 class="heading">Dear {{$lender_name}}</h1>
    <p class="description">
        Did you received payment from {{$borrower_name}} for Deal signed on {{$date}} for {{$obligor_risk_name}}? You
        should receive {{ $amount  }} {{$currency}}.
        <br>
        If you received payment, please click <a href="{{$login_url}}&confirm=1">YES</a> to confirm. If not, please
        click <a href="{{$login_url}}&confirm=0">NO</a>.
    </p>
    <p>Thank you in advance.</p>
@stop

