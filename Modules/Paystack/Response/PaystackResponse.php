<?php

/**
 * @package PaystackResponse
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 * @created 14-2-22
 */

namespace Modules\Paystack\Response;

use Modules\Gateway\Contracts\HasDataResponseInterface;
use Modules\Gateway\Response\Response;
use Modules\Gateway\Entities\Gateway;

class PaystackResponse extends Response implements HasDataResponseInterface
{
    protected $response;
    public $txr;
    public $payment_method;


    /**
     * Constructor of the response
     *
     * @param object $data (Order data object)
     * @param object $response (Payment response)
     */
    public function __construct($data, $response)
    {
        $this->txr = $response->id;
        $this->response = $response;
        $this->payment_method = Gateway::where('alias', 'paystack')->first();
        $this->updateStatus();
        return $this;
    }

    /**
     * Get raw response
     *
     * @return string
     */
    public function getRawResponse(): string
    {
        return json_encode($this->response);
    }

    /**
     * Update status
     *
     * @return void
     */
    protected function updateStatus()
    {
        $this->setPaymentStatus('completed');
    }

    /**
     * Get response
     *
     * @return string
     */
    public function getResponse(): string
    {
        return json_encode($this->getSimpleResponse());
    }

    /**
     * Get simple response
     *
     * @return Array
     */
    private function getSimpleResponse()
    {
        return [
            'amount' => $this->response->amount / 100,
            'amount_captured' => $this->response->amount / 100,
            'currency' => 'NGN',
        ];
    }

    /**
     * Get gateway name.
     *
     * @return string
     */
    public function getGateway(): string
    {
        return 'Paystack';
    }

    /**
     * Set payment status
     *
     * @param String $status
     * @return void
     */
    protected function setPaymentStatus($status)
    {
        $this->status = $status;
    }
}
