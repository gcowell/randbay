@extends('app')

@section('content')


<div class="col-md-6 col-md-offset-3">

    <h1>Buy a Random Thing!</h1>

    <hr/>
    @if ($errors->any())
    <ul class="alert alert-danger" id="error-list">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif


    {!! Form::open(['url' => 'buyorders', 'id' => 'buyorder-form'])!!}



    <fieldset id="first">
        <p>Step One - Pricing</p>
        <div class="form-group" id="price-group">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::label('price', 'How much do you want to spend: ') !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="input-symbol">
                        <span>&pound;</span>
                        {!! Form::input('number', 'price', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    {!! Form::select('requested_currency', ['USD' => 'USD', 'GBP' => 'GBP', 'EUR' => 'EUR'], 'GBP', ['id' => 'requested_currency']) !!}
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info" id="tip-three-1"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;&nbsp;Tip: Most items on Randbay sell at around £10-20 GBP. Try naming a price similar to this.</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <a class="btn btn-sm animated-button thar-three" href="#" id="next-btn1">Next</a>
                </div>
            </div>
        </div>
    </fieldset>


    <fieldset id="second" style="display: none;">
    <p>Step Two - About You</p>
    <div class="form-group" id="you-group">
        <div class="form-group" id="email-group">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::label('buyer_email', 'Your Paypal Email Address: ') !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    {!! Form::email('buyer_email', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
            </div>
        </div>
        <div class="form-group" id="country-group">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::label('country', 'Where are you: ') !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @include('partials.countries')
                </div>
            </div>
        </div>
        <div class="form-group" >
            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-sm animated-button thar-four" href="#" id="prev-btn2">Back</a>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-sm animated-button thar-three" href="#" id="next-btn2">Next</a>
                </div>
            </div>
        </div>
    </div>
    </fieldset>



    <fieldset id="third" style="display: none;">
        <p>Step Three - Agreement</p>
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
                    <a class="btn btn-sm animated-button thar-four" href="#" id="prev-btn3">Back</a>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-sm animated-button victoria-one" href="#" id="form-submit">Find a Random Item!</a>
                </div>
            </div>
        </div>
    </fieldset>
    {!! Form::close() !!}
    <div class="row" id="jumbo-spacer">
        &nbsp;
    </div>

</div>


@stop