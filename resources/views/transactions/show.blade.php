@extends('app')

@section('content')


<div class="col-md-12">

    <div class="col-md-6 col-md-offset-3">
        <div class="row">
            <div class="col-md-12">
                <h2>Transaction for "{{ $saleitem->description }}"</h2>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div id="image-preview">
                    {!! Html::image('images/' . $saleitem->id . '.' . $saleitem->image_type, null, [ 'id' => 'previewing' ]) !!}
                </div>
            </div>
        </div>
        <hr>
<!--        Seller stuff-->
        @if ((Auth::user()->id) == ($transaction->seller_id))

        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <img src="/img/tick1.jpg" class="status-img" alt="Tick" height="42" width="42">
                </div>
                <div class="row">
                    <p style="text-align:center">Payment Complete</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    @if ( $transaction->item_shipped == "true" )
                    <img src="/img/tick1.jpg" class="status-img" alt="Tick" height="42" width="42">
                    @else
                    <img src="/img/cross1.jpg" class="status-img" alt="Cross" height="42" width="42">
                    @endif
                </div>
                <div class="row">
                    <p style="text-align:center">Shipped</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    @if ( $transaction->item_received == "true" )
                    <img src="/img/tick1.jpg" class="status-img" alt="Tick" height="42" width="42">
                    @else
                    <img src="/img/cross1.jpg" class="status-img" alt="Cross" height="42" width="42">
                    @endif
                </div>
                <div class="row">
                    <p style="text-align:center">Received</p>
                </div>
            </div>
        </div>
        <div class="spacer"
             &nbsp;
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


        @if ($transaction->has_support_ticket == 'false')

        @else
        <div class="panel panel-default">
            <div class="panel-heading">Complaints Received</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <p>The buyer has raised a support ticket against this transaction</p>
                        <p><a href="/transactions/support/{{ $transaction->id }}">View Ticket and Respond</a></p>
                    </div>
                </div>
            </div>
        </div>
        @endif


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
                            @if($transaction->item_shipped !== 'true')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-warning"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;&nbsp;When shipping this item be sure that you keep proof of postage in order to avoid disputes.</div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                {!! Form::hidden('item_shipped', 'true')   !!}
                            </div>
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
                    <div class="row">
                        <img src="/img/tick1.jpg" class="status-img" alt="Tick" height="42" width="42">
                    </div>
                    <div class="row">
                        <p style="text-align:center">Payment Complete</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        @if ( $transaction->item_shipped == "true" )
                        <img src="/img/tick1.jpg" class="status-img" alt="Tick" height="42" width="42">
                        @else
                        <img src="/img/cross1.jpg" class="status-img" alt="Cross" height="42" width="42">
                        @endif
                    </div>
                    <div class="row">
                        <p style="text-align:center">Shipped</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        @if ( $transaction->item_received == "true" )
                        <img src="/img/tick1.jpg" class="status-img" alt="Tick" height="42" width="42">
                        @else
                        <img src="/img/cross1.jpg" class="status-img" alt="Cross" height="42" width="42">
                        @endif
                    </div>
                    <div class="row">
                        <p style="text-align:center">Received</p>
                    </div>
                </div>
            </div>
            <div class="spacer"
                &nbsp;
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

                        {!! Form::open(array('url' => '/transactions/'.$transaction->id, 'method' => 'PUT')) !!}
                        @if($transaction->item_received == 'true')
                        <div class="col-md-6">
                            <p>Item Marked as Received:</p>
                        </div>
                        <div class="col-md-6">
                            <p>{{ $transaction->received_date->toFormattedDateString() }}</p>
                        </div>
                        @else
                        <div class="col-md-12">

                            {!! Form::hidden('item_received', 'true')   !!}
                            {!! Form::submit('Mark this Item as Received', ['class' => 'btn btn-primary btn-block'] ) !!}

                        </div>
                        @endif
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Help and Support</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if ($transaction->has_support_ticket == 'false')
                            <p><a href="/support/create/{{ $transaction->id }}">There is a Problem with this Item</a></p>
                            @else
                            <p>A support ticket has been raised against this transaction</p>
                            <p><a href="/transactions/support/{{ $transaction->id }}">View Ticket</a></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if ( $transaction->item_received == "true" )
            <div class="panel panel-default">
                <div class="panel-heading">@if( !$transaction->rating )Rate this Random Item! @else Transaction Rating @endif</div>
                <div class="panel-body">

                    @if( !$transaction->rating )

                        <div class="row" id="rating-clicker">
                            <div class="col-md-12">
                                {!! Form::open(array('url' => '/saleitems/rate/'.$transaction->saleitem_id, 'method' => 'POST')) !!}
                                <fieldset class="rating">
                                    <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="Rocks!">5 stars</label>
                                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Pretty good">4 stars</label>
                                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Meh">3 stars</label>
                                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Kinda bad">2 stars</label>
                                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Sucks big time">1 star</label>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row" id="rating-error">
                            <div class="col-md-12">
                                @if($errors->any())
                                    <ul class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>



                    <div class="row" id="rating-submit">
                        <div class="col-md-12">
                            {!! Form::submit('Rate it', ['class' => 'btn btn-primary btn-block'] ) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>

                    @else

                    <div id="transaction-rating" hidden="">{{ $transaction->rating }}</div>
                    <div class="col-md-12">
                        <fieldset class="rated">
                            <input type="radio" id="rated-star5" name="rated" value="5" disabled /><label for="star5" >5 stars</label>
                            <input type="radio" id="rated-star4" name="rated" value="4" disabled /><label for="star4" >4 stars</label>
                            <input type="radio" id="rated-star3" name="rated" value="3" disabled /><label for="star3" >3 stars</label>
                            <input type="radio" id="rated-star2" name="rated" value="2" disabled /><label for="star2" >2 stars</label>
                            <input type="radio" id="rated-star1" name="rated" value="1" disabled /><label for="star1" >1 star</label>
                        </fieldset>
                    </div>

                    @endif

                    </div>
                </div>




            </div>

            @endif

        </div>

        @endif
        <div id="big-spacer">
            &nbsp;
        </div>

</div>



@stop