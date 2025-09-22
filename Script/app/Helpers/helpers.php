<?php

use App\Models\BasicControl;
use App\Models\Category;
use App\Models\Content;
use App\Models\ContentDetails;
use App\Models\Currency;
use App\Models\ManageMenu;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Language;
use App\Models\PageDetail;
use App\Models\TopUp;
use App\Models\Card;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

if (!function_exists('template')) {
    function template($asset = false)
    {
        $activeTheme = getTheme();

        $currentRouteName = Route::currentRouteName();
        if (Str::startsWith($currentRouteName, 'user.') || request()->param == 'user') {
            if ($asset) return 'assets/themes/dark/';

            return 'themes.dark.';
        }

        if ($asset) return 'assets/themes/' . $activeTheme . '/';
        return 'themes.' . $activeTheme . '.';
    }
}

if (!function_exists('getTheme')) {
    function getTheme()
    {
        $theme = session('theme') ?? basicControl()->theme ?? null;
        return $theme;
    }
}
if (!function_exists('getDash')) {
    function getDash()
    {
        return auth()->user()->active_dashboard ?? 'nightfall';
    }
}


if (!function_exists('getThemesNames')) {
    function getThemesNames()
    {
        $directory = resource_path('views/themes');
        return File::isDirectory($directory) ? array_map('basename', File::directories($directory)) : [];
    }
}

if (!function_exists('stringToTitle')) {
    function stringToTitle($string)
    {
        return implode(' ', array_map('ucwords', explode(' ', preg_replace('/[^a-zA-Z0-9]+/', ' ', $string))));
    }
}

if (!function_exists('getTitle')) {
    function getTitle($title)
    {
        if ($title == "sms") {
            return strtoupper(preg_replace('/[^A-Za-z0-9]/', ' ', $title));
        }
        return ucwords(preg_replace('/[^A-Za-z0-9]/', ' ', $title));
    }
}

if (!function_exists('getRoute')) {
    function getRoute($route, $params = null)
    {
        return isset($params) ? route($route, $params) : route($route);
    }
}

if (!function_exists('getPageSections')) {
    function getPageSections()
    {
        $sectionsPath = resource_path('views/') . str_replace('.', '/', template()) . 'sections';
        $pattern = $sectionsPath . '/*';
        $files = glob($pattern);

        $fileBaseNames = [];

        foreach ($files as $file) {
            if (is_file($file)) {
                $basename = basename($file);
                $basenameWithoutExtension = str_replace('.blade.php', '', $basename);
                $fileBaseNames[$basenameWithoutExtension] = $basenameWithoutExtension;
            }
        }

        return $fileBaseNames;
    }
}
if (!function_exists('strRandomNum')) {
    function strRandomNum($length = 15)
    {
        $characters = '1234567890';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('hex2rgba')) {
    function hex2rgba($color, $opacity = false)
    {
        $default = 'rgb(0,0,0)';

        if (empty($color))
            return $default;

        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        if (strlen($color) == 6) {
            $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return $default;
        }

        $rgb = array_map('hexdec', $hex);

        if ($opacity) {
            if (abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
        } else {
            $output = 'rgb(' . implode(",", $rgb) . ')';
        }
        return $output;
    }
}

if (!function_exists('basicControl')) {
    function basicControl()
    {
        if (session()->get('themeMode') == null) {
            session()->put('themeMode', 'auto');
        }

        try {
            $configure = null;
            DB::connection()->getPdo();
            $configure = Cache::get('ConfigureSetting');
            if (!$configure) {
                if (Schema::hasTable('basic_controls')) {
                    $configure = BasicControl::firstOrCreate();
                    Cache::put('ConfigureSetting', $configure);
                }
            }

            return $configure;
        } catch (\Exception $e) {
        }
    }
}

if (!function_exists('checkTo')) {
    function checkTo($currencies, $selectedCurrency = 'USD')
    {
        foreach ($currencies as $key => $currency) {
            if (property_exists($currency, strtoupper($selectedCurrency))) {
                return $key;
            }
        }
    }
}


if (!function_exists('controlPanelRoutes')) {
    function controlPanelRoutes()
    {
        $listRoutes = collect([]);
        $listRoutes->push(config('generalsettings.settings'));
        $listRoutes->push(config('generalsettings.plugin'));
        $listRoutes->push(config('generalsettings.in-app-notification'));
        $listRoutes->push(config('generalsettings.push-notification'));
        $listRoutes->push(config('generalsettings.email'));
        $listRoutes->push(config('generalsettings.sms'));
        $list = $listRoutes->collapse()->map(function ($item) {
            return $item['route'];
        })->values()->push('admin.settings')->unique();
        return $list;
    }
}


if (!function_exists('menuActive')) {
    function menuActive($routeName, $type = null)
    {
        $class = 'active';
        if ($type == 3) {
            $class = 'active collapsed';
        } elseif ($type == 2) {
            $class = 'show';
        }

        if (is_array($routeName)) {
            foreach ($routeName as $key => $value) {
                if (request()->routeIs($value)) {
                    return $class;
                }
            }
        } elseif (request()->routeIs($routeName)) {
            return $class;
        }
    }
}

if (!function_exists('isMenuActive')) {
    function isMenuActive($routes, $type = 0)
    {
        $class = [
            '0' => 'active',
            '1' => 'style=display:block',
            '2' => true
        ];

        if (is_array($routes)) {
            foreach ($routes as $key => $route) {
                if (request()->routeIs($route)) {
                    return $class[$type];
                }
            }
        } elseif (request()->routeIs($routes)) {
            return $class[$type];
        }

        if ($type == 1) {
            return 'style=display:none';
        } else {
            return false;
        }
    }
}


if (!function_exists('strRandom')) {
    function strRandom($length = 12)
    {
        $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}


if (!function_exists('getFile')) {
    function getFile($disk = 'local', $image = '', $upload = false)
    {
        $default = ($upload == true) ? asset(config('filelocation.default2')) : asset(config('filelocation.default'));
        try {
            if ($disk == 'local') {
                $localImage = asset('/assets/upload') . '/' . $image;
                return !empty($image) && Storage::disk($disk)->exists($image) ? $localImage : $default;
            } else {
                if (!empty($image) && Storage::disk($disk)->exists($image)) {
                    $builtUrl = getDiskFileUrl($disk, $image);
                    return $builtUrl ?: $default;
                }
                return $default;
            }
        } catch (Exception $e) {
            return $default;
        }
    }
}

if (!function_exists('getDiskFileUrl')) {
    function getDiskFileUrl(string $disk, string $path): ?string
    {
        try {
            $config = config("filesystems.disks.{$disk}");
            if (!$config) return null;

            // S3-like drivers
            if (($config['driver'] ?? null) === 's3') {
                $endpoint = rtrim($config['endpoint'] ?? '', '/');
                $bucket = $config['bucket'] ?? '';
                if ($endpoint && $bucket) {
                    return $endpoint . '/' . $bucket . '/' . ltrim($path, '/');
                }
            }
            // SFTP/FTP drivers don't always support url(); fall back to same path (requires web proxy if used)
            if (in_array($config['driver'] ?? '', ['sftp', 'ftp'])) {
                // If you have a CDN/base URL configured for these, you can map here
                return null;
            }
        } catch (\Throwable $e) {
            return null;
        }
        return null;
    }
}

if (!function_exists('getFileForEdit')) {
    function getFileForEdit($disk = 'local', $image = null)
    {
        try {
            if ($disk == 'local') {
                $localImage = asset('/assets/upload') . '/' . $image;
                return !empty($image) && Storage::disk($disk)->exists($image) ? $localImage : null;
            } else {
                if (!empty($image) && Storage::disk($disk)->exists($image)) {
                    $builtUrl = getDiskFileUrl($disk, $image);
                    return $builtUrl ?: asset(config('location.default'));
                }
                return asset(config('location.default'));
            }
        } catch (Exception $e) {
            return null;
        }
    }
}

if (!function_exists('title2snake')) {
    function title2snake($string)
    {
        return Str::title(str_replace(' ', '_', $string));
    }
}

if (!function_exists('snake2Title')) {
    function snake2Title($string)
    {
        return Str::title(str_replace('_', ' ', $string));
    }
}
if (!function_exists('formatFieldName')) {
    function formatFieldName($fieldName)
    {
        $formatted = preg_replace('/([a-z])([A-Z])/', '$1 $2', $fieldName);

        $formatted = str_replace('_', ' ', $formatted);
        return $formatted;
    }
}


if (!function_exists('kebab2Title')) {
    function kebab2Title($string)
    {
        return Str::title(str_replace('-', ' ', $string));
    }
}

if (!function_exists('getMethodCurrency')) {
    function getMethodCurrency($gateway)
    {
        foreach ($gateway->currencies as $key => $currency) {
            if (property_exists($currency, $gateway->currency)) {
                if ($key == 0) {
                    return $gateway->currency;
                } else {
                    return 'USD';
                }
            }
        }
    }
}

if (!function_exists('twoStepPrevious')) {
    function twoStepPrevious($deposit)
    {
        if ($deposit->depositable_type == 'App\\Models\\Fund') {
            return route('fund.initialize');
        }
    }
}


if (!function_exists('slug')) {
    function slug($title)
    {
        return Str::slug($title);
    }
}

if (!function_exists('clean')) {
    function clean($string)
    {
        $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}

if (!function_exists('diffForHumans')) {
    function diffForHumans($date)
    {
        $lang = session()->get('lang');
        \Carbon\Carbon::setlocale($lang);
        return \Carbon\Carbon::parse($date)->diffForHumans();
    }
}

if (!function_exists('loopIndex')) {
    function loopIndex($object)
    {
        return ($object->currentPage() - 1) * $object->perPage() + 1;
    }
}

if (!function_exists('dateTime')) {
    function dateTime($date, $format = null)
    {
        if (!$format) {
            $format = basicControl()->date_time_format;
        }
        return date($format, strtotime($date));
    }
}


if (!function_exists('getProjectDirectory')) {
    function getProjectDirectory()
    {
        return str_replace((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]", "", url("/"));
    }
}

if (!function_exists('defaultLang')) {
    function defaultLang()
    {
        return Language::where('default_status', true)->first();
    }
}

if (!function_exists('removeHyphenInString')) {
    function removeHyphenInString($string)
    {
        return str_replace("_", " ", $string);
    }
}


function updateBalance($user_id, $amount, $action = 0)
{
    try {
        $user = User::where('id', $user_id)->firstOr(function () {
            throw new \Exception('User not found!');
        });
        if ($amount > $user->balance) {
            return back()->with('error', 'Insufficient Balance to deducted.');
        }
        if ($action == 1) { //add money
            $balance = $user->balance + $amount;
            $user->balance = $balance;
        } elseif ($action == 0) { //deduct money
            $balance = $user->balance - $amount;
            $user->balance = $balance;
        }
        $user->save();
    } catch (Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}


function getAmount($amount, $length = 0)
{
    if ($amount == 0) {
        return 0;
    }
    if ($length == 0) {
        preg_match("#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($amount), $o);
        return $o[1] . sprintf('%d', $o[2]) . ($o[3] != '.' ? $o[3] : '');
    }

    return round($amount, $length);
}

function formatAmount($amount)
{
    if ($amount) {
        if ($amount != floor($amount)) {
            return number_format($amount, 2);
        }
        return number_format($amount);
    }
    return 0;
}

if (!function_exists('currencyPosition')) {
    function currencyPosition($amount)
    {
        $basic = basicControl();
        $amount = fractionNumber((float)$amount);
        return $basic->is_currency_position == 'left' && $basic->has_space_between_currency_and_amount ? "{$basic->currency_symbol} {$amount}" :
            ($basic->is_currency_position == 'left' && !$basic->has_space_between_currency_and_amount ? "{$basic->currency_symbol}{$amount}" :
                ($basic->is_currency_position == 'right' && $basic->has_space_between_currency_and_amount ? "{$amount} {$basic->base_currency} " :
                    "{$amount}{$basic->base_currency}"));
    }

}

if (!function_exists('userCurrencyPosition')) {
    function userCurrencyPosition($amount)
    {
        $basic = basicControl();
        $amount = round((float)$amount * (session()->get('currency_rate', 1)), 2);
        $currency_symbol = session()->get('currency_symbol', $basic->currency_symbol);
        $currency_code = session()->get('currency_code', $basic->currency_symbol);

        $space = $basic->has_space_between_currency_and_amount ? ' ' : '';

        if ($basic->is_currency_position == 'left') {
            return "{$currency_symbol}{$space}{$amount}";
        } else {
            return "{$amount}{$space}{$currency_code}";
        }
    }
}


if (!function_exists('fractionNumber')) {
    function fractionNumber($amount, $afterComma = true)
    {
        $basic = basicControl();
        if (!$afterComma) {
            return number_format($amount + 0);
        }
        $formattedAmount = number_format($amount, $basic->fraction_number ?? 2);

        return rtrim(rtrim($formattedAmount, '0'), '.');

    }
}


function hextorgb($hexstring)
{
    $integar = hexdec($hexstring);
    return array("red" => 0xFF & ($integar >> 0x10),
        "green" => 0xFF & ($integar >> 0x8),
        "blue" => 0xFF & $integar);
}

function renderCaptCha($rand)
{
//    session_start();
    $captcha_code = '';
    $captcha_image_height = 50;
    $captcha_image_width = 130;
    $total_characters_on_image = 6;

    $possible_captcha_letters = 'bcdfghjkmnpqrstvwxyz23456789';
    $captcha_font = 'assets/monofont.ttf';

    $random_captcha_dots = 50;
    $random_captcha_lines = 25;
    $captcha_text_color = "0x142864";
    $captcha_noise_color = "0x142864";


    $count = 0;
    while ($count < $total_characters_on_image) {
        $captcha_code .= substr(
            $possible_captcha_letters,
            mt_rand(0, strlen($possible_captcha_letters) - 1),
            1);
        $count++;
    }


    $captcha_font_size = $captcha_image_height * 0.65;
    $captcha_image = @imagecreate(
        $captcha_image_width,
        $captcha_image_height
    );

    /* setting the background, text and noise colours here */
    $background_color = imagecolorallocate(
        $captcha_image,
        255,
        255,
        255
    );

    $array_text_color = hextorgb($captcha_text_color);
    $captcha_text_color = imagecolorallocate(
        $captcha_image,
        $array_text_color['red'],
        $array_text_color['green'],
        $array_text_color['blue']
    );

    $array_noise_color = hextorgb($captcha_noise_color);
    $image_noise_color = imagecolorallocate(
        $captcha_image,
        $array_noise_color['red'],
        $array_noise_color['green'],
        $array_noise_color['blue']
    );

    /* Generate random dots in background of the captcha image */
    for ($count = 0; $count < $random_captcha_dots; $count++) {
        imagefilledellipse(
            $captcha_image,
            mt_rand(0, $captcha_image_width),
            mt_rand(0, $captcha_image_height),
            2,
            3,
            $image_noise_color
        );
    }

    /* Generate random lines in background of the captcha image */
    for ($count = 0; $count < $random_captcha_lines; $count++) {
        imageline(
            $captcha_image,
            mt_rand(0, $captcha_image_width),
            mt_rand(0, $captcha_image_height),
            mt_rand(0, $captcha_image_width),
            mt_rand(0, $captcha_image_height),
            $image_noise_color
        );
    }

    /* Create a text box and add 6 captcha letters code in it */
    $text_box = imagettfbbox(
        $captcha_font_size,
        0,
        $captcha_font,
        $captcha_code
    );
    $x = ($captcha_image_width - $text_box[4]) / 2;
    $y = ($captcha_image_height - $text_box[5]) / 2;
    imagettftext(
        $captcha_image,
        $captcha_font_size,
        0,
        $x,
        $y,
        $captcha_text_color,
        $captcha_font,
        $captcha_code
    );

    /* Show captcha image in the html page */
// defining the image type to be shown in browser widow
    header('Content-Type: image/jpeg');
    imagejpeg($captcha_image); //showing the image
    imagedestroy($captcha_image); //destroying the image instance
//    $_SESSION['captcha'] = $captcha_code;

    session()->put('captcha', $captcha_code);
}

function getIpInfo()
{
//	$ip = '210.1.246.42';
    $ip = null;
    $deep_detect = TRUE;

    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);

    $country = @$xml->geoplugin_countryName;
    $city = @$xml->geoplugin_city;
    $area = @$xml->geoplugin_areaCode;
    $code = @$xml->geoplugin_countryCode;
    $long = @$xml->geoplugin_longitude;
    $lat = @$xml->geoplugin_latitude;


    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    $browser = "Unknown Browser";
    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['long'] = $long;
    $data['lat'] = $lat;
    $data['os_platform'] = $os_platform;
    $data['browser'] = $browser;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');

    return $data;
}


if (!function_exists('convertRate')) {
    function convertRate($currencyCode, $payout)
    {
        $convertRate = 0;
        $rate = optional($payout->method)->convert_rate;
        if ($rate) {
            $convertRate = $rate->$currencyCode;
        }
        return (float)$convertRate;
    }
}
if (!function_exists('stringToRouteName')) {
    function stringToRouteName($string)
    {
        $result = preg_replace('/[^a-zA-Z0-9]+/', '.', $string);
        return empty($result) || $result == '.' ? 'home' : $result;
    }
}
function browserIcon($string)
{
    $list = [
        "Unknown Browser" => "unknown",
        'Internet Explorer' => 'internetExplorer',
        'Firefox' => 'firefox',
        'Safari' => 'safari',
        'Chrome' => 'chrome',
        'Edge' => 'edge',
        'Opera' => 'opera',
        'Netscape' => 'netscape',
        'Maxthon' => 'maxthon',
        'Konqueror' => 'unknown',
        'UC Browser' => 'ucBrowser',
        'Safari Browser' => 'safari'];
    return $list[$string] ?? 'unknown';

}


function deviceIcon($string)
{
    $list = [
        'Tablet' => 'bi-laptop',
        'Mobile' => 'bi-phone',
        'Computer' => 'bi-display'];
    return $list[$string] ?? '';

}

if (!function_exists('timeAgo')) {
    function timeAgo($timestamp)
    {
        //$time_now = mktime(date('h')+0,date('i')+30,date('s'));
        $datetime1 = new DateTime("now");
        $datetime2 = date_create($timestamp);
        $diff = date_diff($datetime1, $datetime2);
        $timemsg = '';
        if ($diff->y > 0) {
            $timemsg = $diff->y . ' year' . ($diff->y > 1 ? "s" : '');

        } else if ($diff->m > 0) {
            $timemsg = $diff->m . ' month' . ($diff->m > 1 ? "s" : '');
        } else if ($diff->d > 0) {
            $timemsg = $diff->d . ' day' . ($diff->d > 1 ? "s" : '');
        } else if ($diff->h > 0) {
            $timemsg = $diff->h . ' hour' . ($diff->h > 1 ? "s" : '');
        } else if ($diff->i > 0) {
            $timemsg = $diff->i . ' minute' . ($diff->i > 1 ? "s" : '');
        } else if ($diff->s > 0) {
            $timemsg = $diff->s . ' second' . ($diff->s > 1 ? "s" : '');
        }
        if ($timemsg == "")
            $timemsg = "Just now";
        else
            $timemsg = $timemsg . ' ago';

        return $timemsg;
    }
}

if (!function_exists('code')) {
    function code($length)
    {
        if ($length == 0) return 0;
        $min = pow(10, $length - 1);
        $max = 0;
        while ($length > 0 && $length--) {
            $max = ($max * 10) + 9;
        }
        return random_int($min, $max);
    }
}


if (!function_exists('recursive_array_replace')) {
    function recursive_array_replace($find, $replace, $array)
    {
        if (!is_array($array)) {
            return str_ireplace($find, $replace, $array);
        }
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[$key] = recursive_array_replace($find, $replace, $value);
        }
        return $newArray;
    }
}

if (!function_exists('getHeaderMenuData')) {
    function getHeaderMenuData()
    {
        // Real-time: fetch header menu directly without caching
        $menu = ManageMenu::where('menu_section', 'header')->where('theme', basicControl()->theme)->first();
        $menuData = [];

        foreach ($menu->menu_items ?? [] as $key => $menuItem) {
            $pageDetails = getPageDetails($menuItem);

            if ($pageDetails->type == 1 && $pageDetails->name != 'Blog' && is_numeric($key)) {

                $cat_type = strtolower(str_replace(' ', '_', $pageDetails->name));

                // Real-time categories with dynamic counts (no caching)
                $catData = Category::where('status', 1)
                    ->withCount([
                        'topUps as computed_topup_children' => function ($q) {
                            $q->where('status', 1)->whereHas('activeServices');
                        },
                        'cards as computed_card_children' => function ($q) {
                            $q->where('status', 1)->whereHas('activeServices');
                        },
                    ])
                    ->orderBy('sort_by', 'asc')
                    ->get();
                $menuIDetails = [
                    'name' => $pageDetails->page_name ?? $pageDetails->name ?? $menuItem,
                    'route' => isset($pageDetails->slug) ? route('page', $pageDetails->slug) : ($pageDetails->custom_link ?? staticPagesAndRoutes($menuItem)),
                    'categories' => $catData->where('type', $cat_type)
                        ->map(function ($item) use ($cat_type) {
                            // Set dynamic active_children based on category type
                            $item->active_children = ($cat_type == 'top_up')
                                ? ($item->computed_topup_children ?? 0)
                                : ($item->computed_card_children ?? 0);
                            $item->search_url = ($cat_type == 'top_up')
                                ? route('top-up', ['category' => $item->id])
                                : route('cards', ['category' => $item->id]);
                            return $item;
                        }),
                ];
            } elseif (is_numeric($key)) {

                $menuIDetails = [
                    'name' => $pageDetails->page_name ?? $pageDetails->name ?? $menuItem,
                    'route' => isset($pageDetails->slug) ? route('page', $pageDetails->slug) : ($pageDetails->custom_link ?? staticPagesAndRoutes($menuItem)),
                ];
            } elseif (is_array($menuItem)) {
                $child = getHeaderChildMenu($menuItem);
                $menuIDetails = [
                    'name' => $pageDetails->page_name ?? $pageDetails->name,
                    'route' => isset($pageDetails->slug) ? route('page', $pageDetails->slug) : ($pageDetails->custom_link ?? staticPagesAndRoutes($key)),
                    'child' => $child
                ];
            }
            $menuData[] = $menuIDetails;
        }
        return $menuData;
    }
}

if (!function_exists('staticPagesAndRoutes')) {
    function staticPagesAndRoutes($name)
    {
        return [
                'blog' => 'blog',
            ][$name] ?? $name;
    }
}


if (!function_exists('getHeaderChildMenu')) {
    function getHeaderChildMenu($menuItem, $menuData = [])
    {
        foreach ($menuItem as $key => $item) {
            if (is_numeric($key)) {
                $pageDetails = getPageDetails($item);
                $menuData[] = [
                    'name' => $pageDetails->page_name ?? $pageDetails->name ?? $item,
                    'route' => isset($pageDetails->slug) ? route('page', $pageDetails->slug) : ($pageDetails->custom_link ?? staticPagesAndRoutes($item)),
                ];
            } elseif (is_array($item)) {
                $pageDetails = getPageDetails($key);
                $child = getHeaderChildMenu($item);
                $menuData[] = [
                    'name' => $pageDetails->page_name ?? $pageDetails->name ?? $key,
                    'route' => isset($pageDetails->slug) ? route('page', $pageDetails->slug) : ($pageDetails->custom_link ?? staticPagesAndRoutes($key)),
                    'child' => $child
                ];
            } else {
                $pageDetails = getPageDetails($key);
                $child = getHeaderChildMenu([$item]);
                $menuData[] = [
                    'name' => $pageDetails->page_name ?? $pageDetails->name ?? $key,
                    'route' => isset($pageDetails->slug) ? route('page', $pageDetails->slug) : ($pageDetails->custom_link ?? staticPagesAndRoutes($key)),
                    'child' => $child
                ];
            }
        }
        return $menuData;
    }
}


if (!function_exists('getPageDetails')) {
    function getPageDetails($name)
    {
        try {
            DB::connection()->getPdo();

            $sessionLang = session('lang') ?? auth()->user()->language_id;

            return Cache::remember("page_details_{$name}", now()->addMinutes(30), function () use ($name) {
                $lang = session('lang');
                return Page::select('id', 'name', 'slug', 'custom_link', 'type', 'slug')
                    ->where('name', $name)
                    ->addSelect([
                        'page_name' => PageDetail::with('language')
                            ->select('name')
                            ->whereHas('language', function ($query) use ($lang) {
                                $query->where('short_name', $lang);
                            })
                            ->whereColumn('page_id', 'pages.id')
                            ->limit(1)
                    ])
                    ->first();
            });

        } catch (\Exception $e) {
            Log::error("Error fetching page details: " . $e->getMessage());
            return null;
        }
    }
}

if (!function_exists('renderHeaderMenu')) {
    function renderHeaderMenu($menuItems, $isDropdown = false)
    {
        foreach ($menuItems as $menuItem) {
            $isActive = strtolower(getLastSegment()) == strtolower(basename($menuItem['route']));

            if (isset($menuItem['categories']) && count($menuItem['categories']) > 0) {
                echo '<li class="nav-item with-mega-menu">';
                echo '<a href="' . $menuItem['route'] . '" class="nav-link ' . ($isActive ? 'active' : '') . '">';
                echo $menuItem['name'];
                echo ' <i class="fa-solid fa-chevron-down headerIconCheev"></i>';
                echo '</a>';
                echo '<div class="mega-menu">';
                echo '<ul>';
                foreach ($menuItem['categories'] as $category) {
                    echo '<li>';
                    echo '<a href="' . $category['search_url'] . '" class="nav-link">';
                    echo '<div class="icon-box"><i class="' . $category['icon'] . '"></i></div>';
                    echo '<div class="text-box">' . $category['name'] . '<span>(' . $category['active_children'] . ')</span></div>';
                    echo '</a>';
                    echo '</li>';
                }
                echo '</ul>';
                echo '</div>';
                echo '</li>';
            } elseif (isset($menuItem['child']) && count($menuItem['child']) > 0) {
                echo '<li class="dropdown hover-dropdown p_relative">';
                echo '<a href="javascript:void(0);" class="' . ($isActive ? 'active' : '') . '">';
                echo $menuItem['name'];
                echo '</a>';
                echo '<ul>';
                renderHeaderMenu($menuItem['child']);
                echo '</ul>';
            } else {
                echo '<li class="nav-item">';
                echo '<a class="nav-link ' . ($isActive ? 'active' : '') . '" href="' . $menuItem['route'] . '">' . $menuItem['name'] . '</a>';
            }
            echo '</li>';
        }
    }
}

function getLastSegment()
{
    $currentUrl = url()->current();
    $lastSegment = last(explode('/', $currentUrl));
    return $lastSegment;
}


if (!function_exists('getFooterMenuData')) {
    function getFooterMenuData($type)
    {
        $menu = Cache::get('footerMenu');
        if (!$menu) {
            $menu = ManageMenu::where('menu_section', 'footer')->where('theme', basicControl()->theme)->first();
            Cache::put('footerMenu', $menu);
        }
        $menuData = [];

        if (isset($menu->menu_items[$type])) {
            foreach ($menu->menu_items[$type] as $key => $menuItem) {
                $pageDetails = getPageDetails($menuItem);
                $menuIDetails = [
                    'name' => $pageDetails->page_name ?? $pageDetails->name ?? $menuItem,
                    'route' => isset($pageDetails->slug) ? route('page', $pageDetails->slug) : ($pageDetails->custom_link ?? staticPagesAndRoutes($menuItem)),
                ];
                $menuData[] = $menuIDetails;
            }

            $flattenedMenuData = [];
            foreach ($menuData as $item) {

                $isActive = request()->url() == $item['route'] ? 'active ' : '';
                $che = '<li><a class="widget-link ' . $isActive . '" href="' . $item['route'] . '">' . $item['name'] . '</a></li>';
                $flattenedMenuData[] = $che;
            }

            return $flattenedMenuData;
        }

        return [];
    }
}

function getPageName($name)
{
    try {
        DB::connection()->getPdo();
        $defaultLanguage = Language::where('default_status', true)->first();
        $pageDetails = PageDetail::with(['page'])->select('id', 'page_id', 'name')
            ->with('page:id,name,slug')
            ->where('language_id', $defaultLanguage->id)
            ->whereHas('page', function ($query) use ($name) {
                $query->where('name', $name);
            })
            ->first();
        return $pageDetails->name ?? $pageDetails->page->name ?? $name;
    } catch (\Exception $e) {

    }
}


function filterCustomLinkRecursive($collection, $lookingKey = '')
{

    $filterCustomLinkRecursive = function ($array) use (&$filterCustomLinkRecursive, $lookingKey) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $filterCustomLinkRecursive($value);
            } elseif ($value === $lookingKey || $key === $lookingKey) {
                unset($array[$key]);
            }
        }
        return $array;
    };
    $filteredCollection = $filterCustomLinkRecursive($collection);

    return $filteredCollection;
}

if (!function_exists('maskString')) {
    function maskString($input)
    {
        $length = strlen($input);
        $visibleCharacters = 2;
        $maskedString = '<span class="masked ms-2">' . substr($input, 0, $visibleCharacters) . '<span class="highlight">' . str_repeat('*', $length - 2 * $visibleCharacters) . '</span>' . substr($input, -$visibleCharacters) . '</span>';
        return $maskedString;
    }
}

if (!function_exists('maskEmail')) {
    function maskEmail($email)
    {
        list($username, $domain) = explode('@', $email);
        $usernameLength = strlen($username);
        $visibleCharacters = 2;
        $maskedUsername = substr($username, 0, $visibleCharacters) . str_repeat('*', $usernameLength - 2 * $visibleCharacters) . substr($username, -$visibleCharacters);
        $maskedEmail = $maskedUsername . '@' . $domain;
        return $maskedEmail;
    }
}

if (!function_exists('removeValue')) {
    function removeValue(&$array, $value)
    {
        foreach ($array as $key => &$subArray) {
            if (is_array($subArray)) {
                removeValue($subArray, $value);
            } else {
                if ($subArray === $value) {
                    unset($array[$key]);
                }
            }
        }
    }
}


if (!function_exists('showActualPrice')) {
    function showActualPrice($service)
    {
        return getAmount($service->price - $service->getDiscount(), 2);
    }
}

if (!function_exists('showAmount')) {
    function showAmount($price)
    {
        if (session()->get('currency_rate') && session()->get('currency_code') && session()->get('currency_symbol')) {
            return round($price * session()->get('currency_rate'), 2);
        }
        return $price;
    }
}

if (!function_exists('calculateDiscountAmount')) {
    function calculateDiscountAmount($amount, $discount, $discountType)
    {
        $discountAmount = $discount;
        if ($discountType == 'percentage') {
            $discountAmount = ($discount * $amount) / 100;
        }

        return $discountAmount;
    }
}


if (!function_exists('formatNumber')) {
    function formatNumber($number)
    {
        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . 'k';
        } else {
            return $number;
        }
    }
}

if (!function_exists('getGameLists')) {
    function getGameLists()
    {
        $topUps = TopUp::select(['id', 'name', 'image', 'status', 'sort_by'])
            ->where('status', 1)->orderBy('sort_by', 'ASC')->get()->map(function ($query) {
                $query->type = 'Direct Top Up';
                return $query;
            });

        $cards = Card::select(['id', 'name', 'image', 'status', 'sort_by'])
            ->where('status', 1)->orderBy('sort_by', 'ASC')->get()->map(function ($query) {
                $query->type = 'Card';
                return $query;
            });

        $combined = $topUps->concat($cards);
        return $combined;
    }
}

if (!function_exists('getFooterExtraData')) {
    function getFooterExtraData()
    {
        $extraInfo = ContentDetails::with(['content' => function ($query) {
            $query->whereIn('name', ['footer', 'social']);
        }])
            ->whereHas('content', function ($query) {
                $query->whereIn('name', ['footer', 'social']);
            })
            ->get()
            ->groupBy('content.name');

        return $extraInfo;
    }
}

if (!function_exists('adminAccessRoute')) {
    function adminAccessRoute($search)
    {
        $permissionLists = auth()->guard('admin')->user()->role->permission ?? null;
        if (!$permissionLists) {
            return true;
        }
        if (in_array(title2snake($search), $permissionLists)) {
            return true;
        }

        return false;
    }
}
if (!function_exists('getSocialData')) {
    function getSocialData()
    {
        $content = 'social';
        $contentData = ContentDetails::with('content')
            ->whereHas('content', function ($query) use ($content) {
                $query->where('name', $content);
            })
            ->get();
        $singleContent = $contentData->where('content.name', $content)->where('content.type', 'single')->first() ?? [];
        $multipleContents = $contentData->where('content.name', $content)->where('content.type', 'multiple')->values()->map(function ($multipleContentData) {
            return collect($multipleContentData->description)->merge($multipleContentData->content->only('media'));
        });
        $languages = Language::orderBy('name')->where('status', 1)->get();
        $currency = Currency::orderBy('sort_by', 'asc')->where('status', 1)->get();
        $activeCurrency = session('currency_code') ?? basicControl()->base_currency;

        $lang = new \App\Http\Middleware\Language();
        $code = $lang->getCode();
        $defaultLanguageCode = session('lang') ?? $code;;
        $defaultLanguage = $languages->where('short_name', $defaultLanguageCode)->first();
        return [
            'single' => $singleContent,
            'multiple' => $multipleContents,
            'language' => $languages,
            'defaultLanguage' => $defaultLanguage,
            'currency' => $currency,
            'activeCurrency' => $activeCurrency,
        ];
    }
}
if (!function_exists('displayStarRating')) {
    function displayStarRating($rating)
    {
        $fullStars = floor($rating);
        $decimalPart = $rating - $fullStars;

        $output = '';

        for ($i = 0; $i < $fullStars; $i++) {
            $output .= '<i class="active fa-solid fa-star"></i>';
        }

        if ($decimalPart > 0) {
            if ($decimalPart <= 0.5) {
                $output .= '<i class="active fa-solid fa-star-half-alt"></i>';
            } else {
                $output .= '<i class="active fa-solid fa-star"></i>';
            }
            $fullStars++;
        }

        $emptyStars = 5 - $fullStars;
        for ($i = 0; $i < $emptyStars; $i++) {
            $output .= '<i class="fa-solid fa-star"></i>';
        }

        return $output;
    }
}
if (!function_exists('displayStarRatingSection')) {
    function displayStarRatingSection($rating)
    {
        $fullStars = floor($rating);
        $decimalPart = $rating - $fullStars;

        $output = '<li>';

        for ($i = 0; $i < $fullStars; $i++) {
            $output .= '<i class="active fa-solid fa-star"></i>';
        }

        if ($decimalPart > 0) {
            if ($decimalPart <= 0.5) {
                $output .= '<i class="active fa-solid fa-star-half-alt"></i>';
            } else {
                $output .= '<i class="active fa-solid fa-star"></i>';
            }
            $fullStars++;
        }

        $emptyStars = 5 - $fullStars;
        for ($i = 0; $i < $emptyStars; $i++) {
            $output .= '<i class="fa-solid fa-star"></i>';
        }

        $output .= '</li>';

        return $output;
    }
}
if (!function_exists('footerData')) {
    function footerData()
    {
        $languages = Cache::get("footer_language");
        if (!$languages || $languages->isEmpty()) {
            $languages = Language::all();
            Cache::put('footer_language', $languages);
        }

        $language = new App\Http\Middleware\Language();
        $code = $language->getCode();
        $defaultLanguage = $languages->where('short_name', $code)->first();

        $contentDetails = Cache::get("footer_content");
        if (!$contentDetails || $contentDetails->isEmpty()) {
            $contentDetails = ContentDetails::with('content')
                ->whereIn('content_id', Content::whereIn('name', ['footer'])->pluck('id'))
                ->get()
                ->groupBy(function ($item) {
                    return $item->content->name;
                });

            Cache::put('footer_content', $contentDetails);
        }

        return prepareContentData($contentDetails->get('footer'), $languages, $defaultLanguage);
    }
}

if (!function_exists('prepareContentData')) {
    function prepareContentData($footerContents, $languages, $defaultLanguage)
    {
        if (is_null($footerContents)) {
            return [
                'single' => [],
                'multiple' => collect(),
                'languages' => $languages,
                'defaultLanguage' => $defaultLanguage,
            ];
        }

        $singleContent = $footerContents->where('content.name', 'footer')
            ->where('content.type', 'single')
            ->first();

        $multipleContents = $footerContents->where('content.name', 'footer')
            ->where('content.type', 'multiple')
            ->values()
            ->map(function ($content) {
                return collect($content->description)->merge($content->content->only('media'));
            });

        return [
            'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
            'multiple' => $multipleContents,
            'languages' => $languages,
            'defaultLanguage' => $defaultLanguage,
        ];
    }
}

if (!function_exists('getFirebaseFileName')) {
    function getFirebaseFileName()
    {
        return 'firebase-service.json';
    }
}

if (!function_exists('getTextColorClass')) {
    function getTextColorClass(): string
    {
        $theme = getTheme();
        $dashboard = auth()->user()->active_dashboard;
        $isUserRoute = Str::contains(request()->route()->getName(), 'user.');

        if ($theme == 'light' && $dashboard == 'daybreak' && $isUserRoute) {
            return 'text-dark';
        }
        if ($theme == 'dark' && $dashboard == 'daybreak' && $isUserRoute) {
            return 'text-dark';
        }
        if ($theme == 'light' && $dashboard == 'nightfall' && $isUserRoute) {
            return 'text-light';
        }
        if ($theme == 'dark' && $dashboard == 'nightfall' && $isUserRoute) {
            return 'text-light';
        }
        if ($theme == 'light' && !$isUserRoute) {
            return 'text-dark';
        }
        if ($theme == 'dark' && !$isUserRoute) {
            return 'text-light';
        }

        return '';
    }
}

