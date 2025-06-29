<?php

namespace App\DataTables;

use App\Models\BedType;
use Yajra\DataTables\Services\DataTable;

class BedTypeDataTable extends DataTable
{
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())

            ->addColumn('status', function($bedType){
                return $bedType->status == null ? 'Active' : $bedType->status;
            })
            ->addColumn('action', function ($bedType) {

                $edit = '<a href="' . url('admin/settings/edit-bed-type/' . $bedType->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                $delete = '<a href="' . url('admin/settings/delete-bed-type/' . $bedType->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';

                return $edit . ' ' . $delete;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function query()
    {
        $query = BedType::query();

        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'name', 'name' => 'bed_type.name', 'title' => 'Name'])
            ->addColumn(['data' => 'status', 'name' => 'bed_type.status', 'title' => 'Status'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }

    protected function getColumns()
    {
        return [
            'id',
            'created_at',
            'updated_at',
        ];
    }

    protected function filename()
    {
        return 'spacetypedatatables_' . time();
    }
}
