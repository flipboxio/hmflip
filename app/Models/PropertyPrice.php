<?php

/**
 * PropertyPrice Model
 *
 * PropertyPrice Model manages PropertyPrice operation.
 *
 * @category   PropertyPrice
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

use App\Models\PropertyDates;
use Illuminate\Database\Eloquent\Model;
use Session;

class PropertyPrice extends Model
{
    protected $table   = 'property_price';
    public $timestamps = false;
    private $dateResult ;

    protected $appends = [ 'original_cleaning_fee', 'original_guest_fee', 'original_price', 'original_weekend_price', 'original_security_fee', 'default_code', 'default_symbol'];

    public function properties()
    {
        return $this->belongsTo('App\Models\Properties', 'property_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_code', 'code');
    }

    public function getOriginalCleaningFeeAttribute()
    {
        return $this->attributes['cleaning_fee'];
    }

    public function getOriginalGuestFeeAttribute()
    {
        return $this->attributes['guest_fee'];
    }

    public function getOriginalSecurityFeeAttribute()
    {
        return $this->attributes['security_fee'];
    }

    public function getOriginalPriceAttribute()
    {
        return $this->attributes['price'];
    }

    public function getOriginalWeekendPriceAttribute()
    {
        return $this->attributes['weekend_price'];
    }

    public function getWeeklyPriceAttribute()
    {
        return 0;
    }

    public function getMonthlyPriceAttribute()
    {
        return 0;
    }

    public function getPriceAttribute()
    {
        return $this->currency_convert('price');
    }

    public function getCleaningFeeAttribute()
    {
        return $this->currency_convert('cleaning_fee');
    }

    public function getGuestFeeAttribute()
    {
        return $this->currency_convert('guest_fee');
    }

    public function getSecurityFeeAttribute()
    {
        return $this->currency_convert('security_fee');
    }

    public function getWeekendPriceAttribute()
    {
        return $this->currency_convert('weekend_price');
    }
    public function getPropertydates($date)
    
    {
        $this->dateResult = PropertyDates::where('property_id',$this->attributes['property_id'])->where('date',$date)->first();
        
    }

    public function price()
    {
        
        if ($this->dateResult->count()) {
            return $this->dateResult->price;
        } else {
            return $this->currency_convert('price');
        }
    }

    //Original Property Price
    public function original_price()
    {
        try {
            return $this->dateResult->price;
        } catch (\Exception $e) {
            return $this->attributes['price'];
        }
    }


    public function available()
    {
        try {
            return $this->dateResult->status;
        } catch (\Exception $e) {
            return 'Available';
        }
    }

    public function currency_convert($field)
    {
        $rate = Currency::getAll()->firstWhere('code',$this->attributes['currency_code'])->rate;
        if ($rate == 0) {
            return 0;
        }

        $unit = $this->attributes[$field] / $rate;

        $default_currency = Currency::getAll()->firstWhere('default', 1)->code;

        $session_rate = Currency::getAll()->firstWhere('code',(\Session::get('currency')) ? \Session::get('currency') : $default_currency)->rate;

        return round($unit * $session_rate,2);
    }

    public function getDefaultCodeAttribute()
    {
        if (Session::get('currency')) {
            return Session::get('currency');
        } else {
            return Currency::getAll()->firstWhere('default', 1)->code;
        }
    }

    public function getDefaultSymbolAttribute()
    {
        if (Session::get('currency')) {
            return Currency::getAll()->firstWhere('code', Session::get('currency'))->symbol;;
        } else {
            return Currency::getAll()->firstWhere('default', 1)->symbol;
        }
    }

    public function color()
    {
        if ($this->dateResult->count()) {
            return $this->dateResult->color;
        } else {
            return false;
        }
    }

    public function type()
    {
        if ($this->dateResult->count()) {
            return $this->dateResult->type;
        } else {
            return false;
        }
    }

    public function min_day()
    {
        if (!empty($this->dateResult)) {
            return $this->dateResult->min_day;
        } else {
            $min_day = 0;
            return $min_day;
        }

    }
}
