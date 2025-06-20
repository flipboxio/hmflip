<?php

/**
 * @package PaytrController
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammed Kamrul Hasan <[kamrul.techvill@gmail.com]>
 * @created 18-09-2024
 */

namespace Modules\Paytr\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{
    Bookings,
    Currency,
    PropertyDates,
    Wallet,
};
use DateTime, Common, DatePeriod, DateInterval;
use Modules\Paytr\Http\Requests\PaytrRequest;
use Modules\Addons\Entities\Addon;
use Modules\Paytr\Entities\{
    Paytr,
    PaytrBody
};

class PaytrController extends Controller
{
    /**
     * Returns form for the edit modal
     *
     * @param \Illuminate\Http\Request
     *
     * @return JsonResponse
     */
    public function edit(Request $request)
    {
        try {
            $module = Paytr::first()->data;
        } catch (\Exception $e) {
            $module = null;
        }

        $addon = Addon::findOrFail('paytr');

        return response()->json(
            [
                'html' => view('gateway::partial.form', compact('module', 'addon'))->render(),
                'status' => true
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PaytrRequest $request
     *
     * @return mixed
     */
    public function store(PaytrRequest $request)
    {
        $paytrBody = new PaytrBody($request);
        Paytr::updateOrCreate(
            ['alias' => 'paytr'],
            [
                'name' => $request->name,
                'instruction' => $request->instruction,
                'status' => $request->status,
                'sandbox' => $request->sandbox,
                'image' => 'thumbnail.png',
                'data' => json_encode($paytrBody)
            ]
        );

        return back()->with(['AddonStatus' => 'success', 'AddonMessage' => __('Paytr settings updated.')]);
    }

    public function paytrCallback(Request $request)
    {
        // Retrieve Paytr configuration
        $paytr = Paytr::firstWhere('alias', config('paytr.alias'))->data;

        // Generate and verify hash
        $hash = base64_encode(
            hash_hmac('sha256', $request->merchant_oid . $paytr->merchant_salt . $request->status . $request->total_amount, $paytr->merchant_key, true)
        );

        if ($hash !== $request->hash) {
            die(__('PAYTR notification failed: bad hash'));
        }

        if ($request->status !== 'success') {
            // Handle failed payment
            $existBooking = Bookings::where('transaction_id', $request->merchant_oid)
                ->where('status', 'Accepted')
                ->first();

            if ($existBooking) {
                // Update booking status to 'Cancelled'
                $existBooking->update(['status' => 'Cancelled']);

                $propertyId = $existBooking->property_id;
                $dates = $this->getAvailableDates($existBooking->start_date, $existBooking->end_date);

                if (!empty($dates)) {
                    // Update PropertyDates status to 'Available'
                    PropertyDates::where('property_id', $propertyId)
                        ->whereIn('date', $dates)
                        ->update(['status' => 'Available']);
                }

                // Update wallet balance
                $walletBalance = Wallet::where('user_id', $existBooking->host_id)->first();
                $defaultCode = Currency::getAll()->firstWhere('default', 1)->code;
                $walletCode = Currency::getAll()->firstWhere('id', $walletBalance->currency_id)->code;

                $balance = $walletBalance->balance
                    - Common::convert_currency($defaultCode, $walletCode, $existBooking->total)
                    - Common::convert_currency($defaultCode, $walletCode, $existBooking->service_charge)
                    - Common::convert_currency($defaultCode, $walletCode, $existBooking->accomodation_tax)
                    - Common::convert_currency($defaultCode, $walletCode, $existBooking->iva_tax);

                Wallet::where('user_id', $existBooking->host_id)
                    ->update(['balance' => $balance]);
            }

            die(__('Response Code') . ':' . $request->failed_reason_code . ' - ' . $request->failed_reason_msg);
        }

        echo "OK";
        exit;
    }

    /**
     * Get available dates between start and end date, excluding dates in the past.
     *
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    private function getAvailableDates($startDate, $endDate)
    {
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $interval = new DateInterval('P1D');
        $dateRange = new DatePeriod($start, $interval, $end);

        $dates = [];
        foreach ($dateRange as $date) {
            if ($date->format('Y-m-d') >= date("Y-m-d")) {
                $dates[] = $date->format('Y-m-d');
            }
        }

        if ($end->format('Y-m-d') >= date("Y-m-d") && !in_array($end->format('Y-m-d'), $dates) && count($dates) == 0) {
            $dates[] = $end->format('Y-m-d');
        }

        return $dates;
    }

}
