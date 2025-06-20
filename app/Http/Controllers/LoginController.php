<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Models\{Favourite, PasswordResets, Settings, User, UserDetails, UsersVerification};
use App\Rules\GoogleReCaptcha;
use Auth, DateTime, Session, Socialite, Validator, DB, Common;


class LoginController extends Controller
{

    public function index()
    {
        $preferenceData = Settings::getAll()->where('type','preferences')->where('name', 'recaptcha_preference')->value('value');
        $data['reCaptchaEnable'] = false;
        
        if (str_contains($preferenceData,'user_login')) {
           
            $data['reCaptchaEnable'] = true;
        }

        $data['social'] = Settings::getAll()->where('type','social')->pluck('value','name');
        return view('login.view', $data);
    }

    public function authenticate(Request $request)
    {
        $data['preferenceData'] = Settings::getAll()->where('type', 'preferences')->where('name', 'recaptcha_preference')->value('value');

        $rules = array(
            'email'    => 'required|email|max:200',
            'password' => 'required',
            
        );

        $fieldNames = array(
            'email'    => 'Email',
            'password' => 'Password',
        );

        if (!empty(settings('recaptcha_preference')) && !empty(settings('recaptcha_key'))) {
            if (str_contains(settings('recaptcha_preference'), 'user_login')) {

                $captchaRule = array('g-recaptcha-response' => ['required', new GoogleReCaptcha]);
                $captchaFieldname = array('g-recaptcha-response' => 'Google reCaptcha');

                $rules = array_merge($rules, $captchaRule);
                $fieldNames = array_merge($fieldNames, $captchaFieldname);
            
            }
        }
        

        $remember = ($request->remember_me) ? true : false;

        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($fieldNames);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            if (n_as_k_c()) {
                Session::flush();
                return view('vendor.installer.errors.user');
            }
            $users = User::where('email', $request->email)->first();

            if (!empty($users)) {
                if ($users->status != 'Inactive') {
                    if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {

                        self::addFavourite();
                        return redirect()->intended('dashboard');

                    } else {
                        Common::one_time_message('error', __('Unable to login with provided information.'));
                        return redirect('login');
                    }
                } elseif ($users->status == 'Inactive') {
                    Common::one_time_message('error', __("User is inactive. Please try agin!"));
                    return redirect('login');
                } else {
                    Common::one_time_message('error', __('Unable to login with provided information.'));
                    return redirect('login');
                }
            } else {
                Common::one_time_message('error', __('There isn’t an account associated with this email address.'));
                    return redirect('login');
            }

        }
    }
    
    public function addFavourite()
    {
        if (Session::has('favourite_property')) {

            Favourite::updateOrCreate(
                ['property_id' => Session::get('favourite_property'), 'user_id' => Auth::user()->id],
                ['status' => 'Active']);
        }
    }

    public function check(Request $request)
    {
        if ($request->get('email')) {
            $email = $request->get('email');
            $data  = DB::table("users")
            ->where('email', $email)
            ->count();
            if ($data > 0) {
                echo 'not_unique';
            } else {
                echo 'unique';
            }
        }
    }

    public function signup(Request $request)
    {
        $preferenceData = Settings::getAll()->where('type','preferences')->where('name', 'recaptcha_preference')->value('value');
        $data['reCaptchaEnable'] = false;
        
        if (str_contains($preferenceData,'user_reg')) {
           
            $data['reCaptchaEnable'] = true;
        }
        $data['social'] = Settings::getAll()->where('type','social')->pluck('value','name');
        return view('home.signup_login', $data);
    }

    public function forgotPassword(Request $request, EmailController $email_controller)
    {
        if (!$request->isMethod('post')) {
            return view('login.forgot_password');
        } else {
            $rules = array(
                'email' => 'required|email|exists:users,email|max:200',
            );

            $messages = array(
                'required' => __('Email is required.'),
                'exists'   => __('No account exists for this email.'),
            );

            $fieldNames = array(
                'email' => 'Email',
            );

            $validator = Validator::make($request->all(), $rules, $messages);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {

                $user = User::whereEmail($request->email)->first();

                $errorMessage = '';
                try {
                    $email_controller->forgot_password($user);
                } catch (\Exception $e) {
                    $errorMessage = __('Email was not sent due to :x', ['x' => $e->getMessage()]);
                }

                if ($errorMessage != '') {
                    Common::one_time_message('danger', $errorMessage);
                } else {
                    Common::one_time_message('success', __('Password reset link has been sent'));
                }

                return redirect('login');
            }
        }
    }

    public function resetPassword(Request $request)
    {
        if (! $request->isMethod('post')) {
            $password_resets = PasswordResets::whereToken($request->secret);

            if ($password_resets->count()) {
                $password_result = $password_resets->first();

                $datetime1 = new DateTime();
                $datetime2 = new DateTime($password_result->created_at);
                $interval  = $datetime1->diff($datetime2);
                $hours     = $interval->format('%h');

                if ($hours >= 1) {
                    $password_resets->delete();

                    Common::one_time_message('error', __('Token has been expired'));
                    return redirect('login');
                }

                $data['result'] = User::whereEmail($password_result->email)->first();
                $data['token']  = $request->secret;

                return view('login.reset_password', $data);
            } else {
                Common::one_time_message('error', __('Invalid Token'));
                return redirect('login');
            }
        } else {
            $rules = array(
                'password'              => 'required|min:6|max:30',
                'password_confirmation' => 'required|same:password',
            );

            $fieldNames = array(
                'password'              => __('New Password'),
                'password_confirmation' => __('Confirm Password'),
            );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $password_resets = PasswordResets::whereToken($request->token)->delete();

                $user           = User::find($request->id);
                $user->password = bcrypt($request->password);
                $user->save();

                Common::one_time_message('success', __('Password has been changed successfully'));
                return redirect('login');
            }
        }
    }

    public function facebookAuthenticate(EmailController $email_controller, UserController $user_controller)
    {

        if (!isset(request()->error)) {
            $userNode = Socialite::with('facebook')->user();

            $verificationUser = Session::get('verification');

            if ($verificationUser == 'yes') {
                return redirect('facebookConnect/' . $userNode->id);
            }

            $ex_name   = explode(' ', $userNode->name);
            $firstName = $ex_name[0];
            $lastName  = $ex_name[1];

            $email = $userNode->email;

            $user = User::where('email', $email);

            if ($user->count() > 0) {
                $user = User::where('email', $email)->first();

                UserDetails::updateOrCreate(
                    ['user_id' => $user->id, 'field' => 'fb_id'],
                    ['value' => $userNode->id]
                );

                $user_id = $user->id;
            } else {
                $user = User::where('email', $email);

                if ($user->count() > 0) {
                    $data['title'] = 'Disabled ';
                    return view('users.disabled', $data);
                }

                $user             = new User();
                $user->first_name = $firstName;
                $user->last_name  = $lastName;
                $user->email      = $email;
                $user->status     = 'Active';
                $user->save();

                $user_details          = new UserDetails();
                $user_details->user_id = $user->id;
                $user_details->field   = 'fb_id';
                $user_details->value   = $userNode->id;
                $user_details->save();

                $user_verification           = new UsersVerification();
                $user_verification->user_id  = $user->id;
                $user_verification->fb_id    = $userNode->id;
                $user_verification->facebook = 'yes';
                $user_verification->save();

                $user_id = $user->id;
                $user_controller->wallet($user->id);
                $email_controller->welcome_email($user);
            }

            $users = User::where('id', $user_id)->first();

            if ($users->status != 'Inactive') {
                if (Auth::loginUsingId($user_id)) {
                    return redirect()->intended('dashboard');
                } else {
                    Common::one_time_message('danger', __('Login Failed'));
                    return redirect('login');
                }
            } else {
                $data['title'] = 'Disabled ';
                return view('users.disabled', $data);
            }
        } else {
            return redirect('login');
        }
    }

    public function googleLogin()
    {
        return Socialite::with('google')->redirect();
    }

    public function facebookLogin()
    {
        return Socialite::with('facebook')->redirect();
    }

    public function googleAuthenticate(EmailController $email_controller, UserController $user_controller)
    {

        if (!isset(request()->error)) {
            $userNode = Socialite::with('google')->user();

            $verificationUser = Session::get('verification');
            if ($verificationUser == 'yes') {
                return redirect('googleConnect/' . $userNode->id);
            }

            $ex_name   = explode(' ', $userNode->name);
            $firstName = $ex_name[0];
            $lastName  = $ex_name[1];

            $email = ($userNode->email == '') ? $userNode->id . '@gmail.com' : $userNode->email;

            $user = User::where('email', $email);

            if ($user->count() > 0) {
                $user = User::where('email', $email)->first();

                UserDetails::updateOrCreate(
                    ['user_id' => $user->id, 'field' => 'fb_id'],
                    ['value' => $userNode->id]
                );

                $user_id = $user->id;
            } else {
                $user = User::where('email', $email);

                if ($user->count() > 0) {
                    $data['title'] = 'Disabled ';
                    return view('users.disabled', $data);
                }

                $user             = new User();
                $user->first_name = $firstName;
                $user->last_name  = $lastName;
                $user->email      = $email;
                $user->status     = 'Active';
                $user->save();

                $user_details          = new UserDetails();
                $user_details->user_id = $user->id;
                $user_details->field   = 'google_id';
                $user_details->value   = $userNode->id;
                $user_details->save();

                $user_id = $user->id;

                $user_verification            = new UsersVerification();
                $user_verification->user_id   = $user->id;
                $user_verification->google_id = $userNode->id;
                $user_verification->google    = 'yes';
                $user_verification->save();

                $user_controller->wallet($user->id);
                $email_controller->welcome_email($user);
            }

            $users = User::where('id', $user_id)->first();

            if ($users->status != 'Inactive') {
                if (Auth::loginUsingId($user_id)) {
                    return redirect()->intended('dashboard');
                } else {
                    Common::one_time_message('danger', __('Login Failed'));
                    return redirect('login');
                }
            } else {
                $data['title'] = 'Disabled ';
                return view('users.disabled', $data);
            }
        } else {
            return redirect('login');
        }
    }


}
