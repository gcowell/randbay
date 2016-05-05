@extends('app')

@section('content')

<div class="col-md-6 col-md-offset-3">

    <h1>Create a Buy Order</h1>

    <hr/>


    {!! Form::open(['url' => 'buyorders', 'id' => 'buyorder-form'])!!}



    <fieldset id="first"">
        <p>Step One - Pricing</p>
        <div class="form-group" id="price-group">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::label('price', 'How much do you want to spend: ') !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    {!! Form::text('price', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::select('requested_currency', ['USD' => 'USD', 'GBP' => 'GBP', 'EUR' => 'EUR'], 'GBP', ['id' => 'requested_currency']) !!}
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <input class="btn btn-large btn-block" id="next-btn1"  type="button" value="Next">
                </div>
            </div>
        </div>
    </fieldset>


    <fieldset id="second" style="display: none;">
        <p>Step Two - Agreement</p>
        <div class="form-group">
            <p class="terms-agreement">I understand that I am agreeing to buy a random item, at a maximum cost of:</p>
            <h3 id="price-statement"></h3>
            <p class="terms-agreement">This purchase is not subject to refunds.</p>
        </div>
        <div class="form-group" id="agreement-group">
            {!! Form::label('agreement', 'I agree') !!}
            {!! Form::checkbox('agreement', 'agreement') !!}
        </div>
        <hr/>
        <div class="form-group" id="submission-group">
            <div class="row">
                <div class="col-md-6">
                    <input class="btn btn-large btn-block" id="prev-btn2"  type="button" value="Back">
                </div>
                <div class="col-md-6">
                    <button type="button" id="form-submit" class="btn btn-primary form-control" >Find a Random Item!</button>
                </div>
            </div>
        </div>
    </fieldset>
    @if ($errors->any())
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif
    {!! Form::close() !!}

</div>

@stop