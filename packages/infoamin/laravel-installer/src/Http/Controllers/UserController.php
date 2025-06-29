<?php

namespace Infoamin\Installer\Http\Controllers;

use Illuminate\Http\Request;
use RegisterController, Validator;

class UserController extends RegisterController
{
    /**
     * Show form.
     *
     * @return \Illuminate\View\View
     */
    public function createUser()
    {
    	$data['fields'] = config('installer.fields');
        $data['field_types'] = config('installer.field_types');
        return view('vendor.installer.register', $data);
    }

    /**
     * Manage form submission.
     *
     * @param    Illuminate\Http\Request $request
     * @return
     */
    public function storeUser(Request $request)
    {
        $request->merge(['password_confirmation' => $request->password, 'role_id' => 1, 'status_id' => 1, 'from_installer' => true]);

        // Form validation with form request or validator method
        $validator = config('installer.validator');
        if ($validator !== null) {
            app($validator);
        } else {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'email' => 'required|unique:admin,email',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
        }
    	$request->is_installer = true;
        // Administrator creation
        $class = config('installer.creator.class');
        if ($class !== null) {
            $class  = app($class);
            $method = config('installer.creator.method');
            $user   = $class->{$method}($request, 1);
        } else {
            $user = $this->create($request->all());
        }

        if (method_exists($this, 'userAddValues')) {
            return $this->userAddValues($user);
        }

        return redirect('install/finish');
    }

}
