<?php

/**
 * Permissions Model
 *
 * Permissions Model manages Permissions operation.
 *
 * @category   Permissions
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

class Permissions extends Model
{
    protected $table = 'permissions';

    public static function getAll()
    {
        $data = Cache::get(config('cache.prefix') . '.permissions');
        if (empty($data)) {
            $data = parent::all();
            Cache::forever(config('cache.prefix') . '.permissions', $data);
        }
        return $data;
    }
}
