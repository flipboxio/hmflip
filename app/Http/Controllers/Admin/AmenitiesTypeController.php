<?php

/**
 * AmenitiesType Controller
 *
 * AmenitiesType Controller manages Amenity types added by admin.
 *
 * @category   AmenitiesType
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    2.7
 * @link       http://techvill.net
 * @since      Version 1.3
 * @deprecated None
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\AmenityTypeDataTable;
use App\Models\AmenityType;
use Validator,Common;

class AmenitiesTypeController extends Controller
{

    public function index(AmenityTypeDataTable $dataTable)
    {
        return $dataTable->render('admin.amenityTypes.view');
    }

    public function add(Request $request)
    {
        
        $info = $request->isMethod('post');
        if (! $info) {
             return view('admin.amenityTypes.add');
        } elseif ($info) {
            $rules = array(
                    'name'           => 'required|max:50',
                    'description'    => 'required|max:100'
                    );

            $fieldNames = array(
                        'name'              => 'Name',
                        'description'       => 'Description'
                        );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $amenityType = new AmenityType;
                $amenityType->name           = $request->name;
                $amenityType->description    = $request->description;
                $amenityType->save();

                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/settings/amenities-type');
            }
        }
    }
    public function update(Request $request)
    {
        $info = $request->isMethod('post');
        if (! $info) {
             $data['result'] = AmenityType::find($request->id);

            return view('admin.amenityTypes.edit', $data);
        } elseif ($info) {
            $rules = array(
                    'name'         => 'required|max:50',
                    'description'  => 'required|max:100'
                    );

            $fieldNames = array(
                        'name'            => 'Name',
                        'description'     => 'Description'
                        );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $amenityType = AmenityType::find($request->id);
                 $amenityType->name           = $request->name;
                 $amenityType->description    = $request->description;
                 $amenityType->save();
                Common::one_time_message('success', 'Updated Successfully');
                return redirect('admin/settings/amenities-type');
            }
        }
    }

    public function delete(Request $request)
    {
        AmenityType::find($request->id)->delete();

        Common::one_time_message('success', 'Deleted Successfully');
        return redirect('admin/settings/amenities-type');
    }
}
