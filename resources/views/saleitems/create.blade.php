@extends('app')

@section('content')

<div class="col-md-6 col-md-offset-3">

    <h1>Sell an Item</h1>

    <hr/>


    {!! Form::open(['url' => 'saleitems', 'id' => 'sale-item-form', 'files' => 'true'])!!}



    <fieldset id="first">
        <p>Step One - Decription</p>
            <div class="form-group" id="description-group">
                <div class="row">
                    <div class="col-md-12">
                    {!! Form::label('description', 'Description of your item: ') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    {!! Form::text('description', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info" id="tip-one-1"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;&nbsp;A short description of your item will do, for example: "A Homemade Handbag"</div>
                        <div class="alert alert-info" id="tip-one-2" hidden="hidden"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;&nbsp;Be sure to read the <a href="{{ url('/rules') }}">rules</a> on what is allowed to be sold on Randbay</div>
                        <div class="alert alert-info" id="tip-one-3" hidden="hidden"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;&nbsp;Buyers won't see this description until after the item has been sold</div>
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
        <p>Step Two - Image</p>
        <p>Please upload an actual picture of your item.</p>
        <div class="form-group" id="image-group">

            <div class="row">
                <div class="col-md-12">
                    <div id="image-preview">
                        <img id="previewing" src="/img/noimage.png" />
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4 col-md-offset-4" style="text-align: center">
                    {!! Form::label('image', 'Please Upload a Picture of your item') !!}
                </div>
            </div>
            <div id="message"></div>
            <div class="row">
                <div class="col-md-12">
                   {!! Form::file('image', ['autocomplete' => 'off']) !!}
                </div>
            </div>

            <hr/>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info" id="tip-two-1"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;&nbsp;Buyers will not see this picture unless they purchase the item.</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-sm animated-button thar-four" href="#" id="prev-btn2">Back</a>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-sm animated-button thar-three" href="#" id="next-btn2">Next</a>
                </div>
            </div>
        </div>
    </fieldset>



        <fieldset id="third" style="display: none;">
            <p>Step Three - Pricing</p>
                <div class="form-group" id="price-group">
                    <div class="row">
                        <div class="col-md-12">
                        {!! Form::label('price', 'Sale price: ') !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="input-symbol">
                                <span>&pound;</span>
                                {!! Form::input('number', 'price', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <div class="col-md-2" id="currency-selector-div">
                            {!! Form::select('native_currency', ['USD' => 'USD', 'GBP' => 'GBP', 'EUR' => 'EUR'], 'GBP', ['id' => 'currency-selector', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info" id="tip-three-1"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;&nbsp;Try to set a price that is likely to be met. Most items on Randbay sell at around £10-20 GBP.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-sm animated-button thar-four" href="#" id="prev-btn3">Back</a>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-sm animated-button thar-three" href="#" id="next-btn3">Next</a>
                        </div>
                    </div>
            </div>
        </fieldset>



        <fieldset id="fourth" style="display: none;">
            <p>Step Four - Postage</p>
                <div class="form-group">
                    {!! Form::label('international', 'Would you like to offer this item internationally? ') !!}<br>
                    <div class="btn-group" data-toggle="buttons" id="postage-toggle">
                        <label class="btn btn-default" id="postoption1">
                            <input name="international"  autocomplete="off" value="true" type="radio"> Yes
                        </label>
                        <label class="btn btn-default" id="postoption2">
                            <input name="international"  autocomplete="off" value="false" type="radio"> No
                        </label>
                    </div>
                </div>

                <div class="form-group" id="domestic-post">
                    {!! Form::label('domestic_postage_cost', 'Postage Cost within your Country: ') !!}
                    <div class="input-symbol">
                        <span>&pound;</span>
                        {!! Form::input('number', 'domestic_postage_cost', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                </div>



                <div class="form-group" id="world-post">
                    {!! Form::label('world_postage_cost', 'World Postage Cost: ') !!}
                    <div class="input-symbol">
                        <span>&pound;</span>
                        {!! Form::input('number', 'world_postage_cost', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                    <div class="row" id="spacer">
                        &nbsp;
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info" id="tip-four-1"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;&nbsp;As you don't know what country your item will sell to, try to set a world postage price to cover all possibilities.</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger" hidden="hidden" id="price_warning"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;&nbsp;Your sale price plus postage exceeds the maximum transaction limit for PayPal ($10,000) </div>
                    </div>
                </div>
                <div class="form-group">
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-sm animated-button thar-four" href="#" id="prev-btn4">Back</a>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-sm animated-button thar-three" href="#" id="next-btn4">Next</a>
                        </div>
                    </div>
                </div>
        </fieldset>



        <fieldset id="fifth" style="display: none;">
            <p>Step Five - Agreement</p>
            <div class="form-group">
                <p class="terms-agreement">Please note, Randbay screens all items for sale for breaches of the seller <a href="{{ url('/rules') }}" target="_blank">rules</a>.</p>
                <p class="terms-agreement">By submitting this item for sale, I confirm that this item abides by the seller rules. </p>
            </div>
            <div class="form-group" id="agreement-group">
                {!! Form::label('agreement', 'I agree') !!}
                {!! Form::checkbox('agreement', 'agreement') !!}
            </div>

            <div class="form-group">
                <hr/>
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-sm animated-button thar-four" href="#" id="prev-btn5">Back</a>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-sm animated-button victoria-one" href="#" id="form-submit">List Your Item!</a>
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
    <div class="row" id="jumbo-spacer">
        &nbsp;
    </div>

</div>




@stop