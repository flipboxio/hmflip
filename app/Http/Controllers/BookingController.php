<?php
namespace App\Http\Controllers;

use Auth, DB, Session, DateTime, Common;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\{
    Controller,
    EmailController
};
use App\Models\{
    Bank,
    Bookings,
    BookingDetails,
    Messages,
    Penalty,
    Payouts,
    Properties,
    PayoutPenalties,
    PropertyDates,
    PropertyFees,
    Settings,
    Currency,
    Country
};
use Modules\Gateway\Entities\GatewayModule;

class BookingController extends Controller
{
    private $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }

    /**
     * Booking Details Show By Host
     * For request to book Accept & Decline
     *
    */
    public function index(Request $request)
    {
        $data['title']      = 'Booking Details';
        $data['booking_id'] = $request->id;
        $data['result']     = Bookings::find($request->id);

        if (! $data['result'] ) {

            abort('404');
            
        } elseif($data['result']->host_id != Auth::user()->id) {

            Common::one_time_message('error', __('You\'re not the host, so looks like you don’t have the keys to this property!'));
            return redirect('my-bookings');

        }
        $data['price_list']         = json_decode(Common::getPrice($data['result']->property_id, $data['result']->start_date, $data['result']->end_date, $data['result']->guest, true));
        $data['symbol'] = Common::getCurrentCurrencySymbol();

        return view('booking.detail', $data);
    }


    /**
     * Request to Book
     * From email link redirect to payment page
     *
    */
    public function requestPayment(Request $request){

        $data['gateways'] = (new GatewayModule)->payableGateways();

        $data['booking_id']    = $request->id;

        $booking                  = Bookings::find($request->id);

        $data['result']           = Properties::find($booking->property_id);
        $data['property_id']      = $booking->property_id;
        $data['number_of_guests'] = $booking->guest;
        $data['booking_type']     = $booking->booking_type;
        $data['checkin']          = setDateForDb($booking->start_date);
        $data['checkout']         = setDateForDb($booking->end_date);
        $data['status']           = $booking->status;
        $data['booking_id']       = $request->id;
        $data['banks'] = Bank::getAll()->where('status', 'Active')->count();

        Session::put('payment_property_id', $booking->property_id);
        Session::put('payment_checkin', $booking->start_date);
        Session::put('payment_checkout', $booking->end_date);
        Session::put('payment_number_of_guests',  $booking->guest);
        Session::put('payment_booking_type', $booking->booking_type);
        Session::put('payment_booking_status', $booking->status);
        Session::put('payment_booking_id', $request->id);

        $from                     = new DateTime(setDateForDb($booking->start_date));
        $to                       = new DateTime(setDateForDb($booking->end_date));
        $data['nights']           = $to->diff($from)->format("%a");
        $travel_credit            = 0;
        $data['price_list']       = json_decode(Common::getPrice($data['property_id'], $data['checkin'], $data['checkout'], $data['number_of_guests']));
        Session::put('payment_price_list', $data['price_list']);

        if (((isset($data['price_list']->status) && ! empty($data['price_list']->status)) ? $data['price_list']->status : '') == 'Not available') {
            Common::one_time_message('success', __('Porperty does not available'));
            Session::forget('payment_property_id');
            Session::forget('payment_checkin');
            Session::forget('payment_checkout');
            Session::forget('payment_number_of_guests');
            Session::forget('payment_booking_type');
            Session::forget('payment_booking_status');
            Session::forget('payment_booking_id');

            return redirect('trips/active');
        }

        $data['currencyDefault']  = $currencyDefault = Currency::where('default', 1)
                                    ->first();
        $data['currentCurrency'] = Common::getCurrentCurrency();
        $data['price_eur']        = Common::convert_currency($data['result']->property_price->code, $currencyDefault->code, $data['price_list']->total);
        $data['price_rate']       = Common::currency_rate($data['result']->property_price->currency_code, $data['currentCurrency']->code);
        $data['country']          = Country::all()->pluck('name', 'short_name');
        $data['title']            = 'Pay for your reservation';
        return view('payment.payment', $data);
    }


    /**
     * Booking Complete redirect here
     *
    */
    public function requested(Request $request)
    {
        $data['booking_details'] = Bookings::with('currency')->where('code', $request->code)->first();
        if ($data['booking_details']->status == 'Pending') {
            $data['title'] = __('Requested Booking');
        }
        $data['price_list'] = json_decode(Common::getPrice($data['booking_details']->property_id, $data['booking_details']->start_date, $data['booking_details']->end_date, $data['booking_details']->guest, true));
        $data['symbol'] = Common::getCurrentCurrencySymbol();

        return view('booking.requested', $data);
    }


    /**
     *  Requst to Booking accept
     *
    */
    public function accept(Request $request, EmailController $email)
    {
        $booking = Bookings::find($request->id);

        $penalty = Penalty::where('user_id', Auth::user()->id)->where('remaining_penalty', '!=', 0)->get();
        $penalty_result = Common::host_penalty_check($penalty, $booking->host_payout, $booking->currency_code);

        $booking->status            = 'Processing';
        $booking->accepted_at       = date('Y-m-d H:i:s');
        $booking->save();

        $payouts = new Payouts;
        $payouts->booking_id     = $request->id;
        $payouts->property_id    = $booking->property_id;
        $payouts->user_id        = $booking->host_id;
        $payouts->user_type      = 'host';
        $payouts->amount         = $penalty_result['host_amount'];
        $payouts->penalty_amount = $penalty_result['penalty_total'];
        $payouts->currency_code  = $booking->currency_code;
        $payouts->status         = 'Future';
        $payouts->save();

        $panalty_ids = explode(',', $penalty_result['penalty_ids']);
        $panalty_amounts = explode(',', $penalty_result['panalty_amounts']);

        for ($i=0; $i < count($panalty_ids); $i++) {
            if ($panalty_ids[$i] != '' && $panalty_amounts[$i] != '') {
                $payout_penalties = new PayoutPenalties;
                $payout_penalties->payout_id  = $payouts->id;
                $payout_penalties->penalty_id = $panalty_ids[$i];
                $payout_penalties->amount     = $panalty_amounts[$i];
                $payout_penalties->save();
            }
        }

        if (!empty($request->message)) {
            $messages = new Messages;
            $messages->property_id    = $booking->property_id;
            $messages->booking_id     = $booking->id;
            $messages->receiver_id    = $booking->user_id;
            $messages->sender_id      = Auth::user()->id;
            $messages->message        = $request->message;
            $messages->type_id        = 5;
            $messages->save();
        }

        $status = 'Processing';
        $errorMessage = '';
        try {
            $email->bookingAcceptedOrDeclined($request->id, $status);
        } catch (\Exception $e) {
           $errorMessage = ' Email was not sent due to'.' '.$e->getMessage();
        }


        $companyName = Settings::getAll()->where('type', 'general')->where('name', 'name')->first()->value;
        $requestBookingConfirm = ($companyName.': ' .'Your booking request for'.' '.$booking->properties->name .' '.'is Accepted, Please Payment for booking.');

        twilioSendSms($booking->users->formatted_phone, $requestBookingConfirm);

        Common::one_time_message('success', __('Booking Request has been Accepted').'.'.$errorMessage);
        return redirect('my-bookings');
    }

    /**
     *  Requst to Booking decline
     *
    */
    public function decline(Request $request, EmailController $email)
    {

        $booking                  = Bookings::find($request->id);
        $booking->status          = 'Declined';
        $booking->declined_at     = date('Y-m-d H:i:s');
        $booking->save();

        $booking_details             = new BookingDetails;
        $booking_details->booking_id = $request->id;
        $booking_details->field      = 'decline_reason';
        $booking_details->value      = ($request->decline_reason == 'other') ? $request->decline_reason_other : $request->decline_reason;
        $booking_details->save();

        $payouts                 = new Payouts;
        $payouts->booking_id     = $request->id;
        $payouts->property_id    = $booking->property_id;
        $payouts->user_id        = $booking->user_id;
        $payouts->user_type      = 'guest';
        $payouts->amount         = $booking->original_guest_payout;
        $payouts->penalty_amount = 0;
        $payouts->currency_code  = $booking->currency_code;
        $payouts->status         = 'Future';
        $payouts->save();

        if ($request->block_calendar == 'yes') {
            $days = Common::get_days($booking->start_date, $booking->end_date);

            for ($i=0; $i<count($days)-1; $i++) {
                $property_date = [
                                'property_id' => $booking->property_id,
                                'date'        => $days[$i],
                                'status'      => 'Not available'
                                ];

                PropertyDates::updateOrCreate(['property_id' => $booking->property_id, 'date' => $days[$i]], $property_date);
            }
        } else {
            $days = Common::get_days($booking->start_date, $booking->end_date);

            for ($i=0; $i<count($days)-1; $i++) {
                $property_date = [
                                'property_id' => $booking->property_id,
                                'date'        => $days[$i],
                                'status'  => 'Available'
                                ];

                PropertyDates::updateOrCreate(['property_id' => $booking->property_id, 'date' => $days[$i]], $property_date);
            }
        }

        if (!empty($request->message)) {
            $messages = new Messages;
            $messages->property_id    = $booking->property_id;
            $messages->booking_id     = $booking->id;
            $messages->receiver_id    = $booking->user_id;
            $messages->sender_id      = Auth::user()->id;
            $messages->message        = $request->message;
            $messages->type_id        = 6;
            $messages->save();
        }

        $status = 'Declined';
        $errorMessage = '';
        try {
            $email->bookingAcceptedOrDeclined($request->id, $status);
        } catch (\Exception $e) {
            $errorMessage = ' Email was not sent due to'.' '.$e->getMessage();
        }

        $companyName = Settings::getAll()->where('type', 'general')->where('name', 'name')->first()->value;
        $requestBookingDecline = ($companyName.': ' .'Your booking request for'.' '.$booking->properties->name .' '.'is Declined.');
        twilioSendSms($booking->users->formatted_phone, $requestBookingDecline);
        clearCache('.calc.property_price');
        Common::one_time_message('success', __('Booking Request has been Declined').'.'.$errorMessage);
        return redirect('my-bookings');
    }

    public function expire(Request $request)
    {

        $booking = Bookings::find($request->id);

        $fees = PropertyFees::pluck('value', 'field');

        $host_penalty     = $fees['host_penalty'];
        $currency         = $fees['currency'];
        $more_then_seven  = $fees['more_then_seven'];
        $less_then_seven  = $fees['less_then_seven'];
        $cancel_limit     = $fees['cancel_limit'];

        if (Session::get('currency')) {
            $code =  Session::get('currency');
        } else {
            $code = DB::table('currency')->where('default', 1)->first()->code;
        }

        if ($host_penalty != 0) {
            $penalty                  = new Penalty;
            $penalty->property_id     = $booking->property_id;
            $penalty->user_id         = $booking->user_id;
            $penalty->booking_id      = $request->id;
            $penalty->currency_code   = $booking->currency_code;
            $penalty->amount          = Common::convert_currency($penalty_currency, $code, $penalty_before_days);
            $penalty->remain_amount   = $penalty->amount;
            $penalty->status          = "Pending";
            $penalty->save();
        }

        $to_time   = strtotime($booking->created_at);
        $from_time = strtotime(date('Y-m-d H:i:s'));
        $diff_mins = round(abs($to_time - $from_time) / 60, 2);

        if ($diff_mins >= 1440) {
            $booking->status       = 'Expired';
            $booking->expired_at   = date('Y-m-d H:i:s');
            $booking->save();

            $days = Common::get_days($booking->start_date, $booking->end_date);
            for ($j=0; $j<count($days)-1; $j++) {
                PropertyDates::where('property_id', $booking->property_id)->where('date', $days[$j])->where('status', 'Not available')->delete();
            }

            $payouts = new Payouts;
            $payouts->booking_id     = $request->id;
            $payouts->property_id    = $booking->property_id;
            $payouts->user_id        = $booking->user_id;
            $payouts->user_type      = 'guest';
            $payouts->amount         = $booking->original_guest_payout;
            $payouts->penalty_amount = 0;
            $payouts->currency_code  = $booking->currency_code;
            $payouts->status         = 'Future';
            $payouts->save();

            $messages = new Messages;
            $messages->property_id    = $booking->property_id;
            $messages->booking_id     = $booking->id;
            $messages->receiver_id    = $booking->user_id;
            $messages->sender_id      = Auth::user()->id;
            $messages->message        = '';
            $messages->type_id        = 7;
            $messages->save();

            Common::one_time_message('success', __('Booking Request has been Expired'));
            clearCache('.calc.property_price');
            return redirect('booking/'.$request->id);
        } else {
            Common::one_time_message('error', __('Booking request has been Expired'));
            return redirect('booking/'.$request->id);
        }
    }

    /**
     * User Booking List
     * User Booking Sort
     *
    */

    public function myBookings(Request $request)
    {
        switch ($request->status) {
            case 'Expired':
                $params  = [['created_at', '<', Carbon::yesterday()], ['status', '!=', 'Accepted']];
                break;
            case 'Current':
                $params  = [['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')],['status', 'Accepted']];
                break;
            case 'Upcoming':
                $params  = [['start_date', '>', date('Y-m-d')], ['status', 'Accepted']];
                break;
            case 'Completed':
                $params  = [['end_date', '<', date('Y-m-d')],['status', 'Accepted']];
                break;
            case 'Pending':
                $params           = [['created_at', '>', Carbon::yesterday()], ['status', $request->status]];
                break;
            case 'Declined':
                $params           = [['status', 'Declined']];
                break;
            default:
                $params           = [];
                break;
        }
        $data['yesterday'] = Carbon::yesterday();
        $data['status']  = $request->status;
        $data['title']   = "Bookings";
        $data['bookings'] = Bookings::with(['users','properties'])
            ->where('host_id', Auth::user()->id)
            ->where($params)->orderBy('id', 'desc')
            ->paginate(Session::get('row_per_page'));

        return view('booking.my_bookings', $data);
    }

    public function hostCancel(Request $request, EmailController $email)
    {
        $bookings    = Bookings::find($request->id);
        $now         = new DateTime();
        $booking_end = new DateTime($bookings->end_date);

        if ($now < $booking_end) {

            $properties = Properties::find($bookings->property_id);
            $payount    = Payouts::where(['user_id'=>$bookings->host_id,'booking_id'=> $request->id])->first();

            if (isset($payount->id)) {
                $payout_penalties = PayoutPenalties::where('payout_id', $payount->id)->get();
                if (!empty($payout_penalties)) {
                    foreach ($payout_penalties as $key => $payout_penalty) {
                        $prv_penalty = Penalty::where('id', $payout_penalty->penalty_id)->first();
                        $update_amount = $prv_penalty->remaining_penalty+$payout_penalty->amount;
                        Penalty::where('id', $payout_penalty->penalty_id)->update(['remaining_penalty' => $update_amount, 'status' => 'Pending']);
                    }
                }
            }

            $payouts = new Payouts;
            $payouts->booking_id     = $request->id;
            $payouts->property_id    = $bookings->property_id;
            $payouts->user_id        = $bookings->user_id;
            $payouts->user_type      = 'guest';
            $payouts->amount         = $bookings->original_total;
            $payouts->currency_code  = $bookings->currency_code;
            $payouts->penalty_amount = 0;
            $payouts->status         = 'Future';
            $payouts->save();



            if ($bookings->booking_type != 'instant' || $request->cancel_reason != 'i_am_uncomfortable_with_guest') {
                $start_date = new DateTime($bookings->start_date);
                $panalty_date = new DateTime(date('Y-m-d H:i:s', strtotime('-7 days')));
                $fees = PropertyFees::pluck('value', 'field')->toArray();
                if ($start_date >= $panalty_date) {
                  //more then 7 days
                    $panalty = new Penalty;
                    $panalty->booking_id        = $request->id;
                    $panalty->property_id       = $bookings->property_id;
                    $panalty->user_id           = Auth::user()->id;
                    $panalty->user_type         = 'Host';
                    $panalty->currency_code     = $bookings->currency_code;
                    $panalty->amount            = $fees['more_then_seven'];
                    $panalty->remaining_penalty = $fees['more_then_seven'];
                    $panalty->reason            = 'cancelation';
                    $panalty->save();
                } else {
                  //less then 7 days
                    $panalty = new Penalty;
                    $panalty->booking_id        = $request->id;
                    $panalty->property_id       = $bookings->property_id;
                    $panalty->user_id           = Auth::user()->id;
                    $panalty->user_type         = 'Host';
                    $panalty->currency_code     = $bookings->currency_code;
                    $panalty->amount            = $fees['less_then_seven'];
                    $panalty->remaining_penalty = $fees['less_then_seven'];
                    $panalty->reason            = 'cancelation';
                    $panalty->save();
                }
            } else {
                $days = Common::get_days($bookings->start_date, $bookings->end_date);

                for ($j=0; $j<count($days)-1; $j++) {
                    PropertyDates::where('property_id', $bookings->property_id)->where('date', $days[$j])->where('status', 'Not available')->delete();
                }
            }

            Payouts::where(['user_id'=>$bookings->host_id,'booking_id'=> $request->id])->delete();

            $messages                 = new Messages;
            $messages->property_id    = $bookings->property_id;
            $messages->booking_id     = $bookings->id;
            $messages->receiver_id    = $bookings->user_id;
            $messages->sender_id      = Auth::user()->id;
            $messages->message        = $request->cancel_message;
            $messages->type_id        = 3;
            $messages->save();

            $cancel = Bookings::find($request->id);
            $cancel->cancelled_by = "Host";
            $cancel->cancelled_at = date('Y-m-d H:i:s');
            $cancel->status = "Cancelled";
            $cancel->save();

            $booking_details = new BookingDetails;
            $booking_details->booking_id = $request->id;
            $booking_details->field      = 'cancelled_reason';
            $booking_details->value      = $request->cancel_reason;
            $booking_details->save();
            $email->bookingCancellation($request->id);
            Common::one_time_message('success', __('Reservation cancelled successfully'));
            clearCache('.calc.property_price');
            return redirect('my-bookings');
        } else {
            Common::one_time_message('danger', __('You cant cancel booking now'));
            return redirect('my-bookings');
        }
    }
}
