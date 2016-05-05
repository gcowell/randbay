<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SaleitemRequest extends Request
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

        return
            [
                'description' => 'required',
                'price' => ['required', 'numeric', 'min:1'],
                'native_currency' => 'required',
                'international' => 'required',
                'domestic_postage_cost' => ['required', 'numeric', 'min:1'],
                'world_postage_cost' => ['required_if:international,true', 'numeric'],
                'image'  => 'required|mimes:jpeg,jpg,bmp,png'

            ];


    }
}
