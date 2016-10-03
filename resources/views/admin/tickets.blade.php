@extends('app')

@section('content')

<div class="col-md-10 col-md-offset-1">
    <div class="row">
        <div class="col-md-2">
            <h3>Type of Issue</h3>
        </div>
        <div class="col-md-2">
            <h3>Details</h3>
        </div>
        <div class="col-md-2">
            <h3>Evidence Status</h3>
        </div>
        <div class="col-md-2">
            <h3>Add Result</h3>
        </div>
        <div class="col-md-2">
            <h3>Resolve</h3>
        </div>
    </div>

    @foreach ($open_tickets as $ticket)

    {!! Form::open(['url' => 'johnpupperman/tickets/' . $ticket->id, 'id' => 'ticket-check'])!!}


    <div class="row">
        <div class="col-md-2">
            {{ $ticket->type }}
        </div>
        <div class="col-md-2">
            {{ $ticket->details }}
        </div>
        <div class="col-md-2">
            {{ $ticket->evidence_added }}
<!--            maybe open modal to show images-->
        </div>
        <div class="col-md-2">
            {!! Form::textarea('result', null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-2">
            {!! Form::submit('Resolve', ['class' => 'btn btn-primary']) !!}
        </div>
            {!! Form::close()  !!}

    </div>

    @endforeach





</div>

@stop