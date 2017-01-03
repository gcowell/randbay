<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

use App\Buyorder;
use App\Currencies;
use App\Jobs\SendMail;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Saleitem extends Model
{
    use DispatchesJobs;

    protected $fillable =
        [
            'price',
            'native_currency',
            'international',
            'domestic_postage_cost',
            'world_postage_cost',
            'description',
            'country',
            'seller_paypal_email'
       ];

    protected $dates = ['created_at', 'updated_at', 'engaged_until'];

//**********************************************************************************************************************

    //RELATIONSHIPS

    public function seller()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    public function getAssociatedTransaction()
    {

        return $this->hasOne('App\Transaction', 'saleitem_id', 'id')->first();
    }


//**********************************************************************************************************************

    //FINDS A SALEITEM FOR GIVEN ORDER
    public function matchOrderToSaleitem(Buyorder $buyorder)
    {

        //SEARCH PARAMETERS
        $target_price = $buyorder->price;
        $target_country = $buyorder->country;
        $current_time = Carbon::now();
        $request_user_email = $buyorder->buyer_email;

        //QUERY STRINGS
        $international_query = '*, ((saleitems.price+saleitems.world_postage_cost)*saleitems.currency_rate) AS total_cost, (((saleitems.price+saleitems.world_postage_cost)*saleitems.currency_rate)/(?)) AS weighted_score';
        $domestic_query = '*, ((saleitems.price+saleitems.domestic_postage_cost)*saleitems.currency_rate) AS total_cost, (((saleitems.price+saleitems.domestic_postage_cost)*saleitems.currency_rate)/(?)) AS weighted_score';

        //INTERNATIONAL QUERY
        $international_saleitems = DB::Table('saleitems')
            ->selectRaw($international_query, array($target_price))
            ->where('engaged_until', '<', $current_time)
            ->where('seller_paypal_email', '!=', $request_user_email)
            ->where('international', '=', "true")
            ->where('matched', '=', 'false')
            ->where('country', '!=', $target_country)
            ->having("total_cost", "<", $target_price)
            ->orderBy("weighted_score", 'DESC')
            ->take(3)
            ->get();

        //DOMESTIC QUERY
        $domestic_saleitems = DB::Table('saleitems')
            ->selectRaw($domestic_query, array($target_price))
            ->where('engaged_until', '<', $current_time)
            ->where('seller_paypal_email', '!=', $request_user_email)
            ->where('matched', '=', 'false')
            ->where('country', '=', $target_country)
            ->having("total_cost", "<", $target_price)
            ->orderBy("weighted_score", 'DESC')
            ->take(3)
            ->get();

        //MERGE AND SORT PRE-SELECTION
        $results = array_merge($domestic_saleitems, $international_saleitems);

        //CHECK IF THERE ARE ANY RESULTS
        if($results == null)
        {
            $result = null;

            return $result;

        }

        //DETERMINE RANDOM ITEM FROM SELECTION
        usort($results, 'self::compareElms');
        $length = count($results);
        $random_index = rand(0, $length-1);
        $result = $results[$random_index];

        //CONVERT RESULT TO USER'S CURRENCY
        $currencies = new Currencies();
        $requested_currency = $buyorder->requested_currency;

        $postage_cost = $result->total_cost - $result->price;
        $converted_postage = $currencies->convertBackToNative($requested_currency, $postage_cost);

        $converted_cost = $currencies->convertBackToNative($requested_currency, $result->total_cost);

        $result->total_cost = $converted_cost;
        $result->postage_cost = $converted_postage;

        return $result;

    }


//**********************************************************************************************************************

    //FOR SORTING ELEMENTS
    public function compareElms($a, $b)
    {
        if ($a->weighted_score == $b->weighted_score)
        {
            return 0;
        }
        return ($a->weighted_score > $b->weighted_score) ? -1 : 1;
    }

//**********************************************************************************************************************

    //FOR SETTING ENGAGED TIME
    public function markAsEngaged()
    {
       $this->engaged_until = Carbon::now()->addMinutes(5);
       $this->save();

       return true;
    }

//**********************************************************************************************************************

    //FOR RESETTING ENGAGED TIME
    public function markAsAvailable()
    {
        $this->engaged_until = Carbon::now()->subMinutes(1);
        $this->save();

        return true;
    }

//**********************************************************************************************************************

    //UPDATE DAILY RATES IN DB FOR EACH SALEITEM
    public function cascadeLatestRates()
    {

        $current_time = Carbon::now();
        $currencies = new Currencies();
        $saleitems = $this->where('matched', '=', 'false')
            ->where('engaged_until', '<', $current_time)
            ->get();

        foreach($saleitems as $saleitem)
        {
            $saleitem->currency_rate = $currencies->getApplicableRate($saleitem->native_currency);
            $saleitem->save();
        }

        return true;
    }

//**********************************************************************************************************************

//FIND RANDOM SALE ITEMS TO POPULATE HOMEPAGE
    public function getRandomItems()
    {
        $current_time = Carbon::now();

        $random_saleitems = DB::Table('saleitems')
            ->select('id', 'description', 'image_type')
            ->where('engaged_until', '<', $current_time)
            ->where('matched', '=', 'false')
            ->orderBy(DB::raw('RAND()'))
            ->take(10)
            ->get();


        return $random_saleitems;

    }

//**********************************************************************************************************************

//FOR ADMIN CHECKING OF SALEITEMS

    public function getUnchecked()
    {
        $unchecked_saleitems = DB::Table('saleitems')
            ->select('*')
            ->where('matched', '=', 'false')
            ->whereNull('checked')
            ->orderBy("created_at", 'DESC')
            ->take(20)
            ->get();

        return $unchecked_saleitems;
    }


//**********************************************************************************************************************
//FOR ADMIN CHECKING OF SALEITEMS

    public function setCheckedTrue()
    {
        $this->checked = 'true';

        return true;
    }


//**********************************************************************************************************************
//FOR ADMIN CHECKING OF SALEITEMS

    public function removeExpiredSaleitems()
    {

        $current_time = Carbon::now();
        $expiry_date = $current_time->subDays(10);

        $expired_saleitems = DB::Table('saleitems')
            ->select('*')
            ->where('matched', '=', 'false')
            ->where('created_at', '<', $expiry_date);

        $saleitems_to_email = $expired_saleitems->get();

        foreach ($saleitems_to_email as $expired_saleitem)
        {

            //SEND EMAIL TO WARN SELLER
            $emailAddress = $expired_saleitem->seller_paypal_email;
            $data =
                [
                    'id'                => $expired_saleitem->id,
                    'description'       => $expired_saleitem->description,
                    'image_type'        => $expired_saleitem->image_type,
                    'image_path'        => Config::get('saleitems.filepath'),

                ];

            $job = (new SendMail($emailAddress, 'expired', $data));
            $this->dispatch($job);
        }

        $expired_saleitems->delete();

        return true;


    }


}

//**********************************************************************************************************************
