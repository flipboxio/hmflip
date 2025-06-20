<?php

namespace Modules\Razorpay\Response;

use Modules\Gateway\Contracts\HasDataResponseInterface;
use Modules\Gateway\Response\Response;
use Modules\Gateway\Entities\Gateway;

class RazorResponse extends Response implements HasDataResponseInterface
{
    protected $response;
    public $txr;
    public $payment_method;

    public function __construct($response)
    {
        $this->response = $response;
        $this->setPaymentStatus('completed');
        $this->payment_method = Gateway::where('alias', 'razorpay')->first();
        return $this;
    }


    protected function setPaymentStatus($status)
    {
        $this->status = $status;
    }

    public function getGateway(): string
    {
        return 'razorpay';
    }


    public function getRawResponse(): string
    {
        return json_encode($this->response);
    }


    public function getResponse(): string
    {
        return json_encode($this->getSimpleResponse());
    }


    private function getSimpleResponse()
    {
        return [
            'amount' => $this->data->total,
            'amount_captured' => $this->data->total,
            'currency' => $this->data->currency_code,
            'code' => $this->data->code
        ];
    }
}
