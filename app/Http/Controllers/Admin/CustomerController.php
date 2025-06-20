<?php
/**
 * Customer Controller
 *
 * Customer Controller manages Customer by admin.
 *
 * @category   Customer
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

use PDF, DB, Session, Validator, Common, Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Exports\CustomersExport;
use App\DataTables\{
    CustomerDataTable,
    PropertyDataTable,
    BookingsDataTable,
    PayoutsDataTable,
    WalletsDataTable
};
use App\Models\{
    User,
    UsersVerification,
    Wallet,
    Properties,
    SpaceType,
    Settings,
    Accounts,
    Country,
    Bookings,
    Messages
};

class CustomerController extends Controller
{

    public function index(CustomerDataTable $dataTable)
    {
        $data['from'] = isset(request()->from) ? request()->from : null;
        $data['to']   = isset(request()->to) ? request()->to : null;


        if (isset(request()->customer)) {
            $data['customers'] = User::where('users.id', request()->customer )->select('id', 'first_name', 'last_name')->get();
        } else {
            $data['customers'] = User::all();
        }

        if (isset(request()->reset_btn)) {
            $data['from']        = null;
            $data['to']          = null;
            $data['allstatus']   = '';
            $data['allcustomers']   = '';
            return $dataTable->render('admin.customers.view', $data);
        }
        $pref = Settings::getAll()->where('type', 'preferences');
        if (! empty($pref)) {
            foreach ($pref as $value) {
                $prefer[$value->name] = $value->value;
            }
            Session::put($prefer);
        }

        isset(request()->customer) ? $data['allcustomers'] = request()->customer : $data['allcustomers']    = '';
        isset(request()->status) ? $data['allstatus'] = $allstatus = request()->status : $data['allstatus'] = $allstatus = '';

        return $dataTable->render('admin.customers.view', $data);
    }

    public function searchCustomer(Request $request)
    {
        $str = $request->term;

        if ($str == null) {
            $myresult = User::select('id', 'first_name', 'last_name')->take(5)->get();
        } else {
            $myresult = User::where('users.first_name', 'LIKE', '%'.$str.'%')->orWhere('users.last_name', 'LIKE', '%'.$str.'%')->select('users.id','users.first_name', 'users.last_name')->get();
        }

        if ($myresult->isEmpty()) {
            $myArr=null;
        } else {
            $arr2 = array(
                "id"   => "",
                "text" => "All"
              );
              $myArr[] = ($arr2);
            foreach ($myresult as $result) {
                $arr = array(
                  "id"   => $result->id,
                  "text" => $result->first_name." ".$result->last_name
                );
                $myArr[] = ($arr);
            }
        }
        return $myArr;
    }

    public function add(Request $request, EmailController $email_controller)
    {
        if (! $request->isMethod('post')) {
            return view('admin.customers.add');
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'first_name'    => 'required|max:255',
                'last_name'     => 'required|max:255',
                'email'         => 'required|max:255|email|unique:users',
                'password'      => 'required|min:6'
            );

            $fieldNames = array(
                'first_name'    => 'First_name',
                'last_name'     => 'Last_name',
                'email'         => 'Email',
                'password'      => 'Password'
            );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $user                  = new User;
                $user->first_name      = strip_tags($request->first_name);
                $user->last_name       = strip_tags($request->last_name);
                $user->email           = $request->email;
                $user->password        = \Hash::make($request->password);
                $user->status          = $request->status;
                $user->profile_image   = NULL;
                $formattedPhone        = str_replace('+' . $request->carrier_code, "", $request->formatted_phone);
                $user->phone           = !empty($request->phone) ? preg_replace("/[\s-]+/", "", $formattedPhone) : NULL;
                $user->default_country = isset($request->default_country) ? $request->default_country : NULL;
                $user->carrier_code    = isset($request->carrier_code) ? $request->carrier_code : NULL;
                $user->formatted_phone = isset($request->formatted_phone) ? $request->formatted_phone : NULL;
                  $user->save();


                $user_verification           = new UsersVerification;
                $user_verification->user_id  =   $user->id;
                $user_verification->save();
                $this->wallet($user->id);
                $errorMessage = '';
                try {

                    $email_controller->welcome_email($user);

                } catch (\Exception $e) {

                    $errorMessage = ' Email was not sent due to '.$e->getMessage();

                }

                Common::one_time_message('success', 'Added Successfully.'.''.$errorMessage);
                return redirect('admin/customers');
            }
        }
    }

    public function ajaxCustomerAdd(Request $request, EmailController $email_controller)
    {
        $data = [];
        if ($request->isMethod('post')) {
            $rules = array(
                'first_name'    => 'required|max:255',
                'last_name'     => 'required|max:255',
                'email'         => 'required|max:255|email|unique:users',
                'password'      => 'required|min:6'
            );

            $fieldNames = array(
                'first_name'    => 'First_name',
                'last_name'     => 'Last_name',
                'email'         => 'Email',
                'password'      => 'Password'
            );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $user                  = new User;
                $user->first_name      = $request->first_name;
                $user->last_name       = $request->last_name;
                $user->email           = $request->email;
                $user->password        = \Hash::make($request->password);
                $user->status          = $request->status;
                $user->profile_image   = NULL;
                $formattedPhone        = str_replace('+' . $request->carrier_code, "", $request->formatted_phone);
                $user->phone           = !empty($request->phone) ? preg_replace("/[\s-]+/", "", $formattedPhone) : NULL;
                $user->default_country = isset($request->default_country) ? $request->default_country : NULL;
                $user->carrier_code    = isset($request->carrier_code) ? $request->carrier_code : NULL;
                $user->formatted_phone = isset($request->formatted_phone) ? $request->formatted_phone : NULL;
                $user->save();
                $this->wallet( $user->id);

                $user_verification           = new UsersVerification;
                $user_verification->user_id  =   $user->id;
                $user_verification->save();

                $data = ['status' => 1,'user' => $user];
            }
        return $data;
     }
   }
    public function customerProperties(PropertyDataTable $dataTable, $id)
    {
        $data['properties_tab'] = 'active';
        $data['user'] = DB::table('users')->where('id',$id)->first();

        $data['from'] = isset(request()->from) ? request()->from:null;
        $data['to']   = isset(request()->to) ? request()->to:null;
        $data['space_type_all'] = SpaceType::all('id','name');


        if (isset(request()->reset_btn)) {
            $data['from']        = null;
            $data['to']          = null;
            $data['allstatus']   = '';
            $data['allSpaceType']   = '';
            return $dataTable->render('admin.customerdetails.properties',$data);
        }
        isset(request()->status) ? $data['allstatus'] = $allstatus = request()->status : $data['allstatus'] = $allstatus = '';
        isset(request()->space_type) ? $data['allSpaceType'] = request()->space_type : $data['allSpaceType']  = '';

        return $dataTable->render('admin.customerdetails.properties',$data);

    }

    public function customerBookings(BookingsDataTable $dataTable, $id)
    {
        $data['bookings_tab'] = 'active';
        $data['user']         = DB::table('users')->where('id',$id)->first();

        $data['from'] = isset(request()->from)?request()->from:null;
        $data['to'] = isset(request()->to)?request()->to:null;
        if (isset(request()->property)) {
            $data['properties'] = Properties::where('properties.id',request()->property )->select('id', 'name')->get();
        } else {
            $data['properties'] = null;
        }
        if (isset(request()->reset_btn)) {
            $data['from']        = null;
            $data['to']          = null;
            $data['allstatus']   = '';
            $data['allproperties']   = '';
            return $dataTable->render('admin.customerdetails.bookings', $data);
        }

        isset(request()->property) ? $data['allproperties'] = request()->property : $data['allproperties'] = '';
        isset(request()->status) ? $data['allstatus'] = request()->status : $data['allstatus'] = '';
        return $dataTable->render('admin.customerdetails.bookings', $data);

    }

    public function customerPayouts(PayoutsDataTable $dataTable, $id)
    {
        $data['payouts_tab'] = 'active';
        $data['user'] = DB::table('users')->where('id',$id)->first();

        $data['from'] = isset(request()->from)?request()->from:null;
        $data['to'] = isset(request()->to)?request()->to:null;
        if (isset(request()->property)) {
            $data['properties'] = Properties::where('properties.id',request()->property )->select('id', 'name')->get();
        } else {
            $data['properties'] = null;
        }

        if (isset(request()->reset_btn)) {
            $data['from']        = null;
            $data['to']          = null;
            $data['allstatus']   = '';
            $data['alltypes']   = '';
            $data['allproperties']   = '';
            return $dataTable->render('admin.customerdetails.payouts', $data);
        }
        isset(request()->property) ? $data['allproperties'] = request()->property : $data['allproperties'] = '';
        isset(request()->status) ? $data['allstatus'] = request()->status : $data['allstatus'] = '';
        isset(request()->types) ? $data['alltypes'] = request()->types : $data['alltypes'] = '';

        return $dataTable->render('admin.customerdetails.payouts', $data);
    }

    public function paymentMethods($id)
    {
        $data['payment_methods_tab'] = 'active';
        $data['user'] = DB::table('users')->where('id',$id)->first();

        $data['payouts']  = Accounts::where('user_id', $id)->orderBy('id','desc')->get();
        $data['country']  = Country::all()->pluck('name','short_name');

        return view('admin.customerdetails.payment_methods', $data);
    }

    public function update(Request $request)
    {
        $data['user'] = DB::table('users')->where('id',$request->id)->first();

        if (! $request->isMethod('post')) {
            $data['customer_edit_tab'] = 'active';
            $data['form_name'] = 'Edit Customer';
            return view('admin.customers.edit', $data);

        } elseif ($request->isMethod('post')) {
            $rules = array(
                'first_name'    => 'required|max:255',
                'last_name'     => 'required|max:255',
                'email'       => 'required|max:255|email|unique:users,email,'.$data['user']->id,

            );
             $messages = array(
                'email' => 'Email already existed.',

            );


            $fieldNames = array(
                'first_name'    => 'First Name',
                'last_name'     => 'Last Name',
                 'email'        => 'Email',

            );

            $validator = Validator::make($request->all(), $rules, $messages);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $booking               = Bookings::where('host_id','=',$request->customer_id)->orWhere('user_id','=',$request->customer_id)->whereDate('end_date','>', now())->count();
                $user                  = User::find($request->customer_id);
                $user->first_name      = strip_tags($request->first_name);
                $user->last_name       = strip_tags($request->last_name);
                $user->email           = $request->email;
                $user->status          = $request->status;
                $user->profile_image   = NULL;
                $formattedPhone        = str_replace('+' . $request->carrier_code, "", $request->formatted_phone);
                $user->phone           = !empty($request->phone) ? preg_replace("/[\s-]+/", "", $formattedPhone) : NULL;
                $user->default_country = isset($request->default_country) ? $request->default_country : NULL;
                $user->carrier_code    = isset($request->carrier_code) ? $request->carrier_code : NULL;
                $user->formatted_phone = isset($request->formatted_phone) ? $request->formatted_phone : NULL;
                if ($request->password != '')
                    $user->password = bcrypt($request->password);

                if ($booking > 0 && $user->status == 'Inactive') {

                    Common::one_time_message('danger', "User Can't be Inactive Due to have booking");
                    return redirect('admin/customers');

                } else {

                    $user->save();

                    Common::one_time_message('success', 'Updated Successfully');
                    return redirect('admin/customers');
                }

            }
        }
    }
    public function delete(Request $request)
    {
        $propertiesWithBookingsCount = Bookings::where('host_id', $request->id)->where('end_date','>=', date('Y-m-d'))->where('status','Accepted')->count();
        $bookingsCount   = Bookings::where('user_id', $request->id)->where('end_date','>=', date('Y-m-d'))->where('status','Accepted')->count();

        if (env('APP_MODE', '') != 'test') {
            if (($propertiesWithBookingsCount) && ($bookingsCount) > 0) {
                Common::one_time_message('danger', 'Sorry, can not possible to delete it due to both customer properties and customer have reservations.');
            } elseif ($propertiesWithBookingsCount > 0) {
                Common::one_time_message('danger', 'Sorry can not possible to delete it due to customer properties have reservations.');
            } elseif ($bookingsCount > 0) {
                Common::one_time_message('danger', 'Sorry can not possible to delete it due to customer have reservations.');
            } else {
                $user = User::find($request->id);
                if (!empty($user)) {

                    $user->payouts()->update(['deleted_at' => now()]);
                    $user->reviews()->where(['sender_id' => $request->id])->orWhere(['receiver_id' => $request->id])->update(['deleted_at' => now()]);
                    $user->bookings()->where(['user_id' => $request->id])->orWhere(['host_id' => $request->id])->update(['deleted_at' => now()]);
                    $user->properties()->update(['deleted_at' => now()]);
                    $user->withdraw()->update(['deleted_at' => now()]);

                    Messages::where(['sender_id' => $request->id])->orWhere(['receiver_id' => $request->id])->update(['deleted_at' => now()]);
                    Wallet::where('user_id', $request->id)->update(['is_active' => '0']);

                    $user->delete();
                    Common::one_time_message('success', 'Deleted Successfully');
                } else {
                    Common::one_time_message('success', 'Deleted Successfully');
                }
            }
        }

        return redirect('admin/customers');
    }

    public function customerCsv()
    {
        return Excel::download(new CustomersExport, 'customer_sheet' . time() .'.xls');
    }

    public function customerPdf()
    {
        $to                   = setDateForDb(request()->to);
        $from                 = setDateForDb(request()->from);
        $customer             = isset(request()->customer) ? request()->customer : null;

        $data['status']     = $status = isset(request()->status) ? request()->status : null;
        $query= User::orderBy('id', 'desc')->select();

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }
        if ($status){
            $query->where('status','=',$status);
        }
        if ($customer){
            $query->where('id','=',$customer);
        }
        if ($from && $to){
          $data['date_range'] = onlyFormat($from) . ' To ' . onlyFormat($to);
        }

        $data['customerList'] = $query->get();
        $pdf = PDF::loadView('admin.customers.list_pdf', $data, [], [
            'format' => 'A3', [750, 1060]
          ]);

        return $pdf->download('customer_list_' . time() . '.pdf', array("Attachment" => 0));
    }



    public function getCurrentCustomerDetails(Request $request)
    {
        $data        = [];
        $userDetails = User::find($request->customer_id)->makeHidden(['created_at', 'updated_at', 'status', 'profile_image', 'balance', 'profile_src']);
        if ($userDetails->exists()) {
            $data['status']      = true;
            $data['userDetails'] = $userDetails;
        } else {
            $data['status']      = false;
        }
        return $data;
    }
        /**
     * Add for user wallet info
     *
     * @param string Request as $request
     *
     * @return  user info
     */
    public function wallet($userId)
    {
       $defaultCurrencyId    = Settings::getAll()->where('name', 'default_currency')->first();
       $wallet               = new Wallet();
       $wallet->user_id      = $userId;
       $wallet->currency_id  = (int)$defaultCurrencyId->value;
       $wallet->save();

    }
      public function customerWallet(WalletsDataTable $dataTable, $id)
    {

        $data['wallet']      = 'active';
        $data['user']         = DB::table('users')->where('id',$id)->first();

        return $dataTable->render('admin.customerdetails.wallets', $data);

    }
}

