<?php

/**
 * AmenitiesData Data Table
 *
 * AmenitiesData Data Table handles AmenitiesData datas.
 *
 * @category   AmenitiesData
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

use App\Models\Amenities;
use Yajra\DataTables\Services\DataTable;

class AmenitiesDataTable extends DataTable
{
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('type_id', function ($amenity) {

                return optional($amenity->amenityType)->name;
            })
            ->addColumn('action', function ($amenity) {

                $edit = '<a href="' . url('admin/edit-amenities/' . $amenity->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                $delete = '<a href="' . url('admin/delete-amenities/' . $amenity->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                return $edit . ' ' . $delete;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function query()
    {
        $query = Amenities::with('amenityType')->select();
        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'title', 'name' =>'amenities.title', 'title' => 'Name'])
            ->addColumn(['data' => 'description', 'name' =>'amenities.description', 'title' => 'Description'])
            ->addColumn(['data' => 'symbol', 'name' =>'amenities.symbol', 'title' => 'Symbol'])
            ->addColumn(['data' => 'type_id', 'name' =>'amenityType.name', 'title' => 'Type'])
            ->addColumn(['data' => 'status', 'name' =>'amenities.status', 'title' => 'Status'])
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
        return 'amenitiesdatatables_' . time();
    }
}
