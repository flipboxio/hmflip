<?php

namespace App\Http\Controllers;

use Auth, DB, Session, Validator, DateTime, Common, DatePeriod, DateInterval;
use App\Http\Controllers\{
    CalendarController,
    EmailController
};
use Illuminate\Http\Request;
use App\Models\{Favourite,
    LeaseType,
    Properties,
    PropertyDetails,
    PropertyAddress,
    PropertyPhotos,
    PropertyPrice,
    PropertyType,
    PropertyDescription,
    Currency,
    Settings,
    Bookings,
    SpaceType,
    BedType,
    PropertySteps,
    Country,
    Amenities,
    AmenityType,
    PropertyDates};

class PropertyController extends Controller
{

    public function userProperties(Request $request)
    {
        switch ($request->status) {
            case 'Listed':
            case 'Unlisted':
                $pram = [['status', '=', $request->status]];
                break;
            default:
                $pram = [];
                break;
        }
        $data['property_approval'] = Settings::getAll()->firstWhere('name', 'property_approval')->value;
        $data['status'] = $request->status;
        $data['properties'] = Properties::with('property_price', 'property_address')
                                ->where('host_id', Auth::id())
                                ->where($pram)
                                ->orderBy('id', 'desc')
                                ->paginate(Session::get('row_per_page'));
        $data['currentCurrency'] =  Common::getCurrentCurrency();
        return view('property.listings', $data);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = array(
                'property_type_id'  => 'required',
                'space_type'        => 'required',
                'accommodates'      => 'required',
                'map_address'       => 'required',
            );

            $fieldNames = array(
                'property_type_id'  => 'Home Type',
                'space_type'        => 'Room Type',
                'accommodates'      => 'Accommodates',
                'map_address'       => 'City',
            );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $property                  = new Properties;
                $property->host_id         = Auth::id();
                $property->name            = SpaceType::getAll()->find($request->space_type)->name . ' in ' . $request->city;
                $property->property_type   = $request->property_type_id;
                $property->space_type      = $request->space_type;
                $property->accommodates    = $request->accommodates;
                $property->slug            = Common::pretty_url($property->name);

                $adminPropertyApproval     = settings('property_approval');

                $property->is_verified     = ($adminPropertyApproval == 'Yes') ? 'Pending' : 'Approved';

                $property->save();

                $property_address                 = new PropertyAddress;
                $property_address->property_id    = $property->id;
                $property_address->address_line_1 = $request->route;
                $property_address->city           = $request->city;
                $property_address->state          = $request->state;
                $property_address->country        = $request->country;
                $property_address->postal_code    = $request->postal_code;
                $property_address->latitude       = $request->latitude;
                $property_address->longitude      = $request->longitude;
                $property_address->save();

                $property_price                 = new PropertyPrice;
                $property_price->property_id    = $property->id;
                $property_price->currency_code  = \Session::get('currency');
                $property_price->save();

                $property_steps                   = new PropertySteps;
                $property_steps->property_id      = $property->id;
                $property_steps->save();

                $property_description              = new PropertyDescription;
                $property_description->property_id = $property->id;
                $property_description->save();

                return redirect('listing/' . $property->id . '/basics');
            }
        }

        $data['property_type'] = PropertyType::getAll()->where('status', 'Active')->pluck('name', 'id');
        $data['space_type']    = SpaceType::getAll()->where('status', 'Active')->pluck('name', 'id');

        return view('property.create', $data);
    }

    public function listing(Request $request, CalendarController $calendar)
    {
        $step            = $request->step;
        $property_id     = $request->id;
        $data['step']    = $step;
        $data['result']  = Properties::where('host_id', Auth::id())->findOrFail($property_id);
        $data['details'] = PropertyDetails::pluck('value', 'field');
        $data['missed']  = PropertySteps::where('property_id', $request->id)->first();

        if ($data['result']->steps_completed == 0 && $data['result']->is_verified == 'Pending') {
            try {

                $email_controller = new EmailController;
                $email_controller->notifyAdminForPropertyApproval($data['result']);
    
    
            } catch (\Exception $e) {
                Common::one_time_message('danger', __('Email was not sent due to :x', ['x' => __($e->getMessage())]));
                return redirect('properties');
            }
        }

        if ($step == 'basics') {
            if ($request->isMethod('post')) {
                $property                     = Properties::find($property_id);
                $property->bedrooms           = $request->bedrooms;
                $property->beds               = $request->beds;
                $property->bathrooms          = $request->bathrooms;
                $property->bed_type           = $request->bed_type;
                $property->property_type      = $request->property_type;
                $property->space_type         = $request->space_type;
                $property->accommodates       = $request->accommodates;
                $property->save();

                $property_steps         = PropertySteps::where('property_id', $property_id)->first();
                $property_steps->basics = 1;
                $property_steps->save();
                return redirect('listing/' . $property_id . '/description');
            }

            $data['bed_type']       = BedType::getAll()->pluck('name', 'id');
            $data['property_type']  = PropertyType::getAll()->where('status', 'Active')->pluck('name', 'id');
            $data['space_type']     = SpaceType::getAll()->pluck('name', 'id');

//            if (n_as_k_c()) {
//                Session::flush();
//                return view('vendor.installer.errors.user');
//            }
        } elseif ($step == 'description') {
            if ($request->isMethod('post')) {

                $rules = array(
                    'name'     => 'required|max:50',
                    'summary'  => 'required|max:1000'
                );

                $fieldNames = array(
                    'name'     => 'Name',
                    'summary'  => 'Summary',
                );

                $validator = Validator::make($request->all(), $rules);
                $validator->setAttributeNames($fieldNames);

                if ($validator->fails())
                {
                    return back()->withErrors($validator)->withInput();
                }
                else
                {
                    $property           = Properties::find($property_id);
                    $property->name     = $request->name;
                    $property->slug     = Common::pretty_url($request->name);
                    $property->save();

                    $property_description              = PropertyDescription::where('property_id', $property_id)->first();
                    $property_description->summary     = $request->summary;
                    $property_description->save();

                    $property_steps              = PropertySteps::where('property_id', $property_id)->first();
                    $property_steps->description = 1;
                    $property_steps->save();
                    return redirect('listing/' . $property_id . '/location');
                }
            }
            $data['description']       = PropertyDescription::where('property_id', $property_id)->first();
        } elseif ($step == 'details') {
            if ($request->isMethod('post')) {
                $property_description                       = PropertyDescription::where('property_id', $property_id)->first();
                $property_description->about_place          = $request->about_place;
                $property_description->place_is_great_for   = $request->place_is_great_for;
                $property_description->guest_can_access     = $request->guest_can_access;
                $property_description->interaction_guests   = $request->interaction_guests;
                $property_description->other                = $request->other;
                $property_description->about_neighborhood   = $request->about_neighborhood;
                $property_description->get_around           = $request->get_around;
                $property_description->save();

                return redirect('listing/' . $property_id . '/description');
            }
        } elseif ($step == 'location') {
            if ($request->isMethod('post')) {
                $rules = array(
                    'address_line_1'    => 'required|max:250',
                    'address_line_2'    => 'max:250',
                    'country'           => 'required',
                    'city'              => 'required',
                    'state'             => 'required',
                    'latitude'          => 'required|not_in:0',
                );

                $fieldNames = array(
                    'address_line_1' => 'Address Line 1',
                    'country'        => 'Country',
                    'city'           => 'City',
                    'state'          => 'State',
                    'latitude'       => 'Map',
                );

                $messages = [
                    'not_in' => 'Please set :attribute pointer',
                ];

                $validator = Validator::make($request->all(), $rules, $messages);
                $validator->setAttributeNames($fieldNames);

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                } else {
                    $property_address                 = PropertyAddress::where('property_id', $property_id)->first();
                    $property_address->address_line_1 = $request->address_line_1;
                    $property_address->address_line_2 = $request->address_line_2;
                    $property_address->latitude       = $request->latitude;
                    $property_address->longitude      = $request->longitude;
                    $property_address->city           = $request->city;
                    $property_address->state          = $request->state;
                    $property_address->country        = $request->country;
                    $property_address->postal_code    = $request->postal_code;
                    $property_address->save();

                    $property_steps           = PropertySteps::where('property_id', $property_id)->first();
                    $property_steps->location = 1;
                    $property_steps->save();

                    return redirect('listing/' . $property_id . '/amenities');
                }
            }
            $data['country']       = Country::pluck('name', 'short_name');
        } elseif ($step == 'amenities') {
            if ($request->isMethod('post') && is_array($request->amenities)) {
                $rooms            = Properties::find($request->id);
                $rooms->amenities = implode(',', $request->amenities);
                $rooms->save();
                return redirect('listing/' . $property_id . '/photos');
            }
            $data['property_amenities'] = explode(',', $data['result']->amenities);
            $data['amenities']          = Amenities::where('status', 'Active')->get();
            $data['amenities_type']     = AmenityType::get();
        } elseif ($step == 'photos') {
            if ($request->isMethod('post')) {
                if ($request->crop == 'crop' && $request->photos) {
                    $baseText = explode(";base64,", $request->photos);
                    $name = explode(".", $request->img_name);
                    $convertedImage = base64_decode($baseText[1]);
                    $request->request->add(['type'=>end($name)]);
                    $request->request->add(['image'=>$convertedImage]);


                    $validate = Validator::make($request->all(), [
                        'type' => 'required|in:png,jpg,JPG,JPEG,jpeg,bmp',
                        'img_name' => 'required',
                        'photos' => 'required',
                    ]);
                } else {
                    $validate = Validator::make($request->all(), [
                        'file' => 'required|file|mimes:jpg,jpeg,bmp,png,gif,JPG|dimensions:min_width=640,min_height=360',
                    ]);
                }

                if ($validate->fails()) {
                    return back()->withErrors($validate)->withInput();
                }

                $path = public_path('images/property/' . $property_id . '/');

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                if ($request->crop == "crop") {
                    $image = $name[0].uniqid() . '.' . end($name);
                    $uploaded = file_put_contents($path . $image, $convertedImage);
                } else {
                    if (isset($_FILES["file"]["name"])) {
                        $tmp_name = $_FILES["file"]["tmp_name"];
                        $name = str_replace(' ', '_', $_FILES["file"]["name"]);
                        $ext = pathinfo($name, PATHINFO_EXTENSION);
                        $image = time() . '_' . $name;
                        $path = 'public/images/property/' . $property_id;
                        if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'JPG') {
                            $uploaded = move_uploaded_file($tmp_name, $path . "/" . $image);
                        }
                    }
                }

                if ($uploaded) {
                    $photos = new PropertyPhotos;
                    $photos->property_id = $property_id;
                    $photos->photo = $image;
                    $photos->serial = 1;
                    $photos->cover_photo = 1;

                    $exist = PropertyPhotos::orderBy('serial', 'desc')
                        ->select('serial')
                        ->where('property_id', $property_id)
                        ->take(1)->first();

                    if (!empty($exist->serial)) {
                        $photos->serial = $exist->serial + 1;
                        $photos->cover_photo = 0;
                    }
                    $photos->save();
                    $property_steps = PropertySteps::where('property_id', $property_id)->first();
                    $property_steps->photos = 1;
                    $property_steps->save();
                }

                return redirect('listing/' . $property_id . '/photos')->with('success', 'File Uploaded Successfully!');

            }

            $data['photos'] = PropertyPhotos::where('property_id', $property_id)
                ->orderBy('serial', 'asc')
                ->get();

        } elseif ($step == 'pricing') {
            if ($request->isMethod('post')) {
                $bookings = Bookings::where('property_id', $property_id)->where('currency_code', '!=', $request->currency_code)->first();
                if ($bookings) {
                    return back()->withErrors(['currency' => __('Booking has been made using the current currency. It cannot be changed now')]);
                }
                $rules = array(
                    'price' => 'required|numeric|min:5',
                    'weekly_discount' => 'nullable|numeric|max:99|min:0',
                    'monthly_discount' => 'nullable|numeric|max:99|min:0'
                );

                $fieldNames = array(
                    'price'  => 'Price',
                    'weekly_discount' => 'Weekly Discount Percent',
                    'monthly_discount' => 'Monthly Discount Percent'
                );

                $validator = Validator::make($request->all(), $rules);
                $validator->setAttributeNames($fieldNames);

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                } else {
                    $property_price                    = PropertyPrice::where('property_id', $property_id)->first();
                    $property_price->price             = $request->price;
                    $property_price->weekly_discount   = $request->weekly_discount;
                    $property_price->monthly_discount  = $request->monthly_discount;
                    $property_price->currency_code     = $request->currency_code;
                    $property_price->cleaning_fee      = $request->cleaning_fee;
                    $property_price->guest_fee         = $request->guest_fee;
                    $property_price->guest_after       = $request->guest_after;
                    $property_price->security_fee      = $request->security_fee;
                    $property_price->weekend_price     = $request->weekend_price;
                    $property_price->save();

                    $property_steps = PropertySteps::where('property_id', $property_id)->first();
                    $property_steps->pricing = 1;
                    $property_steps->save();

                    return redirect('listing/' . $property_id . '/booking');
                }
            }
        } elseif ($step == 'booking') {
            if ($request->isMethod('post')) {


                $property_steps          = PropertySteps::where('property_id', $property_id)->first();
                $property_steps->booking = 1;
                $property_steps->save();

                $properties               = Properties::find($property_id);
                $properties->booking_type = $request->booking_type;
                $properties->status       = ( $properties->steps_completed == 0 ) ?  'Listed' : 'Unlisted';
                $properties->save();


                return redirect('listing/' . $property_id . '/calendar');
            }
        } elseif ($step == 'calendar') {
            $data['calendar'] = $calendar->generate($request->id);
        } elseif ($step == 'lease') {
            if ($request->isMethod('post') && is_array($request->lease_types)) {
                $property = Properties::find($request->id);
                $property->lease_type = implode(',', $request->lease_types);
                $property->save();
                return redirect('listing/' . $property_id . '/basics');
            }
            $data['property_leases'] = explode(',', $data['result']->lease_type);
//            $data['leases'] = LeaseType::where('status', 'Active')->get();
            $data['lease_types']     = LeaseType::get();

        }

        return view("listing.$step", $data);
    }


    public function updateStatus(Request $request)
    {
        $property_id = $request->id;
        $reqstatus = $request->status;
        if ($reqstatus == 'Listed') {
            $status = 'Unlisted';
        } else {
            $status = 'Listed';
        }
        $properties         = Properties::where('host_id', Auth::id())->find($property_id);
        $properties->status = $status;
        $properties->save();
        $properties->prop_status = __($status);
        return  response()->json($properties);

    }

    public function getPrice(Request $request)
    {

        return Common::getPrice($request->property_id, $request->checkin, $request->checkout, $request->guest_count);
    }

    public function single(Request $request)
    {

        $data['result'] = Properties::with('users', 'property_photos', 'property_address')
                            ->where('slug', $request->slug)
                            ->first();

        if (empty($data['result'])) {

            Common::one_time_message('error', __('No property data were found.'));
            return redirect('dashboard');
        }

        if ($data['result']->users?->status == 'Inactive' ) {
            return view('property.host_inactive');

        } elseif ($data['result']->status == 'Unlisted' ) {
            return view('property.unlisted_property');

        } elseif ($data['result']->is_verified == 'Pending') {

            return view('property.pending_property');

        } else {

            $this->makeExpiredDatesAvailable($data['result']->id);

            $data['amenities']        = Amenities::normal($data['result']->id);
            $data['safetyAmenities']  = Amenities::security($data['result']->id);

            $newAmenityTypes          = Amenities::newAmenitiesType();
            $data['allNewAmenities']  = [];

            foreach ($newAmenityTypes as $amenites) {
                $data['allNewAmenities'][$amenites->name] = Amenities::newAmenities($data['result']->id, $amenites->id);
            }

            $data['allNewAmenities']  = array_filter($data['allNewAmenities']);

            $latitude                 = $data['result']->property_address->latitude;

            $longitude                = $data['result']->property_address->longitude;

            $data['checkin'] = $request->checkin ?? '';
            $data['checkout'] = $request->checkout ?? '';
            $data['guests'] = $request->guests ?? '';

            $data['similar'] = Properties::with('property_address')
                                ->join('property_address', 'properties.id', '=', 'property_address.property_id')
                                ->select([
                                    'properties.id',
                                    'properties.slug',
                                    'properties.host_id',
                                    'properties.name',
                                    'properties.accommodates',
                                    'properties.bedrooms',
                                    'properties.bathrooms'
                                ])
                                ->selectRaw(
                                    '(3959 * acos(cos(radians(?)) * cos(radians(property_address.latitude)) * cos(radians(property_address.longitude) - radians(?)) + sin(radians(?)) * sin(radians(property_address.latitude)))) as distance',
                                    [$latitude, $longitude, $latitude]
                                )
                                ->where('properties.host_id', '!=', Auth::id())
                                ->where('properties.id', '!=', $data['result']->id)
                                ->where('properties.status', '=', 'Listed')
                                ->having('distance', '<=', 30)  
                                ->get();

            $data['title']    =   $data['result']->name . ' in ' . $data['result']->property_address?->city;
            $data['symbol'] = Common::getCurrentCurrencySymbol();
            $data['shareLink'] = url('properties/' . $request->slug);

            $data['dateFormat'] = Settings::getAll()->firstWhere('name', 'date_format_type')->value;

            $data['adminPropertyApproval'] = Settings::getAll()->firstWhere('name', 'property_approval')->value;

            return view('property.single', $data);

        }
    }

    public function currencySymbol(Request $request)
    {
        $symbol          = Currency::code_to_symbol($request->currency);
        $data['success'] = 1;
        $data['symbol']  = $symbol;

        return json_encode($data);
    }

    public function photoMessage(Request $request)
    {
        $property = Properties::find($request->id);
        if ($property->host_id == \Auth::user()->id) {
            $photos = PropertyPhotos::find($request->photo_id);
            $photos->message = $request->messages;
            $photos->save();
        }

        return json_encode(['success'=>'true']);
    }

    public function photoDelete(Request $request)
    {
        $property   = Properties::find($request->id);
        if ($property->host_id == \Auth::user()->id) {
            $photos = PropertyPhotos::find($request->photo_id);
            $photos->delete();
        }

        return json_encode(['success'=>'true']);
    }

    public function makeDefaultPhoto(Request $request)
    {

        if ($request->option_value == 'Yes') {
            PropertyPhotos::where('property_id', '=', $request->property_id)
            ->update(['cover_photo' => 0]);

            $photos = PropertyPhotos::find($request->photo_id);
            $photos->cover_photo = 1;
            $photos->save();
        }
        return json_encode(['success'=>'true']);
    }

    public function makePhotoSerial(Request $request)
    {

        $photos         = PropertyPhotos::find($request->id);
        $photos->serial = $request->serial;
        $photos->save();

        return json_encode(['success'=>'true']);
    }


    public function set_slug()
    {

       $properties   = Properties::where('slug', NULL)->get();
       foreach ($properties as $key => $property) {

           $property->slug     = Common::pretty_url($property->name);
           $property->save();
       }
       return redirect('/');

    }

    public function userBookmark()
    {

        $data['bookings'] = Favourite::with(['properties' => function ($q) {
            $q->with('property_address');
        }])->where(['user_id' => Auth::id(), 'status' => 'Active'])->orderBy('id', 'desc')
            ->paginate(Settings::getAll()->where('name', 'row_per_page')->first()->value);
        return view('users.favourite', $data);
    }

    public function addEditBookMark()
    {
        $property_id = request('id');
        $user_id = request('user_id');

        $favourite = Favourite::where('property_id', $property_id)->where('user_id', $user_id)->first();

        if (empty($favourite)) {
            $favourite = Favourite::create([
                'property_id' => $property_id,
                'user_id' => $user_id,
                'status' => 'Active',
            ]);

        } else {
            $favourite->status = ($favourite->status == 'Active') ? 'Inactive' : 'Active';
            $favourite->save();
        }

        return response()->json([
            'favourite' => $favourite
        ]);
    }

    public function unauthenticationFavourite($id) 
    {
        Session::put('favourite_property', $id);

        return redirect('login');

    }

    /**
    * Makes expired booking dates available for a given property.
    * 
    * @param int $propertyId The ID of the property for which expired dates need to be updated.
    * @return void
    */
    public function makeExpiredDatesAvailable(int $propertyId): void
    {
        $existBooking = Bookings::where('property_id', $propertyId)
            ->where('status', 'Pending')
            ->where('created_at', '>=', now()->subDay())
            ->get();

        if ($existBooking->isNotEmpty()) {
            foreach ($existBooking as $booking) {
                $dates = $this->getBookingDatesList($booking->start_date, $booking->end_date);

                if (!empty($dates)) {
                    PropertyDates::where('property_id', $propertyId)
                        ->whereIn('date', $dates)
                        ->update(['status' => 'Available']);
                }
            }
        }
    }


    /**
    * Get a list of booking dates between the start and end date, excluding past dates.
    *
    * @param string $startDate The start date in 'Y-m-d' format.
    * @param string $endDate   The end date in 'Y-m-d' format.
    * @return array            An array of available booking dates.
    */
    private function getBookingDatesList(string $startDate, string $endDate): array
    {
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $interval = new DateInterval('P1D');
        $dateRange = new DatePeriod($start, $interval, $end);

        $dates = [];
        foreach ($dateRange as $date) {
            if ($date->format('Y-m-d') >= date("Y-m-d")) {
                $dates[] = $date->format('Y-m-d');
            }
        }

        // Ensure the end date is included if there are no other dates and it's valid
        if ($end->format('Y-m-d') >= date("Y-m-d") && !in_array($end->format('Y-m-d'), $dates) && count($dates) === 0) {
            $dates[] = $end->format('Y-m-d');
        }

        return $dates;
    }

}
