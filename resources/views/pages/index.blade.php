@extends ('app')

@section('content')

    <div class="jumbotron">
        <h1>Landing Page</h1>
        <p>Bootstrap is the most popular HTML, CSS, and JS framework for developing
            responsive, mobile-first projects on the web.</p>
    </div>


<div class="col-md-6 col-md-offset-3">

    <div class="row">
        <div class="col-md-6">
            <a class="btn btn-primary btn-block" href="{{ url('/buyorders/create') }}">Buy</a>
        </div>
        <div class="col-md-6">
            <a class="btn btn-primary btn-block" href="{{ url('/saleitems/create') }}">Sell</a>
        </div>
    </div>
    <hr>
</div>

@stop