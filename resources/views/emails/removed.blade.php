@extends ('emails.layout')

@section('title')Your Random Item Has Been Removed @stop

@section('preheader')Your Random Item Has Been Removed.... @stop

@section('intro_line') Don't be naughty! Your Random Thing, "{{ $data['description'] }}" has been removed by a moderator because it breached the <a href="http://www.randbay.com/rules">seller rules.</a> @stop

@section('detail_description')
<p>Here's the details: </p>

<h2 style="text-align: center">Item: "{{ $data['description'] }}"</h2>
<h3 style="text-align: center">Status: Removed by Moderator</h3>
<h3 style="text-align: center">This Item Did Not Abide by Randbay's <a href="http://www.randbay.com/rules">seller rules.</a></h3>

@stop

@section('image')
@stop

@section('closing_statements')
<p>Please read the rules before selling on Randbay.</p>
<p>If you attempt to re-list this item repeatedly, your details may be blacklisted.</p>
<p>Thanks for using Randbay for your dedicated source of random.</p>

@stop
