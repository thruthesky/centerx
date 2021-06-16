<?php

setLogout();

inputTest();
startStopTest();


function inputTest()
{

    $user = registerAndLogin();

    // test post.
    $post = request("post.create", [
        CATEGORY_ID => 'advertisement',
        SESSION_ID => $user->sessionId
    ]);

    $re = request("advertisement.start", [
        SESSION_ID => $user->sessionId,
        IDX => $post[IDX],
        CODE => TOP_BANNER,
        'beginDate' => time(),
        'endDate' => time(),
    ]);
    isTrue($re == e()->lack_of_point, "Expect: Error, user lacks point to create advertisement.");

    $user->setPoint(10000);

    $re = request("advertisement.start", [
        SESSION_ID => $user->sessionId,
        CODE => TOP_BANNER,
        'beginDate' => time(),
        'endDate' => time(),
    ]);
    isTrue($re == e()->idx_is_empty, "Expect: Error, empty advertisement IDX.");

    $re = request("advertisement.start", [
        SESSION_ID => $user->sessionId,
        IDX => $post[IDX],
        'beginDate' => time(),
        'endDate' => time(),
    ]);
    isTrue($re == e()->empty_code, "Expect: Error, empty advertisement code (banner type/place).");

    $re = request("advertisement.start", [
        SESSION_ID => $user->sessionId,
        IDX => $post[IDX],
        CODE => TOP_BANNER,
        'endDate' => time(),
    ]);
    isTrue($re == e()->empty_begin_date, "Expect: Error, empty advertisement begin date.");

    $re = request("advertisement.start", [
        SESSION_ID => $user->sessionId,
        IDX => $post[IDX],
        CODE => TOP_BANNER,
        'beginDate' => time(),
    ]);
    isTrue($re == e()->empty_end_date, "Expect: Error, empty advertisement end date.");
}

function startStopTest()
{

    $user = registerAndLogin();
    $user->setPoint(10000);

    // test post.
    $post = request("post.create", [
        CATEGORY_ID => 'advertisement',
        SESSION_ID => $user->sessionId
    ]);

    // Top banner for 1 day (Begin and end date set today, 1000 points).
    // 10000 -> 9000 user points.
    $re = request("advertisement.start", [
        SESSION_ID => $user->sessionId,
        IDX => $post[IDX],
        CODE => TOP_BANNER,
        'beginDate' => time(),
        'endDate' => time(),
    ]);

    isTrue($re['pointPerDay'] == 1000, "Expect: 'pointPerDay' should be equal to 1000.");
    isTrue($re['advertisementPoint'] == 1000, "Expect: 'advertisementPoint' should be equal to 1000.");

    isTrue($user->getPoint() == 9000, "Expect: user points decrease from 10000 to 9000.");
    $activity = userActivity()->last(taxonomy: POSTS, entity: $post[IDX], action: 'advertisement.start');
    isTrue($activity->toUserPointApply == -1000, "Expect: user activity record deduct 1000 points to user.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

    // No refund, all days is served.
    // 9000 -> 9000 user points.
    $re = request("advertisement.stop", [
        SESSION_ID => login()->sessionId,
        IDX => $post[IDX],
    ]);

    isTrue($re['advertisementPoint'] == 0, "Expect: 'advertisementPoint' should be equal to 1000.");

    isTrue($user->getPoint() == 9000, "Expect: user retains it points to 9000.");
    $activity = userActivity()->last(taxonomy: POSTS, entity: $post[IDX], action: 'advertisement.stop');
    isTrue($activity->toUserPointApply == 0, "Expect: user activity should not refund any points.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

    // Top banner for 4 days (4000 points).
    // 9000 -> 5000 user points.
    $re = request("advertisement.start", [
        SESSION_ID => $user->sessionId,
        IDX => $post[IDX],
        CODE => TOP_BANNER,
        'beginDate' => time(),
        'endDate' => strtotime('+3 days'),
    ]);

    isTrue($re['pointPerDay'] == 1000, "Expect: 'pointPerDay' should be equal to 1000.");
    isTrue($re['advertisementPoint'] == 4000, "Expect: 'advertisementPoint' should be equal to 4000.");

    isTrue($user->getPoint() == 5000, "Expect: decrease user points from 9000 to 5000.");
    $activity = userActivity()->last(taxonomy: POSTS, entity: $post[IDX], action: 'advertisement.start');
    isTrue($activity->toUserPointApply == -4000, "Expect: user activity record deducted 4000 points to user.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

    // Deducted 1 day served (1000). 3000 points refund.
    // 5000 => 8000 user points.
    request("advertisement.stop", [
        SESSION_ID => login()->sessionId,
        IDX => $post[IDX],
    ]);

    isTrue($user->getPoint() == 8000, "Expect: increase user points from 5000 to 8000.");
    $activity = userActivity()->last(taxonomy: POSTS, entity: $post[IDX], action: 'advertisement.stop');
    isTrue($activity->toUserPointApply == 3000, "Expect: user activity record refunded 3000 user points (1000 deducted/served).");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

    // Top banner for 2 days (2000 points).
    // 8000 -> 6000 user points.
    request("advertisement.start", [
        SESSION_ID => $user->sessionId,
        IDX => $post[IDX],
        CODE => TOP_BANNER,
        'beginDate' => strtotime('+2 days'),
        'endDate' => strtotime('+3 days'),
    ]);

    isTrue($user->getPoint() == 6000, "Expect: decrease user points from 8000 to 6000.");
    $activity = userActivity()->last(taxonomy: POSTS, entity: $post[IDX], action: 'advertisement.start');
    isTrue($activity->toUserPointApply == -2000, "Expect: user activity record deducted 2000 points to user.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

    // Full refund no days served (2000 points).
    // 6000 => 8000 user points.
    request("advertisement.stop", [
        SESSION_ID => login()->sessionId,
        IDX => $post[IDX],
    ]);

    isTrue($user->getPoint() == 8000, "Expect: increase user points from 6000 to 8000.");
    $activity = userActivity()->last(taxonomy: POSTS, entity: $post[IDX], action: 'advertisement.cancel');
    isTrue($activity->toUserPointApply == 2000, "Expect: user activity record refunded 2000 user points (no served days).");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

    // due advertisement
    // Expectation: nothing will be refunded to user point since it is already due.
    request("advertisement.start", [
        SESSION_ID => $user->sessionId,
        IDX => $post[IDX],
        CODE => TOP_BANNER,
        'beginDate' => strtotime('-1 day'),
        'endDate' => strtotime('-3 day'),
    ]);

    $user->setPoint(10);

    request("advertisement.stop", [
        SESSION_ID => $user->sessionId,
        IDX => $post[IDX],
    ]);

    isTrue($user->getPoint() == 10, "Expect: no refunds for due advertisements.");
    $activity = userActivity()->last(taxonomy: POSTS, entity: $post[IDX], action: 'advertisement.stop');
    isTrue($activity->toUserPointApply == 0, "Expect: user activity record 0 refund since advertisement is due.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

    $user->setPoint(10000);

    request("advertisement.start", [
        SESSION_ID => $user->sessionId,
        IDX => $post[IDX],
        CODE => TOP_BANNER,
        COUNTRY_CODE => 'PH',
        'beginDate' => time(),
        'endDate' => strtotime('+4 day'),
    ]);

    isTrue($user->getPoint() == 0, "Expect: decrease user points from 10000 to 0.");
    $activity = userActivity()->last(taxonomy: POSTS, entity: $post[IDX], action: 'advertisement.start');
    isTrue($activity->toUserPointApply == -10000, "Expect: user activity record 10000 deduction.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");


    request("advertisement.stop", [
        SESSION_ID => $user->sessionId,
        IDX => $post[IDX],
    ]);

    isTrue($user->getPoint() == 8000, "Expect: incrase user points from 0 to 8000.");
    $activity = userActivity()->last(taxonomy: POSTS, entity: $post[IDX], action: 'advertisement.stop');
    isTrue($activity->toUserPointApply == 8000, "Expect: user activity record 8000 refund.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

    $re = request("advertisement.start", [
        SESSION_ID => $user->sessionId,
        IDX => $post[IDX],
        CODE => TOP_BANNER,
        'beginDate' => time(),
        'endDate' => time(),
    ]);
    
    isTrue($user->getPoint() == 7000, "Expect: decrease user points from 8000 to 7000.");
    $activity = userActivity()->last(taxonomy: POSTS, entity: $post[IDX], action: 'advertisement.start');
    isTrue($activity->toUserPointApply == -1000, "Expect: user activity record 1000 deduction.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

    $re = request("advertisement.delete", [
        SESSION_ID => $user->sessionId,
        IDX => $post[IDX],
    ]);
    
    isTrue($re == e()->advertisement_is_active, "Expect: Error, can't delete active advertisement.");

    $re = request("advertisement.stop", [
        SESSION_ID => $user->sessionId,
        IDX => $post[IDX],
    ]);

    isTrue($user->getPoint() == 7000, "Expect: retains user points to 7000 (all days served).");
    $activity = userActivity()->last(taxonomy: POSTS, entity: $post[IDX], action: 'advertisement.stop');
    isTrue($activity->toUserPointApply == 0, "Expect: user activity record 0 refund.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

    $re = request("advertisement.delete", [
        SESSION_ID => $user->sessionId,
        IDX => $post[IDX],
    ]);

    isTrue($re[DELETED_AT] > 0, "Expect: Success deleting advertisement.");
    isTrue($re['advertisementPoint'] == 0, "Expect: 'advertisementPoint' should be equal to 0.");
}
