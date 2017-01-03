@extends ('app')

@section('content')

@if(Session::has('item_for_sale'))

<div id="alertModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Cool Beans! </h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="image-preview">
                            <a id="fancy-img" href="{{ 'images/' . Session::get('item_for_sale')['id'] . '.' . Session::get('item_for_sale')['image_type'] }}">
                                {!! Html::image('images/' . Session::get('item_for_sale')['id'] . '.' . Session::get('item_for_sale')['image_type'], null, [ 'id' => 'previewing' ]) !!}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: center">
                        <h3>Your item "{{ Session::get('item_for_sale')->description }}" is now for sale!</h3>
                    </div>
                </div>
                <div class="row" id="divider">
                    <div class="col-md-12">
                        <img src="/img/line-separator.png" id="line">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: center">
                        <li>You have been sent an automated confirmation email for this listing.</li>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: center">
                        <li>You will be notified by email when your item sells.</li>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12" style="text-align: center">
                        <li>If your item does not sell within 10 days, it will automatically be removed.</li>
                    </div>
                </div>
                <div class="row" id="divider">
                    <div class="col-md-12">
                        <img src="/img/line-separator.png" id="line">
                    </div>
                </div>
                <div class="row" id="divider">
                    <div class="col-md-12" style="text-align: center">
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


@if(Session::has('item_bought'))
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
                            <a id="fancy-img" href="{{ 'images/' . Session::get('item_bought')['id'] . '.' . Session::get('item_bought')['image_type'] }}">
                                {!! Html::image('images/' . Session::get('item_bought')['id'] . '.' . Session::get('item_bought')['image_type'], null, [ 'id' => 'previewing' ]) !!}
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
                        <h3>You have just bought: "{{ Session::get('item_bought')['description'] }}"</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: center">
                        <h4>From {{ Session::get('item_bought')['country'] }}</h4>
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


<div class="bg"></div>
<div class="jumbotron" style=" text-align: center;">
    <img src="/img/logo-big.png" id="logo-big">
    <p>Utterly pointless.</p>
</div>

<div class="row" id="errors-row">
    <div class="col-md-8 col-md-offset-2">
        @if ($errors->any())
            <ul class="alert alert-danger" id="payment-error">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<div class="row" id="divider">
    <div class="col-md-8 col-md-offset-2">
        <img src="/img/line-separator.png" id="line">
    </div>
 </div>

<div class="row button-row">

    <div class="col-md-6 col-md-offset-3">
        <h2>Know what to do? Jump right in!</h2>

        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-sm animated-button victoria-one" href="{{ url('/buyorders/create') }}">BUY</a>
            </div>
            <div class="col-md-6">
                <a class="btn btn-sm animated-button victoria-two" href="{{ url('/saleitems/create') }}">SELL</a>
            </div>
        </div>
        <hr>
    </div>
</div>

<div class="row" id="divider">
    <div class="col-md-8 col-md-offset-2">
        <img src="/img/line-separator.png" id="line">
    </div>
</div>
<div class="row" id="big-spacer">
    &nbsp;
</div>

<div class="row" id="big-picture-row">
    <div class="row" id="big-spacer">
        &nbsp;
    </div>
    <div class="row" id="divider">
        <div class="col-md-8 col-md-offset-2">
            <img src="/img/line-separator.png" id="line">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2 style="text-align: center">First timer?</h2>
            <h2 style="text-align: center">What the Hell is a Randbay?</h2>
            <h2 style="text-align: center">Allow us to explain...</h2>

        </div>
    </div>
    <div class="row" id="divider">
        <div class="col-md-8 col-md-offset-2">
            <img src="/img/line-separator.png" id="line">
        </div>
    </div>

    <div class="row" id="big-spacer">
        &nbsp;
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <img src="/img/bigpicture.png" id="big-picture">
        </div>
    </div>
</div>
    <div class="row" id="big-spacer">
        &nbsp;
    </div>
    <div class="row" id="divider">
        <div class="col-md-8 col-md-offset-2">
            <img src="/img/line-separator.png" id="line">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2>Still confused? It's ok!</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <a class="btn btn-sm animated-button thar-one" href="{{ url('/how') }}">LEARN MORE</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-sm animated-button thar-one" href="{{ url('/faq') }}">VIEW THE FAQ</a>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-sm animated-button thar-one" href="{{ url('/rules') }}">READ THE RULES</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="big-spacer">
        &nbsp;
    </div>


<div class="row" id="big-spacer">
    &nbsp;
</div>


<div class="row" id="divider">
    <div class="col-md-8 col-md-offset-2">
        <img src="/img/line-separator.png" id="line">
    </div>
</div>


<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2 style="text-align: center">Look at all these cool random things for sale, right now!</h2>
    </div>
</div>
<div class="row" id="divider">
    <div class="col-md-8 col-md-offset-2">
        <img src="/img/line-separator.png" id="line">
    </div>
</div>
<div id="big-spacer">
    &nbsp;
</div>
<div class="animation-element slide-left" id=random-img-container>

</div>
<div class="row" id="big-spacer">
    &nbsp;
</div>

<div class="row" id="divider">
    <div class="col-md-8 col-md-offset-2">
        <img src="/img/line-separator.png" id="line">
    </div>
</div>


<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2 style="text-align: center">Just look at all these testimonials from our users</h2>
    </div>
</div>
<div class="row" id="divider">
    <div class="col-md-8 col-md-offset-2">
        <img src="/img/line-separator.png" id="line">
    </div>
</div>
<div id="big-spacer">
    &nbsp;
</div>

<div class="row">
    <div class="col-md-12" data-wow-delay="0.2s">
        <div class="carousel slide" data-ride="carousel" id="quote-carousel">
            <!-- Bottom Carousel Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#quote-carousel" data-slide-to="0" class="active"><img class="img-responsive " src="{{ url('/img/1ted.png') }}" alt="">
                </li>
                <li data-target="#quote-carousel" data-slide-to="1"><img class="img-responsive" src="{{ url('/img/2gaarg.png') }}" alt="">
                </li>
                <li data-target="#quote-carousel" data-slide-to="2"><img class="img-responsive" src="{{ url('/img/3fred.png') }}" alt="">
                </li>
            </ol>

            <!-- Carousel Slides / Quotes -->
            <div class="carousel-inner text-center">

                <!-- Quote 1 -->
                <div class="item active">
                    <blockquote>
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">

                                <p>Buying random objects from strangers helps to drown out the crippling pain of existence. Randbay allows me to temporarily forget that we are all hurtling toward the inevitable void. </p>
                                <small>Ted, Hampshire</small>
                            </div>
                        </div>
                    </blockquote>
                </div>
                <!-- Quote 2 -->
                <div class="item">
                    <blockquote>
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">

                                <p>Selling the entrails of my enemies to random strangers online really allows me to instill fear into the general populace. Thanks Randbay!</p>
                                <small>Gaarg The Unmerciful</small>
                            </div>
                        </div>
                    </blockquote>
                </div>
                <!-- Quote 3 -->
                <div class="item">
                    <blockquote>
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">

                                <p>Wasting my daddy's billions has never been so easy. I don't even have to leave the palace to throw money down the toilet.</p>
                                <small>Fredspoke Gripshiftski, Russian Oligarch</small>
                            </div>
                        </div>
                    </blockquote>
                </div>
            </div>

            <!-- Carousel Buttons Next/Prev -->
            <a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="fa fa-chevron-left"></i></a>
            <a data-slide="next" href="#quote-carousel" class="right carousel-control"><i class="fa fa-chevron-right"></i></a>
        </div>
    </div>
</div>



<div id="jumbo-spacer">
    &nbsp;
</div>

@include('partials.footer')


@stop