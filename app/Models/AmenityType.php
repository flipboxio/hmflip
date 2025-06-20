<?php

/**
 * AmenityType Model
 *
 * AmenityType Model manages AmenityType operation.
 *
 * @category   AmenityType
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

class AmenityType extends Model
{
    protected $table    = 'amenity_type';
    public $timestamps  = false;

    public function amenities()
    {
        return $this->hasMany('App\Models\Amenities', 'type_id', 'id');
    }
}
