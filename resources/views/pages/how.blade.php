@extends ('app')

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">

        <div class="row"  id="buy-details" >
            <div class="col-md-12">
                <div class="row" id="divider">
                    <div class="col-md-12">
                        <img src="/img/line-separator.png" id="line">
                    </div>
                </div>
                <h2>How Buying on Randbay Works:</h2>
                <div class="row" id="divider">
                    <div class="col-md-12">
                        <img src="/img/line-separator.png" id="line">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <h4>Step One</h4>
                        <p>Think of the maximum amount of money you are willing to spend on a completely random item.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="/img/buy01-money.png" id="step-img">
                    </div>

                </div>
                <div class="row" id="divider">
                    <div class="col-md-12">
                        <img src="/img/line-separator.png" id="line">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <img src="/img/buy02-burns.png" id="step-img">
                    </div>
                    <div class="col-md-8">
                        <h4>Step Two</h4>
                        <p>Randbay will find a mysterious, random thing that someone is selling at a price equal to or less than the price you named.</p>
                    </div>
                </div>
                <div class="row" id="divider">
                    <div class="col-md-12">
                        <img src="/img/line-separator.png" id="line">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <h4>Step Three</h4>
                        <p>Randbay arranges anonymous automatic payment through PayPal</p>
                    </div>
                    <div class="col-md-4">
                        <img src="/img/buy03-pay.png" id="step-img">
                    </div>

                </div>
                <div class="row" id="divider">
                    <div class="col-md-12">
                        <img src="/img/line-separator.png" id="line">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <img src="/img/buy04-ghosts.png" id="step-img">
                    </div>
                    <div class="col-md-8">
                        <h4>Step Four</h4>
                        <p>Once you pay, you find out what you bought!</p>
                    </div>

                </div>
                <div class="row" id="divider">
                    <div class="col-md-12">
                        <img src="/img/line-separator.png" id="line">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h4>Why on earth would I want to do this?</h4>
                        <ul>
                            <li>You can potentially get lucky and end up with something priceless, like a Faberge Egg or something...</li>
                            <li>You can be unlucky and end up with something that is utterly terrible, like a photograph of Willem Dafoe...</li>
                            <li>Its vaguely fun to see what you get.</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <img src="/img/buy05-result.png" id="result-img">
                        </div>
                    </div>


                </div>

            </div>
        </div>

        <div class="row" id="divider">
            <div class="col-md-12">
                <img src="/img/line-separator.png" id="line">
            </div>
        </div>

        <div class="row"  id="sell-details" >
            <div class="col-md-12">

                <h2>How Selling on Randbay Works:</h2>
                <div class="row" id="divider">
                    <div class="col-md-12">
                        <img src="/img/line-separator.png" id="line">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <h4>Step One</h4>
                        <p>Name a price for the item you want to sell.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="/img/sell01-money.png" id="step-img">
                    </div>

                </div>
                <div class="row" id="divider">
                    <div class="col-md-12">
                        <img src="/img/line-separator.png" id="line">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <img src="/img/sell02-van.png" id="step-img">
                    </div>
                    <div class="col-md-8">
                        <h4>Step Two</h4>
                        <p>Work out the postage prices for your item. If you want to sell your item internationally, you will have to cover all possible destinations in your postage price.</p>
                    </div>
                </div>
                <div class="row" id="divider">
                    <div class="col-md-12">
                        <img src="/img/line-separator.png" id="line">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <h4>Step Three</h4>
                        <p>When a buyer enters a purchase price that is more than your item, they will win it.</p>
                    </div>
                    <div class="col-md-4">
                        <img src="/img/sell03-buysell.png" id="step-img">
                    </div>

                </div>
                <div class="row" id="divider">
                    <div class="col-md-12">
                        <img src="/img/line-separator.png" id="line">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <img src="/img/sell04-wings.png" id="step-img">
                    </div>
                    <div class="col-md-8">
                        <h4>Step Four</h4>
                        <p>Post your random item to the buyer!</p>
                    </div>

                </div>
                <div class="row" id="divider">
                    <div class="col-md-12">
                        <img src="/img/line-separator.png" id="line">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h4>Why on earth would I want to do this?</h4>
                        <ul>
                            <li>Got a mix tape or a demo that you want people to hear? Why not sell copies on Randbay?</li>
                            <li>Got something that you don't want anymore, but that others might? Go on.</li>
                            <li>Or you might just be a person who likes to make random things and sell them to anonymous strangers. No shame there.</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <img src="/img/sell05-result.png" id="result-img">
                        </div>
                    </div>


                </div>

            </div>
            <div class="row" id="divider">
                <div class="col-md-12">
                    <img src="/img/line-separator.png" id="line">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2>Still a bit lost? Why not visit our tips page for some ideas?</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <a class="btn btn-sm animated-button thar-one" href="{{ url('/tips') }}">TIPS FOR NEW RANDBAYERS</a>
                </div>
            </div>
            <div class="row" id="big-spacer">
                &nbsp;
            </div>
            <div class="row" id="divider">
                <div class="col-md-12">
                    <img src="/img/line-separator.png" id="line">
                </div>
            </div>
        </div>
    </div>
</div>




<div class="row" id="jumbo-spacer">
    &nbsp;
</div>

@include('partials.footer')
@stop