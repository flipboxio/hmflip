<?php

namespace App\DataTables;

use App\Models\Withdrawal;
use Yajra\DataTables\Services\DataTable;
use Auth, Session;

class PayoutListDataTable extends DataTable
{
    public function ajax()
    {
        $payout = $this->query();

        return datatables()
            ->of($payout)

            ->addColumn('user_name', function ($payout) {
                return $payout->user?->first_name . ' ' . $payout->user?->last_name;
                 
            })
            ->addColumn('p_method', function ($payout) {

                return __($payout->payment_methods?->name);
            })
            ->addColumn('amount', function ($payout) {

                return Session::get('symbol') . currency_fix(($payout->status == 'Success' ? $payout->amount : $payout->subtotal), $payout->currency?->code) ;
            })
            ->addColumn('status', function ($payout) {
                return __($payout->status);
            })
            ->addColumn('date', function ($payout) {
                return dateFormat($payout->created_at);
            })

            ->rawColumns(['status','amount'])
            ->make(true);

    }

    public function query()
    {
        $from     = isset(request()->from) ? setDateForDb(request()->from) : null;
        $to       = isset(request()->to) ? setDateForDb(request()->to) : null;
    
        $query = Withdrawal::with('user', 'currency', 'payment_methods')->where('user_id', Auth::id());
       

        if (!empty($from)) {
            $query->whereDate('withdrawals.created_at', '>=', $from);
        }

        if (!empty($to)) {
            $query->whereDate('withdrawals.created_at', '<=', $to);
        }

        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'ID', 'visible' => false])
             ->addColumn(['data' => 'user_name', 'name' => 'user.first_name', 'title' => __('Account')])
             ->addColumn(['data' => 'p_method', 'name' => 'payment_methods.name', 'title' => __('Payment Method')])
             ->addColumn(['data' => 'amount', 'name' => 'amount', 'title' => __('Amount')])
             ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status')])
             ->addColumn(['data' => 'date', 'name' => 'created_at', 'title' => __('Date')])
             ->parameters(dataTableOptions());
    }


    protected function filename()
    {
        return 'payoutsettingsdatatables_' . time();
    }
}
