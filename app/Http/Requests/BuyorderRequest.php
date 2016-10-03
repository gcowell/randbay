<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Validator;

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
                'price' => ['required', 'numeric', 'min:0.01', 'max:99999'],
                'requested_currency' => ['required', 'correct_currency'],

            ];


    }
}
