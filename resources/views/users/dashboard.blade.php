@extends('app')

@section('content')

<div class="col-md-10 col-md-offset-1">

    <div class="row">
        <div class="col-md-12">
            <h1>{{$user->name}}'s Dashboard</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
                <div id="transaction-rating" hidden="">{{ round($user->seller_rating) }}</div>
                <fieldset class="rated">
                    <input type="radio" id="rated-star5" name="rated" value="5" disabled /><label for="star5" >5 stars</label>
                    <input type="radio" id="rated-star4" name="rated" value="4" disabled /><label for="star4" >4 stars</label>
                    <input type="radio" id="rated-star3" name="rated" value="3" disabled /><label for="star3" >3 stars</label>
                    <input type="radio" id="rated-star2" name="rated" value="2" disabled /><label for="star2" >2 stars</label>
                    <input type="radio" id="rated-star1" name="rated" value="1" disabled /><label for="star1" >1 star</label>
                </fieldset>
            </div>
        </div>

    <hr>

    <div class="row">

        <div class="col-md-2">
            <h3>My Stuff</h3>

            <div  id="sidebar-container">

                <ul>
                    <li><a href="/users/{{ $user->id }}">My Details</a></li>
                    <li><a href="/transactions/">My Transactions</a></li>
                    <li><a href="/saleitems/">My Saleitems</a></li>
                    <li><a href="/support/">My Support Tickets</a></li>
                    <li><a href="/support/complaints/">Complaints Received</a></li>

                </ul>
            </div>
        </div>

        <div class="col-md-9" id="notifications-container">
            <h3>My Notifications</h3>
            <div id="notifications-body">

            </div>
            <div id="notifications-loading">
                <img src="/img/loader_blue_128.gif" id="loader-gif">
            </div>



        </div>

    </div>

</div>



@stop