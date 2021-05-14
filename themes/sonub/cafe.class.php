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
class CafeTaxonomy extends CategoryTaxonomy
{

    public $mainmenus;

    public function __construct(int $idx)
    {
        parent::__construct($idx);
        if ( $this->isMainCafe() ) {
            // 메인 사이트(카페)의 경우, wc_categories 에 해당하는 게시판 테이블 레코드가 없다. 그래서, 향후 에러가 나지 않도록, countryCode 를 기본 설정 해 준다.
            // CafeTaxonomy 객체를 초기화 할 때, 각 카페의 경우, 국가 코드가 있지만, 메인 사이트는 없다.
            // 예를 들어, philov.com 과 같은 경우, 필리핀 전용 도메인으로 countryCode 가 있지만,
            // sonub.com 의 경우, 전 세계 글로벌 교민 사이트이므로, 특별히 countryCode 가 없다.
            // 그래서 여기서 초기화를 해 준다.

            $this->updateMemory('countryCode', $this->countryCode());
        }

        $this->mainmenus = CAFE_MAIN_MENUS;

        uasort($this->mainmenus, function($a, $b) {
            if ( $a['priority'] == $b['priority'] ) return 0;
            if ( $a['priority'] > $b['priority'] ) return -1;
            else return 1;
        });
    }

    private function countryDomainSettings(): array|null {
        $rootDomain = get_root_domain();
        if ( isset(CAFE_COUNTRY_DOMAIN_SETTINGS[$rootDomain]) ) {
            return CAFE_COUNTRY_DOMAIN_SETTINGS[$rootDomain];
        } else {
            return null;
        }
    }


    /**
     * 현재 접속 사이트의 루트 도메인이 CAFE_COUNTRY_DOMAIN 이면, 참을 리턴한다.
     *
     * 즉, 카페 개설을 할 때, 현재 도메인이 특정 국가에 속한 도메인이라면, 국가 선택을 보여주지 않을 수 있다.
     * 예를 들어, philov.com 는 필리핀 교민 사이트를 위한 전용 도메인으로 쓰고 싶다면, CAFE_COUNTRY_DOMAIN 으로 등록해 놓는다.
     * 그러면, 카페 개설을 할 때, philov.com 사이트 또는 그 하위 사이트에서는 따로 국가 선택을 안해도 된다.
     *
     * @return bool
     */
    public function isCountryDomain(): bool {
        return array_key_exists(get_root_domain(), CAFE_COUNTRY_DOMAIN_SETTINGS);
    }

    /**
     * main cafe 인 경우, 그 도메인의 country 코드를 리턴한다.
     * main cafe 가 아닌 경우, 해당 카페의 country 코드를 리턴한다.
     * @return string
     */
    private function countryCode(): string {
        if ( $this->isMainCafe() ) { // 메인 카페
            if ( $this->isCountryDomain() ) { // 국가 카페
                return $this->countryDomainSettings()['countryCode'];
            } else { // 전 세계 카페. 예) sonub.com
                // @TODO 사용자가 속한 국가 코드를 리턴한다.
                return 'KR';
            }
        } else {
            return $this->countryCode;
        }
    }




    public function countryName(): string {
        return country_name($this->countryCode);
    }

    /**
     * 현재 카페가 속한 국가 정보를 리턴한다.
     * @return CountryTaxonomy
     */
    public function country(): CountryTaxonomy {
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
     *
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
        return in_array(get_domain(), CAFE_MAIN_DOMAINS);
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
        if ( $this->isMainCafe() ) {
            //// 2021. 05. 14.
            return 'homeButtonLabel';
            return CAFE_COUNTRY_DOMAIN_SETTINGS[get_root_domain()]['homeButtonLabel'];
        }
        if ( $this->title ) return $this->title;
        else return explode('.', $this->id)[0];
    }


    /**
     * 현재 접속 사이트의 CAFE_COUNTRY_DOMAIN 의 국가 코드를 리턴한다.
     * @return string
     */
    public function countryDomainCountryCode(): string {
        return CAFE_COUNTRY_DOMAIN_SETTINGS[get_root_domain()]['countryCode'];
    }
}


/**
 * Cafe 객체를 리턴한다.
 *
 * 해당 카페 객체를 한 번 생성하면, 그 다음 부터는 생성된 객체를 재 사용한다. 즉, Singleton 방식으로 사용한다.
 *
 *
 * @return CafeTaxonomy
 */
global $__cafe;
function cafe(): CafeTaxonomy
{
    global $__cafe;
    // 메모리 캐시 되었으면, 이전 변수를 리턴.
    if ( isset($__cafe) && $__cafe ) {
        return $__cafe;
    }


    $__cafe = new CafeTaxonomy(0);      // 처음, 카페 객체 생성 이 후, 이 코드는 두번 실행되지 않는다.
    $domain = get_domain();     // 현재 도메인

    if ( in_array($domain, CAFE_MAIN_DOMAINS) ) return $__cafe; // 현재 도메인이 메인 도메인 중 하라나면, 빈 Cafe 객체를 리턴.

    // 메인 도메인이 아니면, 해당 도메인의 카페를 찾아 리턴. 카페를 찾지 못하면 에러 설정 됨.
    // 즉, 맨 처음 1회, 현재 카페의 객체를 생성하고, 재 사용한다.
    $__cafe->findOne(['id' => $domain]);
    return $__cafe;
}

cafe(); // 함수를 최초 한번 실행한다.


