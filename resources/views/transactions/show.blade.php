@extends('app')

@section('content')


<div class="col-md-12">

    <div class="col-md-6 col-md-offset-3">
<!--        Seller stuff-->
        @if ((Auth::user()->id) == ($transaction->seller_id))

        <div class="row">
            <div class="col-md-4">
                <img src="/img/tick1.jpg" alt="Tick" height="42" width="42">
            </div>
            <div class="col-md-4">
                @if ( $transaction->item_shipped == "true" )
                <img src="/img/tick1.jpg" alt="Tick" height="42" width="42">
                @else
                <img src="/img/cross1.jpg" alt="Cross" height="42" width="42">
                @endif
            </div>
            <div class="col-md-4">
                @if ( $transaction->item_received == "true" )
                <img src="/img/tick1.jpg" alt="Tick" height="42" width="42">
                @else
                <img src="/img/cross1.jpg" alt="Cross" height="42" width="42">
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <p style="text-align:center">Payment Received</p>
            </div>
            <div class="col-md-4">
                <p style="text-align:center">Shipped</p>
            </div>
            <div class="col-md-4">
                <p style="text-align:center">Received</p>
            </div>
        </div>
        <hr>

        <div class="panel panel-default">
            <div class="panel-heading">Paypal Transaction Details</div>
            <div class="panel-body">

                @if ($transaction->payment_complete == 'true')
                <div class="row">
                    <div class="col-md-6">
                        <p>Paypal Transaction id: </p>
                    </div>
                    <div class="col-md-6">
                        <p> {!! $transaction->remuneration_paypal_ref !!} </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p>Payment completed on: </p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$transaction->payment_date->toFormattedDateString()}} </p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Shipping Details</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Ship to:</p>
                        </div>
                        <div class="col-md-6">
                            <p class="shipping-address">{{$transaction->shipping_address}}</p>
                        </div>
                    </div>

                    @if($transaction->item_shipped == 'true')
                    <div class="row">
                        <div class="col-md-6">
                            <p>Shipped on:</p>
                        </div>
                        <div class="col-md-6">
                            <p>{{$transaction->shipped_date->toFormattedDateString()}}</p>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(array('url' => '/transactions/'.$transaction->id, 'method' => 'PUT')) !!}
                            @if($transaction->item_shipped == 'true')
                            {!! Form::hidden('item_shipped', 'false')   !!}
                            {!! Form::submit('Mark as Unshipped', ['class' => 'btn btn-primary btn-block'] ) !!}
                            @else
                            {!! Form::hidden('item_shipped', 'true')   !!}
                            {!! Form::submit('Mark as Shipped', ['class' => 'btn btn-primary btn-block'] ) !!}
                            @endif
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>




        @else
        <!--        Buyer stuff-->

            <div class="row">
                <div class="col-md-4">
                    <img src="/img/tick1.jpg" alt="Tick" height="42" width="42">
                </div>
                <div class="col-md-4">
                    @if ( $transaction->item_shipped == "true" )
                    <img src="/img/tick1.jpg" alt="Tick" height="42" width="42">
                    @else
                    <img src="/img/cross1.jpg" alt="Cross" height="42" width="42">
                    @endif
                </div>
                <div class="col-md-4">
                    @if ( $transaction->item_received == "true" )
                    <img src="/img/tick1.jpg" alt="Tick" height="42" width="42">
                    @else
                    <img src="/img/cross1.jpg" alt="Cross" height="42" width="42">
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p style="text-align:center">Payment Received</p>
                </div>
                <div class="col-md-4">
                    <p style="text-align:center">Shipped</p>
                </div>
                <div class="col-md-4">
                    <p style="text-align:center">Received</p>
                </div>
            </div>
            <hr>


            <div class="panel panel-default">
                <div class="panel-heading">Paypal Transaction Details</div>
                <div class="panel-body">

                    @if ($transaction->payment_complete == 'true')

                    <div class="row">
                        <div class="col-md-6">
                            <p>Paypal Transaction id: </p>
                        </div>
                        <div class="col-md-6">
                            <p> {!! $transaction->payment_paypal_ref !!} </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p>Payment completed on: </p>
                        </div>
                        <div class="col-md-6">
                            <p>{{$transaction->payment_date->toFormattedDateString()}}</p>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Shipping Details</div>
                <div class="panel-body">
                    @if($transaction->item_shipped == 'true')
                    <div class="row">
                        <div class="col-md-6">
                            <p>Item shipped on:</p>
                        </div>
                        <div class="col-md-6">
                            <p>{{ $transaction->shipped_date->toFormattedDateString() }}</p>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">

                            {!! Form::open(array('url' => '/transactions/'.$transaction->id, 'method' => 'PUT')) !!}
                            @if($transaction->item_received == 'true')
                            {!! Form::hidden('item_received', 'false')   !!}
                            {!! Form::submit('I Have Not Received This Item', ['class' => 'btn btn-primary btn-block'] ) !!}
                            @else
                            {!! Form::hidden('item_received', 'true')   !!}
                            {!! Form::submit('Mark as Received', ['class' => 'btn btn-primary btn-block'] ) !!}
                            @endif
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>

                @if ( $transaction->item_received == "true" )
                <div class="panel panel-default">
                    <div class="panel-heading">Rate this Random Item!</div>
                    <div class="panel-body">

                        @if( !$transaction->rating )

                        {!! Form::open(array('url' => '/saleitems/rate/'.$transaction->saleitem_id, 'method' => 'POST')) !!}
                        <fieldset class="rating">
                            <legend>Please rate:</legend>
                            <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="Rocks!">5 stars</label>
                            <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Pretty good">4 stars</label>
                            <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Meh">3 stars</label>
                            <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Kinda bad">2 stars</label>
                            <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Sucks big time">1 star</label>
                        </fieldset>
                        {!! Form::submit('Rate it', ['class' => 'btn btn-primary btn-block'] ) !!}
                        {!! Form::close() !!}

                        @else

                        <div id="transaction-rating" hidden="">{{ $transaction->rating }}</div>
                        <fieldset class="rated">
                            <legend>Rating</legend>
                            <input type="radio" id="rated-star5" name="rated" value="5" disabled /><label for="star5" title="Rocks!">5 stars</label>
                            <input type="radio" id="rated-star4" name="rated" value="4" disabled /><label for="star4" title="Pretty good">4 stars</label>
                            <input type="radio" id="rated-star3" name="rated" value="3" disabled /><label for="star3" title="Meh">3 stars</label>
                            <input type="radio" id="rated-star2" name="rated" value="2" disabled /><label for="star2" title="Kinda bad">2 stars</label>
                            <input type="radio" id="rated-star1" name="rated" value="1" disabled /><label for="star1" title="Sucks big time">1 star</label>
                        </fieldset>

                        @endif

                        </div>
                    </div>
                </div>

            @endif



        </div>

        @endif

</div>



@stop