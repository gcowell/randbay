@extends ('app')

@section('content')

<div class="col-md-8 col-md-offset-2">

<h2>Frequently Asked Questions</h2>

    <hr>

    <div class="row">
        <div class="col-md-12 collapse-group">
            <p><a id="faq" class="btn" data-toggle="collapse" data-target="#viewdetails1">What is the point of Randbay?</a></p>
            <p class="col-md-12 collapse" id="viewdetails1">-There is absolutely no point to Randbay.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 collapse-group">
            <p><a id="faq"  class="btn" data-toggle="collapse" data-target="#viewdetails2">How does Randbay work?</a></p>
            <p class="col-md-12 collapse" id="viewdetails2">-Click <a href="/how" >here</a> for an explanation of Randbay</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 collapse-group">
            <p><a  id="faq" class="btn" data-toggle="collapse" data-target="#viewdetails3">What's to stop a user selling a useless item for a massive price?</a></p>
            <p class="col-md-12 collapse" id="viewdetails3">-Nothing. It's all in the luck of the draw. We have a rating system to reduce the likelihood of this, but randomness still reigns supreme.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 collapse-group">
            <p><a  id="faq" class="btn" data-toggle="collapse" data-target="#viewdetails4">How does the rating system work?</a></p>
            <p class="col-md-12 collapse" id="viewdetails4">-Every time a user sells an item, the buyer gets to rate it for randomness, value for money, quality etc. Sellers who regularly get poor ratings are less likely to sell their items (due to Randbay's super-clever algorithms). This means sellers who repeatedly sell terrible things gradually sink to the bottom, and the cool, hip sellers float to the top. Democracy!
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 collapse-group">
            <p><a  id="faq" class="btn" data-toggle="collapse" data-target="#viewdetails5">What if I buy an item that I don't like / want?</a></p>
            <p class="col-md-12 collapse" id="viewdetails5">-There are no refunds for Randbay items, as this would ruin the randomness. Unless the random item you have bought has broken <a href="/rules" >the rules</a>, you better get used to it, because it's yours now. Try to enjoy it!
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 collapse-group">
            <p><a  id="faq" class="btn" data-toggle="collapse" data-target="#viewdetails6">What payment methods does Randbay accept?</a></p>
            <p class="col-md-12 collapse" id="viewdetails6">-PayPal payments only. All payments on Randbay are processed through PayPal for its super high-tech security. Randbay does not hold any credit card or bank account information on its servers. Sleep well, for your money is safe.
            </p>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 collapse-group">
            <p><a  id="faq" class="btn" data-toggle="collapse" data-target="#viewdetails7">What are the fees?</a></p>
            <p class="col-md-12 collapse" id="viewdetails7">-Randbay is free to use. For each successful sale, Randbay takes a 10% cut to keep the lights on. Additional fees will also be charged by PayPal - these will vary depending on location and can be found <a href="https://www.paypal.com/uk/webapps/mpp/paypal-fees" target="_blank">here</a>.
            </p>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 collapse-group">
            <p><a  id="faq" class="btn" data-toggle="collapse" data-target="#viewdetails8">What currencies does Randbay accept?</a></p>
            <p class="col-md-12 collapse" id="viewdetails8">-Currently we can work in EUR, GBP and USD. Additional PayPal fees may be incurred due to currency conversion during a sale (find out more <a href="https://www.paypal.com/uk/webapps/mpp/paypal-fees" target="_blank">here</a>).
            </p>
        </div>
    </div>


</div>



@include('partials.footer')



@stop