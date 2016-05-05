@extends('app')

@section('content')

<div class="col-md-12">

    @if ($errors->any())
    <ul class="alert alert-danger" id="payment-error">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    @if (Session::has('success'))
    <div class="alert alert-info" id="payment-success">{{ Session::get('success') }}
    </div>
    @endif

    @if(Session::has('buyer_alert'))
    <div id="alertModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Congratulations! </h4>
                </div>
                <div class="modal-body">
                        <div class="row">
                        {!! Html::image('images/' . Session::get('buyer_alert')['item_img_path'], null, [ 'id' => 'previewing' ]) !!}
                        </div>
                        You have just bought "{{ Session::get('buyer_alert')['item_description'] }}"
                        <br>
                        From
                        <br>
                        {{ Session::get('buyer_alert')['item_country_of_origin'] }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    @endif


    <hr>

    <ul class="nav nav-tabs" id="myTab">
        <li><a href="#items-bought" role="tab" data-toggle="tab">Items Bought</a></li>
        <li><a href="#items-sold" role="tab" data-toggle="tab">Items Sold</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane" id="items-sold">

            <h3>Items Sold</h3>
            @if ($sold)
            @foreach ($sold as $sold_entry)
            <div class="row" id="sale-item-entry">
                <div class="col-md-6">
                    <h3>Order #:{!! $sold_entry['sold_transaction']->id  !!}</h3>
                    <br>
                    <h3>Item: {!! $sold_entry['sold_item']->description  !!}</h3>
                    <br>
                    <br>
                    <p id="time-status">Payment Received: {{  $sold_entry['sold_transaction']->payment_date->diffForHumans()   }} </p>
                    <a href="/transactions/{{ $sold_entry['sold_transaction']->id }}">View Transaction Details</a>
                </div>
                <div class="col-md-3">
                    <br>
                    <p>Ship to:</p>
                    <br>
                    <p class="shipping-address">{{$sold_entry['sold_transaction']->shipping_address}}</p>
                    <br>
                </div>

            </div>
            <hr>
            @endforeach
            <div id="paginator>"
                {!! $sale_transactions->render() !!}
            </div>
            @else
            <p>You haven't sold any items yet.</p>
            @endif
            <hr>
        </div>
    </div>



    <div class="tab-content">
        <div class="tab-pane" id="items-bought">

            <h3>Items Bought</h3>

            @if ($bought)
            @foreach ($bought as $bought_entry)
            <div class="row" id="buy-item-entry">
                <div class="col-md-6">
                    <h3>Order #:{!! $bought_entry['bought_transaction']->id  !!}</h3>
                    <br>
                    <h3>Item: {!! $bought_entry['bought_item']->description  !!}</h3>
                    <br>
                    <p id="time-status"> Payment Sent {{  $bought_entry['bought_transaction']->payment_date->diffForHumans()  }}</p>
                    <a href="/transactions/{{ $bought_entry['bought_transaction']->id }}">View Transaction Details</a>
                </div>
                <div class="col-md-3">
                    <!--        Some shit-->
                </div>
            </div>
            <hr>
            @endforeach
            <div id="paginator>"
                   {!! $buy_transactions->render() !!}
            </div>
            @else
            <p>You haven't bought any items yet.</p>
            @endif
        </div>
    </div>
</div>




@stop