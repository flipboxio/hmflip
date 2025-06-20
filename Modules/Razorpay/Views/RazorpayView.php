<?php

/**
 * @package RazorpayView
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 * @created 16-2-22
 */

namespace Modules\Razorpay\Views;

use App\Http\Controllers\PaymentController;
use Modules\Gateway\Contracts\PaymentViewInterface;
use Modules\Razorpay\Entities\Razorpay;
use Modules\Razorpay\Facades\RazorFacade;
use Razorpay\Api\Errors\BadRequestError;

class RazorpayView implements PaymentViewInterface
{
    public static function paymentView($key = null)
    {

        try {

            $razorpay       = Razorpay::firstWhere('alias', 'razorpay')->data;

            $paymentData    = new PaymentController;

            $data           = $paymentData->getDataForBooking();

            $data['data']   = json_encode(RazorFacade::getOrder($data, $razorpay));

            return view('razorpay::pay', $data);

        } catch (BadRequestError $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => __('Purchase data not found.')]);
        }
    }
}
