@extends('app')

@section('content')

<div class="col-md-12">
    <h1>My Saleitems</h1>

    @foreach ($saleitems as $saleitem)
        <div class="row" id="sale-item-entry">
            <div class="col-md-6">
                <h3>{!! $saleitem->description  !!}<h3>
                <br>
                <p id="time-status"> Offered for sale {!! $saleitem->created_at->diffForHumans() !!}</p>
            </div>
            <div class="col-md-3">
                @if ($saleitem->matched == 0)
                    <h3>Unsold</h3>
                @else
                    <h3>Sold</h3>
                @endif
            </div>

        </div>
    <hr>
    @endforeach

</div>

@stop