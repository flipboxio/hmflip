<?php

/**
 * PropertyFees Model
 *
 * PropertyFees Model manages PropertyFees operation.
 *
 * @category   PropertyFees
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

class PropertyFees extends Model
{
    protected $table   = 'property_fees';
    public $timestamps = false;
}
