<?php

/**
 * Rules Model
 *
 * Rules Model manages Rules operation.
 *
 * @category   Rules
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

class Rules extends Model
{
    protected $table   = 'rules';
    public $timestamps = false;
}
