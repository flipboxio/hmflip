<?php

/**
 * @package YooKassaResponse
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammed Kamrul Hasan <[kamrul.techvill@gmail.com]>
 * @created 18-01-25
 */

namespace Modules\YooKassa\Response;

use Modules\Gateway\Contracts\HasDataResponseInterface;
use Modules\Gateway\Response\Response;
use Modules\Gateway\Entities\Gateway;

class YooKassaResponse extends Response implements HasDataResponseInterface
{
    protected $response;
    private $data;
    public $payment_method;

    /**
     * Initialization
     *
     * @return $this
     */
    public function __construct($data, $yookassaResponse)
    {
        $this->data = $data;
        $this->response = $yookassaResponse;
        $this->updateStatus();
        $this->payment_method = Gateway::where('alias', 'yookassa')->first();
        return $this;
    }

    /**
     * Get Raw Response
     *
     * @return string
     */
    public function getRawResponse(): string
    {
        return json_encode($this->response);
    }

    /**
     * Update Status
     *
     * @return void
     */
    protected function updateStatus()
    {
        if ($this->response->status == 'succeeded') {
            $this->setPaymentStatus('completed');
        } else {
            $this->setPaymentStatus('pending');
        }
    }

    /**
     * Get Response
     *
     * @return string
     */
    public function getResponse(): string
    {
        return json_encode($this->getSimpleResponse());
    }

    /**
     * Get Simple Response
     *
     * @return array
     */
    private function getSimpleResponse()
    {
        return [
            'amount' => $this->response->amount->value,
            'amount_captured' => $this->data->total,
            'currency' => $this->response->amount->_currency,
            'code' => $this->data->code
        ];
    }

    /**
     * Get Gateway
     *
     * @return string
     */
    public function getGateway(): string
    {
        return moduleConfig('yookassa.name');
    }

    /**
     * Set Payment Status
     *
     * @return void
     */
    protected function setPaymentStatus($status)
    {
        $this->status = $status;
    }
}
