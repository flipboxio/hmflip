<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\{
    PropertyIcalimport,
    PropertyDates,
    Bookings
};
use DateTime, File, Log, Artisan, DB, Common;

class CronController extends Controller
{
    private $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }

    public function index()
    {

        $this->sqlDump();
    }

    public function check_booking_expired()
    {
        $date           = new DateTime;
        $date->modify('-24 hours');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $results        = Bookings::where('created_at', '<', $formatted_date)->where('status', 'Pending')->get();
        foreach ($results as $result) {
            Bookings::where('id', $result->id)->update(['status' => 'Expired', 'expired_at' => date('Y-m-d H:i:s')]);
        }
    }

    public function iCalendarSynchronization()
    {
        $result = PropertyIcalimport::get();

        foreach ($result as $row) {

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
                                'property_id' => $row->id,
                                'date'    => $days[$j],
                                'status'  => 'Not available'
                                ];

                    PropertyDates::updateOrCreate(['property_id' => $row->id, 'date' => $days[$j]], $calendarDatas);
                }
            }
            // Update last synchronization DateTime
            $importedIcalendar                      = PropertyIcalimport::find($row->id);
            $importedIcalendar->icalendar_last_sync = date('Y-m-d H:i:s');
            $importedIcalendar->save();
        }
        clearCache('.calc.property_price');
    }

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

    public function reset_data()
    {
        Artisan::call('db:seed', ['--class' => 'ResetDataSeeder']);
    }

    public function importDump()
    {
        try {
            Log::info("Clearing the junk database");
            Artisan::call('app:install --seed=all --migrate=true --dummydata=true');
            $this->restoreFiles();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }


    public function restoreFiles() 
    {
       $folders = [
            'front/images/banners',
            'front/images/logos',
            'front/images/starting_cities',
            'front/images/testimonial',
            'front/img',
            'images/profile',
            'images/property',
            'uploads/booking',
        ];
        foreach ($folders as $folder) {
            $pathDestination = public_path($folder);
            $pathSource = public_path('backup/' . $folder);
            File::cleanDirectory($pathDestination);
            File::copyDirectory($pathSource, $pathDestination);
        }
    }
}
