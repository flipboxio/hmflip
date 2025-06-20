<?php

/**
 * Amenities Model
 *
 * Amenities Model manages Amenities operation.
 *
 * @category   Language
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
use App\Models\AmenityType;
use DB;

class Amenities extends Model
{
    protected $table    = 'amenities';
    public $timestamps  = false;

    public function amenityType()
    {
        return $this->belongsTo(AmenityType::class, 'type_id', 'id');
    }

    public static function normal($property_id) {

        $type_id = AmenityType::orderBy('id','asc')->value('id');
        $result = DB::select("select amenities.title as title, amenities.id as id, amenities.symbol, properties.id as status from amenities left join properties on find_in_set(amenities.id, properties.amenities) and properties.id = $property_id where type_id =  $type_id");

        return $result;
    }

    public static function security($property_id){

        $type_id = AmenityType::orderBy('id','asc')->skip(1)->value('id');
        if ($type_id == null) return [];

        $result = DB::select("select amenities.title as title, amenities.id as id, amenities.symbol, properties.id as status from amenities left join properties on find_in_set(amenities.id, properties.amenities) and properties.id = $property_id where type_id = $type_id");

        return $result;
    }

    public static function newAmenitiesType() {

        $two_ids = AmenityType::select('id')->orderby('id','asc')->limit(2)->get();
        $result = AmenityType::whereNotIn('id', $two_ids)->get(['id', 'name']);
        return $result;
    }

    public static function newAmenities($property_id, $type_id) {

        $result = DB::select("select amenities.title as title, amenities.id as id, amenities.symbol, properties.id as status from amenities left join properties on find_in_set(amenities.id, properties.amenities) and properties.id = $property_id where type_id = $type_id");

        return $result;
    }
}
