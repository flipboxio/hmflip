<?php

/**
 * @package PaytrProcessor
 * @author techvillage <support@techvill.org>
 * @contributor Muhammed Kamrul Hasan <[kamrul.techvill@gmail.com]>
 * @created 18-09-2024
 */

namespace Modules\Paytr\Processor;

use App\Http\Controllers\PaymentController;
use App\Models\{
    BookingDetails,
    Currency,
    Bookings,
    Messages,
    Properties,
};
use Modules\Gateway\Services\GatewayHelper;
use Modules\Paytr\Response\PaytrResponse;
use Modules\Paytr\Entities\Paytr;
use Modules\Gateway\Contracts\{
    PaymentProcessorInterface,
    RequiresCallbackInterface,
    RequiresCancelInterface,
    RequiresWebHookValidationInterface
};
use Modules\Gateway\Entities\PaymentLog;
use Common, Session, Auth;

class PaytrProcessor implements PaymentProcessorInterface, RequiresWebHookValidationInterface, RequiresCallbackInterface, RequiresCancelInterface
{
    /**
     * Paytr credentials
     *
     * @var Object/array
     */
    private $paytr;

    /**
     * Gateway helper instance
     *
     * @var [type]
     */
    private $helper;

    /**
     * Customer email
     *
     * @var String
     */
    private $email;

    /**
     * Paytr sending payload
     *
     * @var Array
     */
    private $payload;

    /**
     * Customer purchase data
     *
     * @var Object/Array
     */
    private $purchaseData;

    /**
     * Paytr token
     *
     * @var String
     */
    public $token;

    /**
     * Paytr request url
     *
     * @var String
     */
    private $requestUrl;

    /**
     * Customer address
     *
     * @var String
     */
    private $userAddress;

    /**
     * Customer phone number
     *
     * @var String
     */
    private $userPhone;

    /**
     * Customer name
     *
     * @var String
     */
    private $username;

    /**
     * Order id
     *
     * @var String
     */
    private $merchantOid;

    /**
     * Payment success url
     *
     * @var String
     */
    private $successUrl;

    /**
     * Payment fail url
     *
     * @var String
     */
    private $failUrl;

    /**
     * User ip address
     *
     * @var String
     */
    private $userIp;

    /**
     * Paytr time out limit
     *
     * @var integer
     */
    private $timeout;

    /**
     * Paytr debug mode
     *
     * @var integer
     */
    private $debug = 1;

    /**
     * Paytr payment mode (test mode or production mode)
     *
     * @var integer
     */
    private $testMode = 1;

    /**
     * order contents
     *
     * @var string
     */
    private $userBasket;

    /**
     * Undocumented variable
     *
     * @var integer
     */
    private $noInstallment = 1;

    /**
     * Maximum number of installments
     *
     * @var integer
     */
    private $maxInstallment = 0;

    /**
     * Hash data for paytr
     *
     * @var String
     */
    private $hashString;

    /**
     * Encrypted token
     *
     * @var string
     */
    private $paytrToken;

    /**
     * Payment amount
     *
     * @var integer
     */
    private $total;

    /**
     * SSL VERIFICATION
     *
     * @var integer
     */
    private $sslVerify = 0;


    /**
     * Paytr processor constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->helper           = GatewayHelper::getInstance();
        $this->paytr            = Paytr::firstWhere('alias', config('paytr.alias'))->data;
        $paymentData            = new PaymentController();
        $this->purchaseData     = $paymentData->getDataForBooking();
    }

    /*
    *   GENERATE PRIVACY HASH CODE
    */
    public function generateHashCode()
    {
        $this->hashString = implode("", [
            $this->paytr->merchantId,
            $this->userIp,
            $this->merchantOid,
            $this->email,
            $this->total,
            $this->userBasket,
            $this->noInstallment,
            $this->maxInstallment,
            $this->purchaseData['code'],
            $this->testMode,
            $this->paytr->merchantSalt
        ]);
    }

    /**
     * Set paytr token
     *
     * @return void
     */
    public function setPaytrToken()
    {
        
        $this->paytrToken = base64_encode(hash_hmac('sha256', $this->hashString, $this->paytr->merchantKey,true));
    }


    /**
     *  Generate random unique key
     *
     * @return key
     */
    public function randomKeyGenerate()
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 50);
    }

    public function requestPaytr($postValues = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->requestUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postValues);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->sslVerify);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->sslVerify);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            curl_close($ch);
            return curl_error($ch);
        } else {
            curl_close($ch);
            return $result;
        }
    }

    /**
     *  Set initials data
     *
     * @return void
     */
    private function setupData()
    {   
        $this->merchantOid  = $this->randomKeyGenerate();
        $this->successUrl   = route(config('gateway.payment_callback'), ['gateway' => 'paytr']) . '?code=' . $this->merchantOid;
        $this->failUrl      = route('gateway.cancel', withOldQueryIntegrity(['gateway' => 'paytr']));
        $this->userIp       = getIpAddress();
        $this->total        = intval($this->purchaseData['price_list']->total * 100);
        $this->timeout      = 30;
        $this->setEnvironment();
        $this->setBasket();
    }


    /**
     *  Set payload data
     *
     * @return void
     */
    private function setPayload()
    {
        $this->payload = [
            'merchant_id'        => $this->paytr->merchantId,
            'user_ip'            => $this->userIp,
            'merchant_oid'       => $this->merchantOid,
            'email'              => $this->email,
            'payment_amount'     => $this->total,
            'paytr_token'        => $this->paytrToken,
            'user_basket'        => $this->userBasket,
            'debug_on'           => $this->debug,
            'no_installment'     => $this->noInstallment,
            'max_installment'    => $this->maxInstallment,
            'user_name'          => $this->username,
            'user_address'       => $this->userAddress,
            'user_phone'         => $this->userPhone,
            'merchant_ok_url'    => $this->successUrl,
            'merchant_fail_url'  => $this->failUrl,
            'timeout_limit'      => $this->timeout,
            'currency'           => $this->purchaseData['price_list']->currency,
            'test_mode'          => $this->testMode
        ];
    }


    /**
     * Ajax payment
     *
     * @param object $request
     * @return payment view
     */
    public function pay($request)
    {
        if (!$request->name) {
            throw new \Exception(__('Name is required.'));
        }

        $this->username = $request->name;

        if (!$request->email) {
            throw new \Exception(__('Email is required.'));
        }

        $this->email = $request->email;

        if (!$request->phone) {
            throw new \Exception(__('Phone number is required.'));
        }

        $this->userPhone = $request->phone;

        if (!$request->address) {
            throw new \Exception(__('Address is required.'));
        }

        $this->userAddress = $request->address;
        $this->setupData();
        
        $this->generateHashCode();
        $this->setPaytrToken();
        $this->setPayload();

        $result = $this->requestPaytr($this->payload);
        $result = json_decode($result, 1);
        if ($result['status'] != 'success') {

            throw new \Exception($result['reason']);
        }
        
        $response = new PaytrResponse($this->purchaseData, $result);
        $response->setUniqueCode($this->merchantOid);
        $response->setPaymentStatus('pending');
        $this->createBooking($this->merchantOid);

        return $response;
    }


    /**
     * Validate Transaction
     *
     * @param Request $request
     * @return PaytrResponse
     */
    public function validateTransaction($request)
    {
        $request['status'] = 'success';
        return new PaytrResponse($this->purchaseData, $request);

    }



    /**
     * Cancel Payment
     *
     * @param object $request
     * @return void
     */
    public function cancel($request)
    {
        throw new \Exception(__('Payment cancelled from Paytr.'));
    }


    /**
     * Set environment
     *
     * @return void
     */
    private function setEnvironment()
    {
        if (!$this->paytr->sandbox) {
            $this->testMode = 0;
            $this->debug = 0;
            $this->sslVerify = 1;
        }

        $this->setUrl();
    }


    /**
     * Set Urls
     *
     * @return void
     */
    private function setUrl()
    {
        $this->requestUrl = "https://www.paytr.com/odeme/api/get-token";
    }

    /*
    * Set user basket(product) info
    *
    * @return void
    */
    public function setBasket()
    {
        $this->userBasket = base64_encode(json_encode(array(
            array($this->purchaseData['code'], $this->total, 1),
        )));
    }

    public function validatePayment($request)
    {
        $hash = base64_encode(techHash($request->merchantOid . $this->paytr->merchant_salt . $request->status . $request->total_amount, $this->paytr->merchant_key));

        if ($hash == $request->hash && $request->status == 'success') {

            $payment = PaymentLog::uniqueCode($request->externalId)->first();

            if (!$payment) {
                paymentLog($request);
                paymentLog('------ Payment data with the requested paytr unique code ("field: custom") -------');
                return false;
            }

            $payment->response_raw = json_encode($request->all());

            if ($request->status == 'success') {

                $payment->status = 'completed';
                $payment->response = json_encode($request->all());
            } else {
                $payment->status = 'cancelled';
            }

            $payment->store();

            return true;
        }
        return false;
    }

    public function createBooking($merchanOId) 
    {

        $bookingId = Session::get('payment_booking_id');

        if (isset($bookingId)) {
            return true;
        }

        $propertyId = Session::get('payment_property_id');
        $checkIn = Session::get('payment_checkin');
        $checkOut = Session::get('payment_checkout');
        $numberOfGuests = Session::get('payment_number_of_guests');

        $currencyDefault    = Currency::getAll()->where('default', 1)->first();
        $priceList         = json_decode(Common::getPrice($propertyId, $checkIn, $checkOut, $numberOfGuests));
        $amount             = round(Common::convert_currency(Session::get('currency'), $currencyDefault->code, $priceList->total), 2);
        
        $country            = Session::get('payment_country');
        $messageToHost    = Session::get('message_to_host_'. Auth::user()->id);

        $data = [
            'property_id'      => $propertyId,
            'checkin'          => $checkIn,
            'checkout'         => $checkOut,
            'number_of_guests' => $numberOfGuests,
            'transaction_id'   => $merchanOId,
            'price_list'       => $priceList,
            'paymode'          => Paytr::firstWhere('alias', config('paytr.alias'))->name,
            'payment_alias'    => 'paytr',
            'first_name'       => Auth::user()->first_name,
            'last_name'        => Auth::user()->last_name,
            'postal_code'      => '',
            'country'          => $country,
            'message_to_host'  => $messageToHost
        ];

        $code = $this->store($data);

        $booking = Bookings::where('code', $code)->first();

        Session::put('payment_booking_id', $booking->id);
  
    }

    public function store($data)
    {
        $currencyDefault = Currency::getAll()->where('default', 1)->first();
        $booking = new Bookings();
        $booking->property_id       = $data['property_id'];
        $booking->host_id           = Properties::find($data['property_id'])->host_id;
        $booking->user_id           = Auth::user()->id;
        $booking->start_date        = setDateForDb($data['checkin']);
        $checkinDate                = onlyFormat($booking->start_date);
        $booking->end_date          = setDateForDb($data['checkout']);
        $booking->guest             = $data['number_of_guests'];
        $booking->attachment        = $data['attachment'] ?? null;
        $booking->bank_id           = $data['bank_id'] ?? null;
        $booking->note              = $data['note'] ?? null;
        $booking->bank_id           = $data['bank_id'] ?? null;
        $booking->total_night       = $data['price_list']->total_nights;
        $booking->per_night         = Common::convert_currency('', $currencyDefault->code, $data['price_list']->property_price);

        $booking->custom_price_dates= isset($data['price_list']->different_price_dates_default_curr) ? json_encode($data['price_list']->different_price_dates_default_curr) : null ;

        $booking->base_price        = Common::convert_currency('', $currencyDefault->code, $data['price_list']->subtotal);
        $booking->cleaning_charge   = Common::convert_currency('', $currencyDefault->code, $data['price_list']->cleaning_fee);
        $booking->guest_charge      = Common::convert_currency('', $currencyDefault->code, $data['price_list']->additional_guest);
        $booking->iva_tax           = Common::convert_currency('', $currencyDefault->code, $data['price_list']->iva_tax);
        $booking->accomodation_tax  = Common::convert_currency('', $currencyDefault->code, $data['price_list']->accomodation_tax);
        $booking->security_money    = Common::convert_currency('', $currencyDefault->code, $data['price_list']->security_fee);
        $booking->service_charge    = Common::convert_currency('', $currencyDefault->code, $data['price_list']->service_fee);
        $booking->host_fee          = Common::convert_currency('', $currencyDefault->code, $data['price_list']->host_fee);
        $booking->total             = Common::convert_currency('', $currencyDefault->code, $data['price_list']->total);

        $booking->currency_code     = $currencyDefault->code;
        $booking->transaction_id    = $data['transaction_id'] ?? " ";
        $booking->payment_method_id = $data['payment_method_id'] ?? " ";
        $booking->cancellation      = Properties::find($data['property_id'])->cancellation;
        $booking->status            = 'Pending';

        $booking->booking_type      = Session::get('payment_booking_type');

        foreach ($data['price_list']->date_with_price as $key => $value) {
            $allData[$key]['price'] = Common::convert_currency('', $currencyDefault->code, $value->original_price);
            $allData[$key]['date']  = setDateForDb($value->date);
        }

        $booking->date_with_price    = json_encode($allData);

        $booking->save();

        $code = $this->generateCode($booking);
    
        $this->saveBookingDetails($data, $booking);

        $this->messageSave($data, $booking);

       return $code;
    }

    public function generateCode($booking)
    {
        do {
            $code = Common::randomCode(6);
            $checkCode = Bookings::where('code', $code)->get();
        } while (empty($checkCode));

        $bookingCode = Bookings::find($booking->id);

        $bookingCode->code = $code;
        
        $bookingCode->save();

        return $code;
    }

    public function messageSave($data, $booking)
    {
        $message = new Messages();
        $message->property_id    = $data['property_id'];
        $message->booking_id     = $booking->id;
        $message->sender_id      = $booking->user_id;
        $message->receiver_id    = $booking->host_id;
        $message->message        = isset($data['message_to_host']) ? $data['message_to_host'] : '';
        $message->type_id        = 4;
        $message->read           = 0;
        $message->save();
    }

    public function saveBookingDetails($data, $booking)
    {
        $bookingDetails['country']          = $data['country'];

        foreach ($bookingDetails as $key => $value) {
            $bookingDetails = new BookingDetails();
            $bookingDetails->booking_id = $booking->id;
            $bookingDetails->field = $key;
            $bookingDetails->value = $value;
            $bookingDetails->save();
        }
    }

    public function getDataForBooking() 
    {
        $data['id'] = $id         = Session::get('payment_property_id');
        $data['result']           = Properties::find($id);
        $data['property_id']      = $id;
        $checkin                  = Session::get('payment_checkin');
        $checkout                 = Session::get('payment_checkout');
        $numberOfGuests           = Session::get('payment_number_of_guests');
        $bookingType              = Session::get('payment_booking_type');
        
        $data['checkin']          = setDateForDb($checkin);
        $data['checkout']         = setDateForDb($checkout);
        $data['number_of_guests'] = $numberOfGuests;
        $data['booking_type']     = $bookingType;

        if ($id == null || $checkin == null || $checkout == null || $numberOfGuests == null || $bookingType == null || empty($data['result'])) {
            return $data;
        }
        
        $from                     = new DateTime(setDateForDb($checkin));
        $to                       = new DateTime(setDateForDb($checkout));
        
        $data['nights']           = $to->diff($from)->format("%a");
        
        $data['price_list']       = json_decode(Common::getPrice($data['property_id'], $data['checkin'], $data['checkout'], $data['number_of_guests']));
        
        $data['currencyDefault']  = $currencyDefault = Currency::getAll()->where('default', 1)->first();
        
        $data['price_eur']        = Common::convert_currency($data['result']->property_price?->default_code, $currencyDefault->code, $data['price_list']->total);
        
        $data['price_rate']       = Common::currency_rate( $currencyDefault->code, Common::getCurrentCurrencyCode());
        $data['symbol']           = Common::getCurrentCurrencySymbol();
        $data['code']             = Common::getCurrentCurrencyCode();
        return $data;
    }
}
