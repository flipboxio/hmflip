<?php

/**
 * @package Paytr
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammed Kamrul Hasan <[kamrul.techvill@gmail.com]>
 * @created 18-09-2024
 */

namespace Modules\Paytr\Entities;

use Modules\Gateway\Entities\GatewayBody;

class PaytrBody extends GatewayBody
{
    /**
     * Payment method name
     *
     * @var string
     */
    public $name;

    /**
     * Paytr merchant id
     *
     * @var string
     */
    public $merchantId;

    /**
     * Paytr merchant key
     *
     * @var string
     */
    public $merchantKey;

    /**
     * Paytr merchant salt
     *
     * @var String
     */
    public $merchantSalt;

    /**
     * Paytr payment instruction 
     *
     * @var String
     */
    public $instruction;

    /**
     * Paytr payment active status
     *
     * @var bool
     */
    public $status;

    /**
     * Paytr payment mode status
     *
     * @var bool
     */
    public $sandbox;

        /**
     * Paytr Callback webhook
     *
     * @var bool
     */
    public $callbackURL;

    /**
     * Paytr body constructor
     *
     * @param Object|mixed $request
     * @return void
     */
    public function __construct($request)
    {
        $this->name = $request->name;
        $this->callbackURL = $request->callbackURL;
        $this->merchantId = $request->merchantId;
        $this->merchantKey = $request->merchantKey;
        $this->merchantSalt = $request->merchantSalt;
        $this->instruction = $request->instruction;
        $this->status = $request->status;
        $this->sandbox = $request->sandbox;
    }
}
