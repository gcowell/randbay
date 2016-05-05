<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => 'index']);
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

        return view('users.show')->with('user', $user);
    }


}
