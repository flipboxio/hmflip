<?php

/**
 * Bank Data Table
 *
 * Bank Data Table handles Bank datas.
 *
 * @category   BankDataTable
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    3.3
 * @link       http://techvill.net
 * @since      Version 3.3
 * @deprecated None
 */

namespace App\DataTables;

use App\Models\Bank;
use Yajra\DataTables\Services\DataTable;

class BankDataTable extends DataTable
{
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('iban', function ($bank) {
                return '*****'. substr($bank->iban,-7);
            })
            ->addColumn('status', function ($bank) {
                $status = $bank->status == 'Active' ? 'success' : 'danger' ;
                return $bank->status;
            })
            ->addColumn('action', function ($bank) {

                $edit   = '<button data-url="' . url('admin/settings/bank/' . $bank->id) . '" data-edit="'.url('admin/settings/bank/edit/' . $bank->id).'" class="btn btn-xs btn-primary edit_bank" data-bs-toggle="modal" data-bs-target="#edit_modal"><i class="fa fa-edit edit-icon"></i></button>&nbsp;';
                $delete = '<a href="' . url('admin/settings/bank/delete/' . $bank->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';

                return $edit . ' ' . $delete;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function query()
    {
        $query = Bank::query();

        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'account_name', 'name' =>'banks.account_name', 'title' => 'Name'])
            ->addColumn(['data' => 'iban', 'name' =>'banks.iban', 'title' => 'Iban'])
            ->addColumn(['data' => 'bank_name', 'name' =>'banks.bank_name', 'title' => 'Bank'])
            ->addColumn(['data' => 'status', 'name' =>'banks.status', 'title' => 'Status'])
            ->addColumn(['data' => 'action', 'name' =>'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }


    protected function filename()
    {
        return 'banksdatatables_' . time();
    }
}
