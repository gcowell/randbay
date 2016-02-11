<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Buyorder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Saleitem extends Model
{
    protected $fillable =
        [
            'price',
            'currency',
            'international',
            'domestic_postage_cost',
            'world_postage_cost',
            'description'

        ];

    protected $dates = ['created_at', 'updated_at'];

    public function seller()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    public function matchOrderToSaleitem(Buyorder $buyorder)
    {
        $target_price = $buyorder->price;
        $target_country = $buyorder->country;
        $request_user_id = Auth::id();

        //International items (
        $international_saleitem = DB::Table('saleitems')
            ->select(DB::raw('*, (saleitems.price+saleitems.world_postage_cost) AS total_cost'))
            ->where('user_id', '!=', $request_user_id)
            ->where('international', '=', "true")
            ->where('country_of_origin', '!=', $target_country)
            ->having("total_cost", "<", $target_price)
            ->orderBy("total_cost", 'DESC')
            ->first();

        //Domestic items
        $domestic_saleitem = DB::Table('saleitems')
            ->select(DB::raw('*, (saleitems.price+saleitems.domestic_postage_cost) AS total_cost'))
            ->where('user_id', '!=', $request_user_id)
            ->where('country_of_origin', '=', $target_country) //CHAANGE
            ->having("total_cost", "<", $target_price)
            ->orderBy("total_cost", 'DESC')
            ->first();


        if(!$domestic_saleitem)
        {
            if(!$international_saleitem)
            {
                $result = null;
            }
            else
            {
                $result = $international_saleitem;
            }
        }
        else
        {
            if(!$international_saleitem)
            {
                $result = $domestic_saleitem;
            }
            else
            {
                if(($domestic_saleitem->total_cost) > ($international_saleitem->total_cost))
                {
                    $result = $domestic_saleitem;
                }
                else
                {
                    $result = $international_saleitem;
                }
            }
        }

        return $result;

    }

}
