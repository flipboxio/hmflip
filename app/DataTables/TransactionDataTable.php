<?php
namespace App\DataTables;

use App\Models\{
    Withdrawal,
    Bookings
};
use Auth, DB, Session;
use Yajra\DataTables\Services\DataTable;

class TransactionDataTable extends DataTable
{
    public function ajax()
    {
        $transaction = $this->query();
        return datatables()
        ->of($transaction)

        ->addColumn('p_method', function ($transaction) {
            return __($transaction->p_method);
        })

        ->addColumn('date', function ($transaction) {
            return dateFormat($transaction->date);
        })

        ->addColumn('type', function ($transaction) {
            if ($transaction->type < 1) {
                return  $transaction->type < 0 ? __('Trip')  : __('Withdrawn');
            }
            return __('Booking');
        })

        ->addColumn('amount', function ($transaction) {
            if ($transaction->type < 1) {
                return '<span class="text-danger">- ' . Session::get('symbol') . currency_fix($transaction->amount, $transaction->code) . '</span>';
            }
            return '<span class="text-success">+ ' . Session::get('symbol') . currency_fix($transaction->amount, $transaction->code) . '</span>';
        })

        ->addColumn('symbol', function ($transaction) {
            return $transaction->symbol;
        })

       ->rawColumns(['amount','type'])

        ->make(true);
    }

    public function query()
    {
        $user_id  = Auth::id();
        $from     = isset(request()->from) ? setDateForDb(request()->from) : null;
        $to       = isset(request()->to) ? setDateForDb(request()->to) : null;

        $withdrawals = Withdrawal::join('currency', function ($join) {
            $join->on('withdrawals.currency_id', '=', 'currency.id');
        })->join('payment_methods', function ($join) {
            $join->on('withdrawals.payment_method_id', '=', 'payment_methods.id');
        })->select(['withdrawals.id as id',  'withdrawals.amount as amount', 'withdrawals.currency_id AS c', 'currency.symbol AS symbol', 'currency.code AS code', 'payment_methods.name AS p_method', 'withdrawals.created_at AS date', DB::raw('0 as type')])->where('withdrawals.user_id', '=', $user_id)->where('withdrawals.status', '=', 'Success');


        if (!empty($from)) {
            $withdrawals->whereDate('withdrawals.created_at', '>=', $from);
        }

        if (!empty($to)) {
            $withdrawals->whereDate('withdrawals.created_at', '<=', $to);
        }

        $bookings = Bookings::join('currency', function ($join) {
            $join->on('bookings.currency_code', '=', 'currency.code');
        })->join('gateways', function ($join) {
            $join->on('bookings.payment_method_id', '=', 'gateways.id');
        })->select(['bookings.id as id', DB::raw('(bookings.total - bookings.service_charge -bookings.accomodation_tax - bookings.iva_tax) as amount'), 'bookings.currency_code AS c', 'currency.symbol AS symbol', 'currency.code AS code','gateways.name AS p_method', 'bookings.created_at AS date', DB::raw('1 as type')])->where('bookings.host_id', '=', $user_id)->where('bookings.status', '=', 'Accepted');

        if (!empty($from)) {
            $bookings->whereDate('bookings.created_at', '>=', $from);
        }

        if (!empty($to)) {
            $bookings->whereDate('bookings.created_at', '<=', $to);
        }

        $trips = Bookings::join('currency', function ($join) {
            $join->on('bookings.currency_code', '=', 'currency.code');
        })->join('gateways', function ($join) {
            $join->on('bookings.payment_method_id', '=', 'gateways.id');
        })->select(['bookings.id as id', 'bookings.total AS amount', 'bookings.currency_code AS c', 'currency.symbol AS symbol', 'currency.code AS code','gateways.name AS p_method', 'bookings.created_at AS date', DB::raw('-1 as type')])->where('bookings.user_id', '=', $user_id)->where('bookings.status', '=', 'Accepted');

        if (!empty($from)) {
            $trips->whereDate('bookings.created_at', '>=', $from);
        }

        if (!empty($to)) {
            $trips->whereDate('bookings.created_at', '<=', $to);
        }

        $query = $withdrawals->union($bookings)->union($trips)->orderBy('date', 'desc')->get();

        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
        ->addColumn(['data' => 'type', 'name' => 'type', 'title' => __('Type')])
        ->addColumn(['data' => 'p_method', 'name' => 'p_method', 'title' => __('Payment Method'), 'searchable' => true])
        ->addColumn(['data' => 'amount', 'name' => 'amount', 'title' => __('Amount')])
        ->addColumn(['data' => 'date', 'name' => 'date', 'title' => __('Date')])
        ->parameters(dataTableOptions());
    }


    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'transactiondatatables_' . time();

    }
}
