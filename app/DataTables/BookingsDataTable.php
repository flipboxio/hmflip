<?php

namespace App\DataTables;

use App\Models\Bookings;
use Yajra\DataTables\Services\DataTable;
use Request;

class BookingsDataTable extends DataTable
{
    public function ajax()
    {
        $bookings = $this->query();
        
        return datatables()
            ->of($bookings)
            ->addColumn('host_name', function ($bookings) {
                return '<a href="' . url('admin/edit-customer/' . $bookings->host_id) . '">' . ucfirst($bookings->host_name) . '</a>';
            })
            ->addColumn('guest_name', function ($bookings) {
                return '<a href="' . url('admin/edit-customer/' . $bookings->user_id) . '">' . ucfirst($bookings->guest_name) . '</a>';
            })
            ->addColumn('total_amount', function ($bookings) {
                return moneyFormat($bookings->symbol, $bookings->total_amount);
            })
            ->addColumn('property_name', function ($bookings) {
                return '<a href="' . url('admin/listing/' . $bookings->property_id . '/basics') . '">' . ucfirst($bookings->property_name) . '</a>';
            })
            ->addColumn('method', function ($bookings) {
                return optional($bookings->payment_methods)->name ?? '-';
            })
            ->addColumn('created_at', function ($bookings) {
                return dateFormat($bookings->created_at);
            })
            ->addColumn('status', function ($bookings) {
                $status = $bookings->status;
                if (!$status == 'Accepted' && !$status == 'Pending') {
                    if ($bookings->check_guest_payout == 'yes') {
                        $status = $bookings->status . "<br/><span class='label label-info'>Refund</span>";
                    }
                }
                return $status ;
            })
            ->addColumn('action', function ($bookings) {
                return '<a href="' . url('admin/bookings/detail/' . $bookings->id) . '" class="btn btn-xs btn-primary" title="Detail View"><i class="fa fa-share"></i></a>&nbsp;';
            })
            ->rawColumns(['host_name', 'guest_name', 'total_amount', 'property_name', 'action'])
            ->make(true);
    }

    public function query()
    {
        $user_id = Request::segment(4);
        $status = isset(request()->status) ? request()->status : null;
        $from = isset(request()->from) ? setDateForDb(request()->from) : null;
        $to = isset(request()->to) ? setDateForDb(request()->to) : null;
        $property = isset(request()->property) ? request()->property : null;
        $customer = isset(request()->customer) ? request()->customer : null;
        
        $bookings = Bookings::join('properties', function ($join) {
            $join->on('properties.id', '=', 'bookings.property_id');
        })
            ->join('users', function ($join) {
                $join->on('users.id', '=', 'bookings.user_id');
            })
            ->join('currency', function ($join) {
                $join->on('currency.code', '=', 'bookings.currency_code');
            })
            ->Join('users as u', function ($join) {
                $join->on('u.id', '=', 'bookings.host_id');
            })
            ->select(['bookings.id as id', 'u.first_name as host_name', 'users.first_name as guest_name', 'bookings.property_id as property_id', 'properties.name as property_name','bookings.total AS total_amount','bookings.payment_method_id','bookings.payment_method_id', 'bookings.status', 'bookings.created_at as created_at', 'bookings.updated_at as updated_at', 'bookings.start_date', 'bookings.end_date', 'bookings.guest', 'u.id as host_id', 'users.id as user_id', 'bookings.total', 'bookings.currency_code','currency.symbol','bookings.service_charge','bookings.host_fee', 'bookings.iva_tax', 'bookings.accomodation_tax']);
  
        if (isset($user_id)) {
            $bookings->where('bookings.user_id', '=', $user_id);
        }
        if (!empty($from)) {
            $bookings->whereDate('bookings.created_at', '>=', $from);
        }
        if (!empty($to)) {
            $bookings->whereDate('bookings.created_at', '<=', $to);
        }
        if (!empty($property)) {
            $bookings->where('bookings.property_id', '=', $property);
        }
        if (!empty($customer)) {
            $bookings->where('bookings.user_id', '=', $customer);
        }
        if (!empty($status)) {
            $bookings->where('bookings.status', '=', $status);
        }
        return $this->applyScopes($bookings);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'bookings.id', 'title' => 'ID', 'visible' => false])
            ->addColumn(['data' => 'host_name', 'name' => 'u.first_name', 'title' => 'Host Name'])
            ->addColumn(['data' => 'guest_name', 'name' => 'users.first_name', 'title' => 'Guest Name'])
            ->addColumn(['data' => 'property_name', 'name' => 'properties.name', 'title' => 'Property Name'])
            ->addColumn(['data' => 'method', 'name' => 'payment_methods.name', 'title' => 'Payment Method','orderable' => false, 'searchable' => false])
            ->addColumn(['data' => 'total_amount', 'name' => 'bookings.total', 'title' => 'Total Amount'])
            ->addColumn(['data' => 'status', 'name' => 'bookings.status', 'title' => 'Status'])
            ->addColumn(['data' => 'created_at', 'name' => 'bookings.created_at', 'title' => 'Date'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }


    protected function filename()
    {
        return 'bookingsdatatables_' . time();
    }
}
