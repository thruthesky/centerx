<?php
/**
 * @file Country.class.php
 */
/**
 * Class Country
 *
 * @property-read string CountryNameKR 한글 국가 이름. 예) 아프가니스탄, 대한민국
 * @property-read string CountryNameEN 영문 국가 이름. 예) Japan, South Korea
 * @property-read string CountryNameOriginal 해당 국가 언어의 표기 이름. 예) 日本, الاردن , 한국
 * @property-read string 2digitCode 국가별 2자리 코드. 예) JP, KR
 * @property-read string 3digitCode 국가별 3자리 코드. 예) JPN, KOR
 * @property-read string currencyCode 통화 코드. 예) JPY, KRW
 * @property-read string currencyKoreanName 한글 통화 이름(명칭). 예) 엔, 원, 유로, 달러, 페소
 * @property-read string currencySymbol 통화 심볼. 예) ¥, €, ₩, HK$
 * @property-read int ISONumericCode 국가별 ISO 코드
 * @property-read string latitude
 * @property-read string longitude
 * @property-read mixed $createdAt
 * @property-read mixed $updatedAt
 *
 * @note README 를 참고한다.
 *
 *
 *
 */
class CountryTaxonomy extends Entity
{
    public string $code;

    public function __construct(int $idx)
    {
        parent::__construct(COUNTRIES, $idx);
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
 * @return CountryTaxonomy
 */
function country(int|string $idx = 0, bool $currencyCode = false): CountryTaxonomy
{
    if (is_string($idx) && strlen($idx) == 2 ) { // 두 자리 코드
        return country()->findOne(['2digitCode' => $idx]);
    } else if (is_string($idx) && strlen($idx) == 3 ) { // 세 자리 코드
        if ( $currencyCode ) return country()->findOne(['currencyCode' => $idx]);
        else return country()->findOne(['3digitCode' => $idx]);
    } else {
        if ( is_numeric($idx) ) return new CountryTaxonomy($idx); // 숫자
        else return new CountryTaxonomy(0); // 그 외
    }
}


