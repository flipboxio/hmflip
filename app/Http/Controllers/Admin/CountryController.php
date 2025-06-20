<?php

/**
 * Country Controller
 *
 * Country Controller manages countries.
 *
 * @category   Country
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    2.7
 * @link       http://techvill.net
 * @email      support@techvill.net
 * @since      Version 1.3
 * @deprecated None
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\CountryDataTable;
use App\Models\Country;
use Validator,Common;

class CountryController extends Controller
{

    public function index(CountryDataTable $dataTable)
    {
        return $dataTable->render('admin.countrys.view');
    }

    public function add(Request $request)
    {
        if (! $request->isMethod('post')) {
             return view('admin.countrys.add');
        } elseif ($request->isMethod('post')) {
            $rules = array(
                    'short_name'        => 'required|max:5|unique:country,short_name',
                    'name'              => 'required|max:100|unique:country,name',
                    'iso3'              => 'required|max:10|unique:country,iso3',
                    'number_code'       => 'required|max:1000|integer|unique:country,number_code',
                    'phone_code'        => 'required|max:1000|integer|unique:country,phone_code'
                    );


            $fieldNames = array(
                        'short_name'        => 'Short Name',
                        'name'              => 'Name',
                        'iso3'              => 'ISO3',
                        'number_code'       => 'Number Code',
                        'phone_code'        => 'Phone Code'
                        );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput($request->input());
            } else {
                $country                = new Country;
                $country->short_name    = $request->short_name;
                $country->name          = $request->name;
                $country->iso3          = $request->iso3;
                $country->number_code   =$request->number_code;
                $country->phone_code    =$request->phone_code;
                $country->save();

                clearCache('.countries');
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/settings/country');
            }
        }
    }

    public function update(Request $request)
    {
        if (! $request->isMethod('post')) {
             $data['result'] = Country::find($request->id);

            return view('admin.countrys.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                    'short_name'        => 'required|max:5',
                    'name'              => 'required|max:100',
                    'iso3'              => 'required|max:10',
                    'number_code'       => 'required|max:1000|integer',
                    'phone_code'        => 'required|max:1000|integer'
                    );

            $fieldNames = array(
                        'short_name'        => 'Short Name',
                        'name'              => 'Name',
                        'iso3'              => 'ISO3',
                        'number_code'       => 'Number Code',
                        'phone_code'        => 'Phone Code'
                        );
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                if (env('APP_MODE', '') != 'test') {
                    $country  = Country::find($request->id);
                    $country->short_name     = $request->short_name;
                    $country->name           = $request->name;
                    $country->iso3           = $request->iso3;
                    $country->number_code    =$request->number_code;
                    $country->phone_code     =$request->phone_code;
                    $country ->save();
                }
                clearCache('.countries');
                Common::one_time_message('success', 'Updated Successfully');

                return redirect('admin/settings/country');
            }
        }
    }

    public function delete(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
            Country::find($request->id)->delete();
        }
        clearCache('.countries');
        Common::one_time_message('success', 'Deleted Successfully');
        return redirect('admin/settings/country');
    }
}
