<?php

namespace App\DataTables;

use App\Models\SpaceType;
use Yajra\DataTables\Services\DataTable;

class SpaceTypeDataTable extends DataTable
{
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', function ($spaceType) {

                $edit = '<a href="' . url('admin/settings/edit-space-type/' . $spaceType->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                $delete = '<a href="' . url('admin/settings/delete-space-type/' . $spaceType->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';

                return $edit . ' ' . $delete;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function query()
    {
        $query = SpaceType::query();
        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'name', 'name' => 'space_type.name', 'title' => 'Name'])
            ->addColumn(['data' => 'description', 'name' => 'space_type.description', 'title' => 'Description'])
            ->addColumn(['data' => 'status', 'name' => 'space_type.status', 'title' => 'Status'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }

    protected function filename()
    {
        return 'spacetypedatatables_' . time();
    }
}
