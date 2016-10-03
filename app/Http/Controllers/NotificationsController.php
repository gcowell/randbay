<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notification;

class NotificationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('banned.check');

    }


/***********************************************************/
    public function index(Request $request)
    {
        if(!$request->ajax())
        {
            return redirect('/');
        }
        $notifications = Auth::User()->notifications()->orderBy('created_at', 'desc')->take(20)->get();
        $returnHTML = view('notifications.framework')->with('notifications', $notifications)->render();

        return response()->json(['success' => true, 'html'=>$returnHTML]);
    }


/***********************************************************/

    public function markAsRead(Request $request, $id)
    {
        if(!$request->ajax())
        {
            return redirect('/');
        }
        $notification = Notification::findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }


/***********************************************************/
    public function checkForNew(Request $request)
    {
        if(!$request->ajax())
        {
            return redirect('/');
        }

        $notifications = Auth::User()->notifications->where('unread', 'true');

        if(!$notifications->isEmpty())
        {
            return ['success' => 'true', 'img' => '/img/notify-yes.png'];
        }
        else
        {
            return ['success' => 'true', 'img' => '/img/notify-no.png'];
        }
    }

}
