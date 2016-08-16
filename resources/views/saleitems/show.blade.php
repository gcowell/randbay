@extends('app')

@section('content')

<div class="col-md-4 col-md-offset-4">

    <h1><a href="{{ url('/saleitems/'. $saleitem->id) }}">{!! $saleitem->description  !!}</a></h1>

    <div class="row">
        <div class="col-md-12">
            <div id="image-preview">
                {!! Html::image('images/' . $saleitem->id . '.' . $saleitem->image_type, null, [ 'id' => 'previewing' ]) !!}
            </div>
        </div>
    </div>

    <br>

    @if ($saleitem->matched == 'true' )

        <div class="row">
            <div class="col-md-12">
                <p>This item has been sold and cannot be edited</p>
                <p><a href="{{ url('/saleitems/transaction/'. $saleitem->id) }}">View transaction</a></p>
            </div>
        </div>


        @else

    @if (Session::has('updated'))
        <div class="alert alert-info" id="updated-item">{{ Session::get('updated') }}
        </div>
    @endif
    @if ($errors->any())
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif





    <div class="row">
        <div class="col-md-12" style="text-align: center">
            {!! Form::model( $saleitem, ['url' => url('saleitems' , $saleitem->id), 'method' => 'post', 'files' => 'true', 'autocomplete' => 'off' ] )!!}
            {!! Form::label('image', 'Change Picture') !!}
        </div>
    </div>
    <hr>
    <div id="message"></div>
    <div class="row">
        <div class="col-md-12">
            {!! Form::file('image') !!}
        </div>
    </div>




    <div class="form-group" id="description-group">
        <div class="row">
            <div class="col-md-12">
                {!! Form::label('description', 'Description') !!}
                <br>
                {!! Form::text('description', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
            </div>
        </div>
    </div>

    <div class="form-group" id="price-group">
        <div class="row">
            <div class="col-md-12">
                {!! Form::label('price', 'Price') !!}
                <div class="input-symbol">
                    <span>{{ $saleitem->native_currency }}</span>
                    {!! Form::text('price', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('international', 'International Postage ') !!}<br>
        <div class="btn-group" data-toggle="buttons" id="postage-toggle">



            @if ($saleitem->international == 'true')



            <label class="btn btn-default active" id="postoption1">
                <input name="international"  autocomplete="off" value="true" type="radio" checked="checked"> Yes
            </label>
            <label class="btn btn-default" id="postoption2">
                <input name="international"  autocomplete="off" value="false" type="radio"> No
            </label>
        </div>

        <div class="form-group" id="domestic-post">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::label('domestic_postage_cost', 'Domestic Post') !!}
                    <div class="input-symbol">
                        <span>{{ $saleitem->native_currency }}</span>
                        {!! Form::text('domestic_postage_cost', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group" id="world-post">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::label('world_postage_cost', 'International Post') !!}
                    <div class="input-symbol">
                        <span>{{ $saleitem->native_currency }}</span>
                        {!! Form::text('world_postage_cost', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                </div>
            </div>
        </div>


        @else


        <label class="btn btn-default" id="postoption1">
            <input name="international"  autocomplete="off" value="true" type="radio"> Yes
        </label>
        <label class="btn btn-default active" id="postoption2">
            <input name="international"  autocomplete="off" value="false" type="radio" checked="checked"> No
        </label>
    </div>

    <div class="form-group" id="domestic-post">
        <div class="row">
            <div class="col-md-12">
                {!! Form::label('domestic_postage_cost', 'Domestic Post') !!}
                {!! Form::text('domestic_postage_cost', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
            </div>
        </div>
    </div>

    <div class="form-group" id="world-post" hidden="hidden">
        <div class="row">
            <div class="col-md-12">
                {!! Form::label('world_postage_cost', 'International Post') !!}
                {!! Form::text('world_postage_cost', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
            </div>
        </div>
    </div>


    @endif


    <div class="form-group" id="submit-group">
        <div class="row">
            <div class="col-md-12">
                {!! Form::submit('Update Item', ['class' => 'btn btn-primary form-control' ]) !!}
            </div>
        </div>
    </div>

    {!! Form::close() !!}

    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary form-control" data-toggle="modal" data-target="#dialogModal">Delete this Item</button>
            </div>
        </div>
    </div>
    <div>
        <p><a href="{{ url('/saleitems/')}}">Back to My Saleitems</a></p>
    </div>

    <!-- Modal -->
    <div id="dialogModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete "{{ $saleitem->description  }}"?</h4>
                </div>
                <div class="modal-body">
                    <p>This item will be deleted.</p>
                    <br>
                    <p>This action cannot be undone</p>
                    <br>
                    {!! Form::open( ['url' => url('saleitems' , $saleitem->id), 'method' => 'delete']) !!}
                    {!! Form::submit('Delete Item', ['class' => 'btn btn-primary form-control' ]) !!}
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    @endif


</div>




@stop