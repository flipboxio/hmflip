<?php

/**
 * @package PaypalView
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 * @created 15-2-22
 */

namespace Modules\Paypal\Views;

use Modules\Gateway\Contracts\PaymentViewInterface;
use Modules\Gateway\Facades\GatewayHelper;
use Modules\Paypal\Entities\Paypal;

class PaypalView implements PaymentViewInterface
{

    public static function paymentView($key = null)
    {
        $helper = GatewayHelper::getInstance();
        try {
            return redirect('gateway/pay/paypal/complete');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => __($e->getMessage())]);
        }
    }
}
