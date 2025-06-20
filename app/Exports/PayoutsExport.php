<?php

namespace App\Exports;

use App\Models\{ Payouts, Withdrawal};
use Maatwebsite\Excel\Concerns\{FromArray, WithHeadings, ShouldAutoSize};

class PayoutsExport implements FromArray,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $to                 = setDateForDb(request()->to);
        $from               = setDateForDb(request()->from);
        $status             = isset(request()->status) ? request()->status : null;
        $id                 = isset(request()->user_id) ? request()->user_id : null;

        $query = Withdrawal::orderBy('id', 'desc')->select();

        if (isset($id)) {
            $query->where('withdrawals.user_id', '=', $id);
        }
        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        if ($status) {
            $query->where('status', '=', $status);
        }


        $payoutsList = $query->get();
        $data = [];
        
        if ($payoutsList->count()) {
            foreach ($payoutsList as $key => $value) {
                $data[$key]['User']            = $value->user->full_name;
                $data[$key]['Payouts Account'] = $value->payment_methods->name;
                $data[$key]['Amount']          = $value->amount;
                $data[$key]['Status']          = $value->status;
                $data[$key]['Date']            = dateFormat($value->created_at);
            }
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'User',
            'Account',
            'Amount',
            'Status',
            'Date'
        ];
    }
}
