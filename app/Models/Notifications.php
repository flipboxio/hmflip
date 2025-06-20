<?php

/**
 * Notifications Model
 *
 * Notifications Model manages Notifications operation.
 *
 * @category   Notifications
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

class Notifications extends Model
{
    protected $table = 'notifications';

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
