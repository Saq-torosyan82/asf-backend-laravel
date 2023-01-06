@extends('appSection@deal::Export.layouts.main')

@section('content')
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
   <div class="deals-wrapper">
       <table class="table table-sm" style="font-size: 15px;border-collapse:separate;border-spacing:5px;">
           <thead>
           <tr>
               <th>Type</th>
               <th>Status</th>
               <th>Reason</th>
               <th>Start date</th>
               <th>End date</th>
               <th>Net amount received</th>
               <th>Paid back</th>
           </tr>
           </thead>
           <tbody>
           @foreach($deals['data'] as $deal)
               <tr>
                   <td>{{$deal['type_label']}}</td>
                   <td>{{$deal['status_label']}}</td>
                   <td>{{$deal['reason_label']}}</td>
                   <td>{{\Carbon\Carbon::parse($deal['start_date'])->format('d/m/Y')}}</td>
                   <td>{{\Carbon\Carbon::parse($deal['finish_date'])->format('d/m/Y')}}</td>
                   <td>{{$deal['net_amount']}} {{$deal['currency']}}</td>
                   <td>{{$deal['paid_back']}} {{$deal['currency']}}</td>
               </tr>
           @endforeach
           </tbody>
       </table>

   </div>
@stop
