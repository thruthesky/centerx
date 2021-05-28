<?php
/**
 * @file Country.model.php
 */
/**
 * Class CountryModel
 *
 * @property-read string $CountryNameKR 한글 국가 이름. 예) 아프가니스탄, 대한민국
 * @property-read string $CountryNameEN 영문 국가 이름. 예) Japan, South Korea
 * @property-read string $CountryNameOriginal 해당 국가 언어의 표기 이름. 예) 日本, الاردن , 한국
 * @property-read string 2digitCode 국가별 2자리 코드. 예) JP, KR
 * @property-read string 3digitCode 국가별 3자리 코드. 예) JPN, KOR
 * @property-read string $currencyCode 통화 코드. 예) JPY, KRW
 * @property-read string $currencyKoreanName 한글 통화 이름(명칭). 예) 엔, 원, 유로, 달러, 페소
 * @property-read string $currencySymbol 통화 심볼. 예) ¥, €, ₩, HK$
 * @property-read int $ISONumericCode 국가별 ISO 코드
 * @property-read string $latitude
 * @property-read string $longitude
 * @property-read mixed $createdAt
 * @property-read mixed $updatedAt
 *
 *
 * @property-read string $countryCode - 2digitCode 와 같은 값을 리턴한다.
 *
 * @note README 를 참고한다.
 *
 *
 *
 */
class CountryModel extends Entity
{
    public string $code;
    public string $city;

    public function __construct(int $idx)
    {
        parent::__construct(COUNTRIES, $idx);
    }

    /**
     *
     * @param $name
     * @return mixed
     */
    public function __get($name): mixed {
        if ( $name == 'countryCode' ) {
            return $this->v('2digitCode');
        } else {
            return parent::__get($name);
        }
    }

}


/**
 * Returns Country instance.
 *
 *
 * @param int|string $idx -
 *  문자열 값으로 입력되면, 국가 코드 또는 currencyCode 인식해서 현재 entity 에 설정한다.
 *  코드에 맞는 존재하지 않으면 에러가 설정된다.
 * @param bool $currencyCode - true 로 지정되면, 입력된 $idx 를 currencyCode 로 인식해서, currencyCode 와 일치하는 레코드를 찾는다.
 * @return CountryModel
 */
function country(int|string $idx = 0, bool $currencyCode = false): CountryModel
{
    if (is_string($idx) && strlen($idx) == 2 ) { // 두 자리 코드
        return country()->findOne(['2digitCode' => $idx]);
    } else if (is_string($idx) && strlen($idx) == 3 ) { // 세 자리 코드
        if ( $currencyCode ) return country()->findOne(['currencyCode' => $idx]);
        else return country()->findOne(['3digitCode' => $idx]);
    } else {
        if ( is_numeric($idx) ) return new CountryModel($idx); // 숫자
        else return new CountryModel(0); // 그 외
    }
}


/**
 * Returns country object that holds IP2Location information
 *
 *
 * 사용자의 접속 IP 를 바탕으로, 사용자가 있는 국가 정보를 Country 객체로 리턴한다.
 * 에러가 있으면, 에러가 설정된 Country 객체가 리턴된다.
 *
 * 주의, IP 를 메모리 캐시하여, 동일한 IP 로 여러번 호출해도 한번만 DB 액세스를 한다.
 *
 * @param string|null $ip - the user ip address. if it's empty, then it takes the user's ip address.
 * @return CountryModel
 * @throws \MaxMind\Db\Reader\InvalidDatabaseException
 */
$__current_country = [];
function get_current_country(string $ip = null): CountryModel {
    global $__current_country;
    if ( isset($__current_country[$ip]) ) return $__current_country[$ip];

//    $reader = new \GeoIp2\Database\Reader(ROOT_DIR . "etc/data/GeoLite2-Country.mmdb");
    $reader = new \GeoIp2\Database\Reader(ROOT_DIR . "etc/data/GeoLite2-City.mmdb");
    try {
//        $record = $reader->country($ip ?? $_SERVER['REMOTE_ADDR']);
        $record = $reader->city($ip ?? $_SERVER['REMOTE_ADDR']);
        $code2 = $record->country->isoCode;
        $country = country($code2);

        if ( isset($record->city->names['en']) ) $country->city = $record->city->names['en'];
        $__current_country[$ip] = $country;
        return $__current_country[$ip];
    } catch (\GeoIp2\Exception\AddressNotFoundException $e) {
        return country()->setError(e()->geoip_address_not_found);
    } catch (\MaxMind\Db\Reader\InvalidDatabaseException $e) {
        return country()->setError(e()->geoip_invalid_database);
    } catch (Exception $e) {
        return country()->setError(e()->geoip_unknown);
    }
}

