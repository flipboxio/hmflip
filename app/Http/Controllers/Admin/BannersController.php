<?php

/**
 * Banners Controller
 *
 * Banners Controller manages banners in home page.
 *
 * @category   Banners
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
use App\DataTables\BannersDataTable;
use App\Models\Banners;
use Validator,Common;

class BannersController extends Controller
{

    public function index(BannersDataTable $dataTable)
    {
        return $dataTable->render('admin.banners.view');
    }

    public function add(Request $request)
    {
        if (! $request->isMethod('post')) {
            return view('admin.banners.add');
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'heading'    => 'required|max:100',
                'image'      => 'required|dimensions:min_width=1920,min_height=860'
            );

            
            $fieldNames = array(
                'heading'    => 'Heading',
                'image'      => 'Image'
            );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {

                if ($request->default == 'Yes') Banners::where('default_banner','Yes')->update(['default_banner'=>'No']);

                $image     =   $request->file('image');
                $extension =   $image->getClientOriginalExtension();
                $filename  =   'banner_'.time() . '.' . $extension;

                $success   = $image->move('public/front/images/banners', $filename);
                
                if (!isset($success)) {
                    return back()->withError('Could not upload Image');
                }

                $banners = new Banners;

                $banners->heading  = $request->heading;
                $banners->image    = $filename;
                $banners->status   = $request->status;
                $banners->default_banner   = $request->default;
                $banners->subheading = $request->subheading;
                $banners->save();

                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/settings/banners');
            }
        } else {
            return redirect('admin/settings/banners');
        }
    }
    public function update(Request $request)
    {

        if (! $request->isMethod('post')) {
            $data['result'] = Banners::find($request->id);

            return view('admin.banners.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                    'heading'    => 'required|max:100',
                    'image'      => 'dimensions:min_width=1920,min_height=860'

                    );

            $fieldNames = array(
                        'heading'    => 'Heading',
                        'image'      => 'dimensions:min_width=1920,min_height=860'
                        );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);


            if ($validator->fails()) {

                return back()->withErrors($validator)->withInput();
            } else {

                if ($request->default == 'Yes') Banners::where('default_banner','Yes')->update(['default_banner'=>'No']);
                
                $banners = Banners::find($request->id);
                $banners->heading  = $request->heading;
                $banners->subheading = $request->subheading;
                $banners->status   = $request->status;
                $banners->default_banner = $request->default;
                
                $image     =   $request->file('image');

                if ($image) {

                    $extension =   $image->getClientOriginalExtension();
                    $filename  =   'banner_'.time() . '.' . $extension;
    
                    $success = $image->move('public/front/images/banners', $filename);
        
                    if (! isset($success)) {

                         return back()->withError('Could not upload Image');
                    }

                    $banners->image = $filename;
                }

                $banners->save();

                Common::one_time_message('success', 'Updated Successfully');
                return redirect('admin/settings/banners');
            }
        } else {
            return redirect('admin/settings/banners');
        }
    }
    public function delete(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
            $banners   = Banners::find($request->id);
            $file_path = public_path().'/front/images/banners/'.$banners->image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            Banners::find($request->id)->delete();
            Common::one_time_message('success', 'Deleted Successfully');
        }
        
        return redirect('admin/settings/banners');
    }
}
