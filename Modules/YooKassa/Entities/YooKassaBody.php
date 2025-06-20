<?php

/**
 * @package YooKassaBody
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammed Kamrul Hasan <[kamrul.techvill@gmail.com]>
 * @created 18-01-25
 */

namespace Modules\YooKassa\Entities;

use Modules\Gateway\Entities\GatewayBody;

class YooKassaBody extends GatewayBody
{
    public $name;
    public $storeId;
    public $secretKey;
    public $instruction;
    public $status;
    public $sandbox;

    /**
     * Initialization
     *
     * @param array $request
     * @return void
     */
    public function __construct($request)
    {
        $this->name = $request->name;
        $this->storeId = $request->storeId;
        $this->secretKey = $request->secretKey;
        $this->instruction = $request->instruction;
        $this->status = $request->status;
        $this->sandbox = $request->sandbox;
    }
}
