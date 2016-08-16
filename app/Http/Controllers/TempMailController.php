<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class TempMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMail()
    {

        $data = [
            'name' => 'Brian bumhole',
            'email' => 'gdcowell@googlemail.com',

        ];

        Mail::send('mail.welcome', $data, function ($message) use ($data)
        {
            $message->from('no-reply@randbay.com', 'Randbay');
            $message->subject('Word on the street is that you signed up for Randbay...');
            $message->to($data['email']);
        });
    }


}
