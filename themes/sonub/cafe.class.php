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

    /**
     * 메인 카페 목록.
     *
     * 주의, 메인 카페 인지 아닌지만 판별한다.  설정은 domain settings 에서 한다.
     *
     * 여기에 기록된 메인 도메인은 2차 도메인이라도, 서브 카페(2차 도메인)로 인식되지 않고, 메인 카페로 인식된다.
     * 주로, sonub.com 또는 www.sonub.com 과 같이 기록이 되어야하고, 사용자가 이 도메인으로 접속하면, 메인 사이트로 인식을 하는 것이다.
     * 하지만, 테스트를 위해서, 개발자 컴퓨터에서 /etc/hosts 에 main.sonub.com 을 등록하고 main.sonub.com 과 같이 접속을 하면, 메인 사이트로 인식을 한다.
     */

    public $cafeMainDomains = [
        'philov.com', 'www.philov.com', 'main.philov.com',
        'sonub.com', 'www.sonub.com', 'main.sonub.com',
    ];



    /**
     * 국가별 도메인 지정.
     *
     * 주의, 국가별 도메인만 입력한다. 설정은 domain settings 에서 한다.
     *
     * 카페의 루트 도메인 별로 특정 국가를 고정하고자할 때, 아래의 목록에 루트 도메인과 국가 코드, 사이트 이름, 홈 화면 이름 등을 추가하면 된다.
     *
     * 예를 들면, philov.com 도메인을 필리핀 국가로 고정하는 경우, countryCode 를 PH 로 하고, 해당 도메인으로 접속하면, 카페 생성할 때에 국가 선택을
     * 보여주지 않는다. 또한 각종 커스터마이징에서 필리핀으로 고정을 시킨다.
     * 또한, abc.philov.com 도메인으로 접속 했을 때, 카페를 생성하려 할 때, 루트 도메인이 country 도메인인지 확인을 한다.
     *
     * 주의 할 점은, sonub.com 은 country domain 이 아니다. country domain 은 그 도메인이 한 국가에 속하는 경우이다.
     *      sonub.com 은 특정 국가의 고정 도메인이 아니라, 전 세계 도메인이므로, 여기에 속하지 않는다.
     *
     * @see sonub/README.md
     */
    public $cafeCountryDomains = [
        'philov.com',
    ];


    /**
     * 각 루트 도메인에 대한 설정이다.
     *
     * sonub 에서 지원하는 모든 루트 도메인(국가 전용 도메인 포함)은 여기에 기록되어야 한다.
     * 만약, countryCode 값이 null 이면, 현재 사용자가 있는 곳의 국가가 자동으로 설정된다.
     */
    public $cafeRootDomainSettings = [
        'sonub.com' => [
            'name' => '필러브',
            'countryCode' => null,
        ],
        'philov.com' => [
            'name' => '필러브',
            'countryCode' => 'PH',
        ]
    ];




    /**
     * @var string[][]
     */
    public $cafeMainMenus = [
        'qna' => [
            'title' => '질문게시판',
        ],
        'discussion' => [
            'title' => '자유게시판',
        ],
        'buyandsell' => [
            'title' => '회원장터',
        ],
        'reminder' => [
            'title' => '공지사항',
        ],
        'job' => [
            'title' => '구인구직',
        ],
        'rent_house' => [
            'title' => '주택임대',
        ],
        'rent_car' => [
            'title' => '렌트카',
        ],
        'im' => [
            'title' => '이민',
        ],
        'real_estate' => [
            'title' => '부동산',
        ],
        'money_exchange' => [
            'title' => '환전',
        ]
    ];


    public function __construct(int $idx)
    {
        parent::__construct($idx);
        if ( $this->isMainCafe() ) {
            // 메인 사이트(카페)의 경우, wc_categories 에 해당하는 게시판 테이블 레코드가 없다. 그래서, 향후 에러가 나지 않도록, countryCode 를 기본 설정 해 준다.
            // CafeTaxonomy 객체를 초기화 할 때, 각 카페의 경우, 국가 코드가 있지만, 메인 사이트는 없다.
            // 예를 들어, philov.com 과 같은 경우, 필리핀 전용 도메인으로 countryCode 가 있지만,
            // sonub.com 의 경우, 전 세계 글로벌 교민 사이트이므로, 특별히 countryCode 가 없다.
            // 그래서 여기서 초기화를 해 준다.

            $this->updateMemoryData('countryCode', $this->countryCode());
        }
    }

    /**
     *
     * @param $name
     * @return mixed
     */
    public function __get($name): mixed {
//        if ( $name == 'title' ) {
//            if ( $this->isMainCafe() ) {
//                return $this->rootDomainSettings()['name'];
//            }
//        }

        return parent::__get($name);

    }


    /**
     * 현재 카페의 루트 도메인 세이팅을 리턴한다.
     * @return array|null
     */
    private function rootDomainSettings(): array|null {
        $rootDomain = get_root_domain();
        if ( isset($this->cafeRootDomainSettings[$rootDomain]) ) {
            return $this->cafeRootDomainSettings[$rootDomain];
        } else {
            return null;
        }
    }

    /**
     * 루트 카페(도메인)의 이름을 리턴한다.
     */
    public function rootCafeName() {
        $setting = $this->rootDomainSettings();
        if ( $setting ) {
            return $setting['name'];
        } else {
            return '';
        }
    }


    /**
     * 현재 접속 사이트의 루트 도메인이 특정 국가에 고정된 도메인이면, 참을 리턴한다.
     *
     * 즉, 카페 개설을 할 때, 현재 도메인이 특정 국가에 속한 도메인이라면, 국가 선택을 보여주지 않을 수 있다.
     * 예를 들어, philov.com 는 필리핀 교민 사이트를 위한 전용 도메인으로 쓰고 싶다면, CAFE_COUNTRY_DOMAIN 으로 등록해 놓는다.
     * 그러면, 카페 개설을 할 때, philov.com 사이트 또는 그 하위 사이트에서는 따로 국가 선택을 안해도 된다.
     *
     * @return bool
     */
    public function isCountryDomain(): bool {
        return in_array(get_root_domain(), $this->cafeCountryDomains);
    }

    /**
     * main cafe 인 경우, 그 도메인의 country 코드를 리턴한다.
     * main cafe 가 아닌 경우, 해당 카페의 country 코드를 리턴한다.
     * @return string
     */
    private function countryCode(): string {
        if ( $this->isMainCafe() ) { // 메인 카페
            if ( $this->isCountryDomain() ) { // 국가 카페
                return $this->rootDomainSettings()['countryCode'];
            } else { // 전 세계 카페. 예) sonub.com
                $country = get_current_country(clientIp());
                if ( $country->hasError ) return 'KR';
                return $country->countryCode;
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
        return in_array(get_domain(), $this->cafeMainDomains);
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
     * - 메인 사이트의 경우, 루트 사이트 이름
     * - 서브 사이트의 경우, category->title (게시판 제목) 또는 2차 도메인.
     * @return string
     */
    public function name(): string {
        if ( $this->isMainCafe() ) {
            return $this->rootDomainSettings()['name'];
        }
        if ( $this->title ) return $this->title;
        else return explode('.', $this->id)[0];
    }


    public function titleImage(): FileTaxonomy {
        return $this->fileByCode('title_image');
    }

    public function appIcon(): FileTaxonomy {
        return $this->fileByCode('app_icon');
    }

    public function fileByCode(string $code): FileTaxonomy {
        return files()->findOne([TAXONOMY => $this->taxonomy, ENTITY => $this->idx, CODE => $code]);
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

    if ( $__cafe->isMainCafe() ) return $__cafe; // 현재 도메인이 메인 도메인 중 하라나면, 빈 Cafe 객체를 리턴.

    // 메인 도메인이 아니면, 해당 도메인의 카페를 찾아 리턴. 카페를 찾지 못하면 에러 설정 됨.
    // 즉, 맨 처음 1회, 현재 카페의 객체를 생성하고, 재 사용한다.
    $__cafe->findOne(['id' => $domain]);
    return $__cafe;
}

cafe(); // 함수를 최초 한번 실행한다.


