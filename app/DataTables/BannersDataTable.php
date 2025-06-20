<?php

namespace App\DataTables;

use App\Models\Banners;
use Yajra\DataTables\Services\DataTable;

class BannersDataTable extends DataTable
{
    public function ajax()
    {
        $banners = $this->query();
        return datatables()
            ->of($banners)
            ->addColumn('image', function ($banners) {

                return '<img src="' . $banners->image_url . '" width="200" height="100">';
            })
            ->addColumn('default', function ($banners) {

                return $banners->default_banner ;
            })
            ->addColumn('action', function ($banners) {

                $edit = '<a href="' . url('admin/settings/edit-banners/' . $banners->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';

                if ($banners->default_banner == 'Yes') {
                    $delete = '';
                } else {
                    $delete = '<a href="' . url('admin/settings/delete-banners/' . $banners->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                }

                return $edit . ' ' . $delete;

            })
            ->rawColumns(['image','default_banner','action'])
            ->make(true);
    }


    public function query()
    {
        $banners = Banners::select();
        return $this->applyScopes($banners);
    }

    public function html()
    {
        return $this->builder()
        ->columns([
            'heading',
            'subheading',
            'image',
            'status',
            'default'

        ])
        ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
        ->parameters(dataTableOptions());
    }
}
