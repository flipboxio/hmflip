<?php

/**
 * PropertyRules Model
 *
 * PropertyRules Model manages PropertyRules operation.
 *
 * @category   PropertyRules
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

class PropertyRules extends Model
{
    protected $table   = 'property_rules';
    public $timestamps = false;

    public function properties()
    {
        return $this->belongsTo('App\Models\Properties', 'property_id', 'id');
    }
}
