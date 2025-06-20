<?php

/**
 * @package Paytr
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammed Kamrul Hasan <[kamrul.techvill@gmail.com]>
 * @created 18-09-2024
 */

namespace Modules\Paytr\Entities;

use Modules\Paytr\Scope\PaytrScope;
use Modules\Gateway\Entities\Gateway;


class Paytr extends Gateway
{

    protected $table = 'gateways';
    protected $appends = ['image_url'];

    /**
     * Global scope for paytr
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new PaytrScope);
    }
}
