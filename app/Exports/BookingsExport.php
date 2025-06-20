<?php

namespace App\Exports;

use App\Http\Controllers\Admin\BookingsController;
use App\Models\Bookings;
use DB;
use Maatwebsite\Excel\Concerns\{FromArray, WithHeadings, ShouldAutoSize};

class BookingsExport implements FromArray,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $to                 = setDateForDb(request()->to);
        $from               = setDateForDb(request()->from);
        $status             = isset(request()->status) ? request()->status : null;
        $property           = isset(request()->property) ? request()->property : null;
        $id                 = isset(request()->user_id) ? request()->user_id : null;

        $bookings           = BookingsController::getAllBookingsCSV();

        if (isset($id)) {
            $bookings->where('bookings.user_id', '=', $id);
        }
        if ($from) {
            $bookings->whereDate('bookings.created_at', '>=', $from);
        }

        if ($to) {
            $bookings->whereDate('bookings.created_at', '<=', $to);
        }
        if ($property) {
            $bookings->where('bookings.property_id', '=', $property);
        }
        if ($status) {
            $bookings->where('bookings.status', '=', $status);
        }
        $bookingList = $bookings->get();
        $data = [];
        if ($bookingList->count()) {
            foreach ($bookingList as $key => $value) {
                    $data[$key]['Host Name']     = $value->host_name;
                    $data[$key]['Guest Name']    = $value->guest_name;
                    $data[$key]['Property Name'] = $value->property_name;
                    $data[$key]['Currency']      = $value->currency_name;
                    $data[$key]['Total Amount']  = $value->total_amount;
                    $data[$key]['Payouts'] = ($value->check_host_payout == "yes") ? "Yes" : "No";

                if ($value->status == 'Accepted') {
                    $status = 'Accepted';
                } elseif ($value->status == 'Pending') {
                    $status = 'Pending';
                } else {
                    if ($value->check_guest_payout == 'yes') {
                        $status = $value->status." (Refund)";
                    } else {
                        $status = $value->status;
                    }
                }
                    $data[$key]['Status']       = $status;
                    $data[$key]['Date']         = dateFormat($value->created_at);
            }
        }

        return $data;
    }


    public function headings(): array
    {
        return [
            'Host Name',
            'Guest Name',
            'Property Name',
            'Currency',
            'Total Amount',
            'Payouts',
            'Status',
            'Date',
        ];
    }
}
