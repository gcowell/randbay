<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BuyorderRequest extends Request
{
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
        return
            [
                'price' => ['required', 'numeric'],
                'requested_currency' => 'required',

            ];


    }
}
