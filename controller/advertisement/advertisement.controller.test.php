<?php

setLogout();

$at = new AdvertisementTest();

$at->lackOfPoint();
$at->emptyIdx();
$at->emptyCode();
$at->beginDateEmpty();
$at->endDateEmpty();
$at->startDeduction();
$at->startDeductionWithPHCountry();
$at->stopNoRefund();
$at->stopExpiredNoRefund();
$at->stopWithDeductedRefund();
$at->stopFullRefund();
$at->errorDeleteActiveAdvertisement();
$at->deleteAdvertisement();

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
     * 1 day * 1000 (Top banner - default)
     */
    function startDeduction()
    {

        $this->loginSetPoint(10000);
        $ad = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => time(), 'endDate' => time()]);

        isTrue($ad['pointPerDay'] == 1000, "Expect: 'pointPerDay' == 1000.");
        isTrue($ad['advertisementPoint'] == 1000, "Expect: 'advertisementPoint' == 1000.");

        isTrue(login()->getPoint() == 9000, "Expect: user points == 9000.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.start');
        isTrue($activity->toUserPointApply == -1000, "Expect: activity->toUserPointApply == -1000.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    /**
     * 3 days * 2000 (Top banner - PH)
     */
    function startDeductionWithPHCountry()
    {

        $this->loginSetPoint(10000);
        $adOpts = [CODE => TOP_BANNER, COUNTRY_CODE => 'PH', 'beginDate' => time(), 'endDate' => strtotime('+2 day')];
        $ad = $this->createAndStartAdvertisement($adOpts);

        isTrue($ad['pointPerDay'] == 2000, "Expect: 'pointPerDay' == 2000.");
        isTrue($ad['advertisementPoint'] == 6000, "Expect: 'advertisementPoint' == 6000.");

        isTrue(login()->getPoint() == 4000, "Expect: user points == 4000.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.start');
        isTrue($activity->toUserPointApply == -6000, "Expect: activity->toUserPointApply == -6000.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    /**
     * begin date - today
     * end date - today
     * 1 day * 1000 (Top banner - default)
     * 
     * No refund (all days served)
     */
    function stopNoRefund()
    {
        $this->loginSetPoint(10000);
        $ad = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => time(), 'endDate' => time()]);
        
        isTrue(login()->getPoint() == 9000, "Expect: user's points => 9000.");

        $ad = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        isTrue($ad['advertisementPoint'] == 0, "Expect: 'advertisementPoint' => 0.");

        isTrue(login()->getPoint() == 9000, "Expect: user's points => 9000.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.stop');
        isTrue($activity->toUserPointApply == 0, "Expect: activity->toUserPointApply == 0.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }

    /**
     * begin date - 8 days ago
     * end date - 3 days ago
     * 5 days * 1000 (Top banner - default)
     * 
     * No refund (expired advertisement)
     */
    function stopExpiredNoRefund()
    {
        $this->loginSetPoint(10000);
        $ad = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => strtotime('-8 days'), 'endDate' => strtotime('-3 days')]);

        isTrue(login()->getPoint() == 4000, "Expect: user's points => 4000.");

        $ad = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        isTrue(login()->getPoint() == 4000, "Expect: user's points => 4000.");

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
        $this->loginSetPoint(10000);
        $ad = $this->createAndStartAdvertisement([CODE => TOP_BANNER, 'beginDate' => strtotime('-2 days'), 'endDate' => strtotime('+3 days')]);

        isTrue(login()->getPoint() == 4000, "Expect: user points == 4000.");

        $ad = request("advertisement.stop", [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        isTrue(login()->getPoint() == 7000, "Expect: user points == 7000.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.stop');
        isTrue($activity->toUserPointApply == 3000, "Expect: activity->toUserPointApply == 3000.");
        isTrue($activity->toUserPointAfter == login()->getPoint(), "Expect: activity->toUserPointAfter == user's points.");
    }


    /**
     * begin date - 3 days in future
     * end date - 11 days in future
     * 9 days * 1200 (Line banner - US)
     * 
     * Cancel (full refund)
     */
    function stopFullRefund()
    {

        $this->loginSetPoint(15000);
        $ad = $this->createAndStartAdvertisement([
            CODE => LINE_BANNER,
            COUNTRY_CODE => 'US',
            'beginDate' => strtotime('+3 days'),
            'endDate' => strtotime('+1 week 4 days')
        ]);

        isTrue(login()->getPoint() == 4200, "Expect: user's points => 4200.");

        $ad = request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        isTrue(login()->getPoint() == 15000, "Expect: user's points => 15000.");

        $activity = userActivity()->last(taxonomy: POSTS, entity: $ad[IDX], action: 'advertisement.cancel');
        isTrue($activity->toUserPointApply == 10800, "Expect: activity->toUserPointApply == 0.");
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
        $ad = $this->createAndStartAdvertisement([ CODE => LINE_BANNER, 'beginDate' => time(), 'endDate' => time() ]);

        request('advertisement.stop', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);
        $ad = request('advertisement.delete', [SESSION_ID => login()->sessionId, IDX => $ad[IDX]]);

        isTrue($ad[DELETED_AT] > 0, "Expect: Success. Inactive advertisement deleted..");
    }
}
