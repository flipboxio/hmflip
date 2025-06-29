<?php

/**
 * @package StripeResponse
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 * @created 06-02-2022
 */

namespace Modules\Stripe\Response;

use Modules\Gateway\Contracts\HasDataResponseInterface;
use Modules\Gateway\Response\Response;
use Modules\Gateway\Entities\Gateway;

class StripeResponse extends Response implements HasDataResponseInterface
{
    protected $response;
    public $txr;
    public $payment_method;

    public function __construct($stripeResponse)
    {
        $this->response = $stripeResponse->jsonSerialize();
        $this->txr = $this->response['id'];
        $this->payment_method = Gateway::where('alias', 'stripe')->first();
        $this->updateStatus();
        return $this;
    }


    public function getRawResponse(): string
    {
        return json_encode($this->response);
    }


    protected function updateStatus()
    {
        if ($this->response['status'] == 'succeeded') {
            $this->setPaymentStatus('completed');
        } else {
            $this->setPaymentStatus('failed');
        }
    }

    public function getResponse(): string
    {
        return json_encode($this->getSimpleResponse());
    }


    private function getSimpleResponse()
    {
        return [
            'amount' => $this->response['amount'] / 100,
            'amount_captured' => $this->response['amount_captured'] / 100,
            'currency' => $this->response['currency'],
        ];
    }


    public function getGateway(): string
    {
        return 'Stripe';
    }

    protected function setPaymentStatus($status)
    {
        $this->status = $status;
    }
}
