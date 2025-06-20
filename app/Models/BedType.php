<?php

/**
 * BedType Model
 *
 * BedType Model manages BedType operation.
 *
 * @category   BedType
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

class BedType extends Model
{
    protected $table    = 'bed_type';
    public $timestamps  = false;

    public static function getAll()
    {
        $data = Cache::get(config('cache.prefix') . '.property.types.bed');
        if (empty($data)) {
            $data = Self::where('status', 'Active')->orWhere('status', null)->get();
            Cache::forever(config('cache.prefix') . '.property.types.bed', $data);
        }
        return $data;
    }
}
