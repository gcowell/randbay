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


        Validator::extend('correct_currency', function($attribute, $value, $parameters)
        {
            $list = ['GBP', 'USD', 'EUR'];

            foreach ($list as $list_item)
            {
                if ($list_item == $value) return true;
            }
            return false;
        });

        return
            [

                'description' => 'required|max:255',
                'price' => ['required', 'numeric', 'min:1', 'max:99999'],
                'native_currency' => [ 'required', 'correct_currency'],
                'international' => 'required|max:255',
                'domestic_postage_cost' => ['required', 'numeric', 'min:1', 'max:99999'],
                'world_postage_cost' => ['required_if:international,true', 'numeric', 'min:1', 'max:99999'],
                'image'  => 'required|mimes:jpeg,jpg,bmp,png|max:2048'

            ];


    }
}
