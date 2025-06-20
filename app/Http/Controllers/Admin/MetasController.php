<?php

/**
 * Metas Controller
 *
 * Metas Controller manages Metas by admin.
 *
 * @category   Metas
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

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\MetasDataTable;
use App\Models\Meta;
use Validator, Common;

class MetasController extends Controller
{
    
    public function index(metasDataTable $dataTable)
    {
        return $dataTable->render('admin.metas.view');
    }
    
    public function add(Request $request)
    {
        if (!$request->isMethod('post')) {
            return view('admin.metas.add');
        } elseif ($request->isMethod('post')) {
            $rules = array(
                    'title'          => 'required|max:255',
                    'url'            => 'required|max:255',
                    'description'    => 'required',
                    'keywords'       => 'required'
                    );

            $fieldNames = array(
                        'title'         => 'Title',
                        'url'           => 'Url',
                        'description'   => 'Description',
                        'keywords'      => 'Keywords'
                        );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $user = new Metas;
                $metas->url          = $request->url;
                $metas->title        = $request->title;
                $metas->description  = $request->description;
                $metas->keywords     = $request->keywords;
                $user->save();

                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/metas');
            }
        }
    }

    public function update(Request $request)
    {
        if (! $request->isMethod('post')) {
             $data['result'] = Meta::find($request->id);

            return view('admin.metas.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'url'           => 'required|max:255',
                'title'         => 'required|max:255',
                'description'   => 'required',
                );

            $fieldNames = array(
                    'url'              => 'Url',
                    'title'            =>'Title',
                    'description'      => 'Description',
                    'keywords'         => 'Keywords'
                    );
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $metas  = Meta::find($request->id);
                $metas ->url          = $request->url;
                $metas ->title        = $request->title;
                $metas ->description  = $request->description;
                $metas ->keywords     = $request->keywords;
                $metas ->save();


                Common::one_time_message('success', 'Updated Successfully');

                return redirect('admin/settings/metas');
            }
        }
    }

    public function delete(Request $request)
    {
        Metas::find($request->id)->delete();

        Common::one_time_message('success', 'Deleted Successfully');

        return redirect('admin/users');
    }
}
