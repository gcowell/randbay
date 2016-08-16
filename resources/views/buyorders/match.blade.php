@extends('app')

@section('content')

<div class="col-md-6 col-md-offset-3">

    <div id="match-loading">

    <h1>Finding an Item</h1>

    <img src="/img/loader_blue_128.gif" id="loader-gif">

    </div>


    <div id="match-statement" style="display: none">
        @if(!$saleitem)
        <h1>Finding an Item</h1>
        <fieldset id="item-not-found" >
            <h1>Oops!</h1>
            <p>Uhoh, we didn't find anything for you</p>
            <hr/>
            <div class="form-group" id="go-back-group">
                <div class="col-md-12">
                    <a class="btn btn-sm animated-button thar-four" href="#" id="go-back">Go Back</a>
                </div>
            </div>
        </fieldset>
        @else
        <fieldset id="item-found">
            <h1>Success!</h1>
            <p>We have found you a random item for:</p>
            <h3><span id="currency-symbol"></span> <span id="total-cost-confirm">{{ ceil($saleitem->total_cost*100)/100 }}</span> </h3>
            <hr/>

            <div class="row">
                <div class="form-group" id="proceed-group">
                    <div class="col-md-6">
                        <a class="btn btn-sm animated-button victoria-two" href="#" id="redo">Get a Different Random Item</a>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-sm animated-button victoria-one" href="#" id="proceed">Pay Securely with PayPal</a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row" style="text-align: center">
                <p><a href="{{ url('/buyorders/create') }}">Start over</a></p>
            </div>
            @include('partials.transaction_hidden_form')
        </fieldset>
        @endif
    </div>
</div>

@stop