<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SupportEvidenceRequest;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\SupportTicket;
use Illuminate\Support\Facades\Auth;
use App\Saleitem;
use App\Notification;
use App\Http\Requests\SupportTicketRequest;
use Illuminate\Support\Facades\Redirect;

class SupportTicketController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('supportticket.check', ['only' => 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Auth::user()->supportTicketsRaised()->orderBy('created_at', 'desc')->get();


        return view('support.index')->with(['tickets' => $tickets, 'complainer' => true ]);
    }



    public function complaints()
    {
        $tickets = Auth::user()->supportTicketsAgainst()->orderBy('created_at', 'desc')->get();

        return view('support.index')->with(['tickets' => $tickets, 'complainee' => true ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTicket($id)
    {
        $transaction = Transaction::findOrFail($id);
        $saleitem = Saleitem::findOrFail($transaction->saleitem_id);

        return view('support.create')->with(['transaction' => $transaction, 'saleitem' => $saleitem ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupportTicketRequest $request)
    {

        $input = $request->all();
        $transaction = Transaction::findOrFail($input['transaction_id']);

        if(count($transaction->ticket))
        {
            return redirect('/support');
        }


        $supportticket = SupportTicket::create(
            [
                'transaction_id' => $input['transaction_id'],
                'type' => $input['type'],
                'complainer_id' => $input['complainer_id'],
                'complainee_id' => $input['complainee_id'],
                'details' => $input['details'],
                'resolved' => 'false',
                'evidence_added' => 'false'
            ]
        );

        $supportticket->createEvidenceDirectory();

        $transaction = Transaction::findOrFail($input['transaction_id']);
        $transaction->addTicket($supportticket->id);


        $notification_details =
            [
                'item_description' => $transaction->saleitem->description,
                'item_img_path' => $transaction->saleitem->id . '.' . $transaction->saleitem->image_type,
                'item_support_ticket_id' => $supportticket->id
            ];


        $seller_notification = new Notification();
        $seller_notification->generate($supportticket->complainee_id, $supportticket->transaction_id, 'ticket-type');
        $seller_notification->setDetails($notification_details);


        return redirect('support');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = SupportTicket::findOrFail($id);

        $evidence_directory = $ticket->evidence_dir;

        if($evidence_directory)
        {
            $directory_contents = scandir($evidence_directory);
            $evidence_files = array_diff($directory_contents, array('.','..'));
        }
        else
        {
            $evidence_files = null;
        }

        return view('support.show')->with(['ticket' => $ticket, 'evidence_files' => $evidence_files ]);
    }


    public function addEvidence(SupportEvidenceRequest $request, $id)
    {

        $ticket = SupportTicket::findOrFail($id);
        $moveDestinationPath = $ticket->evidence_dir;

        $files = $request->files;

        $index = 1;
        foreach ($files as $file)
        {
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $fileName = 'evidence-item'. $index . '.' . $extension; // renaming image
            if (file_exists ( $moveDestinationPath . '\\' . $fileName ))
            {
                unlink($moveDestinationPath . '\\' . $fileName );
            }

            $file->move($moveDestinationPath, $fileName);
            $index++;
        }

        $ticket->evidence_added = 'true';
        $ticket->save();

        $transaction = Transaction::findOrFail($ticket->transaction_id);

        //NOTIFICATION FOR BUYER THAT EVIDENCE HAS BEEN UPDATED
        $notification_details =
            [
                'item_description' => $transaction->saleitem->description,
                'item_img_path' => $transaction->saleitem->id . '.' . $transaction->saleitem->image_type,
                'item_support_ticket_id' => $ticket->id
            ];


        $buyer_notification = new Notification();
        $buyer_notification->generate($ticket->complainee_id, $ticket->transaction_id, 'evidence-type');
        $buyer_notification->setDetails($notification_details);

        return redirect('support/' . $ticket->id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
