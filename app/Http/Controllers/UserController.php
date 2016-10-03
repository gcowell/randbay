<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.check',['except' => 'index' ]);
        $this->middleware('banned.check');

    }


//**********************************************************************************************************************
    //ROUTE TO USER DASHBOARD
    public function index()
    {
        $user = Auth::user();

        return view('users.dashboard')->with('user', $user);
    }



//**********************************************************************************************************************
    //SHOW SELECTED USER
    public function show($id)
    {
        $user = User::findOrFail($id);
        $countries = Config::get('countries.list');

        return view('users.show')->with(['user'=> $user, 'countries' => $countries ]);
    }

//**********************************************************************************************************************
    //SHOW SELECTED USER
    public function update(UserUpdateRequest $request, $id)
    {

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->paypal_email = $request->paypal_email;
        $user->save();

        $countries = Config::get('countries.list');
        Session::flash('updated', 'Your details have been updated');

        return view('users.show')->with(['user'=> $user, 'countries' => $countries ]);
    }

}
