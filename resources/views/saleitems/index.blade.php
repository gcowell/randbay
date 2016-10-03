@extends('app')

@section('content')

<div class="col-md-10 col-md-offset-1">
    <h1>My Saleitems</h1>
    <hr>

    @if (Session::has('deleted'))
    <div class="alert alert-info" id="deleted-item">{{ Session::get('deleted') }}
    </div>
    @endif

    @if (!count($saleitems))
    <div class="row">
        <h3 style="text-align: center;">You have not offered any items for sale yet.</h3>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <a class="btn btn-sm animated-button victoria-two" href="{{ url('/saleitems/create') }}">START HERE</a>
        </div>
    </div>
    @endif

    @foreach ($saleitems as $saleitem)
        <div class="row" id="sale-item-entry">
            <div class="col-md-3" id="image-list">
                <a id="fancy-img" href="{{ 'images/' . $saleitem->id . '.' . $saleitem->image_type }}">
                    {!! Html::image('images/' . $saleitem->id . '.' . $saleitem->image_type, null, [ 'id' => 'previewing' ]) !!}
                </a>
            </div>
            <div class="col-md-6">
                <h3><a href="{{ url('/saleitems/'. $saleitem->id) }}">{!! $saleitem->description  !!}</a></h3>
                <br>
                <h3>
                    <span class="currency-symbol">{{ $saleitem->native_currency }}</span>
                    <span>{{ $saleitem->price }}</span>
                </h3>
                <br>
                <p><a href="{{ url('/saleitems/'. $saleitem->id) }}">Edit this item</a></p>
                <br>
                <p id="time-status"> Offered for sale {!! $saleitem->created_at->diffForHumans() !!}</p>
            </div>
            <div class="col-md-3">
                @if ($saleitem->matched == 'false')
                    <h3>Unsold</h3>
                @else
                    <h3>Sold</h3>
                    <p><a href="{{ url('/saleitems/transaction/'. $saleitem->id) }}">View transaction</a></p>
                @endif
            </div>

        </div>
        <div id="spacer">
            &nbsp;
        </div>
    @endforeach

    <div id="paginator>"
    {!! $saleitems->render() !!}
    </div>




</div>

@stop