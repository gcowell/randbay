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
                    <button type="button" id="go-back" class="btn btn-primary form-control" >Go Back</button>
                </div>
            </div>
        </fieldset>
        @else
        <fieldset id="item-found">
            <h1>Success!</h1>
            <p>We have found you a random item for:</p>
            <h3> {{ $saleitem->total_cost }} </h3>
            <hr/>
            <div class="form-group" id="proceed-group">
                <div class="col-md-12">
                    <button type="button" id="proceed" class="btn btn-primary form-control" >Proceed</button>
                </div>
            </div>
        </fieldset>
        @endif
    </div>
</div>

@stop