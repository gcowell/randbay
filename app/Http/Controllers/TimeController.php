<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class TimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setTimeDiff(Request $request)
    {
        $offset = Input::get('offset');

        if($request->ajax())
        {
            if (!is_numeric($offset))
            {
                exit;
            }

            Session::put('offset', $offset);

            return;
        }
        else
        {
            exit;
        }
    }
}
