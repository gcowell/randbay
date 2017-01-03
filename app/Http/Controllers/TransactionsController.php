<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Saleitem;
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
    }



//**********************************************************************************************************************

    //HANDLES THE PAYMENT ROUTE ONCE DIRECTED BACK FROM PAYPAL
    public function getPaymentStatus()
    {
        $transaction_id = Session::get('transaction_id');
        $transaction = Transaction::findOrFail($transaction_id);
        Session::forget('transaction_id');

        return $transaction->executePaypalPayment($this->_api_context);
    }

}
