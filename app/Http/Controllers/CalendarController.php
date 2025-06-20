<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CalendarPriceSetRequest;
use App\Http\Controllers\Controller;
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

    public function generate($property_id = '', $year = '', $month = '')
    {

        if ($year == '') {
            $year  = date('Y');
        }

        if ($month == '') {
            $month = date('m');
        }

        $property_price = PropertyPrice::where('property_id', $property_id)->first();

        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $startDays = array('sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6);
        $startDay  = ( ! isset($startDays[$this->startDay])) ? 0 : $startDays[$this->startDay];

        $localDate  = mktime(12, 0, 0, $month, 1, $year);

        $date       = getdate($localDate);
        $day        = $startDay + 1 - $date["wday"];

        $prvTime  = mktime(12, 0, 0, $month-1, 1, $year);
        $nxtTime  = mktime(12, 0, 0, $month+1, 1, $year);


        $prvMonth = date('m', $prvTime);
        $nxtMonth = date('m', $nxtTime);

        $prvYear  = date('Y', $prvTime);
        $nxtYear  = date('Y', $nxtTime);


        $curDay    = date('j');
        $curYear   = date('Y');
        $curMonth  = date('m');
        $currentDate =  new \DateTime($curDay."-".$curMonth."-".$curYear);
        $prevTotalDays = date('t', $prvTime);

        while ($day > 1) {
            $day -= 7;
        }

        $monthSelect = '<select name="year_month" id="calendar_dropdown">';
        $yearMonth   = $this->year_month();
        foreach ($yearMonth as $key => $value) {
            $selected = date('Y-m', $localDate) == $key?'selected':'';
            $monthSelect .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
        }
        $monthSelect .= '</select>';

        $out = '';
        $out .= '<div class="host-calendar-container">
                    <div class="calendar-month">';

        $out .= '<div class="row-space-2 deselect-on-click">
                    <a href="'.url('manage-listing/'.$property_id.'/calendar').'" class="month-nav month-nav-previous panel text-center" data-year="'.$prvYear.'" data-month="'.$prvMonth.'"> <i class="fa fa-chevron-left fa-lg calendar-icon-style"></i> </a>
                    <a href="'.url('manage-listing/'.$property_id.'/calendar').'" class="month-nav month-nav-next panel text-center" data-year="'.$nxtYear.'" data-month="'.$nxtMonth.'"> <i class="fa fa-chevron-right fa-lg calendar-icon-style"></i> </a>
                    <div class="current-month-selection"> <h2> <span>'.date('F Y', $localDate).'</span> <span> &nbsp;</span> <span class="current-month-arrow">▾</span> </h2>'.$monthSelect.'<div class="spinner-next-to-month-nav">Just a moment...</div></div>
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
                    $date      = $year.'-'.$month.'-'.$this->zeroDigit($day);
                    $finalDay = $day;
                } else {
                    if ($day <= 0) {
                        $dayPrev  = $prevTotalDays + $day;

                        $date      = $prvYear.'-'.$prvMonth.'-'.$this->zeroDigit($dayPrev);

                        $finalDay = $dayPrev;
                    } elseif ($day > $totalDays) {
                        $dayNext  = $day - $totalDays;

                        $date      = $nxtYear.'-'.$nxtMonth.'-'.$this->zeroDigit($dayNext);

                        $finalDay = $dayNext;
                    }
                }
                $property_price->getPropertyDates($date);

                $dateGreaterThanToday = (new \DateTime($date)) > $currentDate;
                //Price Type CALENDAR
                if ( $dateGreaterThanToday && ($property_price->available()=='Not available') && ($property_price->type()=='calendar') && (($property_price->color())!=null)) {
                    $out .= '<div class="col-md-02">
                                <div class="calender_box date-package-modal"  style="background-color:'.$property_price->color().' !important " id="'.$date.'" data-day="'.$day.'" data-month="'.$month.'" data-year="'.$year.'" data-price="'.$property_price->original_price().'"data-status="'.$property_price->available().'"data-minday="'.$property_price->min_day().'">
                                    <div class="wkText final_day">'.$finalDay.' '.$today.'</div>
                                    <div class="dTfont wkText">'.$property_price->currency->org_symbol.$property_price->original_price().'</div>
                                </div>
                            </div>';
                } elseif (($year >= $curYear && $month >= $curMonth) && ($property_price->available()=='Not available') && ($property_price->type()=='calendar') && (($property_price->color())!=null)) {
                    if (! $dateGreaterThanToday) {
                        $class = 'dt-not-available';
                        $out .= '<div class="col-md-02">
                                    <div class="calender_box date-package-modal '.$class.'" id="'.$date.'" data-day="'.$day.'" data-month="'.$month.'" data-year="'.$year.'" data-price="'.$property_price->original_price().'"data-status="'.$property_price->available().'"data-minday="'.$property_price->min_day().'">
                                        <div class="wkText final_day">'.$finalDay.' '.$today.'</div>
                                        <div class="dTfont wkText">'.$property_price->currency->org_symbol.$property_price->original_price().'</div>
                                    </div>
                                </div>';
                    } else {
                        $out .= '<div class="col-md-02">
                                    <div class="calender_box date-package-modal"  style="background-color:'.$property_price->color().' !important " id="'.$date.'" data-day="'.$day.'" data-month="'.$month.'" data-year="'.$year.'" data-price="'.$property_price->original_price().'"data-status="'.$property_price->available().'"data-minday="'.$property_price->min_day().'">
                                        <div class="wkText final_day">'.$finalDay.' '.$today.'</div>
                                        <div class="dTfont wkText">'.$property_price->currency->org_symbol.$property_price->original_price().'</div>
                                    </div>
                                </div>';
                    }
                }

                //Price type NORMAL
                elseif ($dateGreaterThanToday && ($property_price->available()=='Not available') && ($property_price->type()=='normal')) {
                    $class = 'dt-available-with-events';
                    $out .= '<div class="col-md-02">
                                    <div class="calender_box date-package-modal '.$class.'" id="'.$date.'" data-day="'.$day.'" data-month="'.$month.'" data-year="'.$year.'" data-price="'.$property_price->original_price().'"data-status="'.$property_price->available().'"data-minday="'.$property_price->min_day().'">
                                        <div class="wkText final_day">'.$finalDay.' '.$today.'</div>
                                        <div class="dTfont wkText">'.$property_price->currency->org_symbol.$property_price->original_price().'</div>
                                    </div>
                                </div>';
                } elseif ($dateGreaterThanToday && ($property_price->available()=='Not available') && ($property_price->type()=='normal')) {
                    if (! $dateGreaterThanToday) {
                        $class = 'dt-not-available';
                    } else {
                         $class = 'dt-available-with-events';
                    }

                    $out .= '<div class="col-md-02">
                                    <div class="calender_box date-package-modal '.$class.'" id="'.$date.'" data-day="'.$day.'" data-month="'.$month.'" data-year="'.$year.'" data-price="'.$property_price->original_price().'"data-status="'.$property_price->available().'"data-minday="'.$property_price->min_day().'">
                                        <div class="wkText final_day">'.$finalDay.' '.$today.'</div>
                                        <div class="dTfont wkText">'.$property_price->currency->org_symbol.$property_price->original_price().'</div>
                                    </div>
                                </div>';
                } else {
                    $out .= '<div class="col-md-02">
                                <div class="calender_box date-package-modal '.$class.'" id="'.$date.'" data-day="'.$day.'" data-month="'.$month.'" data-year="'.$year.'" data-price="'.$property_price->original_price().'"data-status="'.$property_price->available().'"data-minday="'.$property_price->min_day().'">
                                    <div class="wkText final_day">'.$finalDay.' '.$today.'</div>
                                    <div class="dTfont wkText">'.$property_price->currency->org_symbol.$property_price->original_price().'</div>
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

    public function calenderJson(Request $request, CalendarController $calendar)
    {
        $year              = isset($request->year) ? $request->year : '';
        $month             = isset($request->month) ? $request->month : '';
        $data['room_step'] = 'edit_calendar';
        $data['calendar']  = $calendar->generate($request->id, $year, $month);

        return json_encode($data);
    }

    public function calenderPriceSet(CalendarPriceSetRequest $request, CalendarController $calendar)
    {
        $dateFormat = Session::get('date_format_type') ?? settings('date_format_type');
        
        $startDateString = $request->start_date;
        $endDateString = $request->end_date;

        $startDate = $this->formatDate($startDateString, $dateFormat);
        $endDate = $this->formatDate($endDateString, $dateFormat);

        $startDateTimestamp = self::datevalidationForPricing(strtotime($startDate));
        $endDateTimestamp = self::datevalidationForPricing(strtotime($endDate));

        if (!$startDateTimestamp || !$endDateTimestamp) {
            return response()->json([
                'status' => 0,
                'message' => __('Invalid date format.')
            ], 400);
        }

        if ($startDateTimestamp > $endDateTimestamp) {
            return response()->json([
                'status' => 0,
                'message' => __('Start date is greater than end date')
            ], 400);
        }

        // Loop through the date range and save the data
        for ($currentTimestamp = $startDateTimestamp; $currentTimestamp <= $endDateTimestamp; $currentTimestamp += 86400) {
            $currentDate = date("Y-m-d", $currentTimestamp);

            $propertyData = [
                'property_id' => $request->id,
                'price' => $request->price ?: '0',
                'status' => $request->status,
                'min_day' => $request->minstay ?: '0',
                'min_stay' => $request->minstay ? '1' : '0',
            ];

            PropertyDates::updateOrCreate(['property_id' => $request->id, 'date' => $currentDate], $propertyData);
        }

        clearCache('.calc.property_price');
        
        return response()->json(['status' => 1, 'message' => __('Data saved successfully.')]);
    }

    /**
     * Format the date based on the specified format.
     *
     * @param string $date
     * @param string $format
     * @return string
     */
    protected function formatDate(string $date, string $format): string
    {
        if ($format == 'mm-dd-yyyy') {
            $dateComponents = self::validateDateComponents($date);
            return date('Y-m-d', strtotime($dateComponents[2] . '-' . $dateComponents[0] . '-' . $dateComponents[1]));
        }

        if (strpos($date, "/") !== false) {
            $normalizedDate = str_replace(['/', '.'], '-', $date);
            return date('Y-m-d', strtotime($normalizedDate));
        }

        return date('Y-m-d', strtotime($date));
    }

    /**
     * Validate the date components of a given date string.
     *
     * @param string $date The date string to validate.
     * @return array
     */
    public function validateDateComponents(string $date): array
    {
        $dateParts = explode('-', $date);
        if (count($dateParts) !== 3) {
            abort(response()->json(['status' => 0, 'message' => __('Invalid date format.')], 400));
        }
        return $dateParts;
    }

    /**
     * Validate the date.
     *
     * @param int $timestamp
     * @return int
     */
    public function datevalidationForPricing(int $timestamp): int
    {
        if (!$timestamp || (date('Y-m-d', $timestamp) < date('Y-m-d'))) {
            abort(response()->json(['status' => 0, 'message' => __('Invalid date format.')], 400));
        }
        return $timestamp;
    }

    public function year_month()
    {
        $res = array();

        for ($i=-2; $i<30; $i++) {
            $date               = strtotime("+$i months");
            $value              = date('Y-m', $date);
            $label              = date('F Y', $date);
            $res[$value]        = $label;
        }
        return $res;
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
        header('Content-Disposition: attachment; filename="'.$explode_id[0].'.ics"');

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
            $color = (strpos($request->customcolor, '#')!==false)?trim($request->customcolor):'#'.trim($request->customcolor);
        } else {
                   $rules = array(
                        'url'  => 'required|url',
                        'name' => 'required',
                        );

                   $fieldNames = array(
                            'url'  => 'URL',
                            'name' => 'Name',
                            );
                   if ($request->customcolor=='none') {
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
          ;
            for ($i=0; $i<$ical->event_count; $i++) {
                $start_date = $ical->iCalDateToUnixTimestamp($events[$i]['DTSTART']);
                $end_date   = $ical->iCalDateToUnixTimestamp($events[$i]['DTEND']);
                $days       = $this->get_days($start_date, $end_date);

                $cnts        = count($days);
                for ($j=0; $j<($cnts-1); $j++) {
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

        if (!$result->isEmpty()) {

            foreach ($result as $row) {
                // Create a new instance of IcalController
                $ical   = new IcalendarController($row->icalendar_url);
                $events = $ical->events();

                // Get events from IcalController
                for ($i=0; $i<$ical->event_count; $i++) {
                    $start_date = $ical->iCalDateToUnixTimestamp($events[$i]['DTSTART']);
                    $end_date   = $ical->iCalDateToUnixTimestamp($events[$i]['DTEND']);
                    $days       = $this->get_days($start_date, $end_date);
                    $cnts        = count($days);
                    // Update or Create a events
                    for ($j=0; $j<count($days)-1; $j++) {
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
            return redirect('listing/'.$request->id.'/calendar');

        }

        Common::one_time_message('warning', __('No data for Synchronization!'));
        return redirect('listing/'.$request->id.'/calendar');
    }

    /**
     * Get days between two dates
     *
     * @param date $sStartDate  Start Date
     * @param date $sEndDate    End Date
     * @return array $days      Between two dates
     */
    public function get_days($sStartDate, $sEndDate)
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

    /**
     * Insert '0' before single digit of date
     * @param $digit
     * @return string
     */
    public function zeroDigit($digit)
    {
        if ($digit <10 && $digit > 0) {
            return '0' . $digit;
        }
        return $digit;
    }
}
