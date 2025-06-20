<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use App\Models\{Accounts,
    Admin,
    Bookings,
    EmailTemplate,
    PasswordResets,
    PaymentMethods,
    PropertyAddress,
    Settings,
    Withdrawal,
};
use Auth, DateTime, Mail, Common;
use Modules\Gateway\Entities\Gateway;

class EmailController extends Controller
{

    public function welcome_email($user)
    {
        $emailSettings               = Settings::getAll()->where('type','email')->toArray();
        $emailConfig                 = Common::key_value('name','value',$emailSettings);
        $adminDetails                = Admin::where('status','active')->first();
        $emailConfig['email_address']= $adminDetails->email;
        $emailConfig['username']     = $adminDetails->username;

        $token                       = Common::randomCode(100);
        $password_resets             = new PasswordResets;
        $password_resets->email      = $user->email;
        $password_resets->token      = $token;
        $password_resets->created_at = date('Y-m-d H:i:s');
        $password_resets->save();

        $data['first_name'] = $user->first_name;
        $data['email']      = $user->email;
        $data['token']      = $token;
        $data['type']       = __('register');
        $data['url']        = url('/').'/';

        $data['view']       = resource_path('views/sendmail/email_confirm.blade.php');

        $data['link']       = $data['url'].'users/confirm_email?code='.$data['token'];
        $data['link_text']   = __('Confirm Email');
        $data['user_name']    = '';

        $englishTemplate = EmailTemplate::where(['temp_id' => 5, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

        $emailTemplatefromDB = EmailTemplate::where([['temp_id',5],['lang', session()->get('language')],['type','email']])->first();
        if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
            $subject_string = $emailTemplatefromDB->subject;
            $body_string    = $emailTemplatefromDB->body;
        } else {
            $subject_string = $englishTemplate->subject;
            $body_string    = $englishTemplate->body;
        }

        $body_string     = str_replace('{first_name}', $user->first_name,$body_string);
        $body_string     = str_replace('{site_name}', siteName() ,$body_string);


        $data['subject']        =   $subject = $subject_string;
        $data['content']        =   $content = $body_string;
        $data['message_body']   =   $content;


        if (env('APP_MODE', '') != 'test') {
            if ($emailConfig['driver']=='smtp' && $emailConfig['email_status']==1) {

                Mail::send('emails.email_confirm_template', $data, function($message) use($data,$subject,$content) {
                    $message->to($data['email'], $data['first_name'])->subject($subject);
                });
            } elseif ($emailConfig['driver']=='sendmail') {
                $this->sendPhpEmail($data,$emailConfig);
            }
        }
        return true;
    }


    public function forgot_password($user, $type = null)
    {
        
        $emailSettings   = Settings::getAll()->where('type', 'email')->toArray();
        $emailConfig     = Common::key_value('name', 'value', $emailSettings);
        $adminDetails    = Admin::where('status', 'active')->first();
        $emailConfig['email_address'] = $adminDetails->email;
        $emailConfig['username']      = $adminDetails->username;
        $token = Common::randomCode(100);
        $exist = PasswordResets::where('token', $token)->count();

        while ($exist) {
            $token = Common::randomCode(100);
            $exist = PasswordResets::where('token', $token)->count();
        }

        $passwordResets             = new PasswordResets;
        $passwordResets->email      = $user->email;
        $passwordResets->token      = $token;
        $passwordResets->created_at = date('Y-m-d H:i:s');
        $passwordResets->save();

        $data['first_name'] = $user->first_name;
        $data['email']      = $user->email;
        $data['token']      = $token;
        $data['url']        = url('/') . '/';
        $data['view']       = resource_path('views/sendmail/forget_password.blade.php');
        $data['subject']    = __("Reset your Password");

        $data['link']       = $data['url'] . ($type == 'admin' ? 'admin/reset-' : 'users/reset_') . 'password?secret=' . $token;

        $data['link_text']       = __('Reset your password');


        $englishTemplate = EmailTemplate::where(['temp_id' => 6, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

        $emailTemplatefromDB = EmailTemplate::where([['temp_id', 6],['lang', session()->get('language')],['type', 'email']])->first();

        if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
            $subjectString  = $emailTemplatefromDB->subject;
            $bodyString     = $emailTemplatefromDB->body;
        } else {
            $subjectString  = $englishTemplate->subject;
            $bodyString     = $englishTemplate->body;
        }

        $bodyString = str_replace('{first_name}', $user->first_name, $bodyString);

        $data['subject']    =   $subject = $subjectString;
        $data['content']    =   $content = $bodyString;

        $data['message_body'] = $content;
        $data['user_name']    = '';
        $data['type']    = $type;

        if (env('APP_MODE', '') != 'test') {

            if ($emailConfig['driver'] == 'smtp' && $emailConfig['email_status'] == 1) {

                Mail::send('emails.forgot_password_template', $data, function($message) use($user, $data, $subject, $content) {
                    $message->to($user->email, $user->first_name)->subject($subject);
                });

            } elseif ($emailConfig['driver'] == 'sendmail') {

                $this->sendPhpEmail($data,$emailConfig);
            }
        }
        return true;
    }

    public function change_email_confirmation($user)
    {

        $emailSettings   = Settings::getAll()->where('type','email')->toArray();
        $emailConfig     = Common::key_value('name','value',$emailSettings);
        $adminDetails    = Admin::where('status','active')->first();
        $emailConfig['email_address']= $adminDetails->email;
        $emailConfig['username']     = $adminDetails->username;
        $token = Common::randomCode(100);

        $password_resets = new PasswordResets;
        $password_resets->email      = $user->email;
        $password_resets->token      = $token;
        $password_resets->created_at = date('Y-m-d H:i:s');
        $password_resets->save();

        $data['first_name']  = $user->first_name;
        $data['email']       = $user->email;
        $data['token']       = $token;
        $data['type']        = __('change');
        $data['url']         = url('/').'/';

        $data['subject']     = __("Please confirm your e-mail address");
        $data['view']        = resource_path('views/sendmail/email_confirm.blade.php');
        $data['link']        = $data['url'].'users/confirm_email?code='.$data['token'];
        $data['link_text']   = __('Confirm Email');
        $englishTemplate = EmailTemplate::where(['temp_id' => 5, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

        $emailTemplatefromDB = EmailTemplate::where([['temp_id',5],['lang', session()->get('language')],['type','email']])->first();
        if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
            $subject_string = $emailTemplatefromDB->subject;
            $body_string    = $emailTemplatefromDB->body;
        } else {
            $subject_string = $englishTemplate->subject;
            $body_string    = $englishTemplate->body;
        }

        $body_string     = str_replace('{first_name}', $user->first_name,$body_string);
        $body_string     = str_replace('{site_name}', siteName() ,$body_string);


        $data['subject']        =   $subject = $subject_string;
        $data['content']        =   $content = $body_string;
        $data['message_body']   =   $content;


        if (env('APP_MODE', '') != 'test') {
            if ($emailConfig['driver']=='smtp' && $emailConfig['email_status']==1) {
                Mail::send('emails.email_confirm', $data, function($message) use($user) {
                $message->to($user->email, $user->first_name)->subject(__('Please confirm your e-mail address'));
            });
            }
            elseif ($emailConfig['driver']=='sendmail') {
              $this->sendPhpEmail($data,$emailConfig);
            }

        }
        return true;
    }

    public function new_email_confirmation($user)
    {

        $emailSettings   = Settings::getAll()->where('type','email')->toArray();
        $emailConfig     = Common::key_value('name','value',$emailSettings);
        $adminDetails    = Admin::where('status','active')->first();
        $emailConfig['email_address']= $adminDetails->email;
        $emailConfig['username']     = $adminDetails->username;
        $token = Common::randomCode(100);

        $password_resets = new PasswordResets;
        $password_resets->email      = $user->email;
        $password_resets->token      = $token;
        $password_resets->created_at = date('Y-m-d H:i:s');
        $password_resets->save();

        $data['first_name']   = $user->first_name;
        $data['email']        = $user->email;
        $data['token']        = $token;
        $data['type']         = __('new_confirm');
        $data['url']          = url('/').'/';

        $data['subject']      = __("Please confirm your e-mail address");
        $data['view']         = resource_path('views/sendmail/email_confirm.blade.php');
        $data['link']         = $data['url'].'users/confirm_email?code='.$data['token'];
        $data['link_text']    = __('Confirm Email');


        $englishTemplate = EmailTemplate::where(['temp_id' => 5, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

        $emailTemplatefromDB = EmailTemplate::where([['temp_id',5],['lang', session()->get('language')],['type','email']])->first();
        if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
            $subject_string = $emailTemplatefromDB->subject;
            $body_string    = $emailTemplatefromDB->body;
        } else {
            $subject_string = $englishTemplate->subject;
            $body_string    = $englishTemplate->body;
        }

        $body_string     = str_replace('{first_name}', $user->first_name,$body_string);
        $body_string     = str_replace('{site_name}', siteName() ,$body_string);


        $data['subject']        =   $subject = $subject_string;
        $data['content']        =   $content = $body_string;
        $data['message_body']   =   $content;

        if (env('APP_MODE', '') != 'test') {
             if ($emailConfig['driver']=='smtp' && $emailConfig['email_status']==1) {
                Mail::send('emails.email_confirm', $data, function($message) use($user) {
                $message->to($user->email, $user->first_name)->subject(__('Please confirm your e-mail address'));
            });
            } elseif ($emailConfig['driver']=='sendmail') {
              $this->sendPhpEmail($data,$emailConfig);
            }
        }

        return true;
    }

    public function account_preferences($account_id, $type = 'update', $updateTime )
    {
        $emailSettings   = Settings::getAll()->where('type', 'email')->toArray();
        $emailConfig     = Common::key_value('name', 'value', $emailSettings);
        $adminDetails    = Admin::where('status', 'active')->first();
        $emailConfig['email_address']= $adminDetails->email;
        $emailConfig['username']     = $adminDetails->username;
        if ($type != 'delete') {
            $result               = Accounts::find($account_id);
            $user                 = $result->users;
            $data['first_name']   = $user->first_name;
            $data['email']        = $user->email;
            $data['updated_time'] = $result->updated_at_time;
            $data['updated_date'] = $result->updated_at_date;
        } else {
            $user = Auth::user();
            $data['first_name'] = $user->first_name;
            $data['email']      = $user->email;
            $now_dt = new DateTime(date('Y-m-d H:i:s'));
            $data['deleted_time'] = $now_dt->format('d M').' at '.$now_dt->format('H:i');
        }

        $data['type']      = __($type);
        $data['url']       = url('/').'/';
        $data['view']      = resource_path('views/sendmail/account_preferences.blade.php');
        $data['link']      = $data['url'].'users/account-preferences';

        if ($type == 'update') {
            $englishTemplate = EmailTemplate::where(['temp_id' => 2, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

            $emailTemplatefromDB = EmailTemplate::where([['temp_id',2],['lang', session()->get('language')],['type','email']])->first();
            if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
                $subjectFromDB = $emailTemplatefromDB->subject;
                $bodyFromDB    = $emailTemplatefromDB->body;
            } else {
                $subjectFromDB = $englishTemplate->subject;
                $bodyFromDB    = $englishTemplate->body;
            }

            $subjectFromDB  = str_replace('{site_name}', siteName() , $subjectFromDB);
            $bodyFromDB     = str_replace('{first_name}', $user->first_name, $bodyFromDB);
            $bodyFromDB     = str_replace('{site_name}', siteName() , $bodyFromDB);
            $bodyFromDB     = str_replace('{date_time}', $updateTime, $bodyFromDB);

            $data['subject'] = $subject = $subjectFromDB;
            $data['content'] = $content = $bodyFromDB;
            $data['message_body'] = $bodyFromDB;


        } elseif ($type == 'delete') {
            $englishTemplate = EmailTemplate::where(['temp_id' => 3, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

            $emailTemplatefromDB = EmailTemplate::where([['temp_id',3],['lang', session()->get('language')],['type','email']])->first();
            if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
                $subjectFromDB = $emailTemplatefromDB->subject;
                $bodyFromDB    = $emailTemplatefromDB->body;
            } else {
                $subjectFromDB = $englishTemplate->subject;
                $bodyFromDB    = $englishTemplate->body;
            }

            $subjectFromDB  = str_replace('{site_name}', siteName() , $subjectFromDB);
            $bodyFromDB     = str_replace('{first_name}', $user->first_name, $bodyFromDB);
            $bodyFromDB     = str_replace('{site_name}', siteName() , $bodyFromDB);
            $bodyFromDB     = str_replace('{date_time}', $updateTime, $bodyFromDB);

            $data['subject'] = $subject = $subjectFromDB;
            $data['content'] = $content = $bodyFromDB;
            $data['message_body'] = $bodyFromDB;


        } elseif ($type == 'default_update') {

            $englishTemplate = EmailTemplate::where(['temp_id' => 1, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

            $emailTemplatefromDB = EmailTemplate::where([['temp_id',1],['lang', session()->get('language')],['type','email']])->first();
            if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
                $subjectFromDB = $emailTemplatefromDB->subject;
                $bodyFromDB    = $emailTemplatefromDB->body;
            } else {
                $subjectFromDB = $englishTemplate->subject;
                $bodyFromDB    = $englishTemplate->body;
            }

            $subjectFromDB  = str_replace('{site_name}', siteName() , $subjectFromDB);
            $bodyFromDB     = str_replace('{site_name}', siteName() , $bodyFromDB);
            $bodyFromDB     = str_replace('{first_name}', $user->first_name, $bodyFromDB);
            $bodyFromDB     = str_replace('{date_time}', $updateTime, $bodyFromDB);


            $data['subject'] = $subject = $subjectFromDB;
            $data['content'] = $content = $bodyFromDB;
            $data['message_body'] = $bodyFromDB;
        }

         $data['user_name']    = '';

        if (env('APP_MODE', '') != 'test') {
            if ($emailConfig['driver']=='smtp' && $emailConfig['email_status']==1) {
                Mail::send('emails.account_preferences_template', $data, function ($message) use ($user, $data, $subject, $content) {
                    $message->to($user->email, $user->first_name)->subject($subject);
                });
            } elseif ($emailConfig['driver']=='sendmail') {
                $this->sendPhpEmail($data, $emailConfig);
            }
        }
        return true;
    }

    public function booking($booking_id, $checkinDate, $bank = false)
    {

        $emailSettings   = Settings::getAll()->where('type', 'email')->toArray();
        $emailConfig     = Common::key_value('name', 'value', $emailSettings);
        $adminDetails    = Admin::where('status', 'active')->first();
        $emailConfig['email_address']= $adminDetails->email;
        $emailConfig['username']     = $adminDetails->username;
        $booking         = Bookings::find($booking_id);
        $user            = $booking->host;
        $data['url']     = url('/') . '/';
        $data['result']  = Bookings::where('bookings.id', $booking_id)->with(['users', 'properties', 'host', 'currency', 'messages'])->first()->toArray();
        $data['logo']       = getLogo('file-img');

        if ($booking->status == 'Pending') {
            $data['view']       = resource_path('views/sendmail/booking.blade.php');
        } else {
            $data['view']       = resource_path('views/sendmail/instant_booking.blade.php');
        }
        $data['link']       = $data['url'] . 'booking/' . $data['result']['id'];
        $data['link_text']  = __('Accept / Decline');
        $data['user_name']  = $data['result']['users']['first_name'];
        $data['first_name'] = $data['result']['host']['first_name'];
        $data['email']      = $user->email;
        $total_night        = $data['result']['total_night'] > 1 ? "nights" : "night";
        $data["total_night"]= $data['result']['total_night'] . ' ' . $total_night;
        $totalPrice         = moneyFormat(codeToSymbol($data['result']['currency_code']), $data['result']['total']);

        $guest = $data['result']['guest'] > 1 ? "guests" : "guest";
        $data["total_guest"]=$data['result']['guest'] . ' ' . $guest;


        if ($booking->status == 'Pending') {
            $englishTemplate = EmailTemplate::where(['temp_id' => 4, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

            $emailTemplatefromDB = EmailTemplate::where([['temp_id', 4],['lang', session()->get('language')], ['type','email']])->first();
        } else {
            $englishTemplate = EmailTemplate::where(['temp_id' => 13, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

            $emailTemplatefromDB = EmailTemplate::where([['temp_id', 13],['lang', session()->get('language')], ['type','email']])->first();
        }
        
        if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
            $subjectFromDB = $emailTemplatefromDB->subject;
            $bodyFromDB    = $emailTemplatefromDB->body;
        } else {
            $subjectFromDB = $englishTemplate->subject;
            $bodyFromDB    = $englishTemplate->body;
        }

        $subjectFromDB  = str_replace('{property_name}', $data['result']['properties']['name'], $subjectFromDB);
        $subjectFromDB  = str_replace('{user_first_name}', $data['result']['users']['first_name'], $subjectFromDB);

        $bodyFromDB     = str_replace('{owner_first_name}', $user->first_name, $bodyFromDB);
        $bodyFromDB     = str_replace('{user_first_name}', $data['result']['users']['first_name'], $bodyFromDB);
        $bodyFromDB     = str_replace('{user_name}', $data['result']['users']['first_name'] . ' ' . $data['result']['users']['last_name'], $bodyFromDB);
        $bodyFromDB     = str_replace('{user_email}', $data['result']['users']['email'], $bodyFromDB);
        $bodyFromDB     = str_replace('{total_night}', $data['result']['total_night'], $bodyFromDB);
        if ($data['result']['total_night'] > 1) {
            $myStr = 'nights';
        }
        if ($data['result']['total_night'] = 1) {
            $myStr = 'night';
        }
        $bodyFromDB     = str_replace('{night/nights}', $myStr, $bodyFromDB);
        $bodyFromDB     = str_replace('{property_name}', $data['result']['properties']['name'], $bodyFromDB);
        $bodyFromDB     = str_replace('{messages_message}', $data['result']['messages'][0]['message'], $bodyFromDB);
        $bodyFromDB     = str_replace('{total_guest}', $data['result']['guest'], $bodyFromDB);
        $bodyFromDB     = str_replace('{start_date}', $checkinDate, $bodyFromDB);
        $bodyFromDB     = str_replace('{total_amount}', $totalPrice, $bodyFromDB);
        $bodyFromDB     = str_replace('{company_name}', siteName(), $bodyFromDB);
        $bodyFromDB     = str_replace('{payment_method}', PaymentMethods::find($data['result']['payment_method_id'])->name ?? 'Not selected yet.', $bodyFromDB);


        $data['subject'] = $subject = $subjectFromDB;
        $data['content'] = $content = $bodyFromDB;
        $data['message_body'] = $content;


        if (env('APP_MODE', '') != 'test') {
            if ($emailConfig['driver']=='smtp' && $emailConfig['email_status'] == 1) {
                    Mail::send('emails.booking_cancel_template', $data, function ($message) use ($user, $data, $subject, $content) {
                        $message->to($user->email, $user->first_name)->subject($subject);
                    });

            } elseif ($emailConfig['driver'] == 'sendmail') {
                $this->sendPhpEmail($data, $emailConfig);
            }
        }
        return true;
    }


    public function booking_user($booking_id, $checkinDate)
    {

        $emailSettings   = Settings::getAll()->where('type', 'email')->toArray();
        $emailConfig     = Common::key_value('name', 'value', $emailSettings);
        $adminDetails    = Admin::where('status', 'active')->first();
        $emailConfig['email_address']= $adminDetails->email;
        $emailConfig['username']     = $adminDetails->username;
        $booking         = Bookings::find($booking_id);
        $user            = $booking->users;
        $data['url']     = url('/') . '/';
        $data['result']  = Bookings::where('bookings.id', $booking_id)->with(['users', 'properties', 'host', 'currency', 'messages'])->first()->toArray();
        $data['logo']       = getLogo('file-img');

        $data['view']       = resource_path('views/sendmail/instant_booking.blade.php');

        $data['link']       = $data['url'] . 'booking/' . $data['result']['id'];
        $data['link_text']  = __('Accept / Decline');
        $data['user_name']  = $data['result']['host']['first_name'];
        $data['first_name'] = $data['result']['users']['first_name'];
        $data['email']      = $user->email;
        $total_night = $data['result']['total_night'] > 1 ? "nights" : "night";
        $data["total_night"]= $data['result']['total_night'] . ' ' . $total_night;
        
        $totalPrice         = moneyFormat(codeToSymbol($data['result']['currency_code']), $data['result']['total']);

        $guest = $data['result']['guest'] > 1 ? "guests" : "guest";
        $data["total_guest"]= $data['result']['guest'] . ' ' . $guest;


        if ($booking->status == 'Pending') {
            $englishTemplate = EmailTemplate::where(['temp_id' => 11, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

            $emailTemplatefromDB = EmailTemplate::where([['temp_id', 11],['lang', session()->get('language')], ['type','email']])->first();
        } else {
            $englishTemplate = EmailTemplate::where(['temp_id' => 12, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

            $emailTemplatefromDB = EmailTemplate::where([['temp_id', 12],['lang', session()->get('language')], ['type','email']])->first();
        }

        if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
            $subjectFromDB = $emailTemplatefromDB->subject;
            $bodyFromDB    = $emailTemplatefromDB->body;
        } else {
            $subjectFromDB = $englishTemplate->subject;
            $bodyFromDB    = $englishTemplate->body;
        }
        $subjectFromDB  = str_replace('{property_name}', $data['result']['properties']['name'], $subjectFromDB);
        $bodyFromDB     = str_replace('{owner_first_name}', $booking->host->first_name, $bodyFromDB);
        $bodyFromDB     = str_replace('{user_first_name}', $data['result']['users']['first_name'], $bodyFromDB);
        $bodyFromDB     = str_replace('{total_night}', $data['result']['total_night'], $bodyFromDB);
        $bodyFromDB     = str_replace('{total_amount}', $totalPrice, $bodyFromDB);
        $bodyFromDB     = str_replace('{company_name}', siteName(), $bodyFromDB);

        if ($data['result']['total_night'] > 1) {
            $myStr = 'nights';
        }
        if ($data['result']['total_night'] = 1) {
            $myStr = 'night';
        }
        $bodyFromDB     = str_replace('{night/nights}', $myStr, $bodyFromDB);
        $bodyFromDB     = str_replace('{property_name}', $data['result']['properties']['name'], $bodyFromDB);
        $bodyFromDB     = str_replace('{messages_message}', $data['result']['messages'][0]['message'], $bodyFromDB);
        $bodyFromDB     = str_replace('{total_guest}', $data['result']['guest'], $bodyFromDB);
        $bodyFromDB     = str_replace('{start_date}', $checkinDate, $bodyFromDB);
        $bodyFromDB     = str_replace('{payment_method}', PaymentMethods::find($data['result']['payment_method_id'])->name ?? 'Not selected yet.', $bodyFromDB);

        $data['subject'] = $subject = $subjectFromDB;
        $data['content'] = $content = $bodyFromDB;
        $data['message_body'] = $content;


        if (env('APP_MODE', '') != 'test') {
            if ($emailConfig['driver']=='smtp' && $emailConfig['email_status'] == 1) {
                    Mail::send('emails.booking_user_template', $data, function ($message) use ($user, $data, $subject, $content) {
                        $message->to($user->email, $user->first_name)->subject($subject);
                    });


            } elseif ($emailConfig['driver'] == 'sendmail') {
                $this->sendPhpEmail($data, $emailConfig);
            }
        }
        return true;
    }


    public function need_pay_account($booking_id, $type)
    {
        $emailSettings   = Settings::getAll()->where('type','email')->toArray();
        $emailConfig     = Common::key_value('name','value',$emailSettings);
        $adminDetails                = Admin::where('status','active')->first();
        $emailConfig['email_address']= $adminDetails->email;
        $emailConfig['username']     = $adminDetails->username;
        $result       = Bookings::find($booking_id);
        $data['type'] = __($type);

        if ($type == 'guest') {
            $user                  = $result->users;
            $data['email']         = $user->email;
            $data['payout_amount'] = $result->original_admin_guest_payment;
        } else {
            $user                  = $result->host;
            $data['email']         = $user->email;
            $data['payout_amount'] = $result->original_admin_host_payment;
        }

        $data['currency_symbol'] = $result->currency->org_symbol;
        $data['first_name']      = $user->first_name;
        $data['user_id']         = $user->id;
        $data['url'] = url('/').'/';

        $data['link']       = $data['url'].'users/account_preferences';
        $data['link_text']  = __("Add a payout method");

        $data['view']       = resource_path('views/sendmail/need_pay_account.blade.php');

        $englishTemplate = EmailTemplate::where(['temp_id' => 7, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

        $emailTemplatefromDB = EmailTemplate::where([['temp_id',7],['lang_id', $this->getDefaultLanguage()],['type','email']])->first();
        if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
            $subjectFromDB = $emailTemplatefromDB->subject;
            $bodyFromDB    = $emailTemplatefromDB->body;
        } else {
            $subjectFromDB = $englishTemplate->subject;
            $bodyFromDB    = $englishTemplate->body;

        }
        $bodyFromDB     = str_replace('{first_name}', $data['first_name'],$bodyFromDB);
        $bodyFromDB     = str_replace('{site_name}', siteName() ,$bodyFromDB);
        $bodyFromDB     = str_replace('{currency_symbol}', $data['currency_symbol'], $bodyFromDB);
        $bodyFromDB     = str_replace('{payout_amount}', $data['payout_amount'], $bodyFromDB);

        $data['subject'] = $subject = $subjectFromDB;
        $data['content'] = $content = $bodyFromDB;
        $data['message_body'] = $content;



        if (env('APP_MODE', '') != 'test') {
            if ($emailConfig['driver']=='smtp' && $emailConfig['email_status']==1) {
            Mail::send('emails.need_pay_account_template', $data, function($message) use($user, $data,$subject,$content) {
                $message->to($user->email, $user->first_name)->subject($subject);
            });
        } elseif ($emailConfig['driver']=='sendmail') {
              $this->sendPhpEmail($data,$emailConfig);
            }
        }
        return true;
    }

    public function bookingCancellation($booking_id)
    {
        $emailSettings   = Settings::getAll()->where('type','email')->toArray();
        $emailConfig     = Common::key_value('name','value',$emailSettings);
        $adminDetails    = Admin::where('status','active')->first();
        $emailConfig['email_address']= $adminDetails->email;
        $emailConfig['username']     = $adminDetails->username;
        $booking         = Bookings::find($booking_id);
        $user            = $booking->host;
        $data['url']     = url('/').'/';
        $data['result']  = Bookings::where('bookings.id', $booking_id)->with(['users', 'properties', 'host', 'currency', 'messages'])->first()->toArray();
        $data['url']        = url('/').'/';
        $data['view']       = resource_path('views/sendmail/booking_cancel.blade.php');
        $data['link']       = $data['url'].'booking/'.$data['result']['id'];
        $data['user_name']  = $data['result']['users']['first_name'];
        $data['first_name'] = $data['result']['host']['first_name'];
        $data['email']      = $user->email;

        $englishTemplate = EmailTemplate::where(['temp_id' => 9, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

        $emailTemplatefromDB = EmailTemplate::where([['temp_id',9],['lang_id', $this->getDefaultLanguage()],['type','email']])->first();
        if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
            $subjectFromDB = $emailTemplatefromDB->subject;
            $bodyFromDB    = $emailTemplatefromDB->body;
        } else {
            $subjectFromDB = $englishTemplate->subject;
            $bodyFromDB    = $englishTemplate->body;
        }

        $subjectFromDB  = str_replace('{property_name}', $data['result']['properties']['name'],$subjectFromDB);
        $bodyFromDB     = str_replace('{owner_first_name}', $user->first_name,$bodyFromDB);
        $bodyFromDB     = str_replace('{user_first_name}', $data['user_name'],$bodyFromDB);
        $bodyFromDB     = str_replace('{property_name}',$data['result']['properties']['name'],$bodyFromDB);
        $bodyFromDB     = str_replace('{link}', $data['link'], $bodyFromDB);
        $data['subject'] = $subject = $subjectFromDB;
        $data['content'] = $content = $bodyFromDB;
        $data['message_body'] = $content;

        if (env('APP_MODE', '') != 'test') {
            if ($emailConfig['driver']=='smtp' && $emailConfig['email_status']==1) {
                    Mail::send('emails.booking_cancel_template', $data, function($message) use($user, $data,$subject,$content) {
                    $message->to($user->email, $user->first_name)->subject($subject);
            });
            } elseif ($emailConfig['driver']=='sendmail') {
              $this->sendPhpEmail($data,$emailConfig);
            }

        }
        return true;
    }


    public function bookingAcceptedOrDeclined($booking_id, $status)
    {
        $emailSettings   = Settings::getAll()->where('type','email')->toArray();
        $emailConfig     = Common::key_value('name','value',$emailSettings);
        $adminDetails    = Admin::where('status','active')->first();
        $emailConfig['email_address']= $adminDetails->email;
        $emailConfig['username']     = $adminDetails->username;
        $booking         = Bookings::find($booking_id);
        $user            = $booking->users;
        $data['url']     = url('/').'/';
        $data['result']  = Bookings::where('bookings.id', $booking_id)->with(['users', 'properties', 'host', 'currency', 'messages'])->first()->toArray();
        $data['url']        = url('/').'/';
        $data['view']       = resource_path('views/sendmail/booking_accept_decline.blade.php');
        $data['link']       = $data['url'].'booking_payment/'.$data['result']['id'];

        $data['link_text']  = __('Payment');

        $data['user_name']  = $data['result']['users']['first_name'];
        $data['first_name'] = $data['result']['host']['first_name'];
        $data['email']      = $user->email;

        $englishTemplate = EmailTemplate::where(['temp_id' => 10, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();
        $emailTemplatefromDB = EmailTemplate::where([['temp_id',10],['lang_id', $this->getDefaultLanguage()],['type','email']])->first();

        if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
            $subjectFromDB = $emailTemplatefromDB->subject;
            $bodyFromDB    = $emailTemplatefromDB->body;
        } else {
            $subjectFromDB = $englishTemplate->subject;
            $bodyFromDB    = $englishTemplate->body;
        }

        if ($status == 'Processing') {
            $subjectFromDB  = str_replace('{Accepted/Declined}', 'Accepted', $subjectFromDB);
            $bodyFromDB     = str_replace('{guest_first_name}', $user->first_name,$bodyFromDB);
            $bodyFromDB     = str_replace('{host_first_name}', $data['first_name'],$bodyFromDB);
            $bodyFromDB     = str_replace('{Accepted/Declined}', 'Accepted', $bodyFromDB);
            $bodyFromDB     = str_replace('{property_name}',$data['result']['properties']['name'],$bodyFromDB);

        } elseif ($status == 'Declined') {
            $subjectFromDB  = str_replace('{Accepted/Declined}', 'Declined', $subjectFromDB);
            $bodyFromDB     = str_replace('{guest_first_name}', $user->first_name,$bodyFromDB);
            $bodyFromDB     = str_replace('{host_first_name}', $data['first_name'],$bodyFromDB);
            $bodyFromDB     = str_replace('{Accepted/Declined}', 'Declined', $bodyFromDB);
            $bodyFromDB     = str_replace('{property_name}',$data['result']['properties']['name'],$bodyFromDB);
        }

        $data['subject'] = $subject = $subjectFromDB;
        $data['content'] = $content = $bodyFromDB;
        $data['message_body'] = $content;

        if (env('APP_MODE', '') != 'test') {
            if ($emailConfig['driver']=='smtp' && $emailConfig['email_status']==1) {
                Mail::send('emails.booking_cancel_template', $data, function($message) use($user, $data,$subject,$content) {
                $message->to($user->email, $user->first_name)->subject($subject);
            });
            } elseif ($emailConfig['driver']=='sendmail') {
              $this->sendPhpEmail($data,$emailConfig);
            }
        }
        return true;
    }

    public function payout_sent($booking_id)
    {
        $emailSettings   = Settings::getAll()->where('type','email')->toArray();
        $emailConfig     = Common::key_value('name','value',$emailSettings);
        $adminDetails                = Admin::where('status','active')->first();
        $emailConfig['email_address']= $adminDetails->email;
        $emailConfig['username']     = $adminDetails->username;
        $result       = Bookings::find($booking_id);

        if ($result->status=="Cancelled" || $result->status=="Declined" || $result->status=="Expired")
        {
            $user        = $result->users;
            $amount      = $result->original_guest_payout;
        } else {
            $user        = $result->host;
            $amount      = $result->original_host_payout;
        }
        $data['email']           = $user->email;

        $payout_payment_methods          = $result->payment_methods;
        $data['payout_payment_method']   = $payout_payment_methods->name;
        $data['payout_amount']           = $amount;
        $data['currency_symbol']         = $result->currency->org_symbol;
        $data['first_name']              = $user->first_name;
        $data['user_id']                 = $user->id;
        $data['url']                     = url('/').'/';

        $data['link']       = $data['url'].'users/transaction_history';
        $data['link_text']  = __('Transaction History');
        $data['view']       = resource_path('views/sendmail/payout_sent.blade.php');

        $englishTemplate = EmailTemplate::where(['temp_id' => 8, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

        $emailTemplatefromDB = EmailTemplate::where([['temp_id',8],['lang_id', $this->getDefaultLanguage()],['type','email']])->first();
        if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
            $subjectFromDB = $emailTemplatefromDB->subject;
            $bodyFromDB    = $emailTemplatefromDB->body;

        } else {
            $subjectFromDB = $englishTemplate->subject;
            $bodyFromDB    = $englishTemplate->body;
        }
        $bodyFromDB     = str_replace('{site_name}', siteName() ,$bodyFromDB);
        $bodyFromDB     = str_replace('{first_name}', $data['first_name'], $bodyFromDB);
        $bodyFromDB     = str_replace('{currency_symbol}', $data['currency_symbol'], $bodyFromDB);
        $bodyFromDB     = str_replace('{payout_amount}', $data['payout_amount'], $bodyFromDB);
        $bodyFromDB     = str_replace('{payout_payment_method}', $data['payout_payment_method'], $bodyFromDB);

        $data['subject'] = $subject = $subjectFromDB;
        $data['content'] = $content = $bodyFromDB;
        $data['message_body'] = $content;

        if ( env('APP_MODE', '') != 'test') {
            if ($emailConfig['driver']=='smtp' && $emailConfig['email_status']==1) {
            Mail::send('emails.payout_sent_template', $data, function($message) use($user, $data,$subject,$content) {
                $message->to($user->email, $user->first_name)->subject($subject);
            });
        } elseif ($emailConfig['driver']=='sendmail') {
              $this->sendPhpEmail($data,$emailConfig);
            }
        }
        return true;
    }


    public function sendPhpEmail($data, $configEmail)
    {
        require_once "vendor/autoload.php";

        $mail = new PHPMailer();

        $mail->isSendmail();

        $mail->setFrom($configEmail['email_address'], $configEmail['username']);
        $mail->addReplyTo($configEmail['email_address'], $configEmail['username']);
        $mail->addAddress($data['email'], $data['first_name']);

        $mail->Subject = $data['subject'];
        $image = getLogo('file-img');
        $link            = isset($data['link']) ? $data['link'] : '' ;
        $lang            = isset($data['link_text']) ? $data['link_text'] : '';
        $message         = file_get_contents($data['view']);
        $message         = str_replace('#message_body#',$data['message_body'], $message);
        $message         = str_replace('#site_name#', $configEmail['from_name'], $message);
        $message         = str_replace('{first_name}', $data['first_name'], $message);
        $message         = str_replace('#lang#', $lang, $message);
        $message         = str_replace('#link#', $link, $message);
        $message         = str_replace('#image_link#', $image, $message);
 
        $mail->msgHTML($message);

        $mail->AltBody = 'This is a plain-text message body';

        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message sent!';
        }
    }


    public function getDefaultLanguage()
    {
        return Settings::getAll()->where('type', 'general')->where('name', 'default_language')
                                ->first()
                                ->value;

    }

    public function bankAdminNotify($bookingId, $checkInDate)
    {

        $emailSettings   = Settings::getAll()->where('type', 'email')->toArray();

        
        $emailConfig     = Common::key_value('name', 'value', $emailSettings);
        $adminDetails    = Admin::where('status', 'active')->first();
        $emailConfig['email_address']= $receiver['email'] = $adminDetails->email;
        $emailConfig['username']     = $adminDetails->username;
        $data['url']     = url('/') . '/';
        $data['result']  = Bookings::where('bookings.id', $bookingId)->with(['users', 'properties', 'host', 'currency', 'messages'])->first()->toArray();
        $data['logo']       = getLogo('file-img');

        $data['view']       = resource_path('views/sendmail/general_template.blade.php');

        $data['link']       = $data['url'] . 'admin/bookings/detail/' . $data['result']['id'];
        $data['link_text']  = __('Accept / Decline');
        $data['user_name']  = $data['result']['users']['first_name'] . ' ' . $data['result']['users']['last_name'];
        $data['first_name'] = $receiver['name'] = $adminDetails->username;
        $data['email']      = $receiver['email'];
        $total_night        = $data['result']['total_night'] > 1 ? "nights" : "night";
        $data["total_night"]= $data['result']['total_night'] . ' ' . $total_night;

        $guest = $data['result']['guest'] > 1 ? "guests" : "guest";
        $data["total_guest"]= $data['result']['guest'] . ' ' . $guest;
        $propertyName       = $data['result']['properties']['name'];
        $totalPrice         = moneyFormat(codeToSymbol($data['result']['currency_code']), $data['result']['total']);
        $englishTemplate = EmailTemplate::where(['temp_id' => 14, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

        $emailTemplatefromDB = EmailTemplate::where([['temp_id', 14],['lang', session()->get('language')], ['type','email']])->first();

        if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
            $subjectFromDB = $emailTemplatefromDB->subject;
            $bodyFromDB    = $emailTemplatefromDB->body;
        } else {
            $subjectFromDB = $englishTemplate->subject;
            $bodyFromDB    = $englishTemplate->body;
        }

        $subjectFromDB  = str_replace('{property_name}', $propertyName, $subjectFromDB);

        $bodyFromDB     = str_replace('{admin_first_name}', $adminDetails->username, $bodyFromDB);
        $bodyFromDB     = str_replace('{user_name}', $data['user_name'], $bodyFromDB);
        $bodyFromDB     = str_replace('{property_name}', $propertyName, $bodyFromDB);
        $bodyFromDB     = str_replace('{payment_method}', Gateway::find($data['result']['payment_method_id'])->name, $bodyFromDB);
        $bodyFromDB     = str_replace('{total_amount}', $totalPrice, $bodyFromDB);
        $bodyFromDB     = str_replace('{company_name}', siteName(), $bodyFromDB);
        
        if ($data['result']['payment_method_id'] == 4) {

            $bodyFromDB     = str_replace('{bankMessages}', 'Please Ensure the Bank Payment and Accept/Decline it from the Admin Panel', $bodyFromDB);
        } else {
            $bodyFromDB     = str_replace('{bankMessages}', '', $bodyFromDB);
        }

        $data['subject'] = $subject = $subjectFromDB;
        $data['content'] = $content = $bodyFromDB;
        $data['message_body'] = $content;

        if (env('APP_MODE', '') != 'test') {
            if ($emailConfig['driver']=='smtp' && $emailConfig['email_status'] == 1) {
                Mail::send('emails.booking_cancel_template', $data, function ($message) use ($receiver, $data, $subject, $content) {
                    $message->to($receiver['email'], $receiver['name'])->subject($subject);
                });

            } elseif ($emailConfig['driver']=='sendmail') {
                $this->sendPhpEmail($data, $emailConfig);
            }
        }
        return true;
    }

    public function notifyAdminForPropertyApproval($property)
    {

        $emailSettings   = Settings::getAll()->where('type', 'email')->toArray();

        
        $emailConfig     = Common::key_value('name', 'value', $emailSettings);
        $adminDetails    = Admin::where('status', 'active')->first();
        $emailConfig['email_address']= $receiver['email'] = $adminDetails->email;
        $emailConfig['username']     = $adminDetails->username;
        $data['url']     = url('/') . '/';
        $data['logo']       = getLogo('file-img');
        $data['view']       = resource_path('views/sendmail/general_template.blade.php');

        $data['first_name'] = $receiver['name'] = $adminDetails->username;
        $data['email']      = $receiver['email'];

        $propertyName       = $property['name'];
        $propertyAddress    = PropertyAddress::where('property_id', $property['id'])->value('address_line_1');

        $englishTemplate = EmailTemplate::where(['temp_id' => 16, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

        $emailTemplatefromDB = EmailTemplate::where([['temp_id', 16], ['lang', session()->get('language')], ['type','email']])->first();

        if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
            $subjectFromDB = $emailTemplatefromDB->subject;
            $bodyFromDB    = $emailTemplatefromDB->body;
        } else {
            $subjectFromDB = $englishTemplate->subject;
            $bodyFromDB    = $englishTemplate->body;
        }

        $subjectFromDB  = str_replace('{property_name}', $propertyName, $subjectFromDB);

        $bodyFromDB     = str_replace('{admin_first_name}', $adminDetails->username, $bodyFromDB);
        $bodyFromDB     = str_replace('{host_name}', $property['host_name'], $bodyFromDB);
        $bodyFromDB     = str_replace('{property_name}', $propertyName, $bodyFromDB);
        $bodyFromDB     = str_replace('{property_address}', $propertyAddress, $bodyFromDB);
        $bodyFromDB     = str_replace('{listed_date}', date(setDateForFront(), strtotime($property['created_at'])), $bodyFromDB);
        $bodyFromDB     = str_replace('{company_name}', siteName(), $bodyFromDB);
        
    
        $data['subject'] = $subject = $subjectFromDB;
        $data['content'] = $content = $bodyFromDB;
        $data['message_body'] = $content;

        if (env('APP_MODE', '') != 'test') {
            if ($emailConfig['driver']=='smtp' && $emailConfig['email_status'] == 1) {
                Mail::send('emails.general_template', $data, function ($message) use ($receiver, $data, $subject, $content) {
                    $message->to($receiver['email'], $receiver['name'])->subject($subject);
                });

            } elseif ($emailConfig['driver']=='sendmail') {
                $this->sendPhpEmail($data, $emailConfig);
            }
        }
        return true;
    }

    public function notifyAdminOfPayoutRequest($withdrawalID)
    {
        
        $emailSettings   = Settings::getAll()->where('type', 'email')->toArray();

        
        $emailConfig     = Common::key_value('name', 'value', $emailSettings);
        $adminDetails    = Admin::where('status', 'active')->first();
        $emailConfig['email_address']= $receiver['email'] = $adminDetails->email;
        $emailConfig['username']     = $adminDetails->username;
        $data['url']     = url('/') . '/';
        $data['logo']       = getLogo('file-img');
        $data['view']       = resource_path('views/sendmail/general_template.blade.php');

        $data['first_name'] = $receiver['name'] = $adminDetails->username;
        $data['email']      = $receiver['email'];


        $result = Withdrawal::with('user', 'currency', 'payment_methods')->where('id', $withdrawalID)->first();

        $userName = $result->user?->first_name . ' ' . $result->user?->last_name;
        $requestAmount = moneyFormat(codeToSymbol($result->currency?->code), $result->subtotal);

        $englishTemplate = EmailTemplate::where(['temp_id' => 15, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

        $emailTemplatefromDB = EmailTemplate::where([['temp_id', 15], ['lang', session()->get('language')], ['type','email']])->first();

        if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
            $subjectFromDB = $emailTemplatefromDB->subject;
            $bodyFromDB    = $emailTemplatefromDB->body;
        } else {
            $subjectFromDB = $englishTemplate->subject;
            $bodyFromDB    = $englishTemplate->body;
        }

        $bodyFromDB     = str_replace('{admin_first_name}', $adminDetails->username, $bodyFromDB);
        $bodyFromDB     = str_replace('{user_name}', $userName, $bodyFromDB);
        $bodyFromDB     = str_replace('{user_email}', $result->user?->email, $bodyFromDB);
        $bodyFromDB     = str_replace('{payout_method}', $result->payment_methods?->name, $bodyFromDB);
        $bodyFromDB     = str_replace('{requested_amount}', $requestAmount, $bodyFromDB);
        $bodyFromDB     = str_replace('{requested_date}', date(setDateForFront(), strtotime($result->created_at)), $bodyFromDB);
        $bodyFromDB     = str_replace('{company_name}', siteName(), $bodyFromDB);
        
    
        $data['subject'] = $subject = $subjectFromDB;
        $data['content'] = $content = $bodyFromDB;
        $data['message_body'] = $content;

        

        if (env('APP_MODE', '') != 'test') {
            if ($emailConfig['driver']=='smtp' && $emailConfig['email_status'] == 1) {
                Mail::send('emails.general_template', $data, function ($message) use ($receiver, $data, $subject, $content) {
                    $message->to($receiver['email'], $receiver['name'])->subject($subject);
                });

            } elseif ($emailConfig['driver']=='sendmail') {
                $this->sendPhpEmail($data, $emailConfig);
            }
        }
        return true;
    }

    public function notifyUserOfPayoutProcessed($withdrawalID)
    {
        $emailSettings   = Settings::getAll()->where('type', 'email')->toArray();

        $result = $data['result'] = Withdrawal::with('user', 'currency', 'payment_methods')->where('id', $withdrawalID)->first();
        
        $emailConfig     = Common::key_value('name', 'value', $emailSettings);
        $adminDetails    = Admin::where('status', 'active')->first();
        $emailConfig['email_address']= $adminDetails->email;
        $emailConfig['username']     = $adminDetails->username;

        $user            = $result->user;
        $data['url']     = url('/') . '/';
        $data['logo']    = getLogo('file-img');

        $data['user_name']  = $data['first_name'] = $user->first_name;
        $data['email']      = $user->email;
        $data['view']       = resource_path('views/sendmail/general_template.blade.php');

        $userName = $user->first_name . ' ' . $result->user?->last_name;
        $totalAmount = moneyFormat(codeToSymbol($result->currency?->code), $result->amount);

        $englishTemplate = EmailTemplate::where(['temp_id' => 17, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();

        $emailTemplatefromDB = EmailTemplate::where([['temp_id', 17], ['lang', session()->get('language')], ['type','email']])->first();

        if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body)) {
            $subjectFromDB = $emailTemplatefromDB->subject;
            $bodyFromDB    = $emailTemplatefromDB->body;
        } else {
            $subjectFromDB = $englishTemplate->subject;
            $bodyFromDB    = $englishTemplate->body;
        }

        $bodyFromDB     = str_replace('{user_name}', $userName, $bodyFromDB);
        $bodyFromDB     = str_replace('{payment_method}', $result->payment_methods?->name, $bodyFromDB);
        $bodyFromDB     = str_replace('{total_amount}', $totalAmount, $bodyFromDB);
        $bodyFromDB     = str_replace('{accepted_date}', date(setDateForFront(), strtotime($result->updated_at)), $bodyFromDB);
        $bodyFromDB     = str_replace('{company_name}', siteName(), $bodyFromDB);
        
    
        $data['subject'] = $subject = $subjectFromDB;
        $data['content'] = $content = $bodyFromDB;
        $data['message_body'] = $content;

        if (env('APP_MODE', '') != 'test') {
            if ($emailConfig['driver']=='smtp' && $emailConfig['email_status'] == 1) {
                Mail::send('emails.general_template', $data, function ($message) use ($user, $data, $subject, $content) {
                    $message->to($user['email'], $user['name'])->subject($subject);
                });

            } elseif ($emailConfig['driver']=='sendmail') {
                $this->sendPhpEmail($data, $emailConfig);
            }
        }
        return true;
    }

}
