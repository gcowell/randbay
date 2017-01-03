<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Validator;
use Illuminate\Support\Facades\Config;

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

        Validator::extend('in_list', function($attribute, $value, $parameters)
        {
            $list = Config::get('countries.list');

            foreach ($list as $list_item)
            {

                if ($list_item === $value) return true;
            }
            return;
        });

        return
            [
                'price' => ['required', 'numeric', 'min:0.01', 'max:99999'],
                'requested_currency' => ['required', 'correct_currency'],
                'country' => ['required', 'in_list'],
                'buyer_email' => 'required|email|max:255',
            ];


    }
}
