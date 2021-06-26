<?php

class CountryController {

    /**
     * Returns 2 letter code and country name.
     * @param $in
     * @return array
     * - ['KR' => '대한민국', ...]
     */
    public function all($in) {
        $rets = [];
        if ( isset($in['ln']) && $in['ln'] == 'ko' ) $ln = 'KR';
        else $ln = 'EN';
        foreach( country()->search(limit: 1000, object: true) as $co ) {
            $rets[ $co->v('2digitCode') ] = $co->v("CountryName$ln");
        }
        asort($rets);
        return $rets;
    }

    /**
     * Returns currency information of a country.
     *
     * @note the return value is in Korean.
     *
     * @param $in
     * @return array|string
     */
    public function currencies($in): array | string {
        $rets = [];
        foreach( country()->search(limit: 1000, object: true) as $co ) {
            if ( isset($in['ln']) && $in['ln'] == 'ko' ) {
                $rets[ $co->CountryNameKR ] = [
                    'currencyCode' => $co->currencyCode,
                    'currencySymbol' => $co->currencySymbol,
                    'currencyKoreanName' => $co->currencyKoreanName,
                ];
            } else {
                $rets[ $co->CountryNameEN ] = [
                    'currencyCode' => $co->currencyCode,
                    'currencySymbol' => $co->currencySymbol,
                    'currencyKoreanName' => $co->currencyKoreanName,
                ];
            }
        }
        ksort($rets);
//        d($rets);
        return $rets;
    }

    /**
     * $in['id'] 에 idx, alpha2(countryCode), alpha3, currencyCode 의 값 중 하나가 들어오면 된다.
     * @param $in
     * @return array|string
     */
    public function get($in) {
        return country($in['id'])->response();
    }
}