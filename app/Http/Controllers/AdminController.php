<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Saleitem;
use App\Notification;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use App\User;
use App\SupportTicket;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin.check');
        $this->saleitemPath = Config::get('saleitems.filepath');
    }


//**********************************************************************************************************************

//ADMIN HOMEPAGE
    public function index()
    {
        return view('admin.index');
    }

//**********************************************************************************************************************

//RETURNS ALL UNCHECKED SALEITEMS
    public function saleitemsMonitoring()
    {
        $saleitem = new Saleitem();
        $unchecked_saleitems = $saleitem->getUnchecked();

        return view('admin.checksaleitems')->with(['unchecked_saleitems' => $unchecked_saleitems]);
    }


//**********************************************************************************************************************

//RETURNS ALL UNCHECKED SALEITEMS
    public function markAsChecked(Request $request)
    {

        $id_array = Input::except('_token');

        foreach ($id_array as $id)
        {
            $saleitem = Saleitem::findOrFail($id);
            $saleitem->setCheckedTrue();
            $saleitem->save();
        }

        return redirect('johnpupperman/saleitems');
    }

//**********************************************************************************************************************

//DELETES AN OFFENDING SALEITEM AND WARNS SELLER
    public function adminDelete($id)
    {
        $saleitem = Saleitem::findOrFail($id);

        //EXTRACT DETAILS FROM SALEITEM
        $seller = $saleitem->seller;
        $description = $saleitem->description;
        $transaction_id = null;
        $fileName = $saleitem->id.'.'.$saleitem->image_type;

        //GENERATE NOTIFICATION
        $notification = new Notification();
        $notification_type = 'deleted-type';
        $notification->generate($seller->id, $transaction_id, $notification_type );

        $notification_details =
            [
                'item_description' => $description,
            ];

        $notification->setDetails($notification_details);

        //DELETE ITEM
        $saleitem->delete();

        //IMAGE FILE REMOVAL
        if(file_exists($this->saleitemPath . $fileName))
        {
            unlink($this->saleitemPath . $fileName); //remove the file
        }

        //ADD STRIKE FOR USER
        $seller->addStrike();

        return redirect('johnpupperman/saleitems');

    }


//**********************************************************************************************************************

//RETURNS ALL OPEN SUPPORT TICKETS
    public function supportTicketMonitoring()
    {
        $support_ticket = new SupportTicket();
        $open_tickets = $support_ticket->getOpenTickets();

        return view('admin.tickets')->with(['open_tickets' => $open_tickets]);

    }

    //**********************************************************************************************************************

//RETURNS ALL OPEN SUPPORT TICKETS
    public function resolveSupportTicket($id, Request $request)
    {
        $support_ticket = SupportTicket::findOrFail($id);
        $support_ticket->resolve(Input::get('result'));

        $complainer_notification = new Notification();
        $complainer_notification->generate($support_ticket->complainer_id, null, 'ticket-closed-type');

        $complainer_notification->setDetails(
        [
            'item_description' => $support_ticket->transaction->saleitem->description,
            'item_support_ticket_id' => $support_ticket->id
        ]
        );

        return redirect('johnpupperman/tickets');

    }


//**********************************************************************************************************************

    //BANS USER AND DELETES THEIR SALEITEMS
    public function banUser($id)
    {
        $user = User::findOrFail($id);
        $user->banUser();


        $bannedSaleitems = $user->saleitems()->where('matched', '=', 'false')->get();

        foreach ($bannedSaleitems as $saleitem)
        {
            $saleitem->delete();

            //IMAGE FILE REMOVAL
            $fileName = $saleitem->id.'.'.$saleitem->image_type;

            if(file_exists($this->saleitemPath . $fileName))
            {
                unlink($this->saleitemPath . $fileName); //remove the file
            }
        }

        return redirect('johnpupperman/users');

    }

//**********************************************************************************************************************

    //RETURNS ALL USERS
    public function userList()
    {
        $users = User::where('banned', '=', null)->orderBy('strikes', 'DESC')->take(50)->get();

        return view('admin.users')->with(['users' => $users]);
    }



}
