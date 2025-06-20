<?php

/**
 * PropertyType Model
 *
 * PropertyType Model manages PropertyType operation.
 *
 * @category   PropertyType
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
use Cache;

class PropertyType extends Model
{
    protected $table   = 'property_type';
    public $timestamps = false;

    public function properties()
    {
        return $this->hasMany('App\Models\Properties', 'property_type', 'id');
    }

    public static function getAll()
    {
        $data = Cache::get(config('cache.prefix') . '.property.types.property');
        if (empty($data)) {
            $data = parent::all();
            Cache::forever(config('cache.prefix') . '.property.types.property', $data);
        }
        return $data;
    }
}
