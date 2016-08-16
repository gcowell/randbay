@extends('app')

@section('content')


<div class="col-md-6 col-md-offset-3">
    <h2>Dark secret realm</h2>
    <h4><a href="{{ url('/johnpupperman/saleitems') }}">Saleitems Monitoring</a></h4>
    <h4><a href="{{ url('/johnpupperman/tickets') }}">Manage Tickets</a></h4>
    <h4><a href="{{ url('/johnpupperman/users') }}">View Users</a></h4>
</div>

@stop