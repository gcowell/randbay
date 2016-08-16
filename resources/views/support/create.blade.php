@extends('app')

@section('content')

<div class="col-md-12">
    <div class="col-md-6 col-md-offset-3">

        <h2>Important notes on Support Tickets</h2>

        <h3>Do not open a ticket if:</h3>
        <ul>
            <li>You do not like your item.</li>
            <li>You feel like you paid too much for your item.</li>
        </ul>

        <p>Randbay will not pursue refunds if a ticket is raised for the above reasons.</p>
        <p>Randbay is a site where users buy random items: The risk of what that random item is lies with the buyer.</p>

        <h3>Only open a ticket if:</h3>
        <ul>
            <li>The item you bought has been dispatched, and you have waited a reasonable amount of time for the item (for world postage items, delivery can take up to 4 weeks).</li>
            <li>The item you bought has not been marked as dispatched by the seller within a reasonable timescale after payment.</li>
            <li>The item has arrived, but is significantly different to the description and/or image.</li>
            <li>The item clearly breaks the rules.</li>
        </ul>

        <p>Randbay will investigate transactions which fall into the above categories.</p>
        <p>Please note however that refunds must be processed through PayPal refund policy.</p>

        <hr>

        <div class="row">
            @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        <div class="row">
            <div class="span4 collapse-group">
                <button class="btn btn-large" data-toggle="collapse" data-target="#viewform">Open a Support Ticket for "{{ $saleitem->description }}" &raquo;</button>
                <div class="collapse" id="viewform">
                    {!! Form::open(['url' => 'support', 'id' => 'support-form'])!!}

                    {!! Form::hidden('transaction_id', $transaction->id) !!}
                    {!! Form::hidden('complainer_id', Auth::user()->id) !!}
                    {!! Form::hidden('complainee_id', $transaction->seller_id) !!}


                    <h3>I have a problem with the item: "{{ $saleitem->description }}"</h3>

                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::label('type', 'Please select the type of problem: ') !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input name="type"  autocomplete="off" value="Item not dispatched" type="radio"> The seller has not dispatched the item
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <input name="type"  autocomplete="off" value="Item not arrived" type="radio"> The item has been dispatched but did not arrive
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <input name="type" autocomplete="off" value="Item is not as described" type="radio"> The item is significantly different to the description and/or picture
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <input name="type" autocomplete="off" value="Item breaks the rules" type="radio"> The item breaks the rules (it is illegal, dangerous, not a real item, or otherwise)
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <input name="type" autocomplete="off" value="Other - See details" type="radio"> Other - please specify below
                        </div>
                    </div>

                    <div id="big-spacer">
                        &nbsp;
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::label('details', 'Give some additional details: ') !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::textarea('details', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::submit('Open a Ticket', ['class' => 'btn btn-primary form-control' ]) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

        </div>

</div>
<div id="jumbo-spacer">
    &nbsp;
</div>





@stop