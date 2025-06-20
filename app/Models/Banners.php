<?php

/**
 * Banners Model
 *
 * Banners Model manages Banners operation.
 *
 * @category   Banners
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

class Banners extends Model
{
    protected $table    = 'banners';
    public $timestamps  = false;
    public $appends     = ['image_url'];

    public function getImageUrlAttribute()
    {
        return url('public/front/images/banners/' . $this->attributes['image']);
    }
}
