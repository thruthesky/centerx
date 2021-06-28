<?php
/**
 * @file Country.model.php
 */
/**
 * Class CountryModel
 *
 * @property-read string koreanName 한글 국가 이름. 예) 아프가니스탄, 대한민국
 * @property-read string englishName 영문 국가 이름. 예) Japan, South Korea
 * @property-read string officialName 해당 국가의 공식 전체 표기명. 각 나라의 언어 표기 이름. 예) 日本, الاردن , 한국
 * @property-read string alpha2 국가별 IOS 2자리 코드. Alpha-2 라고 표기하기도 함. 예) JP, KR. (이전 버전에서 `2digitCode` 로 사용)
 * @property-read string alpha3 국가별 IOS 3자리 코드. Alpha-3 라고 표기하기도 함. 예) JPN, KOR (이전 버전에서 `3digitCode` 로 사용)
 * @property-read int numericCode 국가별 ISO 숫자 코드. 예) 008, 한국은 410.
 *
 * @property-read string $countryCode - 국가 코드. DB 에는 없는 필드인데, alpha2 를 countryCode 로 사용한다.
 *
 * @property-read string $CountryNameKR 한글 국가 이름. 예) 아프가니스탄, 대한민국. 주의) 더 이상 쓰지 않음. 이전 버전 호환 때문에 존재.
 * @property-read string $CountryNameEN 영문 국가 이름. 예) Japan, South Korea. 주의) 더 이상 쓰지 않음. 이전 버전 호환 때문에 존재.
 * @property-read string $CountryNameOriginal 해당 국가 언어의 표기 이름. 예) 日本, الاردن , 한국. 주의) 더 이상 쓰지 않음. 이전 버전 호환 때문에 존재.
 * @property-read string 2digitCode 국가별 2자리 코드. 예) JP, KR.
 * @property-read string 3digitCode 국가별 3자리 코드. 예) JPN, KOR. 주의) 더 이상 쓰지 않음. 이전 버전 호환 때문에 존재.
 * @property-read string $currencyCode 통화 코드. 예) JPY, KRW
 * @property-read string $currencyKoreanName 한글 통화 이름(명칭). 예) 엔, 원, 유로, 달러, 페소
 * @property-read string $currencySymbol 통화 심볼. 예) ¥, €, ₩, HK$
 * @property-read int $ISONumericCode 국가별 ISO 코드. 주의) 더 이상 쓰지 않음. 이전 버전 호환 때문에 존재.
 * @property-read string $latitude - 국가의 중심이 되는 위도
 * @property-read string $longitude - 국가의 중심이 되는 경도
 * @property-read mixed $createdAt
 * @property-read mixed $updatedAt
 *
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



    /**
     * 레코드의 필드명이 변경되어, 이전 버전 호환을 위해서 기존 필드명을 사용 할 수 있게 해준다.
     *
     * @todo 만약, 다음 버전(2022년 이후)에서, 더 이상 기존 필드명을 사용하지 않는 다면, 기존 코드를 변환하는 부분은 삭제를 해도 된다.
     *
     * @param int $idx
     * @return self
     */
    public function read(int $idx = 0): self
    {

        parent::read($idx);
        $this->updateMemoryData('CountryNameKR', $this->koreanName);
        $this->updateMemoryData('CountryNameEN', $this->englishName);
        $this->updateMemoryData('CountryNameOriginal', $this->officialName);
        $this->updateMemoryData('2digitCode', $this->alpha2);
        $this->updateMemoryData('3digitCode', $this->alpha3);
        $this->updateMemoryData('ISONumericCode', $this->numericCode);
        return $this;
    }



}


/**
 * Returns Country instance.
 *
 * 입력 값 $idx 가
 *  - 문자열 2 자리이면, 국가 코드(alpha2)로 인식하여 그 레코드를 읽어 entity 로 리턴한다.
 *  - 문자열 3 자리이면,
 *      - 먼저, currency code(통화 코드)가 존재하는지 보고, 있으면 그 레코드를 읽어 entity 로 리턴
 *      - 또는, ISO 세자리 국가 코드(alpha3)가 존재하는지 보고, 있으면 그 레코드를 읽어, entity 로 리턴.
 *      - 또는, error_entity_not_found 에러 발생.
 * - 숫자이면, 해당 idx 의 record 를 entity 로 리턴
 * - 또는 빈 entity 를 리턴.
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
        return country()->findOne(['alpha2' => $idx]);
    } else if (is_string($idx) && strlen($idx) == 3 ) { // 세 자리 코드
        if ( $currencyCode ) return country()->findOne(['currencyCode' => $idx]);
        else return country()->findOne(['alpha3' => $idx]);
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

