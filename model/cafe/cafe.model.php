<?php
/**
 * @file category.model.php
 */
/**
 * Class CategoryModel
 * @property-read string $app_name
 * @property-read string $app_background_color
 *
 */
class CafeModel extends CategoryModel
{

    /**
     * Cafe main domains
     * 메인 카페 목록.
     *
     * Note, these domains are the only domains that display cafe main page. All other domains are considers as sub cafe.
     * You can add some domains to make the domain to display cafe main page for development.
     * 주의, 메인 카페 인지 아닌지만 판별한다.  설정은 domain settings 에서 한다.
     *
     *
     * 여기에 기록된 메인 도메인은 2차 도메인이라도, 서브 카페(2차 도메인)로 인식되지 않고, 메인 카페로 인식된다.
     * 주로, sonub.com 또는 www.sonub.com 과 같이 기록이 되어야하고, 사용자가 이 도메인으로 접속하면, 메인 사이트로 인식을 하는 것이다.
     * 하지만, 테스트를 위해서, 개발자 컴퓨터에서 /etc/hosts 에 main.sonub.com 을 등록하고 main.sonub.com 과 같이 접속을 하면, 메인 사이트로 인식을 한다.
     */

    public $mainCafeDomains = [
        'philov.com', 'www.philov.com', 'main.philov.com',
        'sonub.com', 'www.sonub.com', 'main.sonub.com',
    ];


    /**
     * Country domain.
     * 국가별 도메인 지정.
     *
     * @attention add domains that belong to a country. For instance, domain `sonub.com` is used for world wide.
     *  That means, when user visit `sonub.com`, they can create a cafe of any country by selecting the country on the form.
     *  But, if a user visit a domain that is added here, the user cannot choose country because the domain is fixed for
     *  that country only.
     *  - Add only root domain.
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
    public $countryDomains = [
        'philov.com',
    ];

    /**
     * Root domain configuration.
     * 각 루트 도메인에 대한 설정이다.
     *
     * Add domain configuration for all root domains.
     *
     * sonub 에서 지원하는 모든 루트 도메인(국가 전용 도메인 포함)은 여기에 기록되어야 한다.
     * 만약, countryCode 값이 null 이면, 현재 사용자가 있는 곳의 국가가 자동으로 설정된다.
     */
    public $mainCafeSettings = [
        'sonub.com' => [
            'name' => '소너브',
            'countryCode' => '',
            'logo' => '/img/cafe/root-domain-logo/sonub-logo.jpg',
            'searchBoxPlaceHolder' => '여행 소셜 네트워크 허브'
        ],
        'philov.com' => [
            'name' => '필러브',
            'countryCode' => 'PH',
            'logo' => '/img/cafe/root-domain-logo/philov-logo.jpg',
            'searchBoxPlaceHolder' => '필리핀 여행 정보 커뮤니티'
        ]
    ];


    /**
     * @var string[][]
     */
    public $mainMenus = [
        'qna',
        'discussion',
        'buyandsell',
        'travel',
        'reminder',
        'job',
        'rent_house',
        'rent_car',
        'im_visa',
        'real_estate',
        'money_exchange',
        // 보딩하우스. 하숙집.
        'boarding_house',
        // 홈스테이. 아이디를 맡아서 돌보면서, 학교를 보내는 곳.
        'homestay',
        // 호텔. 또는 민박. 또는 게스트 하우스.
        'hotel',
        'gathering',
        'weather',
        'greetings',
        'business',
        'house_helper',
        // 사람 찾기, 행방불명
        'missing',

        // 주의 사항,
        'caution',

        'restaurant',
        'food_delivery',
        'school',
        'company_book',
        'golf',
        'knowhow',
        'message',
        'news',
        // 사진, 갤러리
        'photo',
        // 먹방
        'eat',
    ];

    /**
     * @var string[][]
     */
    public $sitemap = [
        'community' => [
            'qna',
            'discussion',
            'reminder',
            'knowhow',
            'gathering',
            'missing',
            'caution',
            'photo',
            'eat',
        ],
        'business' => [
            'job' ,
            'company_book',
        ],
        'real_estate' => [
            'real_estate',
            'boarding_house',
            'hotel',
        ],
        'travel' => [
            'travel',
            'hotel',
        ],
        'lifestyle' => [
            'rent_house',
            'rent_car',
            'im_visa',
            'real_estate',
            'money_exchange',
            'boarding_house',
            'homestay',
            'weather',
            'house_helper',
            'restaurant',
            'food_delivery',
            'school',
            'message',
            'buyandsell',
        ],
        'news' => [
            'news'
        ],
    ];



    public function __construct(int $idx)
    {
        parent::__construct($idx);
        if ( $this->isMainCafe() ) {
            // 메인 사이트(카페)의 경우, wc_categories 에 해당하는 게시판 테이블 레코드가 없다. 그래서, 향후 에러가 나지 않도록, countryCode 를 기본 설정 해 준다.
            // CafeModel 객체를 초기화 할 때, 각 카페의 경우, 국가 코드가 있지만, 메인 사이트는 없다.
            // 예를 들어, philov.com 과 같은 경우, 필리핀 전용 도메인으로 countryCode 가 있지만,
            // sonub.com 의 경우, 전 세계 글로벌 교민 사이트이므로, 특별히 countryCode 가 없다.
            // 그래서 여기서 초기화를 해 준다.

            $this->updateMemoryData('countryCode', $this->countryCode());
        }
    }


    /**
     * @param array $in
     * - rootDomain as 'abc.com'
     * - domain as 'user'. So, the final domain would look 'user.abc.com'.
     * - countryCode as 'PH'.
     * @return $this
     */
    public function create($in):self {
        if( notLoggedIn() ) return $this->error(e()->not_logged_in);

        if( !isset($in['rootDomain']) ) return $this->error(e()->empty_root_domain);

        if( !isset($in['countryCode']) || empty($in['countryCode']) ) return $this->error(e()->empty_country_code);
        if( strlen($in['countryCode']) != 2 || is_numeric($in['countryCode']) ) return $this->error(e()->malformed_country_code);

        if( !isset($in['domain']) ) return $this->error(e()->empty_domain);

        if( preg_match("/^[a-zA-z][0-9a-zA-z]+/", $in['domain']) !== 1 ) return $this->error(e()->domain_should_be_alphanumeric_and_start_with_letter);


        $domain = strtolower($in['domain']) . '.' . $in['rootDomain'];

        if( strlen($domain) > 32 ) return $this->error(e()->domain_too_long);

        if (in_array($domain, $this->mainCafeDomains)) return $this->error(e()->cafe_main_domain);

        if ( category($domain)->exists ) return $this->error(e()->cafe_exists);


        $data = [
            USER_IDX => login()->idx,
            ID => $domain,
            DOMAIN => $in['rootDomain'],
            'countryCode' => $in['countryCode'],
        ];
        return parent::create($data);
    }



    /**
     *
     * @param $name
     * @return mixed
     */
    public function __get($name): mixed {
        if ( $name == 'domain' ) {
            return $this->id;
        }

        return parent::__get($name);

    }


    /**
     * 현재 카페의 루트 도메인 세이팅을 리턴한다.
     * @return array|null
     */
    private function mainCafeSettings(): array|null {
        $rootDomain = get_root_domain();
        if ( isset($this->mainCafeSettings[$rootDomain]) ) {
            return $this->mainCafeSettings[$rootDomain];
        } else {
            return null;
        }
    }

    /**
     * 루트 카페(도메인)의 이름을 리턴한다.
     */
    public function rootCafeName() {
        $setting = $this->mainCafeSettings();
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
        return in_array(get_root_domain(), $this->countryDomains);
    }

    /**
     * main cafe 인 경우, 그 도메인의 country 코드를 리턴한다.
     * main cafe 가 아닌 경우, 해당 카페의 country 코드를 리턴한다.
     * @return string
     */
    private function countryCode(): string {
        if ( $this->isMainCafe() ) { // 메인 카페
            if ( $this->isCountryDomain() ) { // 국가 카페
                return $this->mainCafeSettings()['countryCode'];
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
     * @return CountryModel
     */
    public function country(): CountryModel {
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
    public function isMainCafe(string $domain = null): bool {
        return in_array($domain ?? get_domain(), $this->mainCafeDomains);
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
            return $this->mainCafeSettings()['name'];
        }
        if ( $this->title ) return $this->title;
        else return explode('.', $this->id)[0];
    }


    public function titleImage(): FileModel {
        return $this->fileByCode('title_image');
    }

    public function appIcon(): FileModel {
        return $this->fileByCode('app_icon');
    }

    /**
     * Returns the file object of the image that is related with the cafe category.
     * @param string $code
     * @return FileModel
     */
    public function fileByCode(string $code): FileModel {
        return files()->findOne([TAXONOMY => $this->taxonomy, ENTITY => $this->idx, CODE => $code]);
    }

    /**
     * Returns number of tokens.
     * @return int
     */
    public function countTokens(): int {
        return token()->count(conds: [TOPIC => cafe()->domain]);
    }


}





global $__cafe;
/**
 * Returns the current cafe category object.
 * Cafe 객체를 리턴한다.
 *
 * Note, this function returns previously create object. That means, it is a `Singleton`.
 * 해당 카페 객체를 한 번 생성하면, 그 다음 부터는 생성된 객체를 재 사용한다. 즉, Singleton 방식으로 사용한다.
 *
 * @attention if $idx or $domain is given, it returns the cafe category without using cache data.
 * @attention `cafe()` return the current cafe object.
 *  So, if you do `cafe()->mine()->response()`, then it will return current cafe if there is no cafe by `mine()`.
 *  To do this work, `(new CafeModel(0))->mine()->response();`
 *
 *
 * @param int $idx
 * @param string $domain
 * @return CafeModel
 */
function cafe(int $idx = 0, string $domain = ''): CafeModel
{

    if ( $idx ) {
        return new CafeModel($idx);
    }
    if ( $domain ) {
        return (new CafeModel(0))->findOne(['id' => $domain]);
    }

    global $__cafe;
    // 메모리 캐시 되었으면, 이전 변수를 리턴.
    if ( isset($__cafe) && $__cafe ) {
        return $__cafe;
    }


    $__cafe = new CafeModel(0);      // 처음, 카페 객체 생성 이 후, 이 코드는 두번 실행되지 않는다.
    $domain = get_domain();     // 현재 도메인

    // If it is main cafe, return empty cafe(category) model.
    if ( $__cafe->isMainCafe() ) return $__cafe; // 현재 도메인이 메인 도메인 중 하라나면, 빈 Cafe 객체를 리턴.

    // Or, return cafe category model.
    // 메인 도메인이 아니면, 해당 도메인의 카페를 찾아 리턴. 카페를 찾지 못하면 에러 설정 됨.
    // 즉, 맨 처음 1회, 현재 카페의 객체를 생성하고, 재 사용한다.
    $__cafe->findOne(['id' => $domain]);
    return $__cafe;
}

