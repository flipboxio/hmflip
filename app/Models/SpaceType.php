<?php

/**
 * SpaceType Model
 *
 * SpaceType Model manages SpaceType operation.
 *
 * @category   SpaceType
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

class SpaceType extends Model
{
    protected $table   = 'space_type';
    public $timestamps = false;

    public static function getAll()
    {
        $data = Cache::get(config('cache.prefix') . '.property.types.space');
        if (empty($data)) {
            $data = parent::all();
            Cache::forever(config('cache.prefix') . '.property.types.space', $data);
        }
        return $data;
    }
}
