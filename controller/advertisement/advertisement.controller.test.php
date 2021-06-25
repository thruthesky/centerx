<?php

setLogout();

$at = new AdvertisementTest();

// $at->lackOfPoint();
// $at->emptyCode();
// $at->beginDateEmpty();
// $at->endDateEmpty();
// $at->maximumAdvertisementDays();
// $at->domainEmpty();

// $at->statusCheck();

// $at->startDeduction();

// $at->startWithPHCountryDeduction();

// $at->stopNoRefund();
// $at->stopExpiredNoRefund();

// $at->stopWithDeductedRefund();
// $at->stopWithPHCountryAndDeductedRefund();

// $at->stopFullRefund();
// $at->stopWithUSCountryFullRefund();

// $at->errorDeleteActiveAdvertisement();
// $at->deleteAdvertisement();

// $at->startStopChangeDatesAndCountry();

$at->loadActiveBannersByCountryCode();


/**
 * doesn't work now since when editting without IDX will result to creating instead of update.
 */
// $at->emptyIdx();
// $at->fetchWithCategoryCountryAndCode();

/**
 * 
 * @todo do tests
 * @todo test - check input /
 * @todo test - check point deduction /
 * @todo test - check cancel /
 * @todo test - check refund /
 * @todo test - change dates after create banner and check days left.
 * @todo test - compare the point history. /
 * @todo test - get banners on a specific /
 *    - banner type/place (code) /
 *    - category(subcategory) /
 *    - and countryCode. /
 *
 * @todo test - MAX_END_DAYS
 */
class AdvertisementTest
{

    private function loginSetPoint($point)
    {
        registerAndLogin();
        login()->setPoint($point);
    }

    private function createAdvertisement()
    {
        registerAndLogin();
        return request("advertisement.edit", [
            CATEGORY_ID => 'advertisement',
            SESSION_ID => login()->sessionId
        ]);
    }

    private function createAndStartAdvertisement($options)
    {

        $post = request("advertisement.edit", [
            CATEGORY_ID => 'advertisement',
            SESSION_ID => login()->sessionId
        ]);

        $options[SESSION_ID] = login()->sessionId;
        $options[IDX] = $post[IDX];
        return request("advertisement.start", $options);
    }


    function lackOfPoint()
    {
        registerAndLogin();

        // test post.
        $post = request("advertisement.edit", [
            CATEGORY_ID => 'advertisement',
            SESSION_ID => login()->sessionId
        ]);

        $bp = advertisement()->topBannerPoint();

        $options = [
            SESSION_ID => login()->sessionId,
            IDX => $post[IDX],
            CODE => TOP_BANNER,
            'beginDate' => time(),
            'endDate' => time(),
        ];
        $re = request("advertisement.start", $options);
        if ($bp) {
            isTrue($re == e()->lack_of_point, "Expect: Error, user lacks point to create advertisement.");
        } else {
            isTrue($re[IDX], "Advertisement started with 0 point");
        }
    }


    /**
     * @deprecated
     * 
     * doesn't work now since when editting without IDX will result to creating instead of update.
     */
    function emptyIdx()
    {
        registerAndLogin();
        $options = [SESSION_ID => login()->sessionId];
        $re = request("advertisement.start", $options);
        isTrue($re == e()->idx_is_empty, "Expect: Error, empty advertisement IDX.");
    }

    function emptyCode()
    {
        $post = $this->createAdvertisement();
        $options = [SESSION_ID => login()->sessionId, IDX => $post[IDX]];
        $re = request("advertisement.start", $options);
        isTrue($re == e()->code_is_empty, "Expect: Error. Code must be empty.");
    }

    function beginDateEmpty()
    {
        $post = $this->createAdvertisement();
        $options =  [SESSION_ID => login()->sessionId, IDX => $post[IDX], CODE => TOP_BANNER];
        $re = request("advertisement.start", $options);
        isTrue($re == e()->begin_date_empty, "Expect: Error, empty advertisement begin date.");
    }

    function endDateEmpty()
    {
        $post = $this->createAdvertisement();
        $options =  [SESSION_ID => login()->sessionId, IDX => $post[IDX], CODE => TOP_BANNER, 'beginDate' => time()];
        $re = request("advertisement.start", $options);
        isTrue($re == e()->end_date_empty, "Expect: Error, empty advertisement end date.");
    }


    function maximumAdvertisementDays()
    {
        $this->loginSetPoint(1000000);
        $re = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => time(), 'endDate' => strtotime('+100 days')]);
        if (MAXIMUM_ADVERTISING_DAYS > 0) {
            isTrue($re == e()->maximum_advertising_days, "Expect: Error, exceed maximum advertising days.");
        } else {
            isTrue($re[IDX], "Expect: success, no advertising day limit.");
        }

        $max = MAXIMUM_ADVERTISING_DAYS;

        // Equivalent to $max + 1 days since begin date is counted to the total ad serving days.
        $re = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => time(), 'endDate' => strtotime("+$max days")]);
        if ($max > 0) {
            isTrue($re == e()->maximum_advertising_days, "Expect: Error, exceed maximum advertising days.");
        } else {
            isTrue($re[IDX], "Expect: success, no advertising day limit.");
        }
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
        $this->loginSetPoint(1000000);
        // Advertisement begin date same as now, considered as active.
        $re = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => time(), 'endDate' => strtotime('+1 days')]);
        isTrue($re['status'] == 'active', "Expect: Status == 'active'");

        // Advertisement end date same as now, considered as active.
        $re = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => strtotime('-1 days'), 'endDate' => time()]);
        isTrue($re['status'] == 'active', "Expect: Status == 'active'");

        // considered as inactive.
        $re = request("advertisement.stop", [
            CATEGORY_ID => 'advertisement',
            SESSION_ID => login()->sessionId,
            IDX => $re[IDX]
        ]);
        isTrue($re['status'] == 'inactive', "Expect: Status == 'inactive'");

        // Advertisement started but not served yet, considered as waiting.
        $re = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => strtotime('+3 days'), 'endDate' => strtotime('+4 days')]);
        isTrue($re['status'] == 'waiting', "Expect: Status == 'waiting'");

        // Expired advertisement, considered as inactive
        $re = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => strtotime('-5 days'), 'endDate' => strtotime('-2 days')]);
        isTrue($re['status'] == 'inactive', "Expect: Status == 'inactive'");

        // Advertisement created with begin and end date same as now but not started yet
        // considered as inactive.
        $re = request("advertisement.edit", [
            CATEGORY_ID => 'advertisement',
            SESSION_ID => login()->sessionId,
            'beginDate' => time(),
            'endDate' => time()
        ]);
        isTrue($re['status'] == 'inactive', "Expect: Status == 'inactive'");

        // Advertisement created with begin and end date set to future dates but not started yet
        // considered as inactive.
        $re = request("advertisement.edit", [
            CATEGORY_ID => 'advertisement',
            SESSION_ID => login()->sessionId,
            'beginDate' => strtotime('+3 days'),
            'endDate' => strtotime('+10 days')
        ]);
        isTrue($re['status'] == 'inactive', "Expect: Status == 'inactive'");
    }

    /**
     * 1 day * Top banner point (default)
     */
    function startDeduction()
    {
        $userPoint = 1000000;
        $bp = advertisement()->topBannerPoint();
        $this->loginSetPoint($userPoint);
        $ad = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => time(), 'endDate' => time()]);

        isTrue($ad['pointPerDay'] == $bp, "Expect: 'pointPerDay' == " . $bp);
        isTrue($ad['advertisementPoint'] == $bp, "Expect: 'advertisementPoint' == " . $bp);

        $userPoint -= $bp;
        isTrue(login()->getPoint() == $userPoint, "Expect: user points == $userPoint.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.start');
        isTrue($activity->toUserPointApply == -$bp, "Expect: activity->toUserPointApply == -$bp.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");


        $ad = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => strtotime('+1 days'), 'endDate' => strtotime('+3 days')]);

        $advPoint = $bp * 3;
        $userPoint -= $advPoint;

        isTrue(login()->getPoint() == $userPoint, "Expect: user points == $userPoint.");

        isTrue($ad['pointPerDay'] == $bp, "Expect: 'pointPerDay' == " . $bp);
        isTrue($ad['advertisementPoint'] == $advPoint, "Expect: 'advertisementPoint' == " . $advPoint);

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.start');
        isTrue($activity->toUserPointApply == -$advPoint, "Expect: activity->toUserPointApply == -$advPoint.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    /**
     * 3 days * Top banner point (PH)
     */
    function startWithPHCountryDeduction()
    {
        $userPoint = 1000000;
        $this->loginSetPoint($userPoint);
        $adOpts = [CODE => TOP_BANNER, COUNTRY_CODE => 'PH', 'beginDate' => time(), 'endDate' => strtotime('+2 day')];
        $ad = $this->createAndStartAdvertisement($adOpts);



        $bp = advertisement()->topBannerPoint('PH');
        $advPoint = $bp * 3;
        $userPoint -= $advPoint;

        isTrue(login()->getPoint() == $userPoint, "Expect: user's points => 9000.");

        isTrue($ad['pointPerDay'] == $bp, "Expect: 'pointPerDay' == $bp.");
        isTrue($ad['advertisementPoint'] == $advPoint, "Expect: 'advertisementPoint' == $advPoint.");

        isTrue(login()->getPoint() == $userPoint, "Expect: user points == " . ($userPoint));

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
        $userPoint = 1000000;
        $this->loginSetPoint($userPoint);
        $ad = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => time(), 'endDate' => time()]);

        $bp = advertisement()->topBannerPoint();
        $advPoint = $bp;
        $userPoint -= $advPoint;

        isTrue(login()->getPoint() == $userPoint, "Expect: user's points => $userPoint.");

        $ad = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        isTrue($ad['advertisementPoint'] == '', "Expect: 'advertisementPoint' => ''.");

        isTrue(login()->getPoint() == $userPoint, "Expect: user's points => $userPoint.");

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
        $userPoint = 1000000;
        $this->loginSetPoint($userPoint);
        $ad = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => strtotime('-8 days'), 'endDate' => strtotime('-3 days')]);
        // d(login()->getPoint());

        $bp = advertisement()->topBannerPoint();
        $advPoint = $bp * 6;
        $userPoint -= $advPoint;

        // d(login()->getPoint());
        isTrue(login()->getPoint() == $userPoint, "Expect: user's points => $userPoint.");

        $ad = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        // d(login()->getPoint());
        // d($userPoint);

        isTrue(login()->getPoint() == $userPoint, "Expect: user's points => $userPoint.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.stop');

        // d($activity->toUserPointApply);

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
        $userPoint = 1000000;
        $this->loginSetPoint($userPoint);
        $ad = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => strtotime('-2 days'), 'endDate' => strtotime('+3 days')]);

        $bp = advertisement()->topBannerPoint();
        $advPoint = $bp * 6;
        $refund = $bp * 3;

        $userPoint -= $advPoint;

        isTrue(login()->getPoint() == $userPoint, "Expect: user points == $userPoint.");

        $ad = request("advertisement.stop", [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        $userPoint += $refund;
        isTrue(login()->getPoint() == $userPoint, "Expect: user points == $userPoint");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.stop');
        isTrue($activity->toUserPointApply == $refund, "Expect: activity->toUserPointApply == $refund.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    /**
     * begin date - 2 days ago
     * end date - 3 days from now
     * 6 days * 2000 (Top banner - PH)
     */
    function stopWithPHCountryAndDeductedRefund()
    {
        $userPoint = 1300000;
        $this->loginSetPoint($userPoint);
        $ad = $this->createAndStartAdvertisement([
            CODE => TOP_BANNER,
            COUNTRY_CODE => 'PH',
            'beginDate' => strtotime('-2 days'),
            'endDate' => strtotime('+3 days')
        ]);

        $bp = advertisement()->topBannerPoint('PH');
        $advPoint = $bp * 6;
        $refund = $bp * 3;

        $userPoint -= $advPoint;

        isTrue(login()->getPoint() == $userPoint, "Expect: user points == $userPoint.");

        $ad = request("advertisement.stop", [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        $userPoint += $refund;
        isTrue(login()->getPoint() == $userPoint, "Expect: user points == $userPoint.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.stop');
        isTrue($activity->toUserPointApply == $refund, "Expect: activity->toUserPointApply == $refund.");
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

        $userPoint = 900000;
        $this->loginSetPoint($userPoint);
        $ad = $this->createAndStartAdvertisement([
            CODE => LINE_BANNER,
            'beginDate' => strtotime('+3 days'),
            'endDate' => strtotime('+1 week 4 days')
        ]);

        $bp = advertisement()->LineBannerPoint();
        $advPoint = $bp * 9;

        $userPoint -= $advPoint;
        isTrue(login()->getPoint() == $userPoint, "Expect: user's points => $userPoint.");

        $ad = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        $userPoint += $advPoint;
        isTrue(login()->getPoint() == $userPoint, "Expect: user's points => $userPoint.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.cancel');
        isTrue($activity->toUserPointApply == $advPoint, "Expect: activity->toUserPointApply == $advPoint.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
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

        $userPoint = 1500000;
        $this->loginSetPoint($userPoint);
        $ad = $this->createAndStartAdvertisement([
            CODE => LINE_BANNER,
            COUNTRY_CODE => 'US',
            'beginDate' => strtotime('+3 days'),
            'endDate' => strtotime('+1 week 4 days')
        ]);

        $bp = advertisement()->LineBannerPoint('US');
        $advPoint = $bp * 9;

        $userPoint -= $advPoint;
        isTrue(login()->getPoint() == $userPoint, "Expect: user's points => $userPoint.");

        $ad = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        $userPoint += $advPoint;
        isTrue(login()->getPoint() == $userPoint, "Expect: user's points => $userPoint.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.cancel');
        isTrue($activity->toUserPointApply == $advPoint, "Expect: activity->toUserPointApply == $advPoint.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    /**
     * Deleting active advertisement.
     */
    function errorDeleteActiveAdvertisement()
    {
        $this->loginSetPoint(1500000);
        $ad = $this->createAndStartAdvertisement([CODE => LINE_BANNER, 'beginDate' => time(), 'endDate' => time()]);
        $re = request('advertisement.delete', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);
        isTrue($re == e()->advertisement_is_active, "Expect: Error. Cannot delete active advertisement.");

        $ad2 = $this->createAndStartAdvertisement([CODE => LINE_BANNER, 'beginDate' => strtotime('+2 days'), 'endDate' => strtotime('+3 days')]);
        $re = request('advertisement.delete', [SESSION_ID => login()->sessionId, IDX => $ad2[IDX]]);
        isTrue($re == e()->advertisement_is_active, "Expect: Error. Cannot delete active advertisement.");
    }

    /**
     * Deleting inactive advertisement.
     */
    function deleteAdvertisement()
    {
        $this->loginSetPoint(1500000);
        $ad = $this->createAndStartAdvertisement([CODE => LINE_BANNER, 'beginDate' => time(), 'endDate' => time()]);

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
        $userPoint = 800000;
        $this->loginSetPoint($userPoint);

        // first create
        $ad = $this->createAndStartAdvertisement([
            CODE => LINE_BANNER,
            'beginDate' => strtotime('+3 days'),
            'endDate' => strtotime('+8 days')
        ]);

        $bp = advertisement()->LineBannerPoint();
        $advPoint = $bp * 6;
        $userPoint -= $advPoint;

        isTrue($ad['pointPerDay'] == $bp, "Expect: 'pointPerDay' == $bp.");
        isTrue($ad['advertisementPoint'] == $advPoint, "Expect: 'advertisementPoint' == $advPoint.");

        isTrue(login()->getPoint() == $userPoint, "Expect: user points == $userPoint.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.start');
        isTrue($activity->toUserPointApply == -$advPoint, "Expect: activity->toUserPointApply == -$advPoint.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");

        // cancel
        $ad = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);
        $userPoint += $advPoint;

        isTrue($ad['advertisementPoint'] == '', "Expect: 'advertisementPoint' == 0.");
        isTrue(login()->getPoint() == $userPoint, "Expect: user points == $userPoint.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.cancel');
        isTrue($activity->toUserPointApply == $advPoint, "Expect: activity->toUserPointApply == $advPoint.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");

        // edit same ad with new country and dates
        $newAd = $this->createAndStartAdvertisement([
            CODE => SQUARE_BANNER,
            COUNTRY_CODE => 'US',
            'beginDate' => time(),
            'endDate' => strtotime('+2 days')
        ]);

        $bp = advertisement()->SquareBannerPoint('US');
        $advPoint = $bp * 3;
        $refund = $bp * 2;
        $userPoint -= $advPoint;

        isTrue($newAd['pointPerDay'] == $bp, "Expect: 'pointPerDay' == $bp.");
        isTrue($newAd['advertisementPoint'] == $advPoint, "Expect: 'advertisementPoint' == $advPoint.");

        isTrue(login()->getPoint() == $userPoint, "Expect: user points == $userPoint.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $newAd[IDX], action: 'advertisement.start');
        isTrue($activity->toUserPointApply == -$advPoint, "Expect: activity->toUserPointApply == -$advPoint.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");

        // cancel again
        $newAd = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $newAd[IDX]]);

        $userPoint += $refund;
        isTrue($newAd['advertisementPoint'] == '', "Expect: 'advertisementPoint' == 0.");
        isTrue(login()->getPoint() == $userPoint, "Expect: user points == $userPoint.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $newAd[IDX], action: 'advertisement.stop');
        isTrue($activity->toUserPointApply == $refund, "Expect: activity->toUserPointApply == $refund.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    function loadActiveBannersByCountryCode()
    {
        $userPoint = 800000;
        $this->loginSetPoint($userPoint);

        $rootDomain = 'a' . time() . '.com';
        $countryCodeA = 'AS';
        $countryCodeB = 'AV';

        $cafe = cafe()->create(['rootDomain' => $rootDomain, 'domain' => 'abc', 'countryCode' => $countryCodeA]);
        
        // d($cafe->idx);
        // d($cafe->countryCode);
        
        isTrue($cafe->ok, 'cafe for banner test has been created');
        $domain = 'abc.' . $rootDomain;

        $advOpts = [
            CODE => LINE_BANNER,
            'beginDate' => time(),
            'endDate' => time(),
            'files' => '1',
        ];

        $advOpts[COUNTRY_CODE] = $countryCodeA;
        $adv1 = $this->createAndStartAdvertisement($advOpts);
        $adv2 = $this->createAndStartAdvertisement($advOpts);
        $adv3 = $this->createAndStartAdvertisement($advOpts);
        $adv4 = $this->createAndStartAdvertisement($advOpts);

        $re = request("advertisement.loadBanners", ['cafeDomain' => $domain]);
        // d($re);
        isTrue(count($re) == 4, 'Expect: active banners == 4');

        $advOpts[COUNTRY_CODE] = $countryCodeB;
        post($adv1[IDX])->update($advOpts);
        post($adv2[IDX])->update($advOpts);

        $re = request("advertisement.loadBanners", ['cafeDomain' => $domain]);
        isTrue(count($re) == 2, 'Expect: active banners == 2');
        
        $cafe = cafe($cafe->idx)->update([COUNTRY_CODE => $countryCodeB]);
        isTrue($cafe->countryCode == $countryCodeB, "Expect: country code changed from $countryCodeA to $countryCodeB.");

        $re = request("advertisement.loadBanners", ['cafeDomain' => $domain]);

        // d($re);
        isTrue(count($re) == 2, 'Expect: active banners == 2.');
        
        post($adv3[IDX])->update($advOpts);
        $re = request("advertisement.loadBanners", ['cafeDomain' => $domain]);
        isTrue(count($re) == 3, 'Expect: active banners == 3');

        $advOpts[COUNTRY_CODE] = '';
        request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $adv1[IDX]]);
        request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $adv2[IDX]]);
        request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $adv3[IDX]]);
        request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $adv4[IDX]]);

        $re = request("advertisement.loadBanners", ['cafeDomain' => $domain]);
        isTrue(count($re) == 0, 'Expect: active banners == 0. cafe country code => ' . $cafe->countryCode);

        $cafe = cafe($cafe->idx)->update([COUNTRY_CODE => $countryCodeB]);
        $re = request("advertisement.loadBanners", ['cafeDomain' => $domain]);
        isTrue(count($re) == 0, 'Expect: active banners == 0. cafe country code => ' . $cafe->countryCode);
    }
}
