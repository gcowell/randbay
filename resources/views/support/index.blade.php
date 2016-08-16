@extends('app')

@section('content')

<div class="col-md-10 col-md-offset-1">



    @if (isset($complainer))
    <h2>My Support Tickets</h2>
    @else
    <h2>Complaints Raised Against Me</h2>
    @endif

    @foreach ($tickets as $ticket)
    <div class="row" id="sale-item-entry">
        <div class="col-md-6">
            <h3><a href="{{ url('/support/'. $ticket->id) }}">Ticket #{!! $ticket->id  !!}</a></h3>
            <p><a href="{{ url('/transactions/'. $ticket->transaction_id) }}">View associated transaction</a></p>
            <p>Issue: {!! $ticket->type !!}</p>
            <br>
            <p id="time-status"> Opened: {!! $ticket->created_at->diffForHumans() !!}</p>
        </div>
        <div class="col-md-3">
            @if ($ticket->resolved == 'false')
            <h3>Open</h3>
            @else
            <h3>Resolved</h3>
            @endif
        </div>

    </div>
    <div id="spacer">
        &nbsp;
    </div>
    @endforeach

</div>




@stop