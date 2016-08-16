@extends('app')

@section('content')

<div class="col-md-10 col-md-offset-1">

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

<!--    MODAL FOR NEW PURCHASE-->
<!--    /////////////////////////////////////////////////////////////////////////////////////////////////-->
    @if(Session::has('buyer_alert'))
    <div id="alertModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Congratulations! </h2>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="image-preview">
                                    <a id="fancy-img" href="{{ 'images/' . Session::get('buyer_alert')['item_img_path'] }}">
                                        {!! Html::image('images/' . Session::get('buyer_alert')['item_img_path'], null, [ 'id' => 'previewing' ]) !!}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="divider">
                            <div class="col-md-12">
                                <img src="/img/line-separator.png" id="line">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="text-align: center">
                                <h3>You have just bought: "{{ Session::get('buyer_alert')['item_description'] }}"</h3>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            <h4>From {{ Session::get('buyer_alert')['item_country_of_origin'] }}</h4>
                            <div class="fb-share" ><a>Share</a></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    @endif


    <hr>

    <ul class="nav nav-tabs nav-justified" id="myTab">
        <li><a href="#items-bought" role="tab" data-toggle="tab"><img src="/img/buy01-money.png" class="tab-img"><span class="tab-title">Items Bought</span></a></li>
        <li><a href="#items-sold" role="tab" data-toggle="tab"><img src="/img/sell04-wings.png" class="tab-img"><span class="tab-title">Items Sold</span></a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane" id="items-sold">

            <h3>Items Sold</h3>
            @if ($sold)
            @foreach ($sold as $sold_entry)
            <div class="row" id="sale-item-entry">
                <div class="col-md-3" style="height: 200px;width: 200px;margin: 0 auto;border-radius: 15px;">
                    <a id="fancy-img" href="{{ 'images/' . $sold_entry['sold_item']->id . '.' . $sold_entry['sold_item']->image_type }}">
                        {!! Html::image('images/' . $sold_entry['sold_item']->id . '.' . $sold_entry['sold_item']->image_type, null, [ 'id' => 'transaction-img-entry' ]) !!}
                    </a>
                </div>
                <div class="col-md-6">
                    <h3>Order #:{!! $sold_entry['sold_transaction']->id  !!}</h3>
                    <div id="spacer">
                        &nbsp;
                    </div>
                    <h3>Item: {!! $sold_entry['sold_item']->description  !!}</h3>
                    <div id="spacer">
                        &nbsp;
                    </div>
                    <p id="time-status">Payment Received: {{  $sold_entry['sold_transaction']->payment_date->diffForHumans()   }} </p>
                    <a href="/transactions/{{ $sold_entry['sold_transaction']->id }}">View Transaction Details</a>
                    <div id="spacer">
                        &nbsp;
                    </div>
                </div>
                <div class="col-md-3">
                    <br>
                    <p>Ship to:</p>
                    <br>
                    <p class="shipping-address">{{$sold_entry['sold_transaction']->shipping_address}}</p>
                    <br>
                </div>

            </div>
            <div class="row" id="spacer">

            </div>
            @endforeach
            <div id="paginator">
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
                <div class="col-md-3" style="height: 200px;width: 200px;margin: 0 auto;border-radius: 15px;">
                    <a id="fancy-img" href="{{ 'images/' . $bought_entry['bought_item']->id . '.' . $bought_entry['bought_item']->image_type }}">
                        {!! Html::image('images/' . $bought_entry['bought_item']->id . '.' . $bought_entry['bought_item']->image_type, null, [ 'id' =>  'transaction-img-entry'  ]) !!}
                    </a>
                </div>
                <div class="col-md-6">
                    <h3>Order #:{!! $bought_entry['bought_transaction']->id  !!}</h3>
                    <div id="spacer">
                        &nbsp;
                    </div>
                    <h3>Item: {!! $bought_entry['bought_item']->description  !!}</h3>
                    <div id="spacer">
                        &nbsp;
                    </div>
                    <p id="time-status"> Payment Sent {{  $bought_entry['bought_transaction']->payment_date->diffForHumans()  }}</p>
                    <a href="/transactions/{{ $bought_entry['bought_transaction']->id }}">View Transaction Details</a>
                    <div id="spacer">
                        &nbsp;
                    </div>
                </div>
                <div class="col-md-3">
                    <!--        Some shit-->
                </div>
            </div>
            <div id="spacer">
                &nbsp;
            </div>
            @endforeach
            <div id="paginator">
                   {!! $buy_transactions->render() !!}
            </div>
            @else
            <p>You haven't bought any items yet.</p>
            @endif
        </div>
    </div>
</div>

<div id="jumbo-spacer">
    &nbsp;
</div>


@stop