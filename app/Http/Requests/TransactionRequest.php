<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TransactionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO need a check here to understand if hidden form input has been altered
        //TODO e.g. does saleitem id belong to seller id / does buyer id match buyorder id / does price match the saleitem

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return
            [
                'price' => ['required', 'numeric'],
                'postage_cost' => ['required', 'numeric'],
                'currency' => 'required',
                'saleitem_id' => ['required', 'numeric'],
                'buyorder_id' => ['required', 'numeric'],
                'buyer_id' => ['required', 'numeric'],
                'seller_id' => ['required', 'numeric'],

            ];

    }
}
