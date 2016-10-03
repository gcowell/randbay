<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class UserUpdateRequest extends Request
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

      Validator::extend('in_list', function($attribute, $value, $parameters)
        {
            $list = Config::get('countries.list');

            foreach ($list as $list_item)
            {

                if ($list_item === $value) return true;
            }
            return false;
        });

        $id = Auth::user()->id;

        return [
            'name' => 'required|max:60|alpha_dash|unique:users,name,'.$id,
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'country' => 'required|max:255|in_list',
            'paypal_email' => 'required|email|max:255|unique:users,paypal_email,'.$id,
        ];
    }
}
