<?php


/**
 * @file open-weather-map.controller.php
 */

/**
 * Class OpenWeatherMapController
 */
class CurrencyConverterController
{
    /**
     * @see README.md for details
     * @param $in
     * @return array|mixed
     */
    public function get($in) {
        $c1 = $in['currency1'];
        $c2 = $in['currency2'];

        $firstPair = "{$c1}_{$c2}";
        $secondPair = "{$c2}_${c1}";
        $q = "{$c1}_{$c2},{$c2}_${c1}";

        $currency = cache($firstPair);
        if ( $currency->expired( CURRENCY_CONVERTER_CACHE_EXPIRE  ) ) {
            $currency->renew();
            $url = CURRENCY_CONVERTER_API_URL . "?q=$q&compact=ultra&apiKey=" . CURRENCY_CONVERTER_API_KEY;
            $res = file_get_contents($url);
            $currency->set($res);

            /// Cache another pair!! see README.md for details.
            cache($secondPair)->set($res);
            $re = json_decode($res, true);
            if ($re) return $re;
        } else {
            $re = json_decode($currency->data, true);
            if ($re) {
                $re['cached'] = true;
                return $re;
            }
        }

        // If there is no data, or there is an error on json decode.
        return [];
    }
}
