<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Jobs\SendMail;
use Illuminate\Support\Facades\Config;

class TempMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMail()
    {


//
        $hardCodedEmail = 'gcowell@assystemuk.com';

        $emailAddress = $hardCodedEmail;
        $shipping_address_array =
            [
                "recipient_name" => "Brad Eichelberger",
                "line1" => "1 Main St",
                "city" => "San Jose",
                "state" => "CA",
                "postal_code" => "95131",
                "country_code" => "US"
            ];
        $data =
            [
                'id'                => 3,
                'description'       => 'tits and balls',
                'image_type'        => 'jpg',
                'native_currency'   => 'GBP',
                'price'             => 500,
                'image_path'        => Config::get('saleitems.filepath'),
                'shipping_address'  => $shipping_address_array,
                'randbay_fee'       => 2.00,
                'paypal_fee'        => 2.00,
                'postage_cost'      => 2.00

            ];



        $job = (new SendMail($emailAddress, 'sold', $data));
        $this->dispatch($job);

        return 'Email pushed onto queue';


    }


}
