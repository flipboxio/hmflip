<?php

/**
 * Testimonials Controller
 *
 * Testimonial Controller manages testimonial in home page.
 *
 * @category   Testimonials
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    2.9
 * @link       http://techvill.net
 * @email      support@techvill.net
 * @since      Version 2.9
 * @deprecated None
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\TestimonialsDataTable;
use App\Models\Testimonials;
use Validator, Common;

class TestimonialController extends Controller
{

    public function index(TestimonialsDataTable $dataTable)
    {
        return $dataTable->render('admin.testimonial.view');
    }

    public function add(Request $request)
    {
        if (! $request->isMethod('post')) {
            return view('admin.testimonial.add');
        } elseif ($request->isMethod('post')) {

             $rules = array(
                'name'           => 'required|max:100',
                'designation'    => 'required|max:100',
                'description'    => 'required|max:200',
                'rating_1'       => 'required|numeric|max:5',
                'image'          => 'required'
            );

            
            $fieldNames = array(
                'name'           => 'Name',
                'designation'    => 'Designation',
                'description'    => 'Description',
                'rating_1'       => 'Rating',
                'image'          => 'Image'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $image     =   $request->file('image');
                $extension =   $image->getClientOriginalExtension();
                $filename  =   'testimonial_'.time() . '.' . $extension;

                $success   = $image->move('public/front/images/testimonial', $filename);
                
                if (!isset($success)) {
                    return back()->withError('Could not upload Image');
                }

                $testimonial = new Testimonials;

                $testimonial->name  = $request->name;
                $testimonial->image    = $filename;
                $testimonial->status   = $request->status;
                $testimonial->description   = $request->description;
                $testimonial->designation   = $request->designation;
                $testimonial->review   = $request->rating_1; 
                $testimonial->save();

                Common::vrCacheForget('vr-testimonials');
                
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/testimonials');
            }
        } else {
            return redirect('admin/testimonials');
        }
    }
    public function update(Request $request)
    {
        if (! $request->isMethod('post')) {
            $data['result'] = Testimonials::find($request->id);
             

            return view('admin.testimonial.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'name'           => 'required|max:100',
                'designation'    => 'required|max:100',
                'description'    => 'required|max:200',
                'rating_1'         => 'required|numeric|max:5',
            );

            
            $fieldNames = array(
                'name'           => 'Name',
                'designation'    => 'Designation',
                'description'    => 'Description',
                'rating_1'         => 'Review',
                'image'          => 'Image'
            );
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                
                $testimonial = Testimonials::find($request->id);
                $testimonial->name 		 	= $request->name;
                $testimonial->status   		= $request->status;
                $testimonial->description   = $request->description;
                $testimonial->designation   = $request->designation;
                $testimonial->review   		= $request->rating_1; 
                 
                $image     =   $request->file('image');

                if ($image) {
                    $extension =   $image->getClientOriginalExtension();
                    $filename  =   'testimonial_'.time() . '.' . $extension;
    
                    $success = $image->move('public/front/images/testimonial', $filename);
        
                    if (! isset($success)) {
                         return back()->withError('Could not upload Image');
                    }

                    $testimonial->image = $filename;
                }

                $testimonial->save();

                Common::vrCacheForget('vr-testimonials');

                Common::one_time_message('success', 'Updated Successfully');
                return redirect('admin/testimonials');
            }
        } else {
            return redirect('admin/testimonials');
        }
    }
    public function delete(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
            $testimonial   = Testimonials::find($request->id);
            $file_path = public_path().'/front/images/testimonial/'.$testimonial->image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            Testimonials::find($request->id)->delete();
            Common::vrCacheForget('vr-testimonials');
            Common::one_time_message('success', 'Deleted Successfully');
        }
        
        return redirect('admin/testimonials');
    }
}

