<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'users';


    protected $fillable =
        [
            'name',
            'email',
            'password',
            'country',
            'paypal_email'
        ];

    protected $hidden =
        [
            'email',
            'password',
            'remember_token',
            'paypal_email'
        ];


//**********************************************************************************************************************

    //RELATIONSHIPS

    public function saleitems()
    {
        return $this->hasMany('App\Saleitem', 'user_id');
    }

    public function buyorders()
    {
        return $this->hasMany('App\Buyorder', 'user_id');
    }

    public function sale_transactions()
    {
        return $this->hasMany('App\Transaction', 'seller_id');
    }

    public function buy_transactions()
    {
        return $this->hasMany('App\Transaction', 'buyer_id');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification', 'recipient_id');
    }


//**********************************************************************************************************************

    //RETURNS THE COUNTRY OF THE SALEITEM
    public function getCountry()
    {
        $country = $this->country;

        return $country;
    }

//**********************************************************************************************************************

    //UPDATES THE SELLER RATING
    public function updateSellerRating()
    {
        $initial_rating = 3;

        $saleitems = $this->saleitems;

            $index = 0;
            $ratings = [];
            foreach ($saleitems as $saleitem)
            {
                $ratings[$index] = $saleitem->rating;
                $index++;
            }

        $userRating = (array_sum($ratings) + $initial_rating) / (count($ratings) + 1);
        $this->seller_rating = $userRating;
        $this->save();

        return $userRating;
    }

//**********************************************************************************************************************


    public function cascadeSellerRating($new_seller_rating)
    {
        $saleitems = $this->saleitems;

        foreach ($saleitems as $saleitem)
        {
            $saleitem->seller_rating = $new_seller_rating;
            $saleitem->save();
        }

        return true;
    }

}
