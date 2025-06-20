<?php

namespace Modules\DirectBankTransfer\Entities;

use Modules\Gateway\Entities\GatewayBody;

class DirectBankTransferBody extends GatewayBody
{
    public $name;
    public $account_name;
    public $iban;
    public $swift_code;
    public $routing_no;
    public $bank_name;
    public $branch_name;
    public $branch_city;
    public $branch_address;
    public $country;
    public $logo;
    public $status;
    public $instruction;

    /**
     * Constructor for direct bank transfer body.
     *
     * @param [type] $request
     */
    public function __construct($request)
    {
        

        $this->account_name     = $request->account_name;
        $this->iban             = $request->iban;
        $this->swift_code       = $request->swift_code;
        $this->routing_no       = $request->routing_no;
        $this->bank_name        = $request->bank_name;
        $this->branch_name      = $request->branch_name;
        $this->branch_city      = $request->branch_city;
        $this->branch_address   = $request->branch_address;
        $this->country          = $request->country;
        $this->logo             = $this->bankLogo($request);
        $this->instruction      = $request->instruction;
        $this->status           = $request->status;
        $this->name             = $request->name;

    }
    public function bankLogo($request)
    {
        if($request->logo == null) {
            $bank                   = DirectBankTransfer::first()->data;
            return  $bank->logo ;   
        } else {

            $image_name             =  time() . '_' . $request->logo->getClientOriginalName();
            $destinationPath        = 'Modules/DirectBankTransfer/Resources/assets';
            $request->logo->move($destinationPath, $image_name);
            return $image_name;
        }
    }
}
