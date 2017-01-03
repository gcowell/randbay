{!! Form::open(['url' => 'transactions', 'id' => 'transaction-form'])!!}

{!! Form::hidden('buyorder_id', $buyorder->id) !!}
{!! Form::hidden('saleitem_id', $saleitem->id) !!}
{!! Form::hidden('currency', $buyorder->requested_currency) !!}
{!! Form::hidden('seller_email', $saleitem->seller_paypal_email) !!}
{!! Form::hidden('buyer_email', $buyorder->buyer_email) !!}
{!! Form::hidden('price', $saleitem->total_cost) !!}
{!! Form::hidden('postage_cost', $saleitem->postage_cost) !!}


{!! Form::close() !!}


