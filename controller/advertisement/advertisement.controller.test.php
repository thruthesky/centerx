<?php

// Create 'advertisement' category if it does not exists.
if (!category()->exists([ID => ADVERTISEMENT_CATEGORY])) {
    $admin = setLoginAsAdmin();
    category()->create([ID => ADVERTISEMENT_CATEGORY]);
}
// 회원 가입 포인트를 0 으로 설정.
userActivity()->setRegisterPoint(0);
setLogout();
enableTesting();
$at = new AdvertisementTest();

$at->createBanner();
$at->_0_point_advertisement();
$at->lackOfPoint();
$at->beginDateEmpty();
$at->endDateEmpty();
$at->wrongCode();
$at->maximumAdvertisementDays();
$at->domainEmpty();

$at->statusCheck();

$at->startDeduction();

$at->startWithPHCountryDeduction();

$at->stopNoRefund();
$at->stopExpiredNoRefund();
$at->stopOnPastBanner();

$at->stopWithDeductedRefund();

$at->stopWithPHCountryAndDeductedRefund();

$at->stopFullRefund();

$at->stopWithUSCountryFullRefund();

$at->errorDeleteActiveAdvertisement();
$at->deleteAdvertisement();

$at->startStopChangeDatesAndCountry();

$at->loadActiveBannersByCountryCode();

$at->settings();
$at->pointSettings();
$at->pointSettingDelete();

$at->refundAfterPointSettingChanged();

$at->globalMultiplier();


class AdvertisementTest
{

    //    private function loginSetPoint($point): UserModel
    //    {
    //        $user = setLoginAsAdmin();
    //        $user->_setPoint($point);
    //        return $user;
    //    }

    function __construct()
    {
        $this->resetGlobalMulplying();
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

    private function setMaximumAdvertisementDays($days = 10)
    {
        adminSettings()->set(MAXIMUM_ADVERTISING_DAYS, $days);
    }

    private function resetGlobalMulplying($globalMultiplying = 0)
    {
        adminSettings()->set(ADVERTISEMENT_GLOBAL_BANNER_MULTIPLYING, $globalMultiplying);
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

    public function _0_point_advertisement()
    {
        // 사용자 생성 후, 기본 포인트는 0으로 설정 됨.
        $user = registerAndLogin();

        // 임시 배너 생성
        $post = request("advertisement.edit", [
            SESSION_ID => login()->sessionId,
            COUNTRY_CODE => "XX",
        ]);

        isTrue($post['userIdx'] == login()->idx, "동일한 사용자 확인.");


        // 모든 배너 포인트 0 점 처리
        $this->resetBannerPoints();

        // 배너 시작 옵션. 오늘 하루.
        $options = [
            IDX => $post[IDX],
            CODE => TOP_BANNER,
            'beginDate' => time(),
            'endDate' => time(),
        ];

        // 포인트가 0 이어도 가능.
        $re =  advertisement()->start($options);
        isTrue($re->beginAt > 0, "광고 시작 됨");

        //        $re = request("advertisement.start", $options);
        //        d($re);


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
        $this->resetBannerPoints(top: 1);

        // top banner 를 시작. 오늘 하루.
        $options = [
            IDX => $post[IDX],
            CODE => TOP_BANNER,
            'beginDate' => time(),
            'endDate' => time(),
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
        $options =  [SESSION_ID => login()->sessionId, IDX => $banner[IDX], 'beginDate' => time()];
        $re = request("advertisement.start", $options);
        isTrue($re == e()->end_date_empty, "Expect: Error, empty advertisement end date.");
    }

    function wrongCode()
    {
        $banner = $this->createAdvertisement([COUNTRY_CODE => "HH"]);
        $options =  [SESSION_ID => login()->sessionId, IDX => $banner[IDX], 'beginDate' => time(), 'endDate' => time()];
        $re = request("advertisement.start", $options);
        isTrue($re == e()->wrong_banner_code_or_no_point_setting, "Expect: Error. Wrong code.");
    }

    function maximumAdvertisementDays()
    {
        // 사용자에게 백만 포인트.
        registerAndLogin(1000000);

        // 광고 기간을 3일로 했는데, 5일 광고하려 하면, 에러.
        $this->setMaximumAdvertisementDays(3);
        $max = advertisement()->maximumAdvertisementDays();
        $re = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS",
            CODE => TOP_BANNER,
            'beginDate' => time(),
            'endDate' => strtotime('+5 days'),
            SESSION_ID => login()->sessionId
        ]);
        isTrue($re == e()->maximum_advertising_days, "Expect: Error, exceed maximum advertising days.");


        // 에러 예상. 광고 기간이 3일인데, 3일 하고 하루 더 광고 진행 테스트.
        // Equivalent to $max + 1 days since begin date is counted to the total ad serving days.
        $re = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS", CODE => TOP_BANNER, 'beginDate' => time(), 'endDate' => strtotime("+$max days")
        ]);
        isTrue($re == e()->maximum_advertising_days, "Expect: Error, exceed maximum advertising days.");


        // 성공 예상. 광고 기간이 3일인데, 3일 보다 하루 적게 하고 광고 진행 테스트.
        $days = $max - 1;
        $re = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS", CODE => TOP_BANNER, 'beginDate' => time(), 'endDate' => strtotime("+$days days")
        ]);
        isTrue($re[IDX], "Expect: Success, adv days does not exceed maximum allowed days.");
    }

    function domainEmpty()
    {
        $re = request("advertisement.loadBanners");
        isTrue($re == e()->empty_domain, "Expect: error, no domain when fetching active banners.");

        $re = request("advertisement.loadBanners", ['cafeDomain' => '']);
        isTrue($re == e()->empty_domain, "Expect: error, no domain when fetching active banners.");
    }


    /**
     * TODO
     */
    function statusCheck()
    {
        registerAndLogin(1000000);
        // 광고 가능 기간 100 일로 설정.
        $this->setMaximumAdvertisementDays(100);

        // Advertisement begin date same as now, considered as active.
        $re = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS", CODE => TOP_BANNER, 'beginDate' => time(), 'endDate' => strtotime('+1 days')
        ]);
        isTrue($re['status'] == 'active', "Expect: Status == 'active'");

        // Advertisement end date same as now, considered as active.
        $re = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS", CODE => TOP_BANNER, 'beginDate' => strtotime('-1 days'), 'endDate' => time()
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
            COUNTRY_CODE => "SS", CODE => TOP_BANNER, 'beginDate' => strtotime('+3 days'), 'endDate' => strtotime('+4 days')
        ]);
        isTrue($re['status'] == 'waiting', "Expect: Status == 'waiting'");

        // Expired advertisement, considered as inactive
        $re = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS", CODE => TOP_BANNER, 'beginDate' => strtotime('-5 days'), 'endDate' => strtotime('-2 days')
        ]);

        isTrue($re['status'] == 'inactive', "Expect: Status == 'inactive', but got: " . $re['status']);

        // 광고 생성을 했지만, `advertisement.start` 라우트로 시작을 하지 않아, inactive 한 상태.
        // Advertisement created with begin and end date same as now but not started yet
        // considered as inactive.
        $re = request("advertisement.edit", [
            COUNTRY_CODE => "SS",
            SESSION_ID => login()->sessionId,
            'beginDate' => time(),
            'endDate' => time()
        ]);

        isTrue($re['status'] == 'inactive', "Expect: Status == 'inactive', but got: " . $re['status']);

        // 마찬가지
        // Advertisement created with begin and end date set to future dates but not started yet
        // considered as inactive.
        $re = request("advertisement.edit", [
            COUNTRY_CODE => "SS",
            SESSION_ID => login()->sessionId,
            'beginDate' => strtotime('+3 days'),
            'endDate' => strtotime('+10 days')
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
            COUNTRY_CODE => "SS", CODE => TOP_BANNER, 'beginDate' => time(), 'endDate' => time()
        ]);

        /// 포인트 확인.
        isTrue($ad['pointPerDay'] == $topBannerPoint, "Expect: 'pointPerDay' == " . $topBannerPoint);
        isTrue($ad['advertisementPoint'] == $topBannerPoint, "Expect: 'advertisementPoint' == " . $topBannerPoint);

        /// 포인트 차감 확인.
        $expectedPoint = $startingPoint - $topBannerPoint;
        isTrue(login()->getPoint() == $expectedPoint, "Expect: db user point(" . login()->getPoint() . ") == expected point($expectedPoint).");

        /// 광고 시작, 포인트 기록 확인.
        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.start');
        isTrue($activity->toUserPointApply == -$topBannerPoint, "Expect: activity->toUserPointApply == -$topBannerPoint.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");


        /// 내일 부터 3 일간 광고 진행.
        $ad = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS", CODE => TOP_BANNER, 'beginDate' => strtotime('+1 days'), 'endDate' => strtotime('+3 days')
        ]);

        /// 소모된 광고 포인트 3일치, 확인.
        $advPoint = $topBannerPoint * 3;
        $expectedPoint -= $advPoint;
        isTrue(login()->getPoint() == $expectedPoint,  "Expect: db user point(" . login()->getPoint() . ") == expected point($expectedPoint).");

        /// 포인트 확인.
        isTrue($ad['pointPerDay'] == $topBannerPoint, "Expect: 'pointPerDay' == " . $topBannerPoint);
        isTrue($ad['advertisementPoint'] == $advPoint, "Expect: 'advertisementPoint' == " . $advPoint);

        /// 포인트 기록 확인.
        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.start');
        isTrue($activity->toUserPointApply == -$advPoint, "Expect: activity->toUserPointApply == -$advPoint.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    /**
     * 3 days * Top banner point (PH)
     */
    function startWithPHCountryDeduction()
    {
        // 시작 포인트
        $startingPoint = 1000000;
        registerAndLogin($startingPoint);

        // 필리핀 top banner point 는 70.
        $this->resetBannerPoints('PH', top: 70);

        $adOpts = [CODE => TOP_BANNER, COUNTRY_CODE => 'PH', 'beginDate' => time(), 'endDate' => strtotime('+2 day')];
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
            COUNTRY_CODE => "SS", CODE => TOP_BANNER, 'beginDate' => time(), 'endDate' => time()
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
    function stopExpiredNoRefund()
    {

        $startingPoint = 1000000;
        registerAndLogin($startingPoint);
        // 광고 생성하고 시작, 그러나 이미 종료된 광고.
        $ad = $this->createAndStartAdvertisement([COUNTRY_CODE => "SS", CODE => TOP_BANNER, 'beginDate' => strtotime('-8 days'), 'endDate' => time()]);
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

    public function stopOnPastBanner()
    {
        echo "\n@todo Test on past banner\n";
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
        $ad = $this->createAndStartAdvertisement([COUNTRY_CODE => "SS", CODE => TOP_BANNER, 'beginDate' => strtotime('-2 days'), 'endDate' => strtotime('+3 days')]);

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
    function stopWithPHCountryAndDeductedRefund()
    {
        $startingPoint = 1300000;
        registerAndLogin($startingPoint);
        $this->resetBannerPoints('PH', top: 1234);

        $ad = $this->createAndStartAdvertisement([
            CODE => TOP_BANNER,
            COUNTRY_CODE => 'PH',
            'beginDate' => strtotime('-2 days'),
            'endDate' => strtotime('+3 days')
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
            CODE => LINE_BANNER,
            'beginDate' => strtotime('+3 days'), // 4 days including today.
            'endDate' => strtotime('+1 week 4 days') // 12 days including today. so, it's 9 days.
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
    function stopWithUSCountryFullRefund()
    {

        $startingPoint = 1500000;
        registerAndLogin($startingPoint);
        $this->resetBannerPoints('US', line: 3500);
        $ad = $this->createAndStartAdvertisement([
            CODE => LINE_BANNER,
            COUNTRY_CODE => 'US',
            'beginDate' => strtotime('+3 days'), //
            'endDate' => strtotime('+1 week 4 days') // 9 days.
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

        $ad = $this->createAndStartAdvertisement([COUNTRY_CODE => "SS", CODE => LINE_BANNER, 'beginDate' => time(), 'endDate' => time()]);
        $re = request('advertisement.delete', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);
        isTrue($re == e()->advertisement_is_active, "Expect: Error. Cannot delete active advertisement.");

        $ad2 = $this->createAndStartAdvertisement([COUNTRY_CODE => "SS", CODE => LINE_BANNER, 'beginDate' => strtotime('+2 days'), 'endDate' => strtotime('+3 days')]);
        $re = request('advertisement.delete', [SESSION_ID => login()->sessionId, IDX => $ad2[IDX]]);
        isTrue($re == e()->advertisement_is_active, "Expect: Error. Cannot delete active advertisement.");
    }

    /**
     * Deleting inactive advertisement.
     */
    function deleteAdvertisement()
    {
        registerAndLogin(1500000);
        $ad = $this->createAndStartAdvertisement([COUNTRY_CODE => "SS", CODE => LINE_BANNER, 'beginDate' => time(), 'endDate' => time()]);

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
        $startingPoint = 800000;
        registerAndLogin($startingPoint);
        $this->resetBannerPoints(square: 2020, line: 1580,);
        $this->resetBannerPoints('US', square: 2020, line: 1580,);

        // first create
        $ad = $this->createAndStartAdvertisement([
            COUNTRY_CODE => "SS",
            CODE => LINE_BANNER,
            'beginDate' => strtotime('+3 days'), //
            'endDate' => strtotime('+8 days') //
        ]);

        $bannerPoint = advertisement()->LineBannerPoint();
        isTrue(login()->getPoint() == $startingPoint - $bannerPoint * 6, "Expect: user points == " . $startingPoint - $bannerPoint * 6);

        // cancel
        $ad = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);
        isTrue($ad['status'] == 'inactive', 'banner cancelled');



        isTrue(login()->getPoint() == $startingPoint, "Expect: user points == $startingPoint.");

        // edit same ad with new country and dates
        $newAd = $this->createAndStartAdvertisement([
            CODE => SQUARE_BANNER,
            COUNTRY_CODE => 'US',
            'beginDate' => time(),
            'endDate' => strtotime('+2 days') // advertisement days: 3 days. 2 days will be refunded.
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

    function loadActiveBannersByCountryCode()
    {

        $startingPoint = 800000;
        registerAndLogin($startingPoint);

        $rootDomain = 'ard' . time() . '.com';
        $subDomain = 'abc';
        $countryCodeA = 'AA';
        $countryCodeB = 'ZZ';

        $this->resetBannerPoints($countryCodeA, 1000, 2000, 3000, 4000);
        $this->resetBannerPoints($countryCodeB, 6000, 7000, 8000, 9000);

        $cafe = cafe()->create(['rootDomain' => $rootDomain, 'domain' => $subDomain, 'countryCode' => $countryCodeA]);

        isTrue($cafe->ok, 'cafe for banner test has been created');
        $domain = $subDomain . '.' . $rootDomain;

        $advOpts = [
            CODE => LINE_BANNER,
            'beginDate' => time(),
            'endDate' => time(),
            'fileIdxes' => '1',
        ];

        // create 4 banner with the cafe countryCode.
        $advOpts[COUNTRY_CODE] = $countryCodeA;
        $adv1 = $this->createAndStartAdvertisement($advOpts);
        $adv2 = $this->createAndStartAdvertisement($advOpts);
        $adv3 = $this->createAndStartAdvertisement($advOpts);
        $adv4 = $this->createAndStartAdvertisement($advOpts);

        //
        $re = request("advertisement.loadBanners", ['cafeDomain' => $domain]);
        isTrue(count($re) == 4, 'Expect: active banners == 4 but got ' . count($re));






        // changing the country code of $adv1 and $adv2.
        //
        $advOpts[COUNTRY_CODE] = $countryCodeB;
        post($adv1[IDX])->update($advOpts);
        post($adv2[IDX])->update($advOpts);

        $re = request("advertisement.loadBanners", ['cafeDomain' => $domain]);
        isTrue(count($re) == 2, 'Expect: active banners == 2 but got ' . count($re));
        isTrue($re[0]['idx'] == $adv3['idx'], 'Got adv3 idx');
        isTrue($re[1]['idx'] == $adv4['idx'], 'Got adv4 idx');



        // Change the country of the cafe.
        $cafe = cafe($cafe->idx)->update([COUNTRY_CODE => $countryCodeB]);
        isTrue($cafe->countryCode == $countryCodeB, "Expect: country code changed from $countryCodeA to $countryCodeB.");

        $re = request("advertisement.loadBanners", ['cafeDomain' => $domain]);

        // d($re);
        isTrue(count($re) == 2, 'Expect: active banners == 2 but got ' . count($re));
        isTrue($re[0]['idx'] == $adv1['idx'], 'Got adv1 idx');
        isTrue($re[1]['idx'] == $adv2['idx'], 'Got adv2 idx');

        post($adv3[IDX])->update($advOpts);
        $re = request("advertisement.loadBanners", ['cafeDomain' => $domain]);
        isTrue(count($re) == 3, 'Expect: active banners == 3 but got ' . count($re));

        request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $adv1[IDX]]);
        request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $adv2[IDX]]);
        request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $adv3[IDX]]);
        request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $adv4[IDX]]);

        $re = request("advertisement.loadBanners", ['cafeDomain' => $domain]);
        isTrue(count($re) == 0, 'Expect: active banners == 0. cafe country code => ' . $cafe->countryCode);

        $cafe = cafe($cafe->idx)->update([COUNTRY_CODE => $countryCodeA]);
        $re = request("advertisement.loadBanners", ['cafeDomain' => $domain]);
        isTrue(count($re) == 0, 'Expect: active banners == 0. cafe country code => ' . $cafe->countryCode);
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

    function refundAfterPointSettingChanged()
    {

        $admin = setLoginAsAdmin();
        $countryCode = "PH";

        request('advertisement.setBannerPoint', [
            COUNTRY_CODE => $countryCode,
            TOP_BANNER => 1000,
            SIDEBAR_BANNER => 2000,
            SQUARE_BANNER => 3000,
            LINE_BANNER => 4000,
            SESSION_ID => $admin->sessionId
        ]);

        $settings = request('advertisement.settings');
        $countryPointSetting = $settings['point'][$countryCode];
        isTrue(!empty($countryPointSetting), "Expect: point settings for $countryCode is set.");

        $startingPoint = 1000000;
        registerAndLogin($startingPoint);
        $bannerPoint = advertisement()->topBannerPoint($countryCode);
        $adOpts = [
            CODE => TOP_BANNER,
            COUNTRY_CODE => $countryCode,
            'beginDate' => time(),
            'endDate' => strtotime('+2 day'),
            SESSION_ID => login()->sessionId
        ];

        $ad = $this->createAndStartAdvertisement($adOpts);

        $advPoint = $bannerPoint * 3;
        $expectedPoint = $startingPoint - $advPoint;

        isTrue($ad['pointPerDay'] == $bannerPoint, "Expect: 'pointPerDay' == " . $bannerPoint);
        isTrue($ad['advertisementPoint'] == $advPoint, "Expect: 'advertisementPoint' == " . $advPoint);
        isTrue(login()->getPoint() == $expectedPoint, "Expect: user points == $expectedPoint.");

        /// update point setting for same country code.
        request('advertisement.setBannerPoint', [
            COUNTRY_CODE => $countryCode,
            TOP_BANNER => 3000,
            SIDEBAR_BANNER => 3500,
            SQUARE_BANNER => 4500,
            LINE_BANNER => 5500,
            SESSION_ID => $admin->sessionId
        ]);

        $refundPoint = $bannerPoint * 2;
        $expectedPoint += $refundPoint;
        request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        isTrue(login()->getPoint() == $expectedPoint, "Expect: user points == $expectedPoint. But user has " . login()->getPoint());

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.stop');
        isTrue($activity->toUserPointApply == $refundPoint, "Expect: activity->toUserPointApply == $refundPoint. But applied " . $activity->toUserPointApply);
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    function globalMultiplier()
    {
        $admin = setLoginAsAdmin();
        // set global multiplier
        $globalMultiplying = rand(1, 5);
        request('app.setConfig', [
            SESSION_ID => $admin->sessionId,
            CODE => ADVERTISEMENT_GLOBAL_BANNER_MULTIPLYING, 'data' => $globalMultiplying,
        ]);

        // set points for PH
        $countryCode = "PH";
        $this->resetBannerPoints($countryCode, 1000, 2000, 3000, 4000);

        $startingPoint = 1000000;
        registerAndLogin($startingPoint);

        $noOfDays = 3;
        $advOpts = [
            COUNTRY_CODE => $countryCode,
            CODE => TOP_BANNER,
            'beginDate' => time(),
            'endDate' => strtotime('+2 day'),
            SESSION_ID => login()->sessionId
        ];

        // create adv1 - global top banner for PH for 3 days
        $adv1 = $this->createAndStartAdvertisement($advOpts);

        // create adv2 - qna top banner for PH for 3 days
        $advOpts[SUB_CATEGORY] = 'qna';
        $adv2 = $this->createAndStartAdvertisement($advOpts);

        $bannerPoint = advertisement()->topBannerPoint($countryCode);

        $globalBannerPoint = $bannerPoint * $globalMultiplying;
        $globalAdvertisementPoint = $globalBannerPoint * $noOfDays;

        $categoryBannerPoint = $bannerPoint;
        $categoryAdvertisementPoint = $bannerPoint * $noOfDays;

        // Global Advertisement
        //
        // expect it's POINT_PER_DAY == $globalMultiplying * TOP_BANNER
        // expect it's ADVERTISEMENT_POINT == ($globalMultiplying * TOP_BANNER) * Number of days.
        // expect user_activity toUserPointApply = ADVERTISEMENT_POINT
        isTrue($adv1['pointPerDay'] == $globalBannerPoint, "Expect: 'pointPerDay' == " . $globalBannerPoint);
        isTrue($adv1['advertisementPoint'] == $globalAdvertisementPoint, "Expect: 'advertisementPoint' == " . $globalAdvertisementPoint);

        $activity = userActivity()->last(taxonomy: POSTS, entity: $adv1[IDX], action: 'advertisement.start');
        isTrue($activity->toUserPointApply == -$globalAdvertisementPoint, "Expect: activity->toUserPointApply == $globalAdvertisementPoint. But applied " . $activity->toUserPointApply);

        // Category Advertisement
        //
        // expect it's POINT_PER_DAY == TOP_BANNER
        // expect it's ADVERTISEMENT_POINT == TOP_BANNER * Number of days.
        // expect user_activity toUserPointApply = ADVERTISEMENT_POINT
        isTrue($adv2['pointPerDay'] == $categoryBannerPoint, "Expect: 'pointPerDay' == " . $categoryBannerPoint);
        isTrue($adv2['advertisementPoint'] == $categoryAdvertisementPoint, "Expect: 'advertisementPoint' == " . $categoryAdvertisementPoint);

        $activity = userActivity()->last(taxonomy: POSTS, entity: $adv2[IDX], action: 'advertisement.start');
        isTrue($activity->toUserPointApply == -$categoryAdvertisementPoint, "Expect: activity->toUserPointApply == $categoryAdvertisementPoint. But applied " . $activity->toUserPointApply);

        // Advertisements points comparison
        //
        // expect global banner point is not equal to category banner point
        isTrue($adv1['pointPerDay'] != $adv2['pointPerDay'],  "Expect: Adv1 'pointPerDay' != Adv2 'pointPerDay'");
        isTrue($adv1['advertisementPoint'] != $adv2['advertisementPoint'],  "Expect: Adv1 'advertisementPoint' != Adv2 'advertisementPoint'");
    }
}
