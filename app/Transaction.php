<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Saleitem;
use App\Buyorder;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

//**********************************************************************************************************************
//THESE IMPORTS ARE PAYPAL 'CLASSIC' REST API
use PayPal\Api\Currency;
use PayPal\Api\PayoutItem;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\Transaction as PaypalTransaction;
use PayPal\Api\Payout;
use App\Notification;

//**********************************************************************************************************************
//THESE IMPORTS ARE PAYPAL 'ADAPTIVE' SOAP API
//use PayPal\Types\AP\PayRequest;
//use PayPal\Types\AP\Receiver;
//use PayPal\Types\AP\ReceiverList;
//use PayPal\Types\Common\RequestEnvelope;
//use PayPal\Service\AdaptivePaymentsService;
//use PayPal\Types\AP\SetPaymentOptionsRequest;
//use PayPal\Types\AP\PaymentDetailsRequest;
//use PayPal\Types\AP\DisplayOptions;
//use PayPal\Types\AP\SenderOptions;
//use PayPal\Types\AP\ReceiverOptions;
//use PayPal\Types\AP\InvoiceData;
//use PayPal\Types\AP\InvoiceItem;


class Transaction extends Model
{

    protected $fillable =
        [
            'price',
            'currency',
            'buyorder_id',
            'saleitem_id',
            'buyer_id',
            'seller_id',
            'has_support_ticket',
            'postage_cost'
        ];

    protected $dates = ['created_at', 'updated_at', 'payment_date', 'shipped_date', 'received_date'];


//**********************************************************************************************************************
    //RELATIONSHIPS

    public function buyorder()
    {
        return $this->hasOne('App\Buyorder', 'id', 'buyorder_id' );
    }

    public function saleitem()
    {
        return $this->hasOne('App\Saleitem', 'id', 'saleitem_id');
    }

    public function buyer()
    {
        return $this->hasOne('App\User', 'id',  'buyer_id');
    }

    public function seller()
    {
        return $this->hasOne('App\User', 'id', 'seller_id');
    }

    public function ticket()
    {
        return $this->hasOne('App\SupportTicket', 'id', 'support_ticket_id' );
    }

//**********************************************************************************************************************

    //MARK THE TRANSACTION AS SHIPPED

    public function markAsShipped($shipped)
    {
        $this->item_shipped = 'true';
        $this->shipped_date = new Carbon();
        return true;
    }


//**********************************************************************************************************************

    //MARK THE TRANSACTION AS RECEIVED

    public function markAsReceived($received)
    {

        if($received == 'true')
        {
            $this->item_received = 'true';
            $this->received_date = new Carbon();
        }
        elseif($received == 'false')
        {
            $this->item_received = 'false';
            $this->received_date = null;
        }

        return true;
    }



    public function addTicket($id)
    {
        $this->has_support_ticket = 'true';
        $this->support_ticket_id = $id;
        $this->save();

        return true;
    }


//**********************************************************************************************************************

    //SETS UP PAYPAL PAYMENT AND REDIRECTS TO APPROVAL PAGE
    public function createPaypalPayment($_api_context)
    {

        $transaction_id = $this->id;
        $price = $this->price;
        $currency = $this->currency;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName('A Random Item') // item name
            ->setCurrency($currency)
            ->setQuantity(1)
            ->setPrice($price); // unit price

        // add item to list
        $item_list = new ItemList();
        $item_list->setItems(array($item));

        $amount = new Amount();
        $amount->setCurrency($currency)
            ->setTotal($price);

        $paypalTransaction = new PaypalTransaction();
        $paypalTransaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('A random purchase from Randbay')
            ->setInvoiceNumber(uniqid('RANDBAY'));

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment.status'))
            ->setCancelUrl(URL::route('payment.status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($paypalTransaction));

        try
        {
            $payment->create($_api_context);
        }
        catch (PayPalConnectionException $ex)
        {
            Log::warning("Transaction Error" . print_r($ex->getMessage(), json_decode($ex->getData(), true)));

            return redirect('transactions')
                ->withErrors('An error occured in processing the Paypal payment');
        }

        $approval_url = $payment->getApprovalLink();

        // add payment ID to session
        Session::put('paypal_payment_id', $payment->getId());

        Session::put('transaction_id', $transaction_id);

        if(isset($approval_url))
        {
            return redirect()->away($approval_url);
        }

        return redirect('transactions')
            ->withErrors('Unknown error occurred');

    }

//**********************************************************************************************************************

    //ADDS A RATING TO THE SALEITEM
    public function addRating($rating)
    {
        $this->rating = $rating;

        return true;
    }


//**********************************************************************************************************************


    //EXECUTES PAYMENT WHEN DIRECTED BACK FROM PAYPAL APPROVAL PAGE
    //UPDATES SALEITEMS AND TRANSACTION OBJECTS
    public function executePaypalPayment($_api_context)
    {
        //GET INFO FROM THE SESSION
        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');

        //LOOKUP RELATED SALEITEM
        $target_saleitem = Saleitem::findOrFail($this->saleitem_id);
        if(!$target_saleitem)
        {
            return redirect('transactions')
                ->withErrors('Payment Cancelled: The random item has been removed by the seller');
        }

        //CHECK IF THE PAYMENT HAS BEEN GENERATED SUCCESSFULLY
        if (empty(Input::get('PayerID')) || empty(Input::get('token')))
        {
            //THE PAYMENT HAS FAILED - UNENGAGE SALEITEM
            $failed_saleitem = $target_saleitem;
            $failed_saleitem->markAsAvailable();

            //REDIRECT WITH ERRORS
            return redirect('transactions')
                ->withErrors(['error', 'Payment failed!']);
        }

        //CHECK IF THE SALEITEM HAS EXPIRED
        $engaged_time_limit = $target_saleitem->engaged_until;

        if($engaged_time_limit->isFuture())
        {
            //GENERATE PAYMENT FROM SESSION DATA
            $payment = Payment::get($payment_id, $_api_context);

            //EXECUTE THE PAYMENT
            $execution = new PaymentExecution();
            $execution->setPayerId(Input::get('PayerID'));
            $result = $payment->execute($execution, $_api_context);

            //CHECK THE PAYMENT HAS BEEN APPROVED
            if ($result->getState() == 'approved')
            {
                //STORE SUCCESS MESSAGE
                Session::flash('success', "Payment successful!");

                //STORE TAB TO PASS TO VIEW
                Session::flash('tab', "#bought-items");

                //SET SHIPPING ADDRESS
                $shipping_address = $result->getPayer()->getPayerInfo()->getShippingAddress()->toJSON();
                $this->shipping_address = $shipping_address;

                //RECORD PAYMENT DATA
                $this->payment_complete = 'true';
                $this->payment_date = Carbon::now();
                $this->payment_paypal_ref = $payment_id;
                $this->save();

                //SET SALEITEM AS MATCHED
                $sold_item = $target_saleitem;
                $sold_item->matched = 'true';
                $sold_item->save();

                //SET BUYORDER AS MATCHED
                $fulfilled_buyorder = Buyorder::findOrFail($this->buyorder_id);
                $fulfilled_buyorder->matched = 'true';
                $fulfilled_buyorder->save();

                //CREATE PAYOUT FOR SELLER
                $this->createSellerPayout($sold_item, $_api_context);

                //CREATE NOTIFICATIONS FOR SALE
                $notification_details =
                    [
                        'item_description' => $sold_item->description,
                        'item_img_path' => $sold_item->id . '.' . $sold_item->image_type,
                        'item_country_of_origin' => $sold_item->country_of_origin
                    ];

                $seller_notification = new Notification();
                $seller_notification->generate($this->seller->id, $this->id, 'sold-type');
                $seller_notification->setDetails($notification_details);

                $buyer_notification = new Notification();
                $buyer_notification->generate($this->buyer->id, $this->id, 'bought-type');
                $buyer_notification->setDetails($notification_details);


//                Mail::send('email.bought', $buyer_notification, function ($message) use ($buyer_notification)
//                {
//                    $message->from('no-reply@randbay.com', 'Randbay');
//                    $message->subject('A Random Item with Your Name on it!');
//
//                    //TODO - CHANGE THIS EMAIL WHEN DEPLOYED
//                    $message->to($buyer_notification->recipient->email);
//                });
//
//
//                Mail::send('email.sold', $seller_notification, function ($message) use ($seller_notification)
//                {
//                    $message->from('no-reply@randbay.com', 'Randbay');
//                    $message->subject('You got a sale! Taste that sweet victory...');
//
//                    //TODO - CHANGE THIS EMAIL WHEN DEPLOYED
//                    $message->to($seller_notification->recipient->email);
//                });

                //REDIRECT TO COMPLETE
                return redirect('transactions')->with(['buyer_alert' => $notification_details]);
            }


            //THE PAYMENT HAS FAILED - UNENGAGE SALEITEM
            $failed_saleitem = $target_saleitem;
            $failed_saleitem->markAsAvailable();

            //REDIRECT WITH ERRORS
            return redirect('transactions')
                ->withErrors('Payment failed!');
        }

        //PAYMENT HAS TIMEDOUT AND SALEITEM IS NO LONGER ENGAGED
        return redirect('transactions')
            ->withErrors('You have taken too long to complete the Paypal Payment');
    }


//**********************************************************************************************************************

    //SET UP PAYOUT FROM RANDBAY TO SELLER
    public function createSellerPayout($sold_item, $_api_context)
    {
        //GET SELLER ID
        $receiver_email = User::findOrFail($sold_item->user_id)->paypal_email;
        $payout = new Payout();

        $senderBatchHeader = new PayoutSenderBatchHeader();
        $senderBatchHeader->setSenderBatchId(uniqid('RANDPAY'))
            ->setEmailSubject("You have a Payout!");

        $randbay_rate = 0.9;
        $total_payout_amount_buyer = (($this->price - $this->postage_cost) * $randbay_rate) + $this->postage_cost;

        $currencies = new Currencies();

        $total_payout_amount_GDP = $currencies->convertToBaseGDP($this->currency, $total_payout_amount_buyer);
        $total_payout_amount_seller = $currencies->convertBackToNative($sold_item->native_currency, $total_payout_amount_GDP);

        $currency = new Currency();
        $currency->setCurrency($sold_item->native_currency)
                ->setValue(round($total_payout_amount_seller, 2));

        $senderItem = new PayoutItem();
        $senderItem->setRecipientType('Email')
            ->setNote('You have sold your item: '. $sold_item->description)
            ->setReceiver($receiver_email)
            ->setSenderItemId($sold_item->id)
            ->setAmount($currency);
        $payout->setSenderBatchHeader($senderBatchHeader)
            ->addItem($senderItem);

        $response = $payout->createSynchronous($_api_context);

        $response_item = $response->getItems();
        $payment_ref = $response_item[0]->transaction_id;
        $status = $response->getBatchHeader()->batch_status;

        if($status == "SUCCESS")
        {
            $this->remuneration_complete = 'true';
            $this->remuneration_paypal_ref = $payment_ref;
            $this->save();
            return true;
        }
        else
        {
            Log::warning("Payout failed" . print_r($response));
            return false;
        }

    }

//**********************************************************************************************************************

    //TODO - THE FOLLOWING FUNCTIONS ARE ADAPTIVE PAYMENT METHODS WHICH ARE NOT USED IN THIS APP
    public function chainedPayment($_paypal_adaptive_conf)
    {
//
//        $transaction_id = $this->id;
//        $price = $this->price;
//        $currency = $this->currency;
//
//        $payRequest = new PayRequest();
//
//        $receiver = array();
//        $receiver[0] = new Receiver();
//        $receiver[0]->amount = $price;
//        $receiver[0]->email = $_paypal_adaptive_conf['administrator_paypal_account'];
//        $receiver[0]->primary = "true";
//
//        $receiver[1] = new Receiver();
//        $receiver[1]->amount = $price * 0.9;
//        $receiver[1]->email = "earthen_shrine-buyer-1@mail.com"; //TODO MAKE THIS DYNAMIC FROM USER'S PAYPAL EMAIL
//
//        $receiverList = new ReceiverList($receiver);
//        $payRequest->receiverList = $receiverList;
//
//        $requestEnvelope = new RequestEnvelope("en_US");
//        $payRequest->requestEnvelope = $requestEnvelope;
//        $payRequest->actionType = "CREATE"; //
//        $payRequest->cancelUrl = URL::route('payment.status');
//        $payRequest->returnUrl = URL::route('payment.status');
//        $payRequest->currencyCode = $currency;
//        $payRequest->ipnNotificationUrl = "http://replaceIpnUrl.com";
//        $payRequest->feesPayer = 'EACHRECEIVER';
//
//        $sdkConfig = $_paypal_adaptive_conf['settings'];
//        $approval_url = $_paypal_adaptive_conf['approval_url'];
//
//        $adaptivePaymentsService = new AdaptivePaymentsService($sdkConfig);
//
//        $payResponse = $adaptivePaymentsService->Pay($payRequest);
//        $payKey = $payResponse->payKey;
//
//        $displayOptions = new DisplayOptions();
//        $displayOptions->businessName = 'Randbay';
//
//        $senderOptions = new SenderOptions();
//        $senderOptions->requireShippingAddressSelection = true;
//
//        $item = new InvoiceItem();
//        $item->name = 'A Random Item';
//        $item->identifier = '1';
//        $item->itemCount = 1;
//        $item->itemPrice = $price * 0.9;
//        $item->price = $price * 0.9;
//
//        $invoiceData = new InvoiceData();
//        $invoiceData->item = $item;
//
//        $receiverOptions = new ReceiverOptions();
//        $receiverOptions->invoiceData = $invoiceData;
//        $receiverOptions->receiver = $receiver[1];
//
//        $paymentOptions = new SetPaymentOptionsRequest();
//        $paymentOptions->senderOptions = $senderOptions;
//        $paymentOptions->receiverOptions = $receiverOptions;
//        $paymentOptions->displayOptions = $displayOptions;
//        $paymentOptions->requestEnvelope = $requestEnvelope;
//        $paymentOptions->payKey = $payKey;
//
//        $adaptivePaymentsService->SetPaymentOptions($paymentOptions);
//
//        Session::put('payKey', $payKey);
//        Session::put('transaction_id', $transaction_id);
//
////      $approval_url = 'https://www.sandbox.paypal.com/webapps/adaptivepayment/flow/pay?paykey=';
//
//        return redirect()->away($approval_url . $payKey);

    }


//**********************************************************************************************************************

    //TODO - THE FOLLOWING FUNCTIONS ARE ADAPTIVE PAYMENT METHODS WHICH ARE NOT USED IN THIS APP
    public function checkChainedPaypalPayment($_paypal_adaptive_conf)
    {
//        $payKey= Session::get('payKey');
//        Session::forget('payKey');
//
//        $requestEnvelope = new RequestEnvelope("en_US");
//
//        $request = new PaymentDetailsRequest();
//
//        $request->payKey = $payKey;
//        $request->requestEnvelope = $requestEnvelope;
//
//        $sdkConfig = $_paypal_adaptive_conf['settings'];
//
//        $adaptivePaymentsService = new AdaptivePaymentsService($sdkConfig);
//        $response = $adaptivePaymentsService->PaymentDetails($request);
//
//        $payment_id = $response->paymentInfoList->paymentInfo[1]->transactionId;
//
//        if ($response->status == 'COMPLETED')
//        {
//            Session::flash('success', "Payment successful!");
//
//            $this->payment_complete = 'true';
//            $this->payment_paypal_ref = $payment_id;
//            $this->save();
//
//            $sold_item = Saleitem::findOrFail($this->saleitem_id);
//            $sold_item->matched = 'true';
//            $sold_item->save();
//
//            $fulfilled_buyorder = Buyorder::findOrFail($this->buyorder_id);
//            $fulfilled_buyorder->matched = 'true';
//            $fulfilled_buyorder->save();
//
//            return redirect('transactions')->with(['sold_item' => $sold_item]);
//        }
//        else
//        {
//        return redirect('transactions')
//            ->withErrors('Payment failed!');
//        }

    }

}
