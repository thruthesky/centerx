<?php
/**
 * @file cafe.class.php
 */
/**
 * Class Cafe
 *
 * @property-read string $countryCode
 *
 * @note README 를 참고한다.
 *
 *
 *
 *
 */
class Cafe extends CategoryTaxonomy
{

    public function __construct(int $idx)
    {
        parent::__construct($idx);
        if ( $this->isMainCafe() ) {
            // 메인 카페의 경우, DB 레코드가 없다. 그래서, 향후 에러가 나지 않도록, countryCode 를 기본 설정 해 준다.
            $this->updateData('countryCode', CAFE_COUNTRY_DOMAINS[get_root_domain()]['countryCode']);
        }
    }


    public function countryName(): string {
        return country_name($this->countryCode);
    }

    /**
     * 현재 카페가 속한 국가 정보를 리턴한다.
     * @return Country
     */
    public function country(): Country {
        return country($this->countryCode);
    }


    /**
     * @return mixed
     */
    public function koreanCurrencyName(): string {
        return korean_currency_name($this->countryCode);
    }

    /**
     * 3 자리 국가 통화 코드를 리턴한다.
     * 예) KRW, PHP, USD
     *
     * @return string
     */
    public function currencyCode(): string {
        return country_currency_code($this->countryCode);
    }

    /**
     * `해당 국가 통화 vs 원화` 와 `해당 국가 통화 vs 달러` 두 가지를 리턴한다.
     *
     * @return mixed
     *  - 에러가 있으면 에러 문자열
     *  - 환율 정보가 없으면 빈 배열
     *  - 환율 정보가 있으면, 환율 정보를 담은 배열.
     */
    public function currency(): mixed {
        $currencyCode = $this->currencyCode();
        if ( isError($currencyCode) ) return $currencyCode;
        return country_currency($currencyCode);
    }

    /**
     * 현재 카페가 메인 카페(루트 사이트)이면 true 를 리턴한다.
     *
     * 주의. 현재 카페 도메인이 category 에 생성되지 않은 경우, $this->id 는 falsy 의 값이다. 그래서 $this->id 로 비교하면 안되고,
     *      그냥 현재 접속 도메인을 가지고 비교를 한다.
     * @return bool
     */
    public function isMainCafe(): bool {
        return in_array(get_domain(), CAFE_MAIN_DOMAIS);
    }

    /**
     * Main 카페가 아닌 서브 카페이면 true 를 리턴.
     */
    public function isSubCafe(): bool {
        return $this->isMainCafe() === false;
    }

    /**
     * 카페(사이트) 이름
     *
     * - 메인 사이트의 경우, CAFE_ROOT_DOMAIN 에 기록된 이름
     * - 서브 사이트의 경우, category->title (게시판 제목) 또는 2차 도메인.
     * @return string
     */
    public function name(): string {
        if ( $this->isMainCafe() ) return CAFE_COUNTRY_DOMAINS[get_root_domain()]['homeButtonLabel'];
        if ( $this->title ) return $this->title;
        else return explode('.', $this->id)[0];
    }


    /**
     * 현재 접속 사이트의 루트 도메인이 CAFE_COUNTRY_DOMAIN 이면, 참을 리턴한다.
     *
     * 활용, 카페 개설을 할 때, 현재 도메인이 특정 국가에 속한 도메인이라면, 국가 선택을 보여주지 않을 수 있다.
     *
     * @return bool
     */
    public function isCountryDomain(): bool {
        return array_key_exists(get_root_domain(), CAFE_COUNTRY_DOMAINS);
    }

    /**
     * 현재 접속 사이트의 CAFE_COUNTRY_DOMAIN 의 국가 코드를 리턴한다.
     * @return string
     */
    public function countryDomainCountryCode(): string {
        return CAFE_COUNTRY_DOMAINS[get_root_domain()]['countryCode'];
    }
}


/**
 * Cafe 객체를 리턴한다.
 *
 * 해당 카페 객체를 한 번 생성하면, 그 다음 부터는 생성된 객체를 재 사용한다. 즉, Singleton 방식으로 사용한다.
 *
 *
 * @return Cafe
 */
global $__cafe;
function cafe(): Cafe
{
    global $__cafe;
    if ( isset($__cafe) && $__cafe ) {
//        d("Reuse cafe object: ");
        return $__cafe;
    }


    $__cafe = new Cafe(0);      // 카페 객체 생성. 이 후, 이 코드는 두번 실행되지 않는다.
    $domain = get_domain();     // 현재 도메인

    if ( in_array($domain, CAFE_MAIN_DOMAIS) ) return $__cafe; // 현재 도메인이 메인 도메인 중 하라나면, 빈 Cafe 객체를 리턴.

    $__cafe->findOne(['id' => $domain]); // 메인 도메인이 아니면, 해당 도메인의 카페를 찾아 리턴. 카페를 찾지 못하면 에러 설정 됨.
    return $__cafe;
}


