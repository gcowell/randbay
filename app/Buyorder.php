<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buyorder extends Model
{
    protected $fillable =
        [
            'price',
            'currency',
        ];

    protected $dates = ['created_at', 'updated_at'];


    public function buyer()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
