@extends('app')

@section('content')


<div class="col-md-6 col-md-offset-3">

    <h2>Randbay Mailing List</h2>

    <hr/>
    @if (Session::has('error'))
    <ul class="alert alert-danger" id="error-list">
        <li>{{ Session::get('error') }}</li>
    </ul>
    @endif


    {!! Form::open(['url' => 'mailinglist', 'id' => 'unsubscribe_form' ])!!}

    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                {!! Form::label('email', 'Your Email Address: ') !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! Form::email('email', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
            </div>
            <div class="col-md-12">
                {!! Form::text('id', null, ['autocomplete' => 'off', 'hidden' => 'hidden', 'id' => 'id_input']) !!}
            </div>
        </div>
    </div>


    <div class="form-group" >
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-sm animated-button thar-three" href="#" id="confirm">Unsubscribe</a>
            </div>
        </div>
    </div>



    <div class="row" id="jumbo-spacer">
        &nbsp;
    </div>

</div>


@stop