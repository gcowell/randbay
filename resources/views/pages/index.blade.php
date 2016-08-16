@extends ('app')

@section('content')
    <div class="bg"></div>
    <div class="jumbotron" style=" text-align: center;">
        <img src="/img/logo-big.png" id="logo-big">
        <p>Utterly pointless.</p>
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
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2 style="text-align: center">First timer?</h2>
            <h2 style="text-align: center">What the Hell is a Randbay?</h2>
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
<div class="animation-element slide-left" id=random-img-container>

</div>
<div class="row" id="big-spacer">
    &nbsp;
</div>

@include('partials.footer')


@stop