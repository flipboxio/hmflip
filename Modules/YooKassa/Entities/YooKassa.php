<?php

/**
 * @package YooKassa
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammed Kamrul Hasan <[kamrul.techvill@gmail.com]>
 * @created 18-01-25
 */

namespace Modules\YooKassa\Entities;

use Modules\Gateway\Entities\Gateway;
use Modules\YooKassa\Scope\YooKassaScope;

class YooKassa extends Gateway
{
    /**
     * Table
     *
     * @var string
     */
    protected $table = 'gateways';

    /**
     * Appends
     *
     * @var array
     */
    protected $appends = ['image_url'];

    /**
     * Booted
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new YooKassaScope);
    }
}
