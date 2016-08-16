<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $dates = ['created_at', 'updated_at', 'read_at'];

//**********************************************************************************************************************

    //RELATIONSHIPS

    public function recipient()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    public function getAssociatedTransaction()
    {
        return $this->hasOne('App\Transaction', 'saleitem_id', 'id')->first();
    }


    public function markAsRead()
    {
        $this->unread = 'false';
        $this->save();
    }


    public function generate($recipient_id, $transaction_id, $type)
    {
        $this->recipient_id = $recipient_id;
        $this->transaction_id = $transaction_id;
        $this->type = 'notifications.'. $type;
        $this->unread = 'true';
        $this->save();
    }


    public function setDetails($details)
    {
        $this->item_description = array_key_exists ( 'item_description', $details ) ? $details['item_description'] : null;
        $this->item_img_path =  array_key_exists ( 'item_img_path', $details )  ? $details['item_img_path'] : null;
        $this->item_rating =  array_key_exists ( 'item_rating', $details )  ? $details['item_rating'] : null;
        $this->item_country_of_origin =  array_key_exists ( 'item_country_of_origin', $details )  ? $details['item_country_of_origin'] : null;
        $this->item_support_ticket_id =  array_key_exists ( 'item_support_ticket_id', $details )  ? $details['item_support_ticket_id'] : null;


        $this->save();

        return true;
    }

}
