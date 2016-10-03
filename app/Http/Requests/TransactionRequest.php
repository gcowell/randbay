<?php

namespace App\Http\Requests;

use App\Currencies;
use App\Http\Requests\Request;
use App\Saleitem;
use App\Buyorder;

class TransactionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

      return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //Take the input object ids from the form
        $saleitem_id_input = $this->input('saleitem_id');
        $buyorder_id_input = $this->input('buyorder_id');

        //Independently check the buyer and sellers ids of these objects
        $saleitem = Saleitem::findOrFail($saleitem_id_input);
        $buyorder = Buyorder::findOrFail($buyorder_id_input);
        $seller_id_check = $saleitem->seller->id;
        $buyer_id_check = $buyorder->buyer->id;

        if($buyorder->matched =='true')
        {
            return abort(403, 'Unauthorized action.');
        }

        //Independently check the price has not been modified
        $currencies = new Currencies();
        $requested_currency = $this->input('currency');
        $postage_cost = $this->input('postage_cost');
        $total_cost = $this->input('price');

        $item_cost = $total_cost - $postage_cost;
        $formatted_price_input = number_format((float)$currencies->convertToBaseGDP($requested_currency, $item_cost), 2, '.', '');

        $price_check = Saleitem::findOrFail($saleitem_id_input)->price;

        if($price_check === $formatted_price_input)
        {
            return
                [
                    'price' => ['required', 'numeric'],
                    'postage_cost' => ['required', 'numeric'],
                    'currency' => ['required', 'exists:buyorders,requested_currency,id,' . $buyorder_id_input],
                    'saleitem_id' => ['required', 'numeric'],
                    'buyorder_id' => ['required', 'numeric', 'exists:buyorders,id,matched,false'],
                    'buyer_id' => ['required', 'numeric', 'exists:users,id,id,' . $buyer_id_check],
                    'seller_id' => ['required', 'numeric', 'exists:users,id,id,' . $seller_id_check],

                ];
        }
        else
        {
            return abort(403, 'Unauthorized action.');
        }

    }
}
