<?php

/**
 * PropertyAddress Model
 *
 * PropertyAddress Model manages PropertyAddress operation.
 *
 * @category   PropertyAddress
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
use App\Models\Country;

class PropertyAddress extends Model
{
    protected $table   = 'property_address';
    public $timestamps = false;

    public function properties()
    {
        return $this->belongsTo('App\Models\Properties', 'property_id', 'id');
    }

    public function countries()
    {
        return $this->belongsTo('App\Models\Country', 'country', 'short_name');
    }

    public function getCountryNameAttribute()
    {
        $result = Country::where('short_name', $this->attributes['id'])->first();
        $name = '';
        if (isset($result->name)) {
            $name = $result->name;
        }
        return $name;
    }
}
