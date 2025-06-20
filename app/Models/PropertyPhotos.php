<?php
/**
 * PropertyPhotos Model
 *
 * PropertyPhotos Model manages PropertyPhotos operation.
 *
 * @category   PropertyPhotos
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

class PropertyPhotos extends Model
{
    protected $table   = 'property_photos';
    public $timestamps = false;

    public function properties()
    {
        return $this->belongsTo('App\Models\Properties', 'property_id', 'id');
    }
}
