<?php

/**
 * AmenityTypeDataTable Data Table
 *
 * AmenityTypeDataTable Data Table handles AmenityTypeDataTable datas.
 *
 * @category   AmenityTypeDataTable
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    2.7
 * @link       http://techvill.net
 * @since      Version 1.3
 * @deprecated None
 */

namespace App\DataTables;

use App\Models\AmenityType;
use Yajra\DataTables\Services\DataTable;

class AmenityTypeDataTable extends DataTable
{
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', function ($amenityType) {

                $edit   = '<a href="' . url('admin/settings/edit-amenities-type/' . $amenityType->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                $delete = '<a href="' . url('admin/settings/delete-amenities-type/' . $amenityType->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';

                return $edit . ' ' . $delete;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function query()
    {
        $query = AmenityType::select();

        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'name', 'name' =>'amenity_type.name', 'title' => 'Name'])
            ->addColumn(['data' => 'description', 'name' =>'amenity_type.description', 'title' => 'Description'])
            ->addColumn(['data' => 'action', 'name' =>'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
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
        return 'amenitytypedatatables_' . time();
    }
}
