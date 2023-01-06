@extends('appSection@deal::Export.layouts.main')

@section('content')
    <div style="text-align: center">
        <img
            id="asf-logo"
            src="{{ public_path('images/Logo-email.png') }}"
            style="
        font-family: Mulish;
        padding: 0;
        box-sizing: border-box;
        margin: 8px auto 20px;

      "
        />
    </div>

    <div class="deals-wrapper">

        <div class="deal-info">
            <p><b>Deal Type</b>: {{$deal['deal_type']}}</p>
            <p><b>Contract Type</b>: {{$deal['contract_type']}}</p>
            <p><b>Status</b>: {{$deal['status_label']}}</p>
            <p><b>Reason</b>: {{$deal['reason_label']}}</p>
            <p><b>Currency</b>: {{$deal['currency']}}</p>
            <p><b>Contract amount</b>: {{$deal['contract_amount']}} {{$deal['currency']}}</p>
            <p><b>Upfront amount</b>: {{$deal['upfront_amount']}} {{$deal['currency']}}</p>
            <p><b>Interest rate</b>: {{$deal['interest_rate']}}</p>
            <p><b>Gross amount</b>: {{$deal['gross_amount']}}</p>
            <p><b>Deal amount</b>: {{$deal['deal_amount']}}</p>
            <p><b>First installment</b>: {{\Carbon\Carbon::parse($deal['first_installment'])->format('d/m/Y')}}</p>
            <p><b>Frequency</b>: {{$deal['frequency']}}</p>
            <p><b>Nb installmetnts</b>: {{$deal['nb_installmetnts']}}</p>
        </div>
        <br>

        <h3>Payment schedule</h3>

        <table class="table table-sm" style="font-size: 15px;border-collapse:separate;border-spacing:20px;">
            <thead>
            <tr>
                <th></th>
                <th>Date</th>
                <th>Status</th>
                <th>Gross amount</th>

            </tr>
            </thead>
            <tbody>
            @foreach($deal['payments_data'] as $key => $data)
                <tr>
                    <td>{{$key + 1}}.</td>
                    <td>{{\Carbon\Carbon::parse($data['paymentDate'])->format('d/m/Y')}}</td>
                    <td>{{isset($data['paid']) ? 'Paid' : 'Pending'}}</td>
                    <td>{{$data['grossAmount']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@stop
