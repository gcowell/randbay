@extends('app')

@section('content')

<div class="col-md-6 col-md-offset-3">

    <h1>Create a Sale Item</h1>

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
                    {!! Form::text('description', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <input class="btn btn-large btn-block" id="next-btn1" type="button" value="Next">
                    </div>
                </div>
            </div>
    </fieldset>



    <fieldset id="second" style="display: none;">
        <p>Step Two - Image</p>
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
                    {!! Form::label('image', 'Upload a Picture') !!}
                </div>
            </div>
            <div id="message"></div>
            <div class="row">
                <div class="col-md-12">
                   {!! Form::file('image') !!}
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-6">
                    <input class="btn btn-large btn-block" id="prev-btn2"  type="button" value="Back">
                </div>
                <div class="col-md-6">
                    <input class="btn btn-large btn-block" id="next-btn2"  type="button" value="Next">
                </div>
            </div>
        </div>
    </fieldset>



        <fieldset id="third" style="display: none;">
            <p>Step Three - Pricing</p>
                <div class="form-group" id="price-group">
                    <div class="row">
                        <div class="col-md-12">
                        {!! Form::label('price', 'Minimum sale price: ') !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="input-symbol">
                                <span>&pound;</span>
                                {!! Form::text('price', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            {!! Form::select('native_currency', ['USD' => 'USD', 'GBP' => 'GBP', 'EUR' => 'EUR'], 'GBP', ['id' => 'currency-selector']) !!}
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">
                            <input class="btn btn-large btn-block" id="prev-btn3"  type="button" value="Back">
                        </div>
                        <div class="col-md-6">
                            <input class="btn btn-large btn-block" id="next-btn3"  type="button" value="Next">
                        </div>
                    </div>
            </div>
        </fieldset>



        <fieldset id="fourth" style="display: none;">
            <p>Step Four - Postage</p>
                <div class="form-group">
                    {!! Form::label('international', 'International Postage ') !!}<br>
                    <div class="btn-group" data-toggle="buttons" id="postage-toggle">
                        <label class="btn btn-default" id="postoption1">
                            <input name="international"  autocomplete="off" value="true" type="radio"> Yes
                        </label>
                        <label class="btn btn-default" id="postoption2">
                            <input name="international"  autocomplete="off" value="false" type="radio"> No
                        </label>
                </div>

                <div class="form-group" id="domestic-post">
                    {!! Form::label('domestic_postage_cost', 'Postage Cost: ') !!}
                    <div class="input-symbol">
                        <span>&pound;</span>
                        {!! Form::text('domestic_postage_cost', null, ['class' => 'form-control']) !!}
                    </div>
                </div>



                <div class="form-group" id="world-post">
                    {!! Form::label('world_postage_cost', 'World Postage Cost: ') !!}
                    <div class="input-symbol">
                        <span>&pound;</span>
                        {!! Form::text('world_postage_cost', null, ['class' => 'form-control']) !!}
                    </div>
                </div>



                <div class="form-group">
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">
                            <input class="btn btn-large btn-block" id="prev-btn4"  type="button" value="Back">
                        </div>
                        <div class="col-md-6">
                            <button type="button" id="form-submit" class="btn btn-primary form-control" >List Your Item!</button>
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