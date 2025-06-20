<?php

/**
 * PropertySteps Model
 *
 * PropertySteps Model manages PropertySteps operation.
 *
 * @category   PropertySteps
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

class PropertySteps extends Model
{
    protected $table   = 'property_steps';
    public $timestamps = false;

    public function property()
    {
        return $this->belongsTo('App\Models\Properties', 'property_id', 'id');
    }
}
