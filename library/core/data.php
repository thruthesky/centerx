<?php
/**
 * @file data.php
 */

/**
 * 국가 코드 2자리와 국가 이름을 리턴한다. 국가 이름을 보여주고, 선택하면 국가 코드를 저장하려 할 때 사용가능.
 *
 * @param string $sortby - 이 값이 CountryNameEn 이면, 국가 이름을 영어 이름 정렬한다. 기본적으로 한글 정렬.
 * @return mixed
 * - 리턴되는 국가 코드는 대문자이다.
 * - 리턴 값 예) ['US' => '미국', 'KR' => '한국', ... ]
 *
 * @todo 3 자리 국가 코드를 옵션으로 리턴할 수 있도록 한다.
 *
 * @example
<label class="fs-sm" for="countryCode">교민 카페 운영 국가</label>
<select class="form-select" id="countryCode" name="countryCode" aria-label="Country selection box">
    <option selected>국가를 선택해주세요.</option>
        <?
            foreach( country_code() as $co ) {
        ?>
            <option value="<?=$co['2digitCode']?>"><?=$co['CountryNameKR']?></option>
        <? } ?>
</select>
 */
//function country_code($sortby='CountryNameKR') {
//
//    $countries = json_decode(file_get_contents(ROOT_DIR . 'etc/data/country-code.json'), true);
//    usort($countries, function($a, $b) use ($sortby) {
//        if ($a[$sortby] == $b[$sortby]) return 0;
//        else if ( $a[$sortby] > $b[$sortby] ) return 1;
//        else return -1;
//    });
//
//    return $countries;
//}

/**
 * 국가 코드 2자리를 입력하면, 국가명을 리턴한다.
 *
 * @param $code
 * @param string $lang
 * @return mixed
 */
function country_name($code, $lang="CountryNameKR") {
    return country($code)->v($lang);

//    $countries = json_decode(file_get_contents(ROOT_DIR . 'etc/data/country-code.json'), true);
//    return $countries[$code][$lang];
}





/**
 * 국가 코드 2 자리 또는 3 자리를 입력하면, 3자리 환율 코드를 리턴한다.
 *
 * 리턴되는 3자리 환율 코드는 Currency Api 등에서 사용 할 수 있다.
 *
 *
 * @param string $countryCode
 * @return string
 * - 세 자리 통화 코드
 * - 에러가 있으면 빈 문자열
 *
 *
 * 예)
 *
 * PH 를 입력하면 PHP 를 리턴하고,
 * KR 를 입력하면 KWR 를 리턴한다.
 *
 * ```php
 *  $krw = country_currency_code('KR') ; // KRW 리턴
 *  $php = country_currency_code('PH') ; // PHP 리턴
 *  $usd = country_currency_code('US') ; // UDS 리턴
 * ```
 */
function country_currency_code(string $countryCode): string {
    if ( empty($countryCode) ) return '';
    return country($countryCode)->currencyCode;
//    $currency = json_decode(file_get_contents(ROOT_DIR . 'etc/data/country-currency-code.json'), true);
//    return $currency[$country_id]['currencyId'];
}

/**
 * 각 나라의 통화를 한글 표기된 JSON 를 리턴한다.
 *
 * JSON 은 assoc array 로 사용 할 수 있으며
 *  - $letters[KRW][Country] 는 나라 이름(한국)
 *  - $letters[KRW][Code]는 통화 이름('원')
 *  - $letters[KRW][Symbol] 은 기호(W) 와 같다.
 *
 * 사용처)
 *  - `1페소는 23.45원` 와 같이 표시를 하고자 할 때 사용 할 수 있다.
 *
 * @return array
 */
//function country_currency_korean_letter(): array {
//    $letters = json_decode(file_get_contents(ROOT_DIR . 'etc/data/country-currency-korean-letter.json'), true);
//    return $letters;
//}


/**
 * 2 자리 또는 3 자리 국가 코드를 입력하면, 한글 통화 이름을 리턴한다.
 *
 * 예) KR 를 입력하면 '원', PH 를 입력하면 '페소', US 를 입력하면 '달러' 가 리턴된다.
 * 예) KRW 를 입력하면 '원' 이 리턴된다.
 *
 * @param $countryCode
 * @return string
 * - 통화 한글 이름
 * - 에러가 있으면 빈 문자열
 */
function korean_currency_name($countryCode): string {
    if ( empty($countryCode) ) return '';
    return country($countryCode, currencyCode: true)->currencyKoreanName;

//    if ( strlen($countryCode) == 2 ) {
//        $currency = country_currency_code($countryCode);
//    } else {
//        $currency = $countryCode;
//    }
//    if ( empty($currency) ) return '';
//    $letters = country_currency_korean_letter();
//    return $letters[$currency]['Code'];
}


/**
 * 두 자리 국가 코드를 입력하면, `해당 국가 통화 vs 원화` 와 `해당 국가 통화 vs 달러` 두 가지를 리턴한다.
 *
 * 환율 정보는 https://free.currencyconverterapi.com/ 에서 가져오며, 한 시간에 100 까지 쿼리가 가능하다. 국가별 1시간 당 캐시를 하므로,
 *  사용자가 많지 않은 초기 버전에는 충분하다. 사용자가 많으면, 캐시를 2시간으로 늘리면 충분하다.
 *
 * 참고, 연관 배열에 2개의 키/값이 리턴되는데, 첫번째 것이 `해당 국가 통화 vs 원화` 의 값이다.
 *
 * @param $countryCode
 * @return mixed
 * - 연관 배열
 * - 에러가 있으면 빈 배열
 *
 * @example)
 *  $currencies = country_currency(cafe()->currencyCode());
 *
 * @example widgets/currency/currency-default/currency-default.php
 *
 *
 */
function country_currency($countryCode) {
    if ( empty($countryCode) ) return [];
    $cc = $countryCode;
    // @todo save the key into config.php
    $key = 'bd6ed497a84496be7ee9';
    $currency = cache($cc);
    if ( $currency->olderThan(60 * 60) ) { // cache for 1 hour
        $currency->renew();
        $url = "https://free.currconv.com/api/v7/convert?q={$cc}_KRW,{$cc}_USD&compact=ultra&apiKey=$key";
        $re = file_get_contents($url);
        $currency->set($re);
    }
    $data = $currency->data;

    return json_decode($data, true);
}

/**
 * `PHP_KRW` 와 같이 입력 받아 `['페소', '원']` 으로 리턴한다.
 * @param $codes
 * @return array
 * - 문자열 배열
 * - 에러가 있으면 빈 배열
 *
 * @example
 * ```php
 * list ($src, $dst ) = convert_currency_codes_to_names('PHP_KRW'); // $src 는 '페소', $dst 는 '원'.
 * ```
 */
function convert_currency_codes_to_names($codes): array {
    if ( empty($codes) ) return [];
    $arr = explode('_', $codes);
    $src_name = korean_currency_name($arr[0]);
    $dst_name = korean_currency_name($arr[1]);
    return [$src_name, $dst_name];
}


/**
 * 환율의 값을 적절히 소수점 처리해서 리턴한다.
 *
 * - 환율의 값이 10,000 보다 크면, 소수점 없이 리턴.
 * - 환율의 값이 10 보다 작으면 소수점 3자리로 표시
 * - 환율의 값이 10 보다 크면, 소수점 2자리로 표시
 *
 * @param $rate
 */
function round_currency_rate($rate) {
    if ( $rate > 10000 ) $rate = round($rate);
    else if ( $rate < 10 ) $rate = round($rate, 3);
    else $rate = round($rate, 2);
    return $rate;
}

