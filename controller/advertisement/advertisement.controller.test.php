<?php
// 회원 가입 포인트를 0 으로 설정.
userActivity()->setRegisterPoint(0);
setLogout();
enableTesting();
$at = new AdvertisementTest();


// Input tests
// $at->lackOfPoint();
// $at->beginDateEmpty();
// $at->endDateEmpty();
$at->wrongBannerType();
$at->noPointSettings();
// $at->loadBanners();

// $at->statusCheck();
// $at->createBanner();
// $at->zero_point_advertisement();

// $at->startDeduction();
// $at->startWithCountryDeduction();
// $at->stopWithDeductedRefund();
// $at->stopWithCountryAndDeductedRefund();
// $at->stopFullRefund();
// $at->stopWithCountryFullRefund();
// $at->stopNoRefund();
// $at->stopOnPastOrExpiredBanner();

// $at->settings();
// $at->pointSettings();
// $at->pointSettingDelete();
// $at->maximumAdvertisementDays();
// $at->stopAfterPointSettingChanged();

// $at->startStopChangeDatesAndCountry();

// $at->errorDeleteActiveAdvertisement();
// $at->deleteAdvertisement();

// $at->maximumNoOfLimitTest();
// $at->globalCategoryBannerPoint();
// $at->defaultTopBannerTest();
// $at->topBannerLoadWithNonExistingCafe();

// $at->allCountryBannerPoint();
// $at->loadCafeCountryBanners();
// $at->loadAllCountryBanners();

// $at->topBannerLoad();
// $at->squareBannerLoad();

// $at->bannerLimit(TOP_BANNER);
// $at->bannerLimit(SIDEBAR_BANNER);
// $at->bannerLimit(SQUARE_BANNER);
// $at->bannerLimit(LINE_BANNER);

class AdvertisementTest
{

    function __construct()
    {
        // Create 'advertisement' category if it does not exists.
        if (!category()->exists([ID => ADVERTISEMENT_CATEGORY])) {
            $admin = setLoginAsAdmin();
            category()->create([ID => ADVERTISEMENT_CATEGORY]);
        }

        $this->resetGlobalMulplying();
        $this->resetBannerLimit(TOP_BANNER);
        $this->resetBannerLimit(SIDEBAR_BANNER);
        $this->resetBannerLimit(SQUARE_BANNER);
        $this->resetBannerLimit(LINE_BANNER);
        $this->resetBannerLimit(TOP_BANNER, category: false);
        $this->resetBannerLimit(SIDEBAR_BANNER, category: false);
        $this->resetBannerLimit(SQUARE_BANNER, category: false);
        $this->resetBannerLimit(LINE_BANNER, category: false);
    }

    private function clearAdvertisementData()
    {
        $cat = category(ADVERTISEMENT_CATEGORY);
        db()->delete(post()->getTable(), [CATEGORY_IDX => $cat->idx]);
    }
    /**
     * 배너 하나 생성. 그 배너는 글/제목 등만 있고, 배너 포인트나 기간 등의 옵션은 설정되지 않은 상태이다.
     * @return mixed|null
     */
    private function createAdvertisement($options = [])
    {
        registerAndLogin();
        return request("advertisement.edit", [
            SESSION_ID => login()->sessionId,
            COUNTRY_CODE => $options[COUNTRY_CODE],
        ]);
    }

    /**
     * 배너를 하나 생성하고, 입력된 옵션에 따라 배너를 시작한다. 즉, 광고 기간을 설정하고 실제 광고를 시작하는 것이다.
     *
     * @param $options
     * @return mixed|null
     */
    private function createAndStartAdvertisement($options)
    {

        $post = request("advertisement.edit", [
            SESSION_ID => login()->sessionId,
            COUNTRY_CODE => $options[COUNTRY_CODE]
        ]);
        unset($options[COUNTRY_CODE]);

        $options[SESSION_ID] = login()->sessionId;
        $options[IDX] = $post[IDX];
        return request("advertisement.start", $options);
    }

    /**
     * 관리자 권한 설정 없이, DB 를 수정해서 곧 바로, 포인트 수정을 한다.
     * @param string $countryCode
     * @param int $top
     * @param int $sidebar
     * @param int $square
     * @param int $line
     */
    private function resetBannerPoints($countryCode = '', $top = 0, $sidebar = 0, $square = 0, $line = 0)
    {

        (new AdvertisementPointSettingsModel())->_resetPoints(
            $countryCode,
            $top,
            $sidebar,
            $square,
            $line
        );
    }

    private function resetMaximumAdvertisementDays($days = 10)
    {
        adminSettings()->set(MAXIMUM_ADVERTISING_DAYS, $days);
    }

    private function resetGlobalMulplying($globalMultiplying = 0)
    {
        adminSettings()->set(ADVERTISEMENT_GLOBAL_BANNER_MULTIPLYING, $globalMultiplying);
    }

    private function resetAdvertisementCategories($categories = '')
    {
        adminSettings()->set(ADVERTISEMENT_CATEGORIES, $categories);
    }

    private function resetBannerLimit(string $banner_type, $value = 10, $category = true)
    {
        $k = banner()->maxNoKey($banner_type, $category);
        adminSettings()->set($k, $value);
    }

    private function bannerIsPresent(mixed $banner, mixed $banners): bool
    {
        if (!$banner || !$banners || empty($banners)) return false;

        $ret = 0;
        foreach ($banners as $_b) {
            if ($_b[IDX] == $banner[IDX]) $ret++;
        }
        return $ret != 0;
    }


    // 배너 생성 테스트
    // 참고, readme.md
    public function createBanner()
    {
        /// 로그인하지 않아 에러,
        setLogout();
        $re = advertisement()->edit([]);
        isTrue($re->getError() == e()->not_logged_in, 'not logged in');

        /// 로그인 후, 기본 베너 생성.
        registerAndLogin();
        $re = advertisement()->edit([]);
        isTrue($re->getError() == e()->empty_country_code, 'empty country code');

        $re = advertisement()->edit([COUNTRY_CODE => 'KR']);
        isTrue($re->idx > 0, "배너 생성 성공");
    }

    public function zero_point_advertisement()
    {
        // 사용자 생성 후, 기본 포인트는 0으로 설정 됨.
        $user = registerAndLogin();

        // 임시 배너 생성
        $post = request("advertisement.edit", [
            SESSION_ID => login()->sessionId,
            COUNTRY_CODE => "YZ",
        ]);

        isTrue($post['userIdx'] == login()->idx, "동일한 사용자 확인.");


        // 모든 배너 포인트 0 점 처리
        $this->resetBannerPoints();

        // 배너 시작 옵션. 오늘 하루.
        $options = [
            IDX => $post[IDX],
            BANNER_TYPE => TOP_BANNER,
            BEGIN_DATE => time(),
            END_DATE => time(),
        ];

        // 포인트가 0 이어도 가능.
        $re =  advertisement()->start($options);
        isTrue($re->beginAt > 0, "광고 시작 됨");
    }

    public function lackOfPoint()
    {
        // 사용자 생성 후, 기본 포인트는 0으로 설정 됨.
        registerAndLogin();

        // 임시 배너 생성
        $post = request("advertisement.edit", [
            SESSION_ID => login()->sessionId,
            COUNTRY_CODE => "PH"
        ]);

        // top banner 를 1 점으로 변경
        $this->resetBannerPoints("AC", top: 1);

        // top banner 를 시작. 오늘 하루.
        $options = [
            IDX => $post[IDX],
            BANNER_TYPE => TOP_BANNER,
            COUNTRY_CODE => "AC",
            BEGIN_DATE => time(),
            END_DATE => time(),
        ];

        // 포인트가 0 이므로 에러
        $re =  advertisement()->start($options);
        isTrue($re->getError() == e()->lack_of_point, "Expect: 'error_lack_of_point', User point is 0. but the banner take 1 point per day.");
    }

    function beginDateEmpty()
    {
        $banner = $this->createAdvertisement([COUNTRY_CODE => "HH"]);
        $options =  [SESSION_ID => login()->sessionId, IDX => $banner[IDX]];
        $re = request("advertisement.start", $options);
        isTrue($re == e()->begin_date_empty, "Expect: Error, empty advertisement begin date.");
    }

    function endDateEmpty()
    {
        $banner = $this->createAdvertisement([COUNTRY_CODE => "HH"]);
        $options =  [SESSION_ID => login()->sessionId, IDX => $banner[IDX], BEGIN_DATE => time()];
        $re = request("advertisement.start", $options);
        isTrue($re == e()->end_date_empty, "Expect: Error, empty advertisement end date.");
    }

    function wrongBannerType()
    {
        $banner = $this->createAdvertisement([COUNTRY_CODE => "HH"]);
        $re = request("advertisement.start", [SESSION_ID => login()->sessionId, IDX => $banner[IDX], BEGIN_DATE => time(), END_DATE => time()]);
        isTrue($re == e()->wrong_banner_code_or_no_point_setting, "Expect: Error. Wrong code.");
    }

    function maximumAdvertisementDays()
    {
        // 사용자에게 백만 포인트.
        registerAndLogin(1000000);

        // 광고 기간을 3일로 했는데, 5일 광고하려 하면, 에러.
        $this->resetMaximumAdvertisementDays(3);
        $max = advertisement()->maximumAdvertisementDays();
        $re = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS",
            BANNER_TYPE => TOP_BANNER,
            BEGIN_DATE => time(),
            END_DATE => strtotime('+5 days'),
            SESSION_ID => login()->sessionId
        ]);
        isTrue($re == e()->maximum_advertising_days, "Expect: Error, exceed maximum advertising days.");


        // 에러 예상. 광고 기간이 3일인데, 3일 하고 하루 더 광고 진행 테스트.
        // Equivalent to $max + 1 days since begin date is counted to the total ad serving days.
        $re = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS", BANNER_TYPE => TOP_BANNER, BEGIN_DATE => time(), END_DATE => strtotime("+$max days")
        ]);
        isTrue($re == e()->maximum_advertising_days, "Expect: Error, exceed maximum advertising days.");


        // 성공 예상. 광고 기간이 3일인데, 3일 보다 하루 적게 하고 광고 진행 테스트.
        $days = $max - 1;
        $re = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS", BANNER_TYPE => TOP_BANNER, BEGIN_DATE => time(), END_DATE => strtotime("+$days days")
        ]);
        isTrue($re[IDX], "Expect: Success, adv days does not exceed maximum allowed days.");
        $this->resetMaximumAdvertisementDays(0);
    }

    function loadBanners()
    {
        $re = request("advertisement.loadBanners");
        isTrue($re == e()->empty_domain, "Expect: error, no domain when fetching active banners.");

        $re = request("advertisement.loadBanners", [CAFE_DOMAIN => '']);
        isTrue($re == e()->empty_domain, "Expect: error, no domain when fetching active banners.");

        $re = request("advertisement.loadBanners", [CAFE_DOMAIN => 'main.sonub.com']);
        isTrue($re == e()->empty_banner_type, "Expect: error, no banner type fetching active banners.");

        $re = request("advertisement.loadBanners", [CAFE_DOMAIN => 'main.sonub.com', BANNER_TYPE => '']);
        isTrue($re == e()->empty_banner_type, "Expect: error, empty banner type when fetching active banners.");

        $re = request("advertisement.loadBanners", [CAFE_DOMAIN => 'main.sonub.com', BANNER_TYPE => 'wrong']);
        isTrue($re == e()->wrong_banner_type, "Expect: error, wrong banner type is given.");

        $re = request("advertisement.loadBanners", [CAFE_DOMAIN => 'main.sonub.com', BANNER_TYPE => TOP_BANNER]);
        isTrue(isError($re) == false, "Expect: success.");
    }

    function statusCheck()
    {
        registerAndLogin(1000000);
        // 광고 가능 기간 100 일로 설정.
        $this->resetMaximumAdvertisementDays(100);

        // Advertisement begin date same as now, considered as active.
        $re = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS", BANNER_TYPE => TOP_BANNER, BEGIN_DATE => time(), END_DATE => strtotime('+1 days')
        ]);
        isTrue($re['status'] == 'active', "Expect: Status == 'active'");

        // Advertisement end date same as now, considered as active.
        $re = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS", BANNER_TYPE => TOP_BANNER, BEGIN_DATE => strtotime('-1 days'), END_DATE => time()
        ]);
        isTrue($re['status'] == 'active', "Expect: Status == 'active'");


        // considered as inactive.
        $re = request("advertisement.stop", [
            SESSION_ID => login()->sessionId,
            IDX => $re[IDX]
        ]);

        isTrue($re['status'] == 'inactive', "Expect: Status == 'inactive'");

        // Advertisement started but not served yet, considered as waiting.
        $re = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS", BANNER_TYPE => TOP_BANNER, BEGIN_DATE => strtotime('+3 days'), END_DATE => strtotime('+4 days')
        ]);
        isTrue($re['status'] == 'waiting', "Expect: Status == 'waiting'");

        // Expired advertisement, considered as inactive
        $re = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS", BANNER_TYPE => TOP_BANNER, BEGIN_DATE => strtotime('-5 days'), END_DATE => strtotime('-2 days')
        ]);

        isTrue($re['status'] == 'inactive', "Expect: Status == 'inactive', but got: " . $re['status']);

        // 광고 생성을 했지만, `advertisement.start` 라우트로 시작을 하지 않아, inactive 한 상태.
        // Advertisement created with begin and end date same as now but not started yet
        // considered as inactive.
        $re = request("advertisement.edit", [
            COUNTRY_CODE => "SS",
            SESSION_ID => login()->sessionId,
            BEGIN_DATE => time(),
            END_DATE => time()
        ]);

        isTrue($re['status'] == 'inactive', "Expect: Status == 'inactive', but got: " . $re['status']);

        // 마찬가지
        // Advertisement created with begin and end date set to future dates but not started yet
        // considered as inactive.
        $re = request("advertisement.edit", [
            COUNTRY_CODE => "SS",
            SESSION_ID => login()->sessionId,
            BEGIN_DATE => strtotime('+3 days'),
            END_DATE => strtotime('+10 days')
        ]);
        isTrue($re['status'] == 'inactive', "Expect: Status == 'inactive', but got: " . $re['status']);
    }


    /**
     * 1 day * Top banner point (default)
     */
    function startDeduction()
    {
        $startingPoint = 1000000;
        registerAndLogin($startingPoint);
        $this->resetBannerPoints(top: 30);

        /// top banner point
        $topBannerPoint = advertisement()->topBannerPoint();

        /// 오늘 하루 광고.
        /// 배너를 시작하면, pointPerDay 와 advertisementPoint 가 기록된다.
        $ad = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS", BANNER_TYPE => TOP_BANNER, BEGIN_DATE => time(), END_DATE => time()
        ]);

        /// 포인트 확인.
        isTrue($ad['pointPerDay'] == $topBannerPoint, "Expect: 'pointPerDay' == " . $topBannerPoint);
        isTrue($ad['advertisementPoint'] == $topBannerPoint, "Expect: 'advertisementPoint' == " . $topBannerPoint . ", but got " . $ad['advertisementPoint']);

        /// 포인트 차감 확인.
        $expectedPoint = $startingPoint - $topBannerPoint;
        isTrue(login()->getPoint() == $expectedPoint, "Expect: db user point(" . login()->getPoint() . ") == expected point($expectedPoint).");

        /// 광고 시작, 포인트 기록 확인.
        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.start');
        isTrue($activity->toUserPointApply == -$topBannerPoint, "Expect: activity->toUserPointApply == -$topBannerPoint. got " . $activity->toUserPointApply);
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");


        /// 내일 부터 3 일간 광고 진행.
        $ad = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS", BANNER_TYPE => TOP_BANNER, BEGIN_DATE => strtotime('+1 days'), END_DATE => strtotime('+3 days')
        ]);

        /// 소모된 광고 포인트 3일치, 확인.
        $advPoint = $topBannerPoint * 3;
        $expectedPoint -= $advPoint;
        isTrue(login()->getPoint() == $expectedPoint,  "Expect: db user point(" . login()->getPoint() . ") == expected point($expectedPoint).");

        /// 포인트 확인.
        isTrue($ad['pointPerDay'] == $topBannerPoint, "Expect: 'pointPerDay' == " . $topBannerPoint . ", got " . $ad['pointPerDay']);
        isTrue($ad['advertisementPoint'] == $advPoint, "Expect: 'advertisementPoint' == " . $advPoint . ", got " . $ad['advertisementPoint']);

        /// 포인트 기록 확인.
        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.start');
        isTrue($activity->toUserPointApply == -$advPoint, "Expect: activity->toUserPointApply == -$advPoint. Deducted " . $activity->toUserPointApply);
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points. got " . $activity->toUserPointAfter);
    }

    /**
     * 3 days * Top banner point (PH)
     */
    function startWithCountryDeduction()
    {
        // 시작 포인트
        $startingPoint = 1000000;
        registerAndLogin($startingPoint);

        // 필리핀 top banner point 는 70.
        $this->resetBannerPoints('PH', top: 70);

        $adOpts = [BANNER_TYPE => TOP_BANNER, COUNTRY_CODE => 'PH', BEGIN_DATE => time(), END_DATE => strtotime('+2 day')];
        $ad = $this->createAndStartAdvertisement($adOpts);

        // 70.
        $topBannerPoint = advertisement()->topBannerPoint('PH');

        // 210.
        $advPoint = $topBannerPoint * 3;

        $expectedPoint = $startingPoint - $advPoint;

        isTrue(login()->getPoint() == $expectedPoint, "Expect: user points => " . login()->getPoint() . " == $expectedPoint ");

        isTrue($ad['pointPerDay'] == $topBannerPoint, "Expect: 'pointPerDay' == $topBannerPoint. but got " . $ad['pointPerDay']);
        isTrue($ad['advertisementPoint'] == $advPoint, "Expect: 'advertisementPoint' == $advPoint. but got " . $ad['advertisementPoint']);

        // 기록 확인
        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.start');
        isTrue($activity->toUserPointApply == -$advPoint, "Expect: activity->toUserPointApply == -$advPoint.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    /**
     * begin date - today
     * end date - today
     * 1 day * Top banner point (default)
     * 
     * No refund (all days served)
     */
    function stopNoRefund()
    {
        $startingPoint = 1000000;
        registerAndLogin($startingPoint);
        // 하루 광고.
        $ad = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS", BANNER_TYPE => TOP_BANNER, BEGIN_DATE => time(), END_DATE => time()
        ]);

        $topBannerPoint = advertisement()->topBannerPoint();
        $expectedPoint = $startingPoint - $topBannerPoint;

        isTrue(login()->getPoint() == $expectedPoint, "Expect: user's points => $expectedPoint.");

        // 광고 중단.
        $ad = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        // 포인트가 삭제되어야 함.
        isTrue($ad['advertisementPoint'] == '0', "Expect: 'advertisementPoint' => '0'.");

        // 환불된 포인트 없음.
        isTrue(login()->getPoint() == $expectedPoint, "Expect: user's points => $expectedPoint.");

        // 포인트 기록 확인.
        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.stop');
        isTrue($activity->toUserPointApply == 0, "Expect: activity->toUserPointApply == 0.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    /**
     * begin date - 8 days ago
     * end date - 3 days ago
     * 6 days * Top banner (default)
     * 
     * No refund (expired advertisement)
     */
    function stopOnPastOrExpiredBanner()
    {

        $startingPoint = 1000000;
        registerAndLogin($startingPoint);
        // 광고 생성하고 시작, 그러나 이미 종료된 광고.
        $ad = $this->createAndStartAdvertisement([COUNTRY_CODE => "SS", BANNER_TYPE => TOP_BANNER, BEGIN_DATE => strtotime('-8 days'), END_DATE => time()]);
        // d(login()->getPoint());

        //
        $topBannerPOint = advertisement()->topBannerPoint();
        $advPoint = $topBannerPOint * 9;

        $expectedPoint = $startingPoint - $advPoint;

        // 비록 광고 생성 시, 이미 종료된 광고를 생성하지만, 광고 날짜 만큼 포인트가 종료되어야 한다.
        isTrue(login()->getPoint() == $expectedPoint, "Expect: user's points => $expectedPoint.");

        // 광고 중단. 이미 종료된 광고를 중단하는 것이다.
        $ad = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);


        isTrue(login()->getPoint() == $expectedPoint, "Expect: user's points => $expectedPoint.");

        //
        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.stop');

        //
        isTrue($activity->toUserPointApply == 0, "Expect: activity->toUserPointApply == 0.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    /**
     * begin date - 2 days ago
     * end date - 3 days from now
     * 6 days * 1000 (Top banner - default)
     */
    function stopWithDeductedRefund()
    {
        $startingPoint = 1000000; // 1m
        registerAndLogin($startingPoint);
        $ad = $this->createAndStartAdvertisement([COUNTRY_CODE => "SS", BANNER_TYPE => TOP_BANNER, BEGIN_DATE => strtotime('-2 days'), END_DATE => strtotime('+3 days')]);

        $bannerPoint = advertisement()->topBannerPoint();
        $advPoint = $bannerPoint * 6;
        $refundPoint = $bannerPoint * 3;

        $ad = request("advertisement.stop", [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        $expectedPoint = $startingPoint - $advPoint + $refundPoint;
        isTrue(login()->getPoint() == $expectedPoint, "Banner point: $bannerPoint, Expect: user points to be $expectedPoint but the user point is " . login()->getPoint());

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.stop');
        isTrue($activity->toUserPointApply == $refundPoint, "Expect: activity->toUserPointApply == $refundPoint.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    /**
     * begin date - 2 days ago
     * end date - 3 days from now
     * 6 days * 2000 (Top banner - PH)
     */
    function stopWithCountryAndDeductedRefund()
    {
        $startingPoint = 1300000;
        registerAndLogin($startingPoint);
        $this->resetBannerPoints('PH', top: 1234);

        $ad = $this->createAndStartAdvertisement([
            BANNER_TYPE => TOP_BANNER,
            COUNTRY_CODE => 'PH',
            BEGIN_DATE => strtotime('-2 days'),
            END_DATE => strtotime('+3 days')
        ]);

        $bannerPoint = advertisement()->topBannerPoint('PH');
        $advPoint = $bannerPoint * 6;
        $refundPoint = $bannerPoint * 3;

        $expectPoint = $startingPoint - $advPoint;

        $ad = request("advertisement.stop", [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        $expectPoint += $refundPoint;
        isTrue(login()->getPoint() == $expectPoint, "Expect: user points == $expectPoint.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.stop');
        isTrue($activity->toUserPointApply == $refundPoint, "Expect: activity->toUserPointApply == $refundPoint.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    /**
     * begin date - 3 days in future
     * end date - 11 days in future
     * 9 days * 400 (Line banner - default)
     * 
     * Cancel (full refund)
     */
    function stopFullRefund()
    {
        $startingPoint = 900000;
        registerAndLogin($startingPoint);
        $this->resetBannerPoints(line: 3450);

        $ad = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS",
            BANNER_TYPE => LINE_BANNER,
            BEGIN_DATE => strtotime('+3 days'), // 4 days including today.
            END_DATE => strtotime('+1 week 4 days') // 12 days including today. so, it's 9 days.
        ]);

        $bannerPoint = advertisement()->LineBannerPoint();

        $advPoint = $bannerPoint * 9;

        $expectedPoint = $startingPoint - $advPoint;

        // If it is stop, then 9 days will be refunded.
        $ad = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        $expectedPoint += $advPoint;
        isTrue(login()->getPoint() == $expectedPoint, "Expect: user's points => $expectedPoint.");
    }

    /**
     * begin date - 3 days in future
     * end date - 11 days in future
     * 9 days * 1200 (Line banner - US)
     * 
     * Cancel (full refund)
     */
    function stopWithCountryFullRefund()
    {

        $startingPoint = 1500000;
        registerAndLogin($startingPoint);
        $this->resetBannerPoints('US', line: 3500);
        $ad = $this->createAndStartAdvertisement([
            BANNER_TYPE => LINE_BANNER,
            COUNTRY_CODE => 'US',
            BEGIN_DATE => strtotime('+3 days'), //
            END_DATE => strtotime('+1 week 4 days') // 9 days.
        ]);

        request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        isTrue(login()->getPoint() == $startingPoint, "Expect: user's points => $startingPoint.");
    }

    /**
     * Deleting active advertisement.
     */
    function errorDeleteActiveAdvertisement()
    {
        registerAndLogin(1500000);

        $ad = $this->createAndStartAdvertisement([COUNTRY_CODE => "SS", BANNER_TYPE => LINE_BANNER, BEGIN_DATE => time(), END_DATE => time()]);
        $re = request('advertisement.delete', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);
        isTrue($re == e()->advertisement_is_active, "Expect: Error. Cannot delete active advertisement.");

        $ad2 = $this->createAndStartAdvertisement([COUNTRY_CODE => "SS", BANNER_TYPE => LINE_BANNER, BEGIN_DATE => strtotime('+2 days'), END_DATE => strtotime('+3 days')]);
        $re = request('advertisement.delete', [SESSION_ID => login()->sessionId, IDX => $ad2[IDX]]);
        isTrue($re == e()->advertisement_is_active, "Expect: Error. Cannot delete active advertisement.");
    }

    /**
     * Deleting inactive advertisement.
     */
    function deleteAdvertisement()
    {
        registerAndLogin(1500000);
        $ad = $this->createAndStartAdvertisement([COUNTRY_CODE => "SS", BANNER_TYPE => LINE_BANNER, BEGIN_DATE => time(), END_DATE => time()]);

        request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);
        $ad = request('advertisement.delete', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        isTrue($ad[DELETED_AT] > 0, "Expect: Success. Inactive advertisement deleted..");
    }

    /**
     * Initial start:
     *  begin date - 3 days from now
     *  end date - 8 days from now
     *  6 days * 400 (Line banner - default)
     * 
     * First cancel : Full refund
     * 
     * Editted start: 
     *  begin date - now
     *  end date - 2 days from now
     *  3 days * 1400 (Square banner - US)
     * 
     * Final cancel : Deducted
     *  
     */
    function startStopChangeDatesAndCountry()
    {
        $this->clearAdvertisementData();
        $startingPoint = 800000;
        registerAndLogin($startingPoint);
        $this->resetBannerPoints(square: 2020, line: 1580,);
        $this->resetBannerPoints('US', square: 2020, line: 1580,);

        // first create
        $ad = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS",
            BANNER_TYPE => LINE_BANNER,
            BEGIN_DATE => strtotime('+3 days'), //
            END_DATE => strtotime('+8 days') //
        ]);

        $bannerPoint = advertisement()->LineBannerPoint();
        isTrue(login()->getPoint() == $startingPoint - $bannerPoint * 6, "Expect: user points == " . $startingPoint - $bannerPoint * 6);

        // cancel
        $ad = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);
        isTrue($ad['status'] == 'inactive', 'banner cancelled');



        isTrue(login()->getPoint() == $startingPoint, "Expect: user points == $startingPoint.");

        // edit same ad with new country and dates
        $newAd = $this->createAndStartAdvertisement([
            BANNER_TYPE => SQUARE_BANNER,
            COUNTRY_CODE => 'US',
            BEGIN_DATE => time(),
            END_DATE => strtotime('+2 days') // advertisement days: 3 days. 2 days will be refunded.
        ]);

        $bannerPoint = advertisement()->SquareBannerPoint('US');
        isTrue($bannerPoint == 2020, 'For us square banner');
        $advPoint = $bannerPoint * 3;

        isTrue($newAd['pointPerDay'] == $bannerPoint, "Expect: 'pointPerDay' == $bannerPoint.");
        isTrue($newAd['advertisementPoint'] == $advPoint, "Expect: 'advertisementPoint' == $advPoint.");

        isTrue(login()->getPoint() == $startingPoint - $advPoint, "Expect: user points == " . $startingPoint - $advPoint);


        // cancel again. user will get 2 days of refund.
        $newAd = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $newAd[IDX]]);
        isTrue($newAd['status'] == 'inactive', 'newAd must be inactive');

        isTrue($newAd['advertisementPoint'] == '0', "Expect: 'advertisementPoint' == 0.");
        isTrue(login()->getPoint() == $startingPoint - $bannerPoint, "Expect: user points == " . ($startingPoint - $bannerPoint) . ".");
    }


    function settings()
    {
        $admin = setLoginAsAdmin();

        $re = request('advertisement.settings');
        isTrue($re['types'] == BANNER_TYPES, 'Expect: types should be defined.');

        $maxDays = rand(1, 100);
        $categoryA = 'apple' . time();
        $categoryB = 'banana' . time();
        $categoryC = 'cherry' . time();
        $categoriesString = "$categoryA, $categoryB, $categoryC";
        $categoryArray = [$categoryA, $categoryB, $categoryC];
        $globalMultiplying = rand(1, 10);

        request('app.setConfig', [
            SESSION_ID => $admin->sessionId,
            CODE => MAXIMUM_ADVERTISING_DAYS, 'data' => $maxDays
        ]);
        request('app.setConfig', [
            SESSION_ID => $admin->sessionId,
            CODE => ADVERTISEMENT_CATEGORIES, 'data' => $categoriesString,
        ]);
        request('app.setConfig', [
            SESSION_ID => $admin->sessionId,
            CODE => ADVERTISEMENT_GLOBAL_BANNER_MULTIPLYING, 'data' => $globalMultiplying,
        ]);

        $re = request('advertisement.settings');

        isTrue($re[MAXIMUM_ADVERTISING_DAYS] == $maxDays, "Expect: Max days is set to $maxDays.");
        isTrue($re['categoryArray'] == $categoryArray, "Expect: Categories is set.");
        isTrue($re[ADVERTISEMENT_GLOBAL_BANNER_MULTIPLYING] == $globalMultiplying, "Expect: global banner multiplier is set.");

        $this->resetMaximumAdvertisementDays(0);
        $this->resetAdvertisementCategories();
        $this->resetGlobalMulplying();
    }

    function pointSettings()
    {

        setLogout();
        $re = request('advertisement.setBannerPoint');
        isTrue($re == e()->not_logged_in, 'Expect: Error user is not signed in.');

        $user = registerAndLogin();
        $re = request('advertisement.setBannerPoint', [SESSION_ID => $user->sessionId]);
        isTrue($re == e()->you_are_not_admin, 'Expect: Error user is not admin.');

        $admin = setLoginAsAdmin();
        $top = rand(500, 1000);
        $sidebar = rand(1000, 1500);
        $square = rand(1000, 2000);
        $line = rand(2000, 3000);

        $request = [
            SESSION_ID => $admin->sessionId
        ];


        $re = request('advertisement.setBannerPoint', $request);
        isTrue($re == e()->empty_top_banner_point, 'Expect: Error no top banner point provided.');

        $request[TOP_BANNER] = $top;
        $re = request('advertisement.setBannerPoint', $request);
        isTrue($re == e()->empty_sidebar_banner_point, 'Expect: Error no sidebar banner point provided.');

        $request[SIDEBAR_BANNER] = $sidebar;
        $re = request('advertisement.setBannerPoint', $request);
        isTrue($re == e()->empty_square_banner_point, 'Expect: Error no square banner point provided.');

        $request[SQUARE_BANNER] = $square;
        $re = request('advertisement.setBannerPoint', $request);
        isTrue($re == e()->empty_line_banner_point, 'Expect: Error no line banner point provided.');

        $request[LINE_BANNER] = $line;
        request('advertisement.setBannerPoint', $request);
        $settings = request('advertisement.settings');

        $defaultPointSetting = $settings['point']['default'];
        isTrue(!empty($defaultPointSetting), 'Expect: Default setting is set.');

        isTrue($defaultPointSetting[TOP_BANNER] == $top, "Expect: Top banner point is set to $top");
        isTrue($defaultPointSetting[SIDEBAR_BANNER] == $sidebar, "Expect: Top banner point is set to $sidebar");
        isTrue($defaultPointSetting[SQUARE_BANNER] == $square, "Expect: Top banner point is set to $square");
        isTrue($defaultPointSetting[LINE_BANNER] == $line, "Expect: Top banner point is set to $line");

        $this->resetBannerPoints();
    }

    function pointSettingDelete()
    {
        $admin = setLoginAsAdmin();
        $countryCode = "US";

        $bannerSetting = request('advertisement.setBannerPoint', [
            COUNTRY_CODE => $countryCode,
            TOP_BANNER => 1,
            SIDEBAR_BANNER => 1,
            SQUARE_BANNER => 1,
            LINE_BANNER => 1,
            SESSION_ID => $admin->sessionId
        ]);

        $request = [
            COUNTRY_CODE => $bannerSetting[COUNTRY_CODE]
        ];

        $re = request('advertisement.deleteBannerPoint', $request);
        isTrue($re == e()->not_logged_in, "Expect error deleting, user is not logged in.");

        $user = registerAndLogin();
        $request[SESSION_ID] = $user->sessionId;
        $re = request('advertisement.deleteBannerPoint', $request);
        isTrue($re == e()->you_are_not_admin, "Expect error deleting, user is not admin.");

        $admin = setLoginAsAdmin();
        $request[SESSION_ID] = $admin->sessionId;
        $re = request('advertisement.deleteBannerPoint', $request);
        isTrue($re == e()->idx_is_empty, "Expect error deleting, idx is not provided.");

        $request[IDX] = $bannerSetting[IDX];
        $re = request('advertisement.deleteBannerPoint', $request);
        isTrue($re[IDX] == $bannerSetting[IDX], "Expect success deleting banner point setting.");

        $settings = request('advertisement.settings');
        isTrue(!isset($settings['point'][$bannerSetting[COUNTRY_CODE]]), "Expect success, setting for " . $bannerSetting[COUNTRY_CODE] . " is deleted.");
    }

    function stopAfterPointSettingChanged()
    {
        $this->clearAdvertisementData();
        setLoginAsAdmin();
        $countryCode = "PH";

        $this->resetBannerPoints($countryCode, 1000, 2000, 3000, 4000);

        $settings = request('advertisement.settings');
        $countryPointSetting = $settings['point'][$countryCode];
        isTrue(!empty($countryPointSetting), "Expect: point settings for $countryCode is set.");

        $startingPoint = 1000000;
        registerAndLogin($startingPoint);
        $bannerPoint = advertisement()->topBannerPoint($countryCode);
        $adOpts = [
            BANNER_TYPE => TOP_BANNER,
            COUNTRY_CODE => $countryCode,
            BEGIN_DATE => time(),
            END_DATE => strtotime('+2 day'),
            SESSION_ID => login()->sessionId
        ];

        $ad = $this->createAndStartAdvertisement($adOpts);

        $advPoint = $bannerPoint * 3;
        $expectedPoint = $startingPoint - $advPoint;

        isTrue($ad['pointPerDay'] == $bannerPoint, "Expect: 'pointPerDay' == " . $bannerPoint);
        isTrue($ad['advertisementPoint'] == $advPoint, "Expect: 'advertisementPoint' == " . $advPoint);
        isTrue(login()->getPoint() == $expectedPoint, "Expect: user points == $expectedPoint.");

        /// update point setting for same country code.
        $this->resetBannerPoints($countryCode, 3000, 3500, 4500, 5500);

        $refundPoint = $bannerPoint * 2;
        $expectedPoint += $refundPoint;
        request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        isTrue(login()->getPoint() == $expectedPoint, "Expect: user points == $expectedPoint. But user has " . login()->getPoint());

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.stop');
        isTrue($activity->toUserPointApply == $refundPoint, "Expect: activity->toUserPointApply == $refundPoint. But applied " . $activity->toUserPointApply);
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }


    function maximumNoOfLimitTest()
    {
        $this->resetBannerLimit(TOP_BANNER, 0, false);
        registerAndLogin(100);
        $advOpts = [
            COUNTRY_CODE => 'AC',
            BANNER_TYPE => TOP_BANNER,
            BEGIN_DATE => time(),
            END_DATE => strtotime('+2 day'),
            SESSION_ID => login()->sessionId
        ];
        $adv1 = $this->createAndStartAdvertisement($advOpts);
        isTrue($adv1 == e()->max_no_banner_limit_exeeded, "maximum number of banner is 0");
    }

    function globalCategoryBannerPoint()
    {
        $this->clearAdvertisementData();
        $this->resetBannerLimit(TOP_BANNER, 2, true);
        $this->resetBannerLimit(TOP_BANNER, 2, false);

        $globalMultiplying = rand(2, 5);
        $this->resetGlobalMulplying($globalMultiplying);

        // set points for PH
        $countryCode = "PH";
        $this->resetBannerPoints($countryCode, 1000, 2000, 3000, 4000);

        registerAndLogin(1000000);

        $noOfDays = 3;
        $advOpts = [
            COUNTRY_CODE => $countryCode,
            BANNER_TYPE => TOP_BANNER,
            BEGIN_DATE => time(),
            END_DATE => strtotime('+2 day'),
            SESSION_ID => login()->sessionId
        ];

        // create adv1 - global top banner for PH for 3 days
        $adv1 = $this->createAndStartAdvertisement($advOpts);

        // create adv2 - qna top banner for PH for 3 days
        $advOpts[BANNER_CATEGORY] = 'qna';
        $adv2 = $this->createAndStartAdvertisement($advOpts);

        $bannerPoint = advertisement()->topBannerPoint($countryCode);

        $globalBannerPoint = $bannerPoint * $globalMultiplying;
        $globalAdvertisementPoint = $globalBannerPoint * $noOfDays;

        // Global Advertisement
        isTrue($adv1['pointPerDay'] == $globalBannerPoint, "Expect: 'pointPerDay' == " . $globalBannerPoint);
        isTrue($adv1['advertisementPoint'] == $globalAdvertisementPoint, "Expect: 'advertisementPoint' == " . $globalAdvertisementPoint);

        $activity = userActivity()->last(taxonomy: POSTS, entity: $adv1[IDX], action: 'advertisement.start');
        isTrue($activity->toUserPointApply == -$globalAdvertisementPoint, "Expect: activity->toUserPointApply == $globalAdvertisementPoint. But applied " . $activity->toUserPointApply);

        // expect global banner point is not equal to category banner point
        isTrue($adv1['pointPerDay'] != $adv2['pointPerDay'],  "Expect: Adv1 'pointPerDay' != Adv2 'pointPerDay' (");
        isTrue($adv1['advertisementPoint'] != $adv2['advertisementPoint'],  "Expect: Adv1 'advertisementPoint' != Adv2 'advertisementPoint'");
    }


    function loadCafeCountryBanners()
    {

        $this->clearAdvertisementData();
        $this->resetBannerLimit(LINE_BANNER, false);
        registerAndLogin(800000);

        $rootDomain = 'ard' . time() . '.com';
        $subDomain = 'abc';
        $countryCodeA = 'XX';
        $countryCodeB = 'YY';

        $domain = $subDomain . '.' . $rootDomain;

        $this->resetBannerPoints($countryCodeA, 1000, 2000, 3000, 4000);
        $this->resetBannerPoints($countryCodeB, 6000, 7000, 8000, 9000);

        $cafe = cafe()->create(['rootDomain' => $rootDomain, 'domain' => $subDomain, 'countryCode' => $countryCodeA]);
        isTrue($cafe->ok, 'cafe for banner test has been created');


        $advOpts = [
            BANNER_TYPE => LINE_BANNER,
            BEGIN_DATE => time(),
            END_DATE => time(),
            'fileIdxes' => '1',
        ];

        // Create 2 banner with the different countryCode.
        $advOpts[COUNTRY_CODE] = $countryCodeA;
        $adv1 = $this->createAndStartAdvertisement($advOpts);
        $advOpts[COUNTRY_CODE] = $countryCodeB;
        $adv2 = $this->createAndStartAdvertisement($advOpts);

        // Expect adv1 is present on banners since it has the same countryCode as the cafe.
        // and adv2 is not present since it has different countryCode.
        $re = request("advertisement.loadBanners", [CAFE_DOMAIN => $domain, BANNER_TYPE => LINE_BANNER]);

        isTrue($this->bannerIsPresent($adv1, $re), 'Expect: ADV 1 is present');
        isTrue($this->bannerIsPresent($adv2, $re) == false, 'Expect: ADV 2 is not present');

        // Changing the country code of adv2 from countryCodeB to countryCodeA.
        $advOpts[COUNTRY_CODE] = $countryCodeA;
        post($adv2[IDX])->update($advOpts);

        // Expect that adv2 now is present in cafe with countryCode of countryCodeA.
        $re = request("advertisement.loadBanners", [CAFE_DOMAIN => $domain, BANNER_TYPE => LINE_BANNER]);
        isTrue($this->bannerIsPresent($adv2, $re), 'Expect: ADV 2 is present');

        // Change the country of the cafe from countryCodeA to countryCodeB.
        $cafe = cafe($cafe->idx)->update([COUNTRY_CODE => $countryCodeB]);
        isTrue($cafe->countryCode == $countryCodeB, "Expect: country code changed from $countryCodeA to $countryCodeB.");

        // Expect that adv1 and adv2 is not present since cafe countryCode is changed from countryCodeA to countryCodeB.
        $re = request("advertisement.loadBanners", [CAFE_DOMAIN => $domain, BANNER_TYPE => LINE_BANNER]);
        isTrue($this->bannerIsPresent($adv1, $re) == false, 'Expect: ADV 1 is not present');
        isTrue($this->bannerIsPresent($adv2, $re) == false, 'Expect: ADV 2 is not present');
    }

    function loadAllCountryBanners()
    {
        $this->clearAdvertisementData();
        $this->resetBannerLimit(LINE_BANNER, category: false);
        $this->resetBannerPoints();

        registerAndLogin(1000000);

        $rootDomain = 'mnm' . time() . '.com';

        $subDomainA = 'abc';
        $subDomainB = 'def';

        $domainA = $subDomainA . '.' . $rootDomain;
        $domainB = $subDomainB . '.' . $rootDomain;

        $countryCodeA = 'AA';
        $countryCodeB = 'ZZ';
        $allCountryCode = ALL_COUNTRY_CODE;


        // create cafes with different country codes.
        cafe()->create(['rootDomain' => $rootDomain, 'domain' => $subDomainA, 'countryCode' => $countryCodeA]); // cafeA
        cafe()->create(['rootDomain' => $rootDomain, 'domain' => $subDomainB, 'countryCode' => $countryCodeB]); // cafeB

        // create 'all country' banner
        $banner = $this->createAndStartAdvertisement([
            BANNER_TYPE => LINE_BANNER,
            COUNTRY_CODE => $allCountryCode,
            BEGIN_DATE => time(),
            END_DATE => time(),
            'fileIdxes' => '1',
        ]);

        $banners = advertisement()->loadBanners([CAFE_DOMAIN => $domainA, BANNER_TYPE => LINE_BANNER]);
        isTrue(count($banners) == 1, 'There should be only one adv');

        // Both cafe should have the banner as it is set to $allCountryCode
        $re = request("advertisement.loadBanners", [CAFE_DOMAIN => $domainA, BANNER_TYPE => LINE_BANNER]);
        isTrue($this->bannerIsPresent($banner, $re), "cafeDomain $domainA must have all country banner.");

        $re = request("advertisement.loadBanners", [CAFE_DOMAIN => $domainB, BANNER_TYPE => LINE_BANNER]);
        isTrue($this->bannerIsPresent($banner, $re), "cafeDomain B ($domainB) must have also the same all country banner");

        banner($banner[IDX])->update([COUNTRY_CODE => $countryCodeA]);
        $re = request("advertisement.loadBanners", [CAFE_DOMAIN => $domainA, BANNER_TYPE => LINE_BANNER]);
        isTrue($this->bannerIsPresent($banner, $re), "cafeDomain A must have the same the banner.");

        // $cafeB should not have the banner.
        $re = request("advertisement.loadBanners", [CAFE_DOMAIN => $domainB, BANNER_TYPE => LINE_BANNER]);
        isTrue($this->bannerIsPresent($banner, $re) == false, "Expect: Banner is not present in active banners.");

        request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $banner[IDX]]);

        $re = request("advertisement.loadBanners", [CAFE_DOMAIN => $domainA, BANNER_TYPE => LINE_BANNER]);
        isTrue($this->bannerIsPresent($banner, $re) == false, "cafeDomain A must have no banner since it is stopped.");
    }


    function allCountryBannerPoint()
    {
        $this->clearAdvertisementData();
        $cafeCountryCode = "PH";
        $allCountryCode = "AC";

        $topBannerPoint = 1000;

        $this->resetBannerPoints($cafeCountryCode, top: $topBannerPoint);
        $this->resetBannerPoints($allCountryCode, top: $topBannerPoint);

        $globalMultiplying = rand(2, 5);
        $this->resetGlobalMulplying($globalMultiplying);

        registerAndLogin(1000000);

        // 2 days
        $advOpts = [
            BANNER_TYPE => TOP_BANNER,
            SUB_CATEGORY => 'qna',
            BEGIN_DATE => time(),
            END_DATE => strtotime('+1 days')
        ];
        $days = 2;

        $allCountryBannerPoint = $topBannerPoint * $globalMultiplying;
        $allCountryAdvPoint = $allCountryBannerPoint * $days;

        // Cafe Country Banner
        $advOpts[COUNTRY_CODE] = $cafeCountryCode;
        $cafeCountryBanner = $this->createAndStartAdvertisement($advOpts);

        // All Country Banner
        $advOpts[COUNTRY_CODE] = $allCountryCode;
        $allCountryBanner = $this->createAndStartAdvertisement($advOpts);

        // All Country Banner points must be greater than Cafe Country Banner
        isTrue(
            $allCountryBanner['pointPerDay'] > $cafeCountryBanner['pointPerDay'],
            "Expect: All Country Banner 'pointPerDay' is greater than Cafe Country Banner 'pointPerDay'"
        );
        isTrue(
            $allCountryBanner['advertisementPoint'] > $cafeCountryBanner['advertisementPoint'],
            "Expect: All Country Banner 'advertisementPoint' is greater than Cafe Country Banner 'advertisementPoint'"
        );

        isTrue($allCountryBanner['pointPerDay'] == $allCountryBannerPoint, "Expect: All Country Banner 'pointPerDay' == " . $allCountryBannerPoint . ". But got " . $allCountryBanner['pointPerDay']);
        isTrue($allCountryBanner['advertisementPoint'] == $allCountryAdvPoint, "Expect: All Country Banner 'advertisementPoint' == " . $allCountryAdvPoint . ". But got " . $allCountryBanner['advertisementPoint']);

        $activity = userActivity()->last(taxonomy: POSTS, entity: $allCountryBanner[IDX], action: 'advertisement.start');
        isTrue($activity->toUserPointApply == -$allCountryAdvPoint, "Expect: activity->toUserPointApply == -$allCountryAdvPoint. Deducted " . $activity->toUserPointApply);
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points. got " . $activity->toUserPointAfter);
    }

    function topBannerLoad()
    {
        $this->clearAdvertisementData();
        $this->resetBannerPoints('', 1000, 2000, 3000, 4000);
        registerAndLogin(1000000);

        // create test cafe
        $countryCode = 'T1';
        $subCategory = 'apple' . time();
        $rootDomain = 'wxy.com';
        $subDomain = 'abc' . time();
        $domain = $subDomain . "." . $rootDomain;
        cafe()->create(['rootDomain' => $rootDomain, 'domain' => $subDomain, 'countryCode' => $countryCode]);

        // create test advertisements
        $advOpts = [
            COUNTRY_CODE => 'AC',
            BANNER_TYPE => TOP_BANNER,
            BEGIN_DATE => time(),
            END_DATE => strtotime('+1 day'),
            'fileIdxes' => '1'
        ];

        // create one for global all country
        $banner1 = $this->createAndStartAdvertisement($advOpts);

        // create one for test cafe country.
        $advOpts[COUNTRY_CODE] = $countryCode;
        $advOpts[SUB_CATEGORY] = $subCategory;
        $banner2 = $this->createAndStartAdvertisement($advOpts);

        // fetch active banners with TOP_BANNER type and 'apple' subcategory in $domain.
        $fetchOptions = [CAFE_DOMAIN => $domain, BANNER_TYPE => TOP_BANNER, SUB_CATEGORY => $subCategory];
        $banners = request("advertisement.loadBanners", $fetchOptions);

        // expect all banner is present.
        isTrue(count($banners) >= 2, 'banners should be more than or equal to 2');
        isTrue($this->bannerIsPresent($banner1, $banners), 'banner 1 is present');
        isTrue($this->bannerIsPresent($banner2, $banners), 'banner 2 is present');
    }

    function squareBannerLoad()
    {

        $this->clearAdvertisementData();
        $this->resetBannerPoints('', square: 1000);
        registerAndLogin(1000000);

        // create test cafe
        $countryCode = 'T2';
        $subCategory = 'banana' . time();
        $rootDomain = 'wxy.com';
        $subDomain = 'abc' . time();
        $cafe = cafe()->create(['rootDomain' => $rootDomain, 'domain' => $subDomain, 'countryCode' => $countryCode]);

        // create test advertisements
        $advOpts = [
            COUNTRY_CODE => 'AC',
            BANNER_TYPE => SQUARE_BANNER,
            SUB_CATEGORY => '',
            BEGIN_DATE => time(),
            END_DATE => strtotime('+1 day'),
            FILE_IDXES => '1'
        ];

        // create one for global all country
        $banner1 = $this->createAndStartAdvertisement($advOpts);


        // create one for category all country
        $advOpts[SUB_CATEGORY] = $subCategory;
        $banner2 = $this->createAndStartAdvertisement($advOpts);

        // create one for global cafe country.
        $advOpts[COUNTRY_CODE] = $countryCode;
        $advOpts[SUB_CATEGORY] = '';
        $banner3 = $this->createAndStartAdvertisement($advOpts);

        // create one for category cafe country.
        $advOpts[SUB_CATEGORY] = $subCategory;
        $banner4 = $this->createAndStartAdvertisement($advOpts);

        // fetch active banners with TOP_BANNER type and 'apple' subcategory in $domain.
        $fetchOptions = [CAFE_DOMAIN => $cafe->id, BANNER_TYPE => SQUARE_BANNER, SUB_CATEGORY => $subCategory];
        $banners = request("advertisement.loadBanners", $fetchOptions);

        // expect all banners are present.
        isTrue(count($banners) == 4, 'banners should be more than or equal to 4');
        isTrue($this->bannerIsPresent($banner1, $banners), 'banner 1 is present');
        isTrue($this->bannerIsPresent($banner2, $banners), 'banner 2 is present');
        isTrue($this->bannerIsPresent($banner3, $banners), 'banner 3 is present');
        isTrue($this->bannerIsPresent($banner4, $banners), 'banner 4 is present');

        // Add one more on all category of All country
        $banner4 = $this->createAndStartAdvertisement($advOpts);
    }


    /**
     * Testing "Limiting maximum number of banners". See README.md
     * @param string $banner_type
     */
    function bannerLimit(string $banner_type)
    {
        $this->clearAdvertisementData();
        $this->resetBannerPoints(top: 1000);
        registerAndLogin(1000000);

        $advOpts = [
            COUNTRY_CODE => 'T1',
            BANNER_TYPE => $banner_type,
            BANNER_CATEGORY => '',
            BEGIN_DATE => time(),
            END_DATE => strtotime('+1 day'),
            'fileIdxes' => '1'
        ];

        $this->resetBannerLimit($banner_type, 2, false); // Global
        $this->resetBannerLimit($banner_type, 3); // Category

        // Create two banners for the banner type, category, country.
        $this->createAndStartAdvertisement($advOpts);
        $re = $this->createAndStartAdvertisement($advOpts);
        isTrue(isOk($re), "Limit did not reach yet");

        // try to create one more and it will be an error.
        $adv3 = $this->createAndStartAdvertisement($advOpts);
        isTrue($adv3 == e()->max_no_banner_limit_exeeded, "advertisement cannot be activated because limit has been reached. GLOBAL - " . $banner_type);


        $advOpts[SUB_CATEGORY] = 'abc' . time();
        $this->createAndStartAdvertisement($advOpts);
        $this->createAndStartAdvertisement($advOpts);
        $re = $this->createAndStartAdvertisement($advOpts);
        isTrue(isOk($re), "Limit did not reach yet");

        $adv3 = $this->createAndStartAdvertisement($advOpts);
        isTrue($adv3 == e()->max_no_banner_limit_exeeded, "advertisement cannot be activated because limit has been reached. GLOBAL - " . $banner_type);
    }

    /**
     * Two default top banner test.
     */
    function defaultTopBannerTest()
    {

        // hardCodedTopBanners() 는 1개 또는 2개의 베너를 리턴한다.
        $banners = banner()->hardCodedTopBanners(0);
        isTrue(count($banners) == 2, 'hard coded top banner must have 2 default banners');
        $banners = banner()->hardCodedTopBanners(1);
        isTrue(count($banners) == 1, '1 hard coded top banner.');


        $this->clearAdvertisementData();
        $banners = banner()->loadBanners([CAFE_DOMAIN => cafe()->mainCafeDomains[0], BANNER_TYPE => TOP_BANNER, SUB_CATEGORY => 'abc']);
        isTrue(count($banners) == 2, 'there must be at least two banners');
        $banners = banner()->loadBanners([CAFE_DOMAIN => cafe()->mainCafeDomains[0], BANNER_TYPE => TOP_BANNER, SUB_CATEGORY => '']);
        isTrue(count($banners) == 2, 'there must be at least two banners regardless category.');


        $firstHardCodedBanner = banner()->hardCodedTopBanners(1);

        isTrue($banners[0]->idx == $firstHardCodedBanner[0]->idx, 'idx must be 0');
        isTrue($banners[0]->clickUrl == $firstHardCodedBanner[0]->clickUrl, 'click url match');
    }

    function topBannerLoadWithNonExistingCafe()
    {
        $this->clearAdvertisementData();
        $banners = banner()->loadBanners([CAFE_DOMAIN => 'non-existing.domain.com', BANNER_TYPE => TOP_BANNER]);
        isTrue(count($banners) >= 2, "Two top banners for non-existing domains.");
    }
}
