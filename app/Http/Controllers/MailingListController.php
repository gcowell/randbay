<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MailingList;
use App\Http\Requests\MailingListRequest;
use Illuminate\Support\Facades\Session;

class MailingListController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirm($id)
    {
        return view('mailinglist.confirm')->with(['id' => $id]);
    }


    public function index()
    {
        return redirect('/');
    }


    public function unsubscribe(MailingListRequest $request)
    {

        $stored_email = MailingList::findOrFail($request->id)->email;

        if($stored_email === $request->email)
        {
            MailingList::destroy($request->id);

            return view('mailinglist.result');

        }
        else
        {
            $error = 'The email you have entered does not match our records. Please try again.';

            Session::flash('error' , $error );

            return view('mailinglist.confirm');
        }

    }


}
