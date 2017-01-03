@extends ('emails.layout')

@section('title')Your Random Thing is up for Sale @stop

@section('preheader')Your Random Thing is up for Sale.... @stop

@section('intro_line') Your Random Thing is up for Sale on Randbay!   @stop

@section('detail_description')
<p>Here are the details: </p>

<h2 style="text-align: center">"{{ $data['description'] }}"</h2>
<h3 style="text-align: center">Asking price: {{ $data['native_currency'] . $data['price']  }}</h3>

@stop

@section('image')
<img src="{{ $message->embed($data['image_path'] . '/' . $data['id'] . '.' . $data['image_type']) }}" alt="" style="max-height: 500px; max-width: 500px" />
@stop

@section('closing_statements')
<p>We will drop you an email telling you where to ship this bad boy when it sells.</p>
<p>If your random thing doesn't sell within 10 days, we will automatically remove the listing (you can add it again afterwards if you want).</p>

<p>Thanks for using Randbay for your dedicated source of random!</p>
@stop