<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\{
    Controller, 
    IcalendarController
};
use App\Http\Requests\CalendarPriceSetRequest;
use App\Models\{
    PropertyPrice,
    PropertyDates,
    PropertyIcalimport
};
use Validator, Session, Common, Cache;
use Illuminate\Routing\UrlGenerator;

class CalendarController extends Controller
{
    public $startDay = 'monday';
    protected $url;

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    public function generate($propertyId = '', $year = '', $month = '')
    {
        if ($year == '') {
            $year  = date('Y');
        }

        if ($month == '') {
            $month = date('m');
        }

        $propertyPrice = PropertyPrice::where('property_id', $propertyId)->first();

        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $startDays = array('sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6);
        $startDay  = (! isset($startDays[$this->startDay])) ? 0 : $startDays[$this->startDay];

        $localDate  = mktime(12, 0, 0, $month, 1, $year);

        $date       = getdate($localDate);
        $day        = $startDay + 1 - $date["wday"];

        $prvTime  = mktime(12, 0, 0, $month - 1, 1, $year);
        $nxtTime  = mktime(12, 0, 0, $month + 1, 1, $year);


        $prvMonth = date('m', $prvTime);
        $nxtMonth = date('m', $nxtTime);

        $prvYear  = date('Y', $prvTime);
        $nxtYear  = date('Y', $nxtTime);


        $curDay    = date('j');
        $curYear   = date('Y');
        $curMonth  = date('m');
        $currentDate =  new \DateTime($curDay ."-". $curMonth ."-". $curYear);
        $prevTotalDays = date('t', $prvTime);

        while ($day > 1) {
            $day -= 7;
        }

        $monthSelect = '<select name="year_month" id="calendar_dropdown">';
        $yearMonth   = $this->yearMonth();
        foreach ($yearMonth as $key => $value) {
            $selected = date('Y-m', $localDate) == $key ? 'selected' : '';
            $monthSelect .= '<option value="'. $key .'" '. $selected .'>'. $value .'</option>';
        }
        $monthSelect .= '</select>';

        $out = '';
        $out .= '<div class="host-calendar-container">
                    <div class="calendar-month">';

        $out .= '<div class="row-space-2 deselect-on-click">
                    <a href="'. url('admin/manage-listing/'. $propertyId .'/calendar') .'" class="month-nav month-nav-previous panel text-center" data-year="'. $prvYear .'" data-month="'. $prvMonth .'"> <i class="fa fa-chevron-left fa-lg calendar-icon-style"></i> </a>
                    <a href="'. url('admin/manage-listing/'. $propertyId .'/calendar') .'" class="month-nav month-nav-next panel text-center" data-year="'. $nxtYear .'" data-month="'. $nxtMonth .'"> <i class="fa fa-chevron-right fa-lg calendar-icon-style"></i> </a>
                    <div class="current-month-selection"> <h2> <span>'. date('F Y', $localDate) .'</span> <span> &nbsp;</span> <span class="current-month-arrow">▾</span> </h2>'. $monthSelect .'<div class="spinner-next-to-month-nav">Just a moment...</div></div>
                 </div>';

        $out .= '<div class="col-md-12 col-sm-12 col-xs-12"><div class="calenBox">';
        $out .='<div class="margin-top10">
                    <div class="col-md-02"><div class="wkText">Mon</div></div>
                    <div class="col-md-02"><div class="wkText">Tue</div></div>
                    <div class="col-md-02"><div class="wkText">Wed</div></div>
                    <div class="col-md-02"><div class="wkText">Thu</div></div>
                    <div class="col-md-02"><div class="wkText">Fri</div></div>
                    <div class="col-md-02"><div class="wkText">Sat</div></div>
                    <div class="col-md-02"><div class="wkText">Sun</div></div>
                </div>';

        while ($day <= $totalDays) {
            for ($i = 0; $i < 7; $i++) {
                $class = '';
                if ($day < $curDay && $year <= $curYear && $month <= $curMonth) {
                    $class = 'dt-not-available';
                } elseif ($year < $curYear || $month < $curMonth) {
                    $class = 'dt-not-available';
                } elseif ($day == $curDay && $year == $curYear && $month == $curMonth) {
                    $class = 'dt-today';
                }

                if ($year > $curYear) {
                    $class = '';
                }

                $today = '';
                if ($day == $curDay && $year == $curYear && $month == $curMonth) {
                    $today = 'Today';
                }


                if ($day > 0 && $day <= $totalDays) {
                    $date      = $year .'-'. $month .'-'. $this->zeroDigit($day);
                    $finalDay = $day;
                } else {
                    if ($day <= 0) {
                        $dayPrev  = $prevTotalDays + $day;

                        $date      = $prvYear .'-'. $prvMonth .'-'. $this->zeroDigit($dayPrev);

                        $finalDay = $dayPrev;
                    } elseif ($day > $totalDays) {
                        $dayNext  = $day - $totalDays;

                        $date      = $nxtYear .'-'. $nxtMonth .'-'. $this->zeroDigit($dayNext);

                        $finalDay = $dayNext;
                    }
                }
                $propertyPrice->getPropertyDates($date);

                $dateGreaterThanToday = (new \DateTime($date)) > $currentDate;
                //Price Type CALENDAR
                if ( $dateGreaterThanToday && ($propertyPrice->available() == 'Not available') && ($propertyPrice->type() == 'calendar') && (($propertyPrice->color()) != null)) {
                    $class = 'dt-available-with-events';
                    
                    $out .= '<div class="col-md-02">
                                <div class="calender_box date-package-modal-admin"  style="background-color:'. $propertyPrice->color() .' !important " id="'. $date .'" data-day="'. $day .'" data-month="'. $month .'" data-year="'. $year .'" data-price="'. $propertyPrice->original_price() .'"data-status="'. $propertyPrice->available(). '"data-minday="'. $propertyPrice->min_day() .'">
                                    <div class="wkText final_day">'. $finalDay .' '. $today .'</div>
                                    <div class="dTfont wkText">'. $propertyPrice->currency->org_symbol . $propertyPrice->original_price() .'</div>
                                </div>
                            </div>';
                } elseif (($year >= $curYear && $month >= $curMonth) && ($propertyPrice->available() == 'Not available') && ($propertyPrice->type() == 'calendar') && (($propertyPrice->color()) != null)) {
                    if (! $dateGreaterThanToday) {
                        $class = 'dt-not-available';
                        $out .= '<div class="col-md-02">
                                    <div class="calender_box date-package-modal-admin '. $class .'" id="'. $date .'" data-day="'. $day .'" data-month="'. $month .'" data-year="'. $year .'" data-price="'. $propertyPrice->original_price() .'"data-status="'. $propertyPrice->available() .'"data-minday="'. $propertyPrice->min_day() .'">
                                        <div class="wkText final_day">'. $finalDay .' '. $today .'</div>
                                        <div class="dTfont wkText">'. $propertyPrice->currency->org_symbol . $propertyPrice->original_price() .'</div>
                                    </div>
                                </div>';
                    } else {
                        $out .= '<div class="col-md-02">
                                    <div class="calender_box date-package-modal-admin '. $class .'"  style="background-color:'. $propertyPrice->color() .' !important " id="'. $date .'" data-day="'. $day .'" data-month="'. $month .'" data-year="'. $year .'" data-price="'. $propertyPrice->original_price() .'"data-status="'. $propertyPrice->available() .'"data-minday="'. $propertyPrice->min_day() .'">
                                        <div class="wkText final_day">'. $finalDay .' '. $today .'</div>
                                        <div class="dTfont wkText">'. $propertyPrice->currency->org_symbol . $propertyPrice->original_price() .'</div>
                                    </div>
                                </div>';
                    }
                }

                //Price type NORMAL
                elseif ($dateGreaterThanToday && ($propertyPrice->available() == 'Not available') && ($propertyPrice->type() == 'normal')) {
                    $class = 'dt-available-with-events';
                    $out .= '<div class="col-md-02">
                                    <div class="calender_box date-package-modal-admin '. $class .'" id="'. $date .'" data-day="'. $day .'" data-month="'. $month .'" data-year="'. $year .'" data-price="'. $propertyPrice->original_price() .'"data-status="'. $propertyPrice->available() .'"data-minday="'. $propertyPrice->min_day() .'">
                                        <div class="wkText final_day">'. $finalDay .' '. $today .'</div>
                                        <div class="dTfont wkText">'. $propertyPrice->currency->org_symbol . $propertyPrice->original_price() .'</div>
                                    </div>
                                </div>';
                } elseif ($dateGreaterThanToday && ($propertyPrice->available() == 'Not available') && ($propertyPrice->type() == 'normal')) {
                    if (! $dateGreaterThanToday) {
                        $class = 'dt-not-available';
                    } else {
                         $class = 'dt-available-with-events';
                    }

                    $out .= '<div class="col-md-02">
                                    <div class="calender_box date-package-modal-admin '. $class .'" id="'. $date .'" data-day="'. $day .'" data-month="'. $month .'" data-year="'.$year.'" data-price="'. $propertyPrice->original_price() .'"data-status="'. $propertyPrice->available() .'"data-minday="'. $propertyPrice->min_day() .'">
                                        <div class="wkText final_day">'. $finalDay .' '. $today .'</div>
                                        <div class="dTfont wkText">'. $propertyPrice->currency->org_symbol . $propertyPrice->original_price() .'</div>
                                    </div>
                                </div>';
                } else {
                    $out .= '<div class="col-md-02" style="cursor:pointer">
                                <div class="calender_box date-package-modal-admin '. $class .'" id="'. $date .'" data-day="'. $day .'" data-month="'. $month .'" data-year="'. $year .'" data-price="'. $propertyPrice->original_price() .'"data-status="'. $propertyPrice->available() .'"data-minday="'. $propertyPrice->min_day() .'" data-bs-toggle="modal" data-bs-target="#hotel_date_package_admin">
                                    <div class="wkText final_day">'. $finalDay .' '. $today .'</div>
                                    <div class="dTfont wkText">'. $propertyPrice->currency->org_symbol . $propertyPrice->original_price() .'</div>
                                </div>
                            </div>';
                }

                $day++;
            }
        }

        $out .= '</div></div></div></div>';
        Cache::forget(config('cache.prefix') . '.calc.property_price');
        return $out;
    }


    /**
     * iCal Export
     *
     * @param array $request    Input values
     * @return iCal file
    */
    public function icalendarExport(Request $request)
    {

        $explode_id = explode('.', $request->id);
        // 1. Create new calendar
        $vCalendar  = new \Eluceo\iCal\Component\Calendar($this->url->to('/'));
        $result     = PropertyDates::where('property_id', $explode_id[0])->get();
        foreach ($result as $row) {
            // 2. Create an event
            $vEvent = new \Eluceo\iCal\Component\Event();
            $vEvent
                ->setDtStart(new \DateTime($row->date))
                ->setDtEnd(new \DateTime($row->date))
                ->setDescription($row->notes)
                ->setNoTime(true)
                ->setSummary($row->status);
            // 3. Add event to calendar
            $vCalendar->addComponent($vEvent);
        }
        // 4. Set headers
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="'. $explode_id[0] .'.ics"');
        // 5. Output
        echo $vCalendar->render();
    }

    /**
     * Import iCal Calendar
     *
     * @param array $request    Input values
     * @return redirect to Edit Calendar
    */
    public function icalendarImport(Request $request)
    {
        // Validation for iCalendar import fields
        if ($request->color=='custom') {
            $rules = array(
                    'url'  => 'required|url',
                    'name' => 'required',
                    'customcolor' => 'required'
                    );

            $fieldNames = array(
                        'url'  => 'URL',
                        'name' => 'Name',
                        'customcolor' => 'Custom Color'
                        );
            $color = (strpos($request->customcolor, '#') !== false) ? trim($request->customcolor) : '#' . trim($request->customcolor);
        } else {
                   $rules = array(
                        'url'  => 'required|url',
                        'name' => 'required',
                        );

                   $fieldNames = array(
                            'url'  => 'URL',
                            'name' => 'Name',
                            );
                   if ($request->customcolor == 'none') {
                       $color = trim($request->color);
                   }
        }

        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($fieldNames);

        if ($validator->fails()) {
            $error            = $validator->errors();
            $data['error']    = $error;
            return  $data;
        } else {
            $icalendarData = [
                    'property_id'         => $request->property_id,
                    'icalendar_url'       => $request->url,
                    'icalendar_name'      => $request->name,
                    'icalendar_last_sync' => date('Y-m-d H:i:s'),

                    ];

            PropertyIcalimport::updateOrCreate(['property_id' => $request->property_id, 'icalendar_url' => $request->url], $icalendarData);

            // Create a new instance of IcalendarController
            $ical   = new IcalendarController($request->url);
            $events = $ical->events();
            for ($i = 0; $i < $ical->event_count; $i++) {
                $start_date = $ical->iCalDateToUnixTimestamp($events[$i]['DTSTART']);
                $end_date   = $ical->iCalDateToUnixTimestamp($events[$i]['DTEND']);
                $days       = $this->getDays($start_date, $end_date);

                $cnts        = count($days);
                for ($j = 0; $j < ($cnts - 1); $j++) {
                    $calendarData = [
                                'property_id' => $request->property_id,
                                'date'    => $days[$j],
                                'status'  => 'Not available',
                                'color'  => $color,
                                'type'  => 'calendar'
                                ];

                    PropertyDates::updateOrCreate(['property_id' => $request->property_id, 'date' => $days[$j]], $calendarData);
                }
            }
            clearCache('calc.property_price');
            $data['status'] = 1;
            $data['success_message'] = __('Data imported successfully');

            return $data;
        }
    }

    /**
     * iCal Synchronization
     *
     * @param array $request    Input values
     * @return redirect to Edit Calendar
     */
    public function icalendarSynchronization(Request $request)
    {
        // Get all imported iCalendar URLs for give Room ID
        $result = PropertyIcalimport::where('property_id', $request->id)->get();
        foreach ($result as $row) {
            // Create a new instance of IcalController
            $ical   = new IcalendarController($row->icalendar_url);
            $events = $ical->events();

            // Get events from IcalController
            for ($i = 0; $i < $ical->event_count; $i++) {
                $start_date = $ical->iCalDateToUnixTimestamp($events[$i]['DTSTART']);
                $end_date   = $ical->iCalDateToUnixTimestamp($events[$i]['DTEND']);
                $days       = $this->getDays($start_date, $end_date);

                $cnts        = count($days);
                for ($j = 0; $j < count($days) - 1; $j++) {
                    $calendarDatas = [
                                'property_id' => $request->id,
                                'date'    => $days[$j],
                                'status'  => 'Not available'
                                ];

                    PropertyDates::updateOrCreate(['property_id' => $request->id, 'date' => $days[$j]], $calendarDatas);
                }
            }

            // Update last synchronization DateTime
            $importedIcalendar                      = PropertyIcalimport::find($row->id);
            $importedIcalendar->icalendar_last_sync = date('Y-m-d H:i:s');
            $importedIcalendar->save();
        }
        clearCache('.calc.property_price');
        Common::one_time_message('success', __('Synchronization successfully completed!'));
        return redirect('admin/listing/'. $request->id .'/calender');
    }

    /**
     * Get days between two dates
     *
     * @param date $sStartDate  Start Date
     * @param date $sEndDate    End Date
     * @return array $days      Between two dates
    */
    public function getDays($sStartDate, $sEndDate)
    {
        $sStartDate   = gmdate("Y-m-d", $sStartDate);
        $sEndDate     = gmdate("Y-m-d", $sEndDate);

        $aDays[]      = $sStartDate;

        $sCurrentDate = $sStartDate;

        while ($sCurrentDate < $sEndDate) {
            $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));

            $aDays[]      = $sCurrentDate;
        }

        return $aDays;
    }

    public function calenderJson(Request $request, CalendarController $calendar)
    {
        $year              = $request->year;
        $month             = $request->month;
        $data['room_step'] = 'edit_calendar';
        $data['calendar']  = $this->generate($request->id, $year, $month);
        return json_encode($data);
    }

    public function calenderPriceSet(CalendarPriceSetRequest $request, CalendarController $calendar)
    {
        $startDate = self::datevalidationForPricing(date('Y-m-d', strtotime($request->start_date)));
        $endDate   = self::datevalidationForPricing(date('Y-m-d', strtotime($request->end_date)));

        $startDate = strtotime($startDate);
        $endDate   = strtotime($endDate);

        for ($i = $startDate; $i <= $endDate; $i += 86400) {
            $date = date("Y-m-d", $i);

            $data = [ 'property_id' => $request->id,
                      'price'   => ($request->price) ? $request->price : '0',
                      'status'  => $request->status,
                      'min_day' => ($request->min_stay) ? $request->min_stay : '0',
                      'min_stay' => ($request->min_stay) ? '1' : '0',
                    ];

            PropertyDates::updateOrCreate(['property_id' => $request->id, 'date' => $date], $data);
        }
        clearCache('.calc.property_price');
        $data['status'] = 1;
        return json_encode($data);
    }

    /**
     * Validate the date.
     *
     *
     * @param string $date .
     * @return string|JsonResponse The date parts if valid, or a JSON response with an error message.
     */

     public function datevalidationForPricing(string $date): string
     {
         if ($date < date('Y-m-d')) {
             return abort(response()->json([
                 'status' => 0,
                 'message' => __('Invalid date format.')
             ], 400));
         }
 
         return $date;
     }

    public function yearMonth()
    {
        $res = array();

        for ($i = -2; $i < 30; $i++) {
            $date               = strtotime("+$i months");
            $value              = date('Y-m', $date);
            $label              = date('F Y', $date);
            $res[$value]        = $label;
        }
        return $res;
    }

    /**
     * Insert '0' before single digit of date
     * @param $digit
     * @return string
     */
    public function zeroDigit($digit)
    {
        if ($digit < 10 && $digit > 0) {
            return '0' . $digit;
        }
        return $digit;
    }
}
