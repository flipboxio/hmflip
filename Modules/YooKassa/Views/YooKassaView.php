<?php

/**
 * @package YooKassaView
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammed Kamrul Hasan <[kamrul.techvill@gmail.com]>
 * @created 18-01-25
 */

namespace Modules\YooKassa\Views;

use App\Http\Controllers\PaymentController;
use Modules\Gateway\Contracts\PaymentViewInterface;
use Modules\Gateway\Services\GatewayHelper;
use Modules\Gateway\Traits\ApiResponse;
use Modules\YooKassa\Entities\YooKassa;

class YooKassaView implements PaymentViewInterface
{
    use ApiResponse;

    /**
     * Payment View
     *
     * @param string $key
     * @return \Illuminate\Contracts\View\View
     */
    public static function paymentView($key = null)
    {
        try {
            $yookassa = YooKassa::firstWhere('alias', config('yookassa.alias'))->data;

            $paymentData            = new PaymentController();

            $data                   = $paymentData->getDataForBooking();

            $data['name']           = $yookassa->name;
            $data['secretKey']      = $yookassa->secretKey;
            $data['instruction']    = $yookassa->instruction;
            return view('yookassa::pay', $data);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => __('Purchase data not found.')]);
        }
    }

    /**
     * Payment Response
     *
     * @param string $key
     * @return array
     */
    public static function paymentResponse($key)
    {
        $helper = GatewayHelper::getInstance();

        $yookassa = YooKassa::firstWhere('alias', config('yookassa.alias'))->data;
        return [
            'secretKey' => $yookassa->secretKey,
            'instruction' => $yookassa->instruction,
            'purchaseData' => $helper->getPurchaseData($key)
        ];
    }
}
