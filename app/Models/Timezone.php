<?php

/**
 * Timezpne Model
 *
 * Timezpne Model manages Timezpne operation.
 *
 * @category   Timezpne
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

class Timezone extends Model
{
    protected $table   = 'timezone';
    public $timestamps = false;
}
