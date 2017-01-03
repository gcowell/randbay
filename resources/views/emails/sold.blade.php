@extends ('emails.layout')

@section('title')You've Just Sold Your Random Thing  @stop

@section('preheader')You've Just Sold Your Random Thing....  @stop

@section('intro_line') Congratulations! You've just sold your Random thing: "{{ $data['description'] }}"   @stop

@section('detail_description')
<p>Here's the details: </p>

<h2 style="text-align: center">"{{ $data['description'] }}"</h2>
<h3 style="text-align: center">Sold for: {{ $data['native_currency'] . $data['price']   }}</h3>
<h3 style="text-align: center">Randbay Fee (10%): -{{ $data['native_currency'] . $data['randbay_fee']  }}</h3>
<h3 style="text-align: center">Paypal Fee: -{{ $data['native_currency'] . $data['paypal_fee'] }}</h3>
<h3 style="text-align: center">Postage Paid: +{{ $data['native_currency'] . $data['postage_cost'] }}</h3>


@stop

@section('image')
<img src="{{ $message->embed($data['image_path'] . '/' . $data['id'] . '.' . $data['image_type']) }}" alt="" style="margin: auto; top: 0; bottom: 0; left: 0; right: 0; position: absolute; display: block; max-width: 580px; padding: 10px; width: auto !important; width: 580px; height: auto;" />
@stop

@section('closing_statements')

<p>Please send this item to the following lucky customer:</p>

@foreach ($data['shipping_address'] as $address_line )
    @if ($address_line == 'Empty')
        @continue
    @else
        <p style="margin-bottom: 0px !important; text-indent: 50px">{{ $address_line }},</p>
    @endif
@endforeach
<br>

<p>Be sure to ship promptly or the transaction may be reversed.</p>
<p>Thanks for using Randbay for your dedicated source of random!</p>
@stop