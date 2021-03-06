<?php

namespace App\Http\Controllers;

use App\Saleitem;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BuyorderRequest;
use App\Http\Controllers\Controller;
use App\Buyorder;
use App\Currencies;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Jobs\AddMailingAddress;

class BuyordersController extends Controller
{


//**********************************************************************************************************************

    //NO NEED FOR THIS METHOD, SO JUST REDIRECT TO CREATE
    public function index()
    {
        $errors = Session::get('errors');

        return redirect('buyorders/create')->with(['errors' => $errors ]);

    }

//**********************************************************************************************************************

    //DIRECTS TO BUYORDER CREATION FORM
    public function create()
    {
        return view('buyorders.create');

    }

//**********************************************************************************************************************

    //POSTS BUYORDER TO DB AND FINDS MATCHING SALEITEM
    public function find(BuyorderRequest $request)
    {
        //ALL PRICES IN DB ARE IN GBP!
        $currencies = new Currencies();
        $requested_currency = $request->requested_currency;

        $buyorder = new Buyorder();
        $buyorder->requested_currency = $requested_currency;
        $buyorder->price = $currencies->convertToBaseGDP($requested_currency, $request->price);
        $buyorder->country = $request->country;
        $buyorder->buyer_email = $request->buyer_email;

        $buyorder->matched = 'false';

        $saleitem = new Saleitem();
        $result = $saleitem->matchOrderToSaleitem($buyorder);

        if($result)
        {
            $buyorder->save();
        }

        $job = (new AddMailingAddress($request->buyer_email));
        $this->dispatch($job);

        return view('buyorders.match')->with(['saleitem' => $result, 'buyorder' => $buyorder ]);

    }

    public function redo(Request $request, $id)
    {
        if(!$request->ajax())
        {
            return redirect('buyorders/create');
        }

        $buyorder = Buyorder::findOrFail($id);
        $saleitem = new Saleitem();
        $result = $saleitem->matchOrderToSaleitem($buyorder);

        $JSON_result = json_encode($result);

        return $JSON_result;

    }

//**********************************************************************************************************************



}
