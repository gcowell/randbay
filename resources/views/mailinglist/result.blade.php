@extends ('app')

@section('content')

<div class="col-md-6 col-md-offset-3">

    <h2>Randbay Mailing List</h2>

    <hr>

    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())

            <p style="text-align: center">{{ $error }}</p>
            @else
            <h4 style="text-align: center">You have been removed from the mailing list.</h4>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-sm animated-button thar-three" href="{{ url('/') }}" id="home">Home</a>
        </div>
    </div>



    <div class="row" id="jumbo-spacer">
        &nbsp;
    </div>

</div>

@stop