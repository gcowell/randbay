<?php

namespace App\Http\Controllers;

use App\Currencies;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TempCurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRate()
    {
        $currency = new Currencies();
        $currency->getLatestCurrencyRates();
    }


}
