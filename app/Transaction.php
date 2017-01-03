<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Saleitem;
use App\Buyorder;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendMail;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Currencies;

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
use PayPal\Api\Links;
use App\Notification;


class Transaction extends Model
{
    use DispatchesJobs;

    protected $fillable =
        [
            'price',
            'currency',
            'buyorder_id',
            'saleitem_id',
            'buyer_email',
            'seller_email',
            'postage_cost'
        ];

    protected $dates = ['created_at', 'updated_at', 'payment_date'];


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
            Log::warning("Transaction Error" . ($ex->getMessage()) . json_decode($ex->getData(), true));

            return redirect('/')
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

        return redirect('/')
            ->withErrors('Unknown payment error occurred');

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
            return redirect('/')
                ->withErrors('Payment Cancelled: The random item has been removed by the seller');
        }

        //CHECK IF THE PAYMENT HAS BEEN GENERATED SUCCESSFULLY
        if (empty(Input::get('PayerID')) || empty(Input::get('token')))
        {
            //THE PAYMENT HAS FAILED - UNENGAGE SALEITEM
            $failed_saleitem = $target_saleitem;
            $failed_saleitem->markAsAvailable();

            //REDIRECT WITH ERRORS
            return redirect('/')
                ->withErrors( 'Payment failed!');
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

            try
            {
                $result = $payment->execute($execution, $_api_context);
            }
            catch (PayPalConnectionException $ex)
            {
                Log::warning("Transaction Error" . ($ex->getMessage()) . json_decode($ex->getData(), true));

                return redirect('/')
                    ->withErrors('An error occured in processing the Paypal payment');
            }



            //CHECK THE PAYMENT HAS BEEN APPROVED
            if ($result->getState() == 'approved')
            {
                //FIND OUT WHAT THE FEE WAS
                $paypal_fee = $result->getTransactions()[0]->getRelatedResources()[0]->getSale()->getTransactionFee()->getValue();
                $this->paypal_fee = floatval($paypal_fee);

                //SET SHIPPING ADDRESS
                $shipping_address_object = $result->getPayer()->getPayerInfo()->getShippingAddress();

                $shipping_address = $shipping_address_object->toJSON();
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


                //CONVERT FEE AND POSTAGE FOR SELLER
                $currencies = new Currencies();
                $GDP_fee = $currencies->convertToBaseGDP($this->currency, $this->paypal_fee);
                $converted_fee = $currencies->convertBackToNative($sold_item->native_currency, $GDP_fee);
                $GDP_postage = $currencies->convertToBaseGDP($this->currency,$this->postage_cost);
                $converted_postage = $currencies->convertBackToNative($sold_item->native_currency, $GDP_postage);

               //CREATE PAYOUT FOR SELLER
                $this->createSellerPayout($sold_item, $converted_fee, $_api_context);

                //SEND CONFIRMATION EMAIL TO BUYER
                $emailAddress = $fulfilled_buyorder->buyer_email;
                $data =
                    [
                        'id'                => $sold_item->id,
                        'description'       => $sold_item->description,
                        'image_type'        => $sold_item->image_type,
                        'native_currency'   => $currencies->getSymbol($this->currency),
                        'price'             => $this->price,
                        'image_path'        => Config::get('saleitems.filepath')
                    ];

                $job = (new SendMail($emailAddress, 'bought', $data));
                $this->dispatch($job);



                //SEND CONFIRMATION EMAIL TO SELLER
                $emailAddress = $sold_item->seller_paypal_email;

                //PREPARE ADDRESS FOR HUMANS
                $iso_list = Config::get('countries.iso_list');

                $emailable_shipping_address = $shipping_address_object->toArray();
                $emailable_shipping_address['country_code'] = $iso_list[$emailable_shipping_address['country_code']];

                $data =
                    [
                        'id'                => $sold_item->id,
                        'description'       => $sold_item->description,
                        'image_type'        => $sold_item->image_type,
                        'native_currency'   => $currencies->getSymbol($sold_item->native_currency),
                        'price'             => $sold_item->price,
                        'image_path'        => Config::get('saleitems.filepath'),
                        'shipping_address'  => $emailable_shipping_address,
                        'randbay_fee'       => number_format($sold_item->price * (1-Config::get('saleitems.rate')), 2, '.', ''),
                        'paypal_fee'        => number_format($converted_fee, 2, '.', ''),
                        'postage_cost'      => number_format($converted_postage, 2, '.', '')

                    ];

                $job = (new SendMail($emailAddress, 'sold', $data));
                $this->dispatch($job);

                //FLASH ALERT
                Session::flash('item_bought', $sold_item);

                //REDIRECT TO COMPLETE
                return redirect('/');
            }

            //THE PAYMENT HAS FAILED - UNENGAGE SALEITEM
            $failed_saleitem = $target_saleitem;
            $failed_saleitem->markAsAvailable();

            //REDIRECT WITH ERRORS
            return redirect('/')
                ->withErrors('Payment failed!');
        }

        //PAYMENT HAS TIMEDOUT AND SALEITEM IS NO LONGER ENGAGED
        return redirect('/')
            ->withErrors('You have taken too long to complete the Paypal Payment');
    }


//**********************************************************************************************************************

    //SET UP PAYOUT FROM RANDBAY TO SELLER
    public function createSellerPayout($sold_item, $fee, $_api_context)
    {
        //GET SELLER ID
        $receiver_email = $sold_item->seller_paypal_email;
        $payout = new Payout();

        $senderBatchHeader = new PayoutSenderBatchHeader();
        $senderBatchHeader->setSenderBatchId(uniqid('RANDPAY'))
            ->setEmailSubject("You sold your item on Randbay!");


        //TODO set customer service url (hello world currently)

        $randbay_rate = Config::get('saleitems.rate');
        $total_payout_amount_buyer = (($this->price - $this->postage_cost) * $randbay_rate) + $this->postage_cost;

        $currencies = new Currencies();

        //CONVERSION IS REQUIRED HERE AS THE PRICE MUST COME FROM THE TRANSACTION IN ORDER TO UNDERSTAND POSTAGE COST OPTION
        $total_payout_amount_GDP = $currencies->convertToBaseGDP($this->currency, $total_payout_amount_buyer);
        $total_payout_amount_seller = $currencies->convertBackToNative($sold_item->native_currency, $total_payout_amount_GDP);

        //NOTE THAT THE FEE HAS ALREADY BEEN CONVERTED
        $final_payout_amount = $total_payout_amount_seller - $fee;


        $currency = new Currency();
        $currency->setCurrency($sold_item->native_currency)
                ->setValue(round($final_payout_amount, 2));

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
            Log::warning("Payout failed" . ($response));
            return false;
        }

    }

}
