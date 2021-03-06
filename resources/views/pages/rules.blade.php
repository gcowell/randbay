@extends ('app')

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">

    <h2>You can sell anything on Randbay, as long as it obeys a few simple rules</h2>
        <h3>It must be a physical thing.</h3>
            <p>-Something you can touch. You can't sell your soul, or "good vibes". Real, physical things only.</p>
        <h3>It must be something that you own and are able to sell.</h3>
            <p>-You can't sell Mount Everest, or your nextdoor neighbours house. Only things that you are able to sell.</p>
        <h3>No explosives, firearms, biological agents, nuclear warheads, etc.</h3>
            <p>-Common sense, really. Nothing that's obviously dangerous or illegal.</p>
        <h3>No drugs, or other controlled substances</h3>
            <p>-Goes without saying. Don't do drugs, kids.</p>
        <h3>Your description and picture must be accurate.</h3>
            <p>-Don't make things up in your description, and don't use a misleading picture.</p>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3>Shifty sellers beware! Items that break these rules will be removed!</h3>
    </div>
</div>


<div class="row" id="jumbo-spacer">
    &nbsp;
</div>

@include('partials.footer')


@stop