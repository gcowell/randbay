<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class Currencies extends Model
{
    protected $fillable =
        [
            'EUR_to_GBP',
            'USD_to_GBP',
        ];

    protected $dates = ['created_at', 'updated_at'];

//**********************************************************************************************************************

    //REQUEST LATEST DAILY RATES FROM ECB
    public function getLatestCurrencyRates()
    {

        $XMLContent = file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
        //the file is updated daily between 2.15 p.m. and 3.00 p.m. CET

        foreach($XMLContent as $line){
            if(preg_match("/currency='([[:alpha:]]+)'/",$line,$currencyCode)){
                if(preg_match("/rate='([[:graph:]]+)'/",$line,$rate)){
                    //Output the value of 1EUR for a currency code

                    if($currencyCode[1] == "GBP")
                    {

                        $GBP_to_EUR = 1 / $rate[1];
                    }

                    if($currencyCode[1] == "USD")
                    {
                        $EUR_to_USD = $rate[1];
                    }

                }
            }
        }


        $GBP_to_USD = $GBP_to_EUR * $EUR_to_USD;

        $this->USD_to_GBP = (1 / $GBP_to_USD);
        $this->EUR_to_GBP = (1 / $GBP_to_EUR);
        $this->save();

        return true;

    }




//**********************************************************************************************************************

    //CONVERT CURRENCY TO GBP FOR DATABASE INTERACTION

    public function convertToBaseGDP($requested_currency, $value)
    {
        $rate = $this->getApplicableRate($requested_currency);
        $converted_value = $rate * $value;

        return $converted_value;
    }



//**********************************************************************************************************************

    //CONVERT CURRENCY FROM GBP FOR USER INTERACTION

    public function convertBackToNative($native_currency, $value)
    {

        $rate = $this->getApplicableRate($native_currency);
        $back_rate = 1/ $rate;
        $converted_value = $back_rate * $value;

        return $converted_value;
    }


//**********************************************************************************************************************

    //RETURN LATEST RATE SAVED IN THE DB
    public function getApplicableRate($currency)
    {
        $latest_rates = DB::Table('currencies')->orderBy('id', 'desc')->first();

        switch ($currency)
        {
            case "GBP":
                $rate = 1;
                break;
            case "EUR":
                $rate = ($latest_rates->EUR_to_GBP);
                break;
            case "USD":
                $rate = ($latest_rates->USD_to_GBP);
                break;
        }

        return $rate;
    }

//**********************************************************************************************************************

    //RETURN CURRENCY SYMBOLS
    public function getSymbol($currency)
    {
        $symbol_lookup = Config::get('currencies.symbols');

        $symbol = $symbol_lookup[$currency];

        return $symbol;
    }

}
