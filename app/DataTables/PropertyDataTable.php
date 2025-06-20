<?php

namespace App\DataTables;

use App\Models\Properties;
use Yajra\DataTables\Services\DataTable;
use Request, Common;

class PropertyDataTable extends DataTable
{
    public function ajax()
    {
        $properties = $this->query();

        return datatables()
            ->of($properties)
            ->addColumn('action', function ($properties) {
                $edit = $delete = '';
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_properties')) {
                    $edit = '<a href="' . url('admin/listing/' . $properties->id) . '/basics" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                }
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'delete_property')) {
                    $delete = '<a href="' . url('admin/delete-property/' . $properties->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                }
                return $edit . $delete;
            })
            ->addColumn('id', function ($properties) {
                return $properties->id;
            })
            ->addColumn('host_name', function ($properties) {
                return '<a href="' . url('admin/edit-customer/' . optional($properties->users)->id) . '">' . ucfirst(optional($properties->users)->first_name) . '</a>';
            })
            ->addColumn('name', function ($properties) {
                return '<a href="' . url('admin/listing/' . $properties->id . '/basics') . '">' . ucfirst($properties->name) . '</a>';
            })
            ->addColumn('created_at', function ($properties) {
                return dateFormat($properties->created_at);
            })
            ->addColumn('recomended', function ($properties) {

                if ($properties->recomended == 1) {
                    return 'Yes';
                }
                return 'No';

            })
            ->addColumn('verified', function ($properties) {

                return ($properties->is_verified == 'Approved' || $properties->is_verified == '') ? 'Approved' : 'Pending';

            })
            ->rawColumns(['host_name', 'name', 'action'])
            ->make(true);
    }

    public function query()
    {
        $user_id    = Request::segment(4);
        $status     = isset(request()->status) ? request()->status : null;
        $from = isset(request()->from) ? setDateForDb(request()->from) : null;
        $to = isset(request()->to) ? setDateForDb(request()->to) : null;
        $space_type = isset(request()->space_type) ? request()->space_type : null;

        $query = Properties::with(['users:id,first_name,profile_image']);
        if (isset($user_id)) {
            $query->where('host_id', '=', $user_id);
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
        if ($space_type) {
            $query->where('space_type', '=', $space_type);
        }
        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'properties.id', 'title' => 'Id'])
            ->addColumn(['data' => 'name', 'name' => 'properties.name', 'title' => 'Name'])
            ->addColumn(['data' => 'host_name', 'name' => 'users.first_name', 'title' => 'Host Name'])
            ->addColumn(['data' => 'space_type_name', 'name' => 'space_type', 'title' => 'Space Type'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'Status'])
            ->addColumn(['data' => 'recomended', 'name' => 'recomended', 'title' => 'Recomended'])
            ->addColumn(['data' => 'verified', 'name' => 'verified', 'title' => 'Verified'])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => 'Date'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }


    protected function filename()
    {
        return 'propertydatatables_' . time();
    }
}
