<?php

namespace Modules\Flutterwave\Response;

use Modules\Gateway\Contracts\HasDataResponseInterface;
use Modules\Gateway\Response\Response;
use Modules\Gateway\Entities\Gateway;

class FlutterwaveResponse extends Response implements HasDataResponseInterface
{
    protected $response;
    public $txr;
    public $payment_method;

    public function __construct($response)
    {
        $this->txr              = $response->id;
        $this->response         = $response;
        $this->payment_method = Gateway::where('alias', 'flutterwave')->first();
        $this->updateStatus();
        return $this;
    }


    public function getRawResponse(): string
    {
        return json_encode($this->response);
    }


    protected function updateStatus()
    {
        $this->response->status == 'successful' ? $this->setPaymentStatus('completed') : $this->setPaymentStatus('failed');
    }


    public function getResponse(): string
    {
        return json_encode($this->getSimpleResponse());
    }


    private function getSimpleResponse()
    {
        return [
            'amount' => $this->data->total,
            'amount_captured' => $this->response->amount,
            'app_fee' => $this->response->app_fee,
            'charged_amount' => $this->response->charged_amount,
            'currency' => $this->response->currency,
            'code' => $this->data->code
        ];
    }


    public function getGateway(): string
    {
        return 'Flutterwave';
    }


    protected function setPaymentStatus($status)
    {
        $this->status = $status;
    }
}
