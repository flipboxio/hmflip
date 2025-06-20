<?php

namespace Modules\Gateway\Http\Controllers;

use App\Http\Controllers\PaymentController;
use App\Models\PaymentMethods;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Gateway\Contracts\{
    RequiresWebHookValidationInterface,
    HasDataResponseInterface,
    RequiresCallbackInterface
};
use Modules\Gateway\Entities\{
    Gateway,
    GatewayModule,
    PaymentLog
};
use Modules\Gateway\Facades\GatewayHandler;
use Modules\Gateway\Redirect\GatewayRedirect;
use Modules\Gateway\Services\GatewayHelper;
use Modules\Gateway\Traits\ApiResponse;
use Auth, Session, Common;

class GatewayController extends Controller
{
    use ApiResponse;

    private $helper;

    public function __construct()
    {
        $this->helper = GatewayHelper::getInstance();
    }


    /**
     * Display payable payment gateway.
     *
     * @return Renderable
     */
    public function paymentGateways(Request $request)
    {
        
        $query = $request->query->all() ?? [];
        $data = ['total'=>100,'currency_code'=>'NGN'];
        $purchaseData = (object) $data;
        $gateways = (new GatewayModule)->payableGateways();

        return view('gateway::pay', compact('gateways', 'purchaseData'));
    }


    /**
     * Displays the payment page for specific payment gateway
     *
     * @param \Illuminate\Http\Request
     *
     * @return Renderable
     */
    public function pay(Request $request)
    {
      
        $gateway = Session('payment_method');
        if (moduleAvailable($gateway) && $this->helper->isModuleActive($gateway)) {
            $viewClass = GatewayHandler::getView($gateway);
            return $viewClass::paymentView();
        }
        return redirect(route('gateway.payment', withOldQueryString()))->withErrors(__('Payment method not found.'));
    }


    /**
     * Process the payment for specific gateway
     *
     * @param \Illuminate\Http\Request
     *
     * @return redirect
     */
    public function makePayment(Request $request)
    {
        $gateway = Session('payment_method');
        if (moduleAvailable($gateway)) {
            try {
                
                $processor = GatewayHandler::getProcessor($gateway);
                $response = $processor->pay($request);
                
                if ($processor instanceof RequiresWebHookValidationInterface) {
                    return redirect($response->getUrl());
                }

                if ($processor instanceof RequiresCallbackInterface) {
                    return $response;
                }

                $code = $this->getAllData($response);

                return redirect('booking/requested?code=' . $code);

            } catch (\Exception $e) {

                Common::one_time_message('error', $e->getMessage());
                return redirect()->back();

            }
            return redirect()->route(request()->to);
        }
        return redirect(route('gateway.payment', withOldQueryIntegrity()))->withErrors(__('Payment method not available.'));
    }


    /**
     * This function handle response of redirected payment callbacks
     *
     * @param \Illuminate\Http\Request
     *
     * @return redirect
     */
    public function paymentCallback(Request $request)
    {
        $gateway = session('payment_method') != null ? session('payment_method') : $request->payment_method;

        if ($gateway == 'razorpay') {

            $sessionData = json_decode($request->sessionData, true);

            foreach ($sessionData as $key => $data) {

                if ($key == 'payment_price_list') {

                    Session::put($key, json_decode(json_encode((object) $data)));

                } else {

                    Session::put($key,  $data);
                }
            }
            Auth::loginUsingId(Session::get('user'));
        }
         
        try {

            $processor = GatewayHandler::getProcessor($gateway);
            $response = $processor->validateTransaction($request);
            $code = $this->getAllData($response);

            return redirect('booking/requested?code=' . $code);

        } catch (\Exception $e) {
            Common::one_time_message('error', $e->getMessage());
            return redirect(url('payments/book',Session('payment_property_id')));

        }
    }

    public function getAllData($response)
    {
        $booking_id            = Session::get('payment_booking_id');
        $booking_type          = Session::get('payment_booking_type');
        $payment_method        = $response->payment_method;
        $data  = [
            'property_id'      => Session::get('payment_property_id'),
            'checkin'          => Session::get('payment_checkin'),
            'checkout'         => Session::get('payment_checkout'),
            'number_of_guests' => Session::get('payment_number_of_guests'),
            'transaction_id'   => $response->txr ?? null,
            'price_list'       => Session::get('payment_price_list'),
            'country'          => Session::get('payment_country'),
            'message_to_host'  => Session::get('message_to_host_'. Auth::user()->id),
            'payment_method_id'=> $payment_method->id,
            'paymode'          => $payment_method->name,
            'payment_alias'    => $payment_method->alias,
            'booking_id'       => $booking_id,
            'booking_type'     => $booking_type,
            'attachment'       => $response->attachments ?? null,
            'note'             => $response->note ?? null
        ];

        $conn = new PaymentController;
        if (isset($booking_id) && !empty($booking_id)) {
            $msg = explode('||', $conn->update($data));
            $code = $msg[0];
            $errorMessage = $msg[1];

        } else {

            $msg = explode('||', $conn->store($data));
            $code = $msg[0];
            $errorMessage = $msg[1];
        }

        Common::one_time_message('success', __('Payment was Successful') . '.' . $errorMessage);
        return $code;
    }


    /**
     * Handles cancelled payment request
     *
     * @param \Illuminate\Http\Request
     *
     * @return redirect
     */
    public function paymentCancelled(Request $request)
    {
        try {
            $processor = GatewayHandler::getProcessor($request->gateway);
            $processor->cancel($request);
        } catch (\Exception $e) {
            Common::one_time_message('error', $e->getMessage());
                return redirect(url('payments/book',Session('payment_property_id')));
        }
    }

    /**
     * Process payment from gateways which sends response to the hook URL
     *
     * @param \Illuminate\Http\Request
     *
     * @return bool
     */
    public function paymentHook(Request $request)
    {
        try {
            $processor = GatewayHandler::getProcessor($request->gateway);
            $payment = $processor->validatePayment($request);
            if (!$payment) {
                return false;
            }
        } catch (\Exception $e) {
            paymentLog([$e, $request->all()]);
            return false;
        }
        return true;
    }


    /**
     * Process payment response
     *
     * @param \Modules\Gateway\Response\Response
     *
     * @return array
     */
    private function getUpdateData($response)
    {
        $array['gateway'] = $response->getGateway();
        $array['status'] = $response->getStatus();
        if ($response instanceof HasDataResponseInterface) {
            $array['response'] = $response->getResponse();
            $array['response_raw'] = $response->getRawResponse();
        }
        
        return $array;
    }


    public function paymentConfirmation(Request $request)
    {
        $code = techDecrypt($request->code);
        $purchaseData = PaymentLog::where('code', $code)->orderBy('id', 'desc')->first();
        return view("gateway::confirmation", compact('purchaseData'));
    }

    public function paymentFailed(Request $request)
    {
        $errors = [
            'integrity' => __("Invalid payment request authentication failed. Please retry payment from the start."),
            'error' => __("Payment processing failed.")
        ];
        $data = [];
        if (isset($errors[$request->error])) {
            $data['message'] = $errors[$request->error];
        }
        return view("gateway::failed-payment", $data);
    }
}
