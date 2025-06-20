<?php

/**
 * PaymentMethods Model
 *
 * PaymentMethods Model manages PaymentMethods operation.
 *
 * @category   PaymentMethods
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

use Illuminate\Database\Eloquent\Model;

class PaymentMethods extends Model
{
    protected $table   = 'payment_methods';
    public $timestamps = false;

    public function accounts()
    {
        return $this->hasMany('App\Models\Account', 'payment_method_id', 'id');
    }

    public function payout_settings()
    {
        return $this->belongsTo('App\Models\PayoutSetting', 'type', 'id');
    }

    public function withdrawals()
    {
        return $this->belongsTo('App\Models\Withdraw', 'payment_method_id', 'id');
    }

    public function bookings()
    {
        return $this->hasMany('App\Models\Bookings', 'payment_method_id', 'id');
    }
}
