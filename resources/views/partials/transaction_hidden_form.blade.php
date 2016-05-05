{!! Form::open(['url' => 'transactions', 'id' => 'transaction-form'])!!}

{!! Form::hidden('buyorder_id', $buyorder->id) !!}
{!! Form::hidden('saleitem_id', $saleitem->id) !!}
{!! Form::hidden('currency', $buyorder->requested_currency) !!}
{!! Form::hidden('seller_id', $saleitem->user_id) !!}
{!! Form::hidden('buyer_id', $buyorder->user_id) !!}
{!! Form::hidden('price', $saleitem->total_cost) !!}
{!! Form::hidden('postage_cost', $saleitem->postage_cost) !!}


{!! Form::close() !!}


