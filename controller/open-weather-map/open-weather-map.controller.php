<?php
/**
 * @file open-weather-map.controller.php
 */

/**
 * Class OpenWeatherMapController
 */
class OpenWeatherMapController {

    /**
     * Returns current weather forecast.
     * return empty array if error
     * Cache  25minutes
     *
     * @param $in
     *
     */
    public function current($in): array | string
    {

        $country = get_current_country(clientIp());
        $city = $country->city;
        $twoDigitCode = $country->v('2digitCode');

        // @TODO language support for open weather map does not follow the standard.
        // https://openweathermap.org/forecast5#multi
        // Need a conversion.
        $lang = get_user_language();
        if ( $lang == 'ko' ) $lang = 'kr';

        $cacheTime = $o['cacheTime'] ?? 60 * 25;
        $weather = cache("current" . $lang . $city);
        if ( $weather->expired( $cacheTime  ) ) {
            $weather->renew();
            $url = "https://api.openweathermap.org/data/2.5/weather?q=$city,$twoDigitCode&lang=$lang&units=metric&appid=" . OPENWEATHERMAP_API_KEY;
            $res = file_get_contents($url);
            $weather->set($res);
            $re = json_decode($res, true);
        } else {
            $re = json_decode($weather->data, true);
        }
        if (!$re) return [];

        return $re;
    }

}