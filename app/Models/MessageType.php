<?php

/**
 * Message Model
 *
 * Message Model manages Message operation.
 *
 * @category   Message
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

class MessageType extends Model
{
    protected $table    = 'message_type';
    public $timestamps  = false;

    public function messages()
    {
        return $this->hasMany('App\Models\Messages', 'type_id', 'id');
    }
}
