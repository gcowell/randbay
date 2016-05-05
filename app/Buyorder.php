<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Buyorder extends Model
{
    protected $fillable =
        [
            'price',
            'requested_currency',
        ];

    protected $dates = ['created_at', 'updated_at'];


    public function buyer()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    public function clearUnusedOrders()
    {
        $current_time = Carbon::now();
        $one_week_ago = $current_time->subWeek();

        DB::Table('buyorders')->where('matched', '=', 'false')
                              ->where('updated_at', '<', $one_week_ago)
                              ->delete();

        return true;
    }

}
