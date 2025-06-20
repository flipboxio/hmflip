<?php

/**
 * @package PaytrView
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammed Kamrul Hasan <[kamrul.techvill@gmail.com]>
 * @created 18-09-2024
 */

namespace Modules\Paytr\Views;

use App\Http\Controllers\PaymentController;
use Modules\Paytr\Entities\Paytr;
use Modules\Gateway\Contracts\PaymentViewInterface;
use Modules\Gateway\Services\GatewayHelper;
use Modules\Gateway\Traits\ApiResponse;

class PaytrView implements PaymentViewInterface
{
    use ApiResponse;

    /**
     * Paytr payment view
     *
     * @param String $key
     * @return view|redirectResponse
     */
    public static function paymentView($key = null)
    {
        try {
            $paytr = Paytr::firstWhere('alias', 'paytr')->data;

            $paymentData            = new PaymentController();
            
            $data                   = $paymentData->getDataForBooking();
            $data['name']           = $paytr->name;
            $data['merchantId']     = $paytr->merchantId;
            $data['merchantKey']    = $paytr->merchantKey;
            $data['merchantSalt']   = $paytr->merchantSalt;
            $data['instruction']    = $paytr->instruction;

            return view('paytr::pay', $data);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => __('Purchase data not founds.')]);
        }
    }

    /**
     * Paytr payment response
     *
     * @param String $key
     * @return Array
     */
    public static function paymentResponse($key)
    {
        $helper = GatewayHelper::getInstance();

        $paytr = Paytr::firstWhere('alias', 'paytr')->data;
        return [
            'merchantId' => $paytr->merchantId,
            'merchantKey' => $paytr->merchantKey,
            'merchantSalt' => $paytr->merchantSalt,
            'instruction' => $paytr->instruction,
            'purchaseData' => $helper->getPurchaseData($key)
        ];
    }
}
