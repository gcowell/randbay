@extends('app')

@section('content')

<div class="col-md-10 col-md-offset-1">
    <div class="row">
        <div class="col-md-2">
            <h3>Username</h3>
        </div>
        <div class="col-md-2">
            <h3>Email</h3>
        </div>
        <div class="col-md-2">
            <h3>Paypal</h3>
        </div>
        <div class="col-md-2">
            <h3>Strikes</h3>
        </div>
        <div class="col-md-2">
            <h3>Ban</h3>
        </div>
    </div>

    @foreach ($users as $user)

    <div class="row">
        <div class="col-md-2">
            {{ $user->name }}
        </div>
        <div class="col-md-2">
            {{ $user->email }}
        </div>
        <div class="col-md-2">
            {{ $user->paypal_email }}
        </div>
        <div class="col-md-2">
            @if ($user->strikes)
            <p>{{ $user->strikes }}</p>
            @else
            <p>None</p>
            @endif
        </div>
        <div class="col-md-2">
            <a href="{{ url('johnpupperman/users/ban/'. $user->id) }}">Ban</a>
        </div>

    </div>

    @endforeach

</div>

@stop