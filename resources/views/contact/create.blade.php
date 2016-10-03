@extends ('app')

@section('content')

<div class="col-md-12">


    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            @if (Session::has('success'))
            <h2>{{ Session::get('success') }}</h2>
            <p style="text-align: center;"><a href="{{ url('/') }}">Return Home</a></p>
            @else

            <h3>Contact Randbay</h3>
            <p>If you can't find what you are looking for in the FAQ or you need specific help with something else, then you can contact us directly using the form below:</p>

            {!! Form:: open(['url' => 'contact']) !!}

            @if ($errors->any())
            <ul class="alert alert-danger" id="payment-error">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif

            <div class="form-group">
                {!! Form::label('name', 'Your name') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Your email address') !!}
                {!! Form::text('email', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('subject', 'Subject') !!}
                {!! Form::text('subject', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('message', 'Message') !!}
                {!! Form:: textarea ('message', null, ['class' => 'form-control', 'id' => 'message', 'rows' => '4', 'id' => 'message-textarea' ]) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Send Message', ['class' => 'btn btn-primary']) !!}
                {!! Form:: close() !!}
            </div>
            @endif

        </div>
    </div>
    <div class="row" id="jumbo-spacer">
        &nbsp;
    </div>


</div>


@include('partials.footer')
@stop