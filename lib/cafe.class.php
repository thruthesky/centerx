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
class Cafe extends Category
{

    public function __construct()
    {
        parent::__construct(0);
        if ( $this->isMainCafe() ) {
            $this->updateData('countryCode', CAFE_ROOT_DOMAIN[get_root_domain()]['countryCode']);
        }
    }


    public function countryName(): string {
        return country_name($this->countryCode);
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
     */
    public function currency() {
        return country_currency($this->currencyCode());
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
        if ( $this->isMainCafe() ) return CAFE_ROOT_DOMAIN[get_root_domain()]['homeButtonLabel'];
        if ( $this->title ) return $this->title;
        else return explode('.', $this->id)[0];
    }

}


/**
 * Cafe 객체를 리턴한다.
 *
 * 해당 카페 객체를 한 번 생성하면, 그 다음 부터는 생성된 객체를 재 사용한다. 즉, Singleton 방식으로 사용한다.
 *
 *
 * @param string $domain
 *  $domain 이 입력되면, $domain 에 해당하는 카페를 찾아 현재 객체로 전환한다. 만약, 코드에 맞는 존재하지 않으면 에러가 설정된다.
 *  만약, 루트 도메인이면, $domain 을 입력하지 않으면 된다. 그러면 에러가 설정되지 않고, cafe() 로 생성된 객체를 적절하게 사용 할 수 있다.
 *
 * @return Cafe
 */
global $__cafe;
function cafe(string $domain=''): Cafe
{
    global $__cafe;
    if ( isset($__cafe) && $__cafe ) {
//        debug_log("Reuse cafe object: ");
        return $__cafe;
    }

    $__cafe = new Cafe();

    if ( $domain ) {
        $__cafe->findOne(['id' => $domain]);
    }

    return $__cafe;
}


