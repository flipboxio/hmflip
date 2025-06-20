<?php

/**
 * Reviews Model
 *
 * Reviews Model manages Reviews operation.
 *
 * @category   Reviews
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    2.7
 * @link       http://techvill.net
 * @since      Version 1.3
 * @deprecated None
 */

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Reviews extends Model
{
    use SoftDeletes;

    protected $table = 'reviews';

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'sender_id', 'id');
    }


    public function users_from()
    {
        return $this->belongsTo('App\Models\User', 'receiver_id', 'id');
    }

    public function properties()
    {
        return $this->belongsTo('App\Models\Properties', 'property_id', 'id')->withTrashed();

    }

    public function bookings()
    {
        return $this->belongsTo('App\Models\Bookings', 'booking_id', 'id');
    }

    public function getDateFyAttribute()
    {
        return date('F Y', strtotime($this->attributes['updated_at']));
    }


    public function getHiddenReviewAttribute()
    {
        $booking_id = $this->attributes['booking_id'];
        $sender_id = $this->attributes['sender_id'];
        $receiver_id = $this->attributes['receiver_id'];
        $check = Reviews::where(['sender_id'=>$receiver_id, 'receiver_id'=>$sender_id, 'booking_id'=>$booking_id])->get();
        if ($check->count()) {
            return false;
        } else {
            return true;
        }
    }
}
