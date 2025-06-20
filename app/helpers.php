<?php

use App\Http\Helpers\Common;
use App\Models\{Banners, Settings, Currency, StartingCities};
use Illuminate\Support\Facades\{Cache, DB};
use Twilio\Http\CurlClient;


if (!function_exists('appVersion')) {
    function appVersion()
    {
        return 'V' . config('vrent.app_version');
    }
}
/**
 * [dateFormat description for database date]
 * @param  [type] $value    [any number]
 * @return [type] [formates date according to preferences setting in Admin Panel]
 */

 if (!function_exists('setDateForFront')) {
    function setDateForFront()
    {
        
        $separator   = Settings::getAll()->firstWhere('name', 'date_separator')->value;
        $date_format = Settings::getAll()->firstWhere('name', 'date_format_type')->value;

        $dateFormateWithoutSeparator = str_replace($separator, '', $date_format);


        if ($dateFormateWithoutSeparator == "mmddyyyy") {
            $date = 'm' . $separator . 'd' . $separator . 'Y';
        } else if($dateFormateWithoutSeparator == "yyyymmdd") {
            $date =  'Y' . $separator . 'm' . $separator . 'd';
        }  else if($dateFormateWithoutSeparator == "ddmmyyyy") {
            $date =  'd' . $separator . 'm' . $separator . 'Y';
        } else if($dateFormateWithoutSeparator == "ddMyyyy") {
            $date =  'd' . $separator . 'M' . $separator . 'Y';
        } else if($dateFormateWithoutSeparator == "yyyyMdd") {
            $date =  'Y' . $separator . 'M' . $separator . 'd';
        }

        return $date;
    }
}

if (!function_exists('getIpAddress')) {
    function getIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}


if (!function_exists('setDateForDb')) {
    function setDateForDb($value = null)
    {
        if (empty($value)) {
            return null;
        }
        $separator   = Settings::getAll()->firstWhere('name', 'date_separator')->value;
        $date_format = Settings::getAll()->firstWhere('name', 'date_format_type')->value;
        if (str_replace($separator, '', $date_format) == "mmddyyyy") {
            $value = str_replace($separator, '/', $value);
            $date  = date('Y-m-d', strtotime($value));
        } else {
            $date = date('Y-m-d', strtotime(str_replace($separator, '-', $value)));
        }
        
        return $date;
    }
}

if (!function_exists('top_destinations')) {
    function top_destinations()
    {
        return StartingCities::where('status', 'Active')->get();
        
    }
}

if (!function_exists('miniCollection')) {

    /**
     * Returns a new \App\Lib\MiniCollection object
     * @param array $hayStack optional
     * @return \App\Lib\MiniCollection;
     */
    function miniCollection($hayStack = [], $nested = false)
    {
        return new \App\Lib\MiniCollection($hayStack, $nested);
    }
}



if (!function_exists('settings')) {

    function settings($field = null)
    {

        $settings = Settings::getAll()->pluck('value', 'name')->toArray();
        if (is_null($field)) {
            return $settings;
        }

        if (array_key_exists($field, $settings)) {
            $result = $settings[$field];
        } else {
            $result = Settings::getAll()->where('type', $field)->pluck('value', 'name')->toArray();
        }
        return $result;
    }
}

if (!function_exists('siteName')) {

    function siteName()
    {
        return settings('name') != '' ? settings('name') : config('app.name');
    }
}

if (!function_exists('getDirectory')) {
    function getDirectory($name = null)
    {
        $folder = [
            'logo' => 'public/front/images/logos/',
            'favicon' => 'public/front/images/logos/',
            'banner' => 'public/front/images/banners/',
        ];
         return $folder[$name] ?? '';
       
    }
}

if (!function_exists('image')) {
    function image(?string $imageName, string $directoryName): string
    {
        if (empty($imageName)) {
            return defaultImage($directoryName);
        }
        
        $imageFullPath = getDirectory(strtolower($directoryName)) . $imageName;
        if (file_exists(base_path($imageFullPath))) {
            return asset($imageFullPath);
        }

        return defaultImage($directoryName);
    }
}

if (!function_exists('defaultImage')) {    
    /**
     * defaultImage
     *
     * @param  mixed $type
     * @return string
     */
    function defaultImage(string $type): string
    {
        $defaultImages = [
            'logo' => 'public/front/images/logos/logo.png',
            'favicon' => 'public/front/images/logos/favicon.png',
            'banner' => 'public/front/images/banners/banner_1.jpg',
        ];
 
        return array_key_exists(strtolower($type), $defaultImages) ? asset($defaultImages[strtolower($type)]) : asset('public/front/images/default-error-image.png');
    }
}

if (!function_exists('getLogo')) {
    function getLogo($className = 'logo_size')
    {   
        return '<img src="' . image(settings('logo'), 'logo') . '"class="' . $className . '" alt="' . __('Logo') . '"/>';
            
    }
}

if (!function_exists('getFavicon')) {
    function getFavicon($className = null)
    {
        if ( $className <> '') {
            return '<img src="' . image(settings('favicon'), 'favicon') . '" class="' . $className . '"alt="' . __('Favicon') . '"/>';

        } else {
            return image(settings('favicon'), 'favicon');
        }
    }
}

if (!function_exists('getBanner')) {
    function getBanner()
    {
        $banner = Banners::where('status', 'Active')->where('default_banner', 'Yes')->first();
        return image($banner?->image ,'banner');

    }
}

if (!function_exists('getColumnValue')) {

    function getColumnValue($object, $columnOne = 'first_name', $columnTwo = 'last_name', $emptyReturn = '-')
    {
        $name = [];
        if (optional($object)->{$columnOne}) {
            $name[] = $object->{$columnOne};
        }
        if (optional($object)->{$columnTwo}) {
            $name[] = $object->{$columnTwo};
        }

        return count($name) ? implode(' ', $name) : $emptyReturn;
    }
}

/**
 * [Default timezones]
 * @return [timezonesArray]
 */
function phpDefaultTimeZones()
{
    $zonesArray  = array();
    $timestamp   = time();
    foreach (timezone_identifiers_list() as $key => $zone) {
        date_default_timezone_set($zone);
        $zonesArray[$key]['zone']          = $zone;
        $zonesArray[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
    }
    return $zonesArray;
}


/**
 * [dateFormat description]
 * @param  [type] $value    [any number]
 * @return [type] [formates date according to preferences setting in Admin Panel]
 */
function dateFormat($value, $type = null)
{
    $timezone       = '';
    $timezone       = Settings::getAll()->where('type', 'preferences')->where('name', 'dflt_timezone')->first()->value;
    $today          = new DateTime($value, new DateTimeZone(config('app.timezone')));
    $today->setTimezone(new DateTimeZone($timezone));
    $value          = $today->format('Y-m-d H:i:s');


    $preferenceData = Settings::getAll()->where('type','preferences')->whereIn('name', ['date_format_type', 'date_separator'])->toArray();
    $preferenceData = Common::key_value('name', 'value', $preferenceData);
    $preference     = $preferenceData['date_format_type'];
    $separator      = $preferenceData['date_separator'];

    $data           = str_replace(['/', '.', ' ', '-'], $separator, $preference);
    $data           = explode($separator, $data);
    $first          = $data[0];
    $second         = $data[1];
    $third          = $data[2];

    $dateInfo       = str_replace(['/', '.', ' ', '-'], $separator, $value);
    $datas          = explode($separator, $dateInfo);
    $year           = $datas[0];
    $month          = $datas[1];
    $day            = $datas[2];

    $dateObj        = DateTime::createFromFormat('!m', $month);
    $monthName      = $dateObj->format('F');

    $toHoursMin     = \Carbon\Carbon::createFromTimeStamp(strtotime($value))->format(' g:i A');

    if ($first == 'yyyy' && $second == 'mm' && $third == 'dd') {
        $value = $year . $separator . $month . $separator . $day. $toHoursMin;
    } elseif ($first == 'dd' && $second == 'mm' && $third == 'yyyy') {
        $value = $day . $separator . $month . $separator . $year. $toHoursMin;
    } elseif ($first == 'mm' && $second == 'dd' && $third == 'yyyy') {
        $value = $month . $separator . $day . $separator . $year. $toHoursMin;
    } elseif ($first == 'dd' && $second == 'M' && $third == 'yyyy') {
        $value = $day . $separator . $monthName . $separator . $year. $toHoursMin;
    } elseif ($first == 'yyyy' && $second == 'M' && $third == 'dd') {
        $value = $year . $separator . $monthName . $separator . $day. $toHoursMin;
    }
    return $value;

}


/**
* Process of sending twilio message
*
* @param string $request
*
* @return mixed
*/
function twilioSendSms($toNumber,$messages)
{

    try {

        $client          = new CurlClient();
        $response        = $client->request('GET', 'https://api.twilio.com:8443');
        $phoneSms        = Settings::getAll()->where('type','twilio')->whereIn('name', ['twilio_sid', 'twilio_token','formatted_phone'])->pluck('value', 'name')->toArray();
        $sid             = !empty($phoneSms['twilio_sid']) ? $phoneSms['twilio_sid'] : 'ACf4fd1e';
        $token           = !empty($phoneSms['twilio_token']) ? $phoneSms['twilio_token'] : 'da9580307';

        $url             = "https://api.twilio.com/2010-04-01/Accounts/$sid/SMS/Messages";
        $trimmedMsg      = trim(preg_replace('/\s\s+/', ' ', $messages));

        if (!empty($phoneSms['formatted_phone'])) {
            $data = array (
                'From' => $phoneSms['formatted_phone'],
                'To' => $toNumber,
                'Body' => strip_tags($trimmedMsg),
            );
            $post = http_build_query($data);
            $x    = curl_init($url );
            curl_setopt($x, CURLOPT_POST, true);
            curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
            if ($response->getStatusCode() <= 200 || $response->getStatusCode() >= 300) {
                curl_setopt($x, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
            }
            curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($x, CURLOPT_USERPWD, "$sid:$token");
            curl_setopt($x, CURLOPT_POSTFIELDS, $post);
            $y = curl_exec($x);
            curl_close($x);
        }
        return redirect()->back();

    } catch (Exception $e) {

        return redirect()->back();
    }

}

/**
 * [onlyFormat description]
 * @param  [type] $value    [any number]
 * @return [type] [formates date according to preferences setting in Admin Panel]
 */
function onlyFormat($value)
{
    $preferenceData = Settings::getAll()->whereIn('name', ['date_format_type', 'date_separator'])->where('type','preferences')
        ->map(function($d) {
            return [
                'name'=>$d->name,
                'value'=>$d->value
            ];
        })->toArray();

    $preferenceData = Common::key_value('name', 'value', $preferenceData);
    $separator      = $preferenceData['date_separator'];
    $preference     = str_replace(['/', '.', ' ', '-'], '', $preferenceData['date_format_type']);
    
    switch ($preference) {
        case 'yyyymmdd':
            $value = date('Y' . $separator . 'm' . $separator . 'd', strtotime($value));
            break;
        case 'ddmmyyyy':
            $value = date('d' . $separator . 'm' . $separator . 'Y', strtotime($value));
            break;
        case 'mmddyyyy':
            $value = date('m' . $separator . 'd' . $separator . 'Y', strtotime($value));
            break;
        case 'ddMyyyy':
            $value = date('d' . $separator . 'M' . $separator . 'Y', strtotime($value));
            break;
        case 'yyyyMdd':
            $value = date('Y' . $separator . 'M' . $separator . 'd', strtotime($value));
            break;
        default:
            $value = date('Y-m-d', strtotime($value));
            break;
    }
    return $value;

}




/**
 * [roundFormat description]
 * @param  [type] $value     [any number]
 * @return [type] [placement of money symbol according to preferences setting in Admin Panel]
 */
function moneyFormat($symbol, $value)
{
    $symbolPosition = currencySymbolPosition();
    if ($symbolPosition == "before") {
         $value = $symbol . ' ' . $value;
    } else {
        $value = $value . ' ' . $symbol;
    }
    return $value;
}

/**
 * [currencySymbolPosition description]
 * @return [position type of symbol after or before]
 */
function currencySymbolPosition()
{
    $position = settings('money_format');
    return !empty($position) ? $position : 'after';
}


 function codeToSymbol($code)
{
    $symbol = Currency::getAll()->firstWhere('code', $code)->symbol;
    return $symbol;
}


function SymbolToCode($symbol)
{
    $code = Currency::getAll()->firstWhere('symbol', $symbol)->code;
    return $code;
}


function changeEnvironmentVariable($key, $value)
{
    $path = base_path('.env');

    if (is_bool(env($key)))
        $old = env($key) ? 'true' : 'false';

    elseif (env($key) === null) 
        $old = 'null';

    else 
        $old = env($key);
    

    if (file_exists($path))
    {
        if ($old == 'null')
        {

            file_put_contents($path, "\n$key=" . $value, FILE_APPEND);
        } else {
            file_put_contents($path, str_replace(
                "$key=" . $old, "$key=" . $value, file_get_contents($path)
            ));
        }
    }
}


function currency_fix($field, $code)
{
    $default_currency = Currency::getAll()->firstWhere('default', 1)->code;
    $rate = Currency::getAll()->firstWhere('code',$code)->rate;


    $base_amount = $field / $rate;


    $session_rate = Currency::getAll()->firstWhere('code', (session()->get('currency')) ? session()->get('currency') : $default_currency)->rate;

    return round($base_amount * $session_rate, 2);
}

function xss_clean($data)
{
    // Fix &entity\n;
    $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do
    {
        // Remove really unwanted tags
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    }
    while ($old_data !== $data);

    return $data;
}

/**
 * stripBeforeSave method
 * This function strips or skips HTML tags
 *
 * @param string $string [The text that will be stripped]
 * @param array $options
 *
 * @return string
 */
function stripBeforeSave($string = null, $options = ['skipAllTags' => true, 'mergeTags' => false])
{
    $finalString = [];
    if ($options['skipAllTags'] === false) {
        $allow = '<h1><h2><h3><h4><h5><h6><p><b><br><hr><i><pre><small><strike><strong><sub><sup><time><u><form><input><textarea><button><select><option><label><frame><iframe><img><audio><video><a><link><nav><ul><ol><li><table><th><tr><td><thead><tbody><div><span><header><footer><main><section><article>';
        if (isset($options['mergeTags']) && $options['mergeTags'] === true && isset($options['allowedTags'])) {
            $allow .= is_array($options['allowedTags']) ? implode('', $options['allowedTags']) : trim($options['allowedTags']);
        } else {
            $allow = isset($options['allowedTags']) && is_array($options['allowedTags']) ? implode('', $options['allowedTags']) : trim($options['allowedTags']);
        }
        if (is_array($string)) {
            foreach ($string as $key => $value) {
                $finalString[$key] = strip_tags($value, $allow);
            }
        } else {
            $finalString = strip_tags($string, $allow);
        }
    } else {
        if (is_array($string)) {
            foreach ($string as $key => $value) {
                $finalString[$key] = strip_tags($value);
            }
        } else {
            $finalString = strip_tags($string);
        }
    }
    return !empty($finalString) ? $finalString : null;
}

function dataTableOptions(array $options = [])
{
    $default = [
        'dom' => 'lBfrtip',
        'buttons' => [],
        'order' => [0, 'desc'],
        'pageLength' => session()->get('row_per_page') ?? settings('row_per_page'),
    ];

    return array_merge($default, $options);
}

function numberFormat($number, $decimal) 
{
    return number_format($number, $number == intval($number) ? 0 : $decimal);
}

function clearCache($name) 
{
    Cache::forget(config('cache.prefix') . $name);
}

function getInboxUnreadCount() 
{
    return DB::table(DB::raw("(SELECT * from messages where receiver_id=".Auth()->id()." and `read`=0 ORDER by id DESC) as msg"))
        ->groupBy('booking_id')
        ->get()->count();
}

function n_as_k_c() 
{
    if ( g_e_v() == "") {
        return true;
    }
    if (!g_c_v()) {
        try {
            $d_ = g_d(); //127.0.0.1
            $e_ = g_e_v();
            $e_ = explode('.', $e_);
            $c_ = md5($d_ . $e_[1]); // 7cf247898eaaccdc5a4f2d251ccf71ab
            if ($e_[0] == $c_) {
                p_c_v();
                return false;
            }
            return true;
        } catch (\Exception $e) {
            return true;
        }
    }
    return false;
}

function g_e_v() 
{
    return env(a_k());
}

function a_k() 
{
    return base64_decode('SU5TVEFMTF9BUFBfU0VDUkVU');
}

function g_d() 
{
    return request()->getHost();
}

function g_c_v() 
{
    return cache('a_s_k');
}

function p_c_v() 
{
    return cache(['a_s_k' => g_e_v()], 2629746);
}

function convert_currency( $from , $to , $price) 
{

    $from = currentCurrency($from);
    $to = currentCurrency($to);
    $price       = str_replace(']','',$price);//For Php Version 7.2
    $base_amount = (float) $price / $from->rate;
    return round($base_amount * $to->rate, $to->rate > 1000 ? 0 : 2);
}

function defaultCurrency() 
{
    return Currency::getAll()->firstWhere('default', 1);
}

function currentCurrency($code = null) 
{
    if ($code && $code <> '') {
        return Currency::getAll()->firstWhere('code', $code);
    } elseif (session()->get('currency')) {
        return Currency::getAll()->firstWhere('code', session()->get('currency'));
    }
    return Currency::getAll()->firstWhere('default', 1);
}
