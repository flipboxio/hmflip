<?php

/**
 * RoleAdmin Model
 *
 * RoleAdmin Model manages RoleAdmin operation.
 *
 * @category   RoleAdmin
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

class RoleAdmin extends Model
{
    protected $table     = 'role_admin';
    protected $fillable  = ['role_id', 'admin_id'];
    public $timestamps   = false;

    public static function getAll()
    {
        $data = Cache::get(config('cache.prefix') . '.role_admin');
        if (empty($data)) {
            $data = parent::all();
            Cache::forever(config('cache.prefix') . '.role_admin', $data);
        }
        return $data;
    }
}
