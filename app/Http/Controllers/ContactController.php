<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send(ContactRequest $request)
    {
        $data = $request->except('_token');

//        Mail::queue('emails.help', $data, function($message) use ($data)
//        {
//            $message->from($data['email'] , $data['first_name']);
//            $message->from('no-reply@randbay.com', 'Randbay Help Service');
//            $message->to('master@randbay.com')->subject($data['subject']);
//
//        });


        //ADD ADDITIONAL MAIL TO SEND CONFIRMATION TO CUSTOMER EMAIL


        // Redirect to page
        return redirect('contact')
            ->with('success', 'Your message has been sent. Thank You!');
    }


}
