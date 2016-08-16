<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{


    public function index()
    {
        return view('pages.index');
    }




    public function how()
    {
        return view('pages.how');
    }

    public function FAQ()
    {
        return view('pages.faq');
    }


    public function rules()
    {
        return view('pages.rules');
    }
    public function tips()
    {
        return view('pages.tips');
    }
}
