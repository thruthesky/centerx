<?php

setLogout();

$at = new AdvertisementTest();

$at->lackOfPoint();
$at->emptyIdx();
$at->emptyCode();
$at->beginDateEmpty();
$at->endDateEmpty();

$at->startDeduction();

$at->startWithPHCountryDeduction();

$at->stopNoRefund();
$at->stopExpiredNoRefund();

$at->stopWithDeductedRefund();
$at->stopWithPHCountryAndDeductedRefund();

$at->stopFullRefund();
$at->stopWithUSCountryFullRefund();

$at->errorDeleteActiveAdvertisement();
$at->deleteAdvertisement();

$at->startStopChangeDatesAndCountry();

$at->fetchWithCategoryCountryAndCode();

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
        return request("post.create", [
            CATEGORY_ID => 'advertisement',
            SESSION_ID => login()->sessionId
        ]);
    }

    private function createAndStartAdvertisement($options)
    {

        $post = request("post.create", [
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
        $post = request("post.create", [
            CATEGORY_ID => 'advertisement',
            SESSION_ID => login()->sessionId
        ]);

        $options = [
            SESSION_ID => login()->sessionId,
            IDX => $post[IDX],
            CODE => TOP_BANNER,
            'beginDate' => time(),
            'endDate' => time(),
        ];

        $re = request("advertisement.start", $options);
        isTrue($re == e()->lack_of_point, "Expect: Error, user lacks point to create advertisement.");
    }


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


    /**
     * 1 day * Top banner point (default)
     */
    function startDeduction()
    {
        $userPoint = 10000;
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
    }

    /**
     * 3 days * Top banner point (PH)
     */
    function startWithPHCountryDeduction()
    {
        $userPoint = 10000;
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
        $userPoint = 10000;
        $this->loginSetPoint($userPoint);
        $ad = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => time(), 'endDate' => time()]);
        
        $bp = advertisement()->topBannerPoint();
        $advPoint = $bp;
        $userPoint -= $advPoint;

        isTrue(login()->getPoint() == $userPoint, "Expect: user's points => $userPoint.");

        $ad = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        isTrue($ad['advertisementPoint'] == 0, "Expect: 'advertisementPoint' => 0.");

        isTrue(login()->getPoint() == $userPoint, "Expect: user's points => $userPoint.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.stop');
        isTrue($activity->toUserPointApply == 0, "Expect: activity->toUserPointApply == 0.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    /**
     * begin date - 8 days ago
     * end date - 3 days ago
     * 6 days * 1000 (Top banner - default)
     * 
     * No refund (expired advertisement)
     */
    function stopExpiredNoRefund()
    {
        $userPoint = 10000;
        $this->loginSetPoint($userPoint);
        $ad = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => strtotime('-8 days'), 'endDate' => strtotime('-3 days')]);
        
        $bp = advertisement()->topBannerPoint();
        $advPoint = $bp * 6;
        $userPoint -= $advPoint;

        isTrue(login()->getPoint() == $userPoint, "Expect: user's points => $userPoint.");

        $ad = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        isTrue(login()->getPoint() == $userPoint, "Expect: user's points => $userPoint.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.stop');
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
        $userPoint = 10000;
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
        $userPoint = 13000;
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

        $userPoint = 9000;
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

        $userPoint = 15000;
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
        $this->loginSetPoint(15000);
        $ad = $this->createAndStartAdvertisement([CODE => LINE_BANNER, 'beginDate' => time(), 'endDate' => time()]);

        $ad = request('advertisement.delete', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        isTrue($ad == e()->advertisement_is_active, "Expect: Error. Cannot delete active advertisement.");
    }

    /**
     * Deleting inactive advertisement.
     */
    function deleteAdvertisement()
    {
        $this->loginSetPoint(15000);
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
        $userPoint = 8000;
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

        isTrue($ad['advertisementPoint'] == 0, "Expect: 'advertisementPoint' == 0.");
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
        isTrue($newAd['advertisementPoint'] == 0, "Expect: 'advertisementPoint' == 0.");
        isTrue(login()->getPoint() == $userPoint, "Expect: user points == $userPoint.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $newAd[IDX], action: 'advertisement.stop');
        isTrue($activity->toUserPointApply == $refund, "Expect: activity->toUserPointApply == $refund.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    function fetchWithCategoryCountryAndCode()
    {
        $alpha = 'alpha' . time();
        $omega = 'omega' . time();
        $adOpts = [
            CODE => TOP_BANNER,
            'beginDate' => time(),
            'endDate' => time()
        ];

        $this->loginSetPoint(1000000);

        $adOpts[SUB_CATEGORY] = $alpha;
        $adOpts[COUNTRY_CODE] = "US";
        $adOpts[CODE] = TOP_BANNER;
        $this->createAndStartAdvertisement($adOpts); // a - us - top
        $this->createAndStartAdvertisement($adOpts); // a - us - top

        $adOpts[CODE] = SIDEBAR_BANNER;
        $this->createAndStartAdvertisement($adOpts); // a - us - side
        $this->createAndStartAdvertisement($adOpts); // a - us - side

        $adOpts[COUNTRY_CODE] = "PH";
        $this->createAndStartAdvertisement($adOpts); // a - ph - side
        $this->createAndStartAdvertisement($adOpts); // a - ph - side

        $adOpts[CODE] = LINE_BANNER;
        $this->createAndStartAdvertisement($adOpts); // a - ph - line

        $adOpts[SUB_CATEGORY] = $omega;
        $adOpts[CODE] = SQUARE_BANNER;
        $this->createAndStartAdvertisement($adOpts); // o - ph - square
        $this->createAndStartAdvertisement($adOpts); // o - ph - square

        $adOpts[COUNTRY_CODE] = "US";
        $this->createAndStartAdvertisement($adOpts); // o - us - square
        $this->createAndStartAdvertisement($adOpts); // o - us - square

        $adOpts[CODE] = SIDEBAR_BANNER;
        $this->createAndStartAdvertisement($adOpts); // o - us - side

        $adOpts[CODE] = TOP_BANNER;
        $this->createAndStartAdvertisement($adOpts); // o - us - top

        $adOpts[CODE] = LINE_BANNER;
        $this->createAndStartAdvertisement($adOpts); // o - us - line
        $this->createAndStartAdvertisement($adOpts); // o - us - line


        // --- fetch with category (subcategory) --- //
        // alpha
        $searchOpts[SUB_CATEGORY] = $alpha;
        $re = request("post.search", $searchOpts);
        isTrue(count($re) == 7, "Expect: 7 advertisement with " . $alpha . " category.");

        // omega
        $searchOpts[SUB_CATEGORY] = $omega;
        $re = request("post.search", $searchOpts);
        isTrue(count($re) == 8, "Expect: 8 advertisement with " . $omega . " category.");


        // --- fetch with category (subcategory) and country code. --- //
        // omega - PH
        $searchOpts[COUNTRY_CODE] = "PH";
        $re = request("post.search", $searchOpts);
        isTrue(count($re) == 2, "Expect: 2 advertisement with " . $omega . " category and PH country code");

        // omega - US
        $searchOpts[COUNTRY_CODE] = "US";
        $re = request("post.search", $searchOpts);
        isTrue(count($re) == 6, "Expect: 6 advertisement with " . $omega . " category and US country code");

        // alpha - US
        $searchOpts[SUB_CATEGORY] = $alpha;
        $re = request("post.search", $searchOpts);
        isTrue(count($re) == 4, "Expect: 4 advertisement with " . $omega . " category and US country code");

        // alpha - PH
        $searchOpts[COUNTRY_CODE] = "PH";
        $re = request("post.search", $searchOpts);
        isTrue(count($re) == 3, "Expect: 3 advertisement with " . $omega . " category and PH country code");

        unset($searchOpts[COUNTRY_CODE]);

        // --- fetch with category (subcategory) and banner type (code). --- //
        // alpha - top
        $searchOpts[CODE] = TOP_BANNER;
        $re = request("post.search", $searchOpts);
        isTrue(count($re) == 2, "Expect: 2 advertisement with " . $alpha . " category and top banner type.");

        // alpha - side
        $searchOpts[CODE] = SIDEBAR_BANNER;
        $re = request("post.search", $searchOpts);
        isTrue(count($re) == 4, "Expect: 4 advertisement with " . $alpha . " category and sidebar banner type.");

        // alpha - line
        $searchOpts[CODE] = LINE_BANNER;
        $re = request("post.search", $searchOpts);
        isTrue(count($re) == 1, "Expect: 1 advertisement with " . $alpha . " category and line banner type.");

        // alpha - square
        $searchOpts[CODE] = SQUARE_BANNER;
        $re = request("post.search", $searchOpts);
        isTrue(count($re) == 0, "Expect: 0 advertisement with " . $alpha . " category and square banner type.");

        // omega - square
        $searchOpts[SUB_CATEGORY] = $omega;
        $re = request("post.search", $searchOpts);
        isTrue(count($re) == 4, "Expect: 4 advertisement with " . $omega . " category and square banner type.");

        // omega - top
        $searchOpts[CODE] = TOP_BANNER;
        $re = request("post.search", $searchOpts);
        isTrue(count($re) == 1, "Expect: 1 advertisement with " . $omega . " category and top banner type.");

        // omega - side
        $searchOpts[CODE] = SIDEBAR_BANNER;
        $re = request("post.search", $searchOpts);
        isTrue(count($re) == 1, "Expect: 1 advertisement with " . $omega . " category and sidebar banner type.");

        // omega - line
        $searchOpts[CODE] = LINE_BANNER;
        $re = request("post.search", $searchOpts);
        isTrue(count($re) == 2, "Expect: 2 advertisement with " . $omega . " category and line banner type.");
    }
}
