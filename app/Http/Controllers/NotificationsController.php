<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Notification;
use PayPal\Api\Transaction;

class NotificationsController extends Controller
{

    public function index(Request $request)
    {
        if(!$request->ajax())
        {
            return redirect('/');
            exit;
        }
        $notifications = Auth::User()->notifications;
        $returnHTML = view('notifications.framework')->with('notifications', $notifications)->render();

        return response()->json(['success' => true, 'html'=>$returnHTML]);
    }

    public function markAsRead(Request $request, $id)
    {
        if(!$request->ajax())
        {
            return redirect('/');
            exit;
        }
        $notification = Notification::findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function checkForNew(Request $request)
    {
        if(!$request->ajax())
        {
            return redirect('/');
            exit;
        }

        $notifications = Auth::User()->notifications->where('notifications.unread', "true");

        if($notifications)
        {
            return ('img');
        }
        else
        {
            return ('other_img');
        }
    }

}
