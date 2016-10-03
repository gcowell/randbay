@extends('app')

@section('content')



<div class="col-md-4 col-md-offset-4">

<h1>{!! $user->name  !!}'s Details</h1>

@if (Session::has('updated'))
    <div class="alert alert-info" id="updated-user">{{ Session::get('updated') }}
     </div>
@endif
@if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
@endif

    <div class="panel panel-default">
        <div class="panel-heading">
            User Information
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                <p>Member since: </p>
            </div>
            <div class="col-md-6">
                <p>{{$user->created_at->toDateString()}} </p>
            </div>

        </div>

    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            Edit Details
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-12" style="text-align: center">
                    {!! Form::model( $user, ['url' => url('users' , $user->id), 'method' => 'post', 'autocomplete' => 'off' ] )!!}
                </div>
            </div>

            <div class="form-group" id="name-group">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::label('name', 'Username') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                </div>
            </div>

            <div class="form-group" id="email-group">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::label('email', 'Email Address') !!}
                        {!! Form::email('email', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                </div>
            </div>

            <div class="form-group" id="paypal-group">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::label('paypal_email', 'Paypal Email') !!}
                        {!! Form::email('paypal_email', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </div>
                </div>
            </div>

            <div class="form-group" id="paypal-group">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::label('country', 'Country') !!}
                        {!! Form::select( 'country', $countries, $user->country, ['class' => 'form-control', 'autocomplete' => 'off'] ) !!}
                    </div>
                </div>
            </div>

            <div class="form-group" id="submit-group">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::submit('Update Details', ['class' => 'btn btn-primary form-control' ]) !!}
                    </div>
                </div>
            </div>

            {!! Form::close() !!}


        </div>
    </div>








</div>




@stop