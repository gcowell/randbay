<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Buyorder extends Model
{
    protected $fillable =
        [
            'price',
            'requested_currency',
            'country',
            'buyer_email'
        ];



    protected $dates = ['created_at', 'updated_at'];



//**********************************************************************************************************************


}
