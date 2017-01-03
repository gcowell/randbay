@extends ('emails.layout')

@section('title')Your Random Item Did Not Sell @stop

@section('preheader')Your Random Item Did Not Sell.... @stop

@section('intro_line') Oh No! Your Random Thing, "{{ $data['description'] }}" did not sell. @stop

@section('detail_description')
<p>Here's the details: </p>

<h2 style="text-align: center">"{{ $data['description'] }}"</h2>
<h3 style="text-align: center">Did not sell.</h3>
<h3 style="text-align: center">This Listing has Expired After 10 Days.</h3>

@stop

@section('image')
<img src="{{ $message->embed($data['image_path'] . '/' . $data['id'] . '.' . $data['image_type']) }}" alt="" style="margin: auto; top: 0; bottom: 0; left: 0; right: 0; position: absolute; display: block; max-height: 100%; max-width: 100%; width: auto; height: auto;" />
@stop

@section('closing_statements')
<p>Your thing has been automatically removed from Randbay. Don't be too downhearted.</p>
<p>You can always re-list your thing <a href="http://www.randbay.com/sell">here</a>, maybe try a different price and see how that goes.</p>
<p>Thanks for using Randbay for your dedicated source of random</p>
@stop


