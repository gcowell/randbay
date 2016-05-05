<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Buyorder;
use App\Saleitem;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Requests\TransactionRequest;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Config;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use Illuminate\Support\Facades\Session;

//Paypal Classic
use PayPal\Api\Payment;
use PayPal\Api\ExecutePayment;


class TransactionsController extends Controller
{

    private $_api_context;

    public function __construct()
    {
        //THIS SETS UP THE API CONFIG FOR THE CLASSIC REST PAYPAL API
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);

        //THIS CAN BE USED TO CONFIGURE THE API FOR ADAPTIVE PAYMENTS
        //$this->_paypal_adaptive_conf = Config::get('paypaladaptive');

     }



//**********************************************************************************************************************
    //FETCHES ALL TRANSACTION OBJECTS AND ASSOCIATED SALES ITEMS
    public function index()
    {

///////////////for debugging/////////////////////////////////////
//        $notification_details =
//            [
//                'item_description' => 'a name',
//                'item_img_path' => '1.jpg',
//                'item_country_of_origin' => 'Germany'
//            ];
//
//        Session::flash('buyer_alert', $notification_details);

/////////////for debugging/////////////////////////////////////////////////////////////

        $sale_transactions = Auth::user()->sale_transactions()
                                         ->where('transactions.payment_complete', "true")
                                         ->orderBy('created_at', 'desc')
                                         ->simplePaginate(5);

        $buy_transactions = Auth::user()->buy_transactions()
                                        ->where('transactions.payment_complete', "true")
                                        ->orderBy('created_at', 'desc')
                                        ->simplePaginate(5);

        $sold = [];
        $index = 0;
        foreach ($sale_transactions as $sale_transaction)
        {

            $sold[$index] =
                [
                    'sold_item' => Saleitem::findOrFail($sale_transaction->saleitem_id),
                    'sold_transaction' => $sale_transaction,
                ];
            $index++;
        }

        $bought = [];
        $index = 0;
        foreach ($buy_transactions as $buy_transaction)
        {

            $bought[$index] =
                [
                    'bought_item' => Saleitem::findOrFail($buy_transaction->saleitem_id),
                    'bought_transaction' => $buy_transaction
                ];
            $index++;
        }


        return view('transactions.index')->with
        (
            [
                'sold' => $sold,
                'bought' => $bought,
                'sale_transactions' => $sale_transactions,
                'buy_transactions' => $buy_transactions,
            ]
        );
    }



//**********************************************************************************************************************

    //CREATE THE TRANSACTION OBJECT AND SET UP THE PAYPAL REQUEST
    public function create(TransactionRequest $request)
    {


        $transaction = new Transaction($request->all());
        $transaction->payment_complete = 'false';
        $transaction->remuneration_complete = 'false';
        $transaction->save();

        $saleitem = Saleitem::findOrFail($request->saleitem_id);
        $saleitem->markAsEngaged();

        return $transaction->createPaypalPayment($this->_api_context);

        //THIS CAN BE USED IF ADAPTIVE PAYMENTS ARE REQUIRED
        //return $transaction->chainedPayment($this->_paypal_adaptive_conf);

    }



//**********************************************************************************************************************

    //HANDLES THE PAYMENT ROUTE ONCE DIRECTED BACK FROM PAYPAL
    public function getPaymentStatus()
    {

        $transaction_id = Session::get('transaction_id');
        $transaction = Transaction::findOrFail($transaction_id);
        Session::forget('transaction_id');

        return $transaction->executePaypalPayment($this->_api_context);

        //THE BELOW FUNCTION CAN BE USED IF PAYPAL ADAPTIVE PAYMENT IS REQUIRED
        //return $transaction->checkChainedPaypalPayment($this->_paypal_adaptive_conf);


    }


//**********************************************************************************************************************

    public function show($id)
    {

        $transaction = Transaction::findOrFail($id);

        return view('transactions.show')->with(['transaction' => $transaction]);

    }


//**********************************************************************************************************************

    public function edit($id)
    {
        //
    }



//**********************************************************************************************************************

    public function update(Request $request, $id)
    {

        $transaction = Transaction::findOrFail($id);
        $ship_update = Input::get('item_shipped');
        $receive_update = Input::get('item_received');

        if($ship_update)
        {
            $transaction->markAsShipped($ship_update);

            $notification = new Notification();
            $notification_type = 'dispatched-type';
            $notification->generate($transaction->buyer->id, $transaction->id, $notification_type);

            $notification_details =
                [
                    'item_description' => $transaction->saleitem->description,
                    'item_img_path' => $transaction->saleitem->id . '.' . $transaction->saleitem->image_type,
                ];

            $notification->setDetails($notification_details);

        }

        if($receive_update)
        {
            $transaction->markAsReceived($receive_update);

            $notification = new Notification();
            $notification_type = 'received-type';
            $notification->generate($transaction->seller->id, $transaction->id, $notification_type);

            $notification_details =
                [
                    'item_description' => $transaction->saleitem->description,
                    'item_img_path' => $transaction->saleitem->id . '.' . $transaction->saleitem->image_type,
                ];

            $notification->setDetails($notification_details);
        }

        $transaction->save();

        return redirect('/transactions/'. $id);



    }


//**********************************************************************************************************************


    public function destroy($id)
    {
        //
    }







}
