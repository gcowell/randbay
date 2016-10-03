<?php

namespace App\Http\Controllers\Auth;

use App\EmailManager;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        Validator::extend('in_list', function($attribute, $value, $parameters)
        {
            $list = Config::get('countries.list');

            foreach ($list as $list_item)
            {

                if ($list_item === $value) return true;
            }
            return;
        });


        $rules =
            [
            'name' => 'required|max:60|alpha_dash|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6|max:255',
            'country' => 'required|max:255|in_list',
            'paypal_email' => 'required|email|max:255|unique:users',
            ];

        $messages = array(
            'in_list' => 'Please select the :attribute from the dropdown',
        );

        return Validator::make($data, $rules, $messages);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'country' => $data['country'],
            'seller_rating' => 3.00,
            'paypal_email' => $data['paypal_email'],
        ]);



        //TODO DEPLOYED wrap in try catch
//        Mail::queue('mail.welcome', $data, function ($message) use ($user)
//        {
//            $message->from('no-reply@randbay.com', 'Randbay');
//            $message->subject('Word on the street is that you signed up for Randbay...');
//            //TODO DEPLOYED - CHANGE THIS EMAIL WHEN DEPLOYED
//            $message->to($user['email']);
//        });

        return $user;
    }
}
