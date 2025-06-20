<?php

/**
 * @package Preprocessor
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 * @created 16-2-22
 */

namespace Modules\Razorpay\Processor;

use Modules\Gateway\Facades\GatewayHelper;
use Modules\Razorpay\Entities\Razorpay;
use Razorpay\Api\Api;
use Session, Auth, Common;


class PreProcessor
{
    private $razor = null;
    private $data = null;

    public function getOrder($key = null, $razor = null)
    {
        $this->setup($key, $razor);

        try {
            return $this->paymentData($this->order());
        } catch (\Throwable $th) {
            Common::one_time_message('error', $th->getMessage());
            return redirect()->back();
        }
        
    }


    public function setup($key = null, $razor = null)
    {
        if (!$this->razor) {
            $this->razor = $this->razorData($razor);
        }
        if (!$this->data) {
            $this->data = $key;
        }
    }


    public function fetchData($key)
    {
        if (!$this->data) {
            return GatewayHelper::getPurchaseData($key);
        }
        return $this->data;
    }


    public function razorData($razor = null)
    {
        if (!$this->razor && !$this->razor = $razor) {
            return Razorpay::firstWhere('alias', 'razorpay')->data;
        }
        return $this->razor;
    }


    public function api($apiKey = null, $apiSecret = null)
    {
        if ($apiKey && $apiSecret) {
            return new Api($apiKey, $apiSecret);
        }
        return new Api($this->razor->apiKey, $this->razor->apiSecret);
    }


    public function order()
    {
        return $this->api()->order->create($this->orderData());
    }


    public function orderData()
    {
        return
            [
                'receipt'   => 'RC- '. random_int(10000, 99999),
                'amount'    => $this->data['price_list']->subtotal * 100,
                'currency'  => $this->data['price_list']->currency
            ];
    }


    public function paymentData($order)
    {
        $this->setOrderId($order['id']);

        $sessionData = json_encode([
            'payment_booking_id'                 => Session::get('payment_booking_id'),
            'payment_booking_type'               => Session::get('payment_booking_type'),
            'user'                               => Auth::user()->id,
            'payment_property_id'                => Session::get('payment_property_id'),
            'payment_checkin'                    => Session::get('payment_checkin'),
            'payment_checkout'                   => Session::get('payment_checkout'),
            'payment_number_of_guests'           => Session::get('payment_number_of_guests'),
            'payment_price_list'                 => Session::get('payment_price_list'),
            'payment_country'                    => Session::get('payment_country'),
            'message_to_host_' . Auth::user()->id=> Session::get('message_to_host_' . Auth::user()->id)
        ]);

        return [
            "key"           => $this->razor->apiKey,
            "amount"        => $order['amount'],
            "notes"         => [
                "merchant_order_id" => $order['receipt'],
                "test" => "test"
            ],
            "order_id"      => $order['id'],
            'callback_url'  => route(config('gateway.payment_callback'), withOldQueryIntegrity(['gateway' => 'razorpay', 'payment_method' => 'razorpay', 'sessionData'   => $sessionData])),
            'redirect'      => true
        ];
    }


    private function setOrderId($id)
    {
        session(['razor_order_id' => $id]);
    }

    public function getOrderId()
    {
        return session('razor_order_id');
    }
}
