<?php

/**
 * @package YookassaProcessor
 * @author techvillage <support@techvill.org>
 * @contributor Muhammed Kamrul Hasan <[kamrul.techvill@gmail.com]>
 * @created 18-01-25
 */

namespace Modules\YooKassa\Processor;

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Cache;
use Modules\Gateway\Services\GatewayHelper;
use Modules\Gateway\Contracts\{
    PaymentProcessorInterface,
    RequiresCallbackInterface,
    RequiresCancelInterface,
};
use Modules\Subscription\Services\PackageSubscriptionService;
use Modules\YooKassa\Entities\YooKassa;
use Modules\YooKassa\Response\YooKassaResponse;
use YooKassa\Client;

class YooKassaProcessor implements PaymentProcessorInterface, RequiresCallbackInterface, RequiresCancelInterface
{
    /**
     * yookassa credentials
     */
    private $yookassa;

    /**
     * yookassaClient 
     */
    private $yookassaClient;

    /**
     * Gateway helper instance
     */
    private $helper;

    /**
     * Customer purchase data
     */
    private $purchaseData;


    /**
     * Notify url
     */
    private $notifyUrl;

    /**
     * Payload
     */
    private $payload;


    /**
     * Paytr processor constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->yookassa = YooKassa::firstWhere('alias', config('yookassa.alias'))->data;
        $paymentData            = new PaymentController();
        $this->purchaseData     = (object) $paymentData->getDataForBooking();
        $this->yookassaClient = new Client();
        $this->yookassaClient->setAuth($this->yookassa->storeId, $this->yookassa->secretKey);
        $this->notifyUrl = route('gateway.callback', withOldQueryIntegrity(['gateway' => config('yookassa.alias')]));
       
    }

    /**
     * Ajax payment
     *
     * @param object $request
     * @return payment view
     */
    public function pay($request)
    {
        $this->setEnvironment();

        if (strtoupper($this->purchaseData->code) != 'RUB') {
            throw new \Exception(__('Currency not supported by merchant'));
        }

        $response = $this->yookassaClient->createPayment(
            $this->payload,
            uniqid('', true)
        );

        if (!$response->confirmation->confirmation_url) {
           throw new \Exception(__('There seems to be an issue. Please attempt the action again.'));
           
        }

        Cache::put($this->purchaseData->code, $response->id, 3600);

        return redirect($response?->confirmation?->confirmation_url);
    }


    /**
     * Validate Transaction
     *
     * @param Request $request
     * @return YooKassaResponse
     */
    public function validateTransaction($request)
    {
        $this->setEnvironment();

        if (!Cache::has($this->purchaseData->code)) {
            throw new \Exception(__('Purchase data not found.'));
        }

        $paymentId = Cache::get($this->purchaseData->code);
        $paymentInfo = $this->yookassaClient->getPaymentInfo($paymentId);
        Cache::forget($this->purchaseData->code);
        return new YooKassaResponse($this->purchaseData, $paymentInfo);
    }


    /**
     * Cancel Payment
     *
     * @param object $request
     * @return void
     */
    public function cancel($request)
    {
        throw new \Exception(__('Payment cancelled from YooKassa.'));
    }


    /**
     * Set environment
     *
     * @return void
     */
    private function setEnvironment(): void
    {
        $this->setPayload();
    }

    /**
     * Setup the payload values
     */
    private function setPayload(): void
    {
        $this->payload = [
            'amount' => [
                'value' => $this->purchaseData->price_list->total,
                'currency' => $this->purchaseData->code,
            ],
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => $this->notifyUrl,
            ],
            'capture' => true,
            'description' => $this->purchaseData->code,
            'metadata' => [
                'order_id' => uniqid('order-')
            ]
        ];
    }

    /**
     * Check validate payment
     * 
     * @param $request
     * @return boolean
     */
    public function validatePayment($request)
    {
        if ((new PackageSubscriptionService)->updateYookassaPayment($request)) {
            return true;
        }
        return false;
    }
}
