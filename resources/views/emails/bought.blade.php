@extends ('emails.layout')

@section('title')You've Just Bought a Random Item @stop

@section('preheader')You've Just Bought a Random Item.... @stop

@section('intro_line') You've just bought a random item from Randbay!   @stop

@section('detail_description')
<p>Here's what you got: </p>

<h2 style="text-align: center">"{{ $data['description'] }}"</h2>
<h3 style="text-align: center">Price Paid: {{ $data['native_currency'] . $data['price']  }}</h3>

@stop

@section('image')
<img src="{{ $message->embed($data['image_path'] . '/' . $data['id'] . '.' . $data['image_type']) }}" alt="" style="margin: auto; top: 0; bottom: 0; left: 0; right: 0; position: absolute; display: block; max-height: 100%; max-width: 100%; width: auto; height: auto;"/>
@stop

@section('closing_statements')
<p>Isn't that exciting!?</p>
<p>Thanks for using Randbay for your dedicated source of random</p>
@stop
