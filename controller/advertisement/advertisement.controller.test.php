<?php

setLogout();

advertisementCRUD();
// advertisementFetch();


/**
 * @todo test - change dates after create banner and check days left.
 * @todo test - compare the point history.
 */
function advertisementCRUD()
{

    $now = new DateTime();

    $re = request("advertisement.edit");
    isTrue($re == e()->not_logged_in, "not logged in.");

    $user = registerAndLogin();
    $user->setPoint(10000);

    $re = request("advertisement.edit", [
        SESSION_ID => login()->sessionId
    ]);
    // Code (Banner type/place) is required.
    isTrue($re == e()->empty_code, "empty code (banner type/place).");

    $re = request("advertisement.edit", [
        SESSION_ID => login()->sessionId,
        CODE => TOP_BANNER,
        BEGIN_AT => $now->getTimestamp(),
        END_AT => $now->getTimestamp(),
    ]);

    // check point deduction for 1 day * 1000 (default TOP_BANNER).
    isTrue($user->getPoint() == 9000, "create TOP_BANNER for 1 day. deduct 1000 points to user.");

    // check if point deduction matches user activity record.
    $activity = userActivity()->last(taxonomy: POSTS, entity: $re[IDX], action: 'advertisement');
    isTrue($activity->toUserPointApply == -1000, "check if deducted point is recorded.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "check if recorded user activity point after match current user point.");

    // Both total advertisement point and point per day must be equal to 1000.
    isTrue($re['advertisementPoint'] == 1000, "create TOP_BANNER for 1 day. 'advertisementPoint' => 1000");
    isTrue($re['pointPerDay'] == 1000, "create TOP_BANNER for 1 day. 'pointPerDay' => 1000");

    // Error deleting active advertisement.
    $del = request("advertisement.delete", [ SESSION_ID => login()->sessionId, IDX => $re[IDX] ]);
    isTrue($del == e()->advertisement_is_active, "error deleting active advertisement.");

    $advToCancel = request("advertisement.edit", [
        SESSION_ID => login()->sessionId,
        CODE => SIDEBAR_BANNER,
        BEGIN_AT => strtotime("+3 days"),
        END_AT => strtotime("+1 week"),
    ]);

    // check point deduction for 5 days * 500 (default SIDEBAR_BANNER).
    isTrue($user->getPoint() == 6500, "create SIDEBAR_BANNER for 5 days. deduct 2500 points to user.");

    // check if point deduction matches user activity record.
    $activity = userActivity()->last(taxonomy: POSTS, entity: $advToCancel[IDX], action: 'advertisement');
    isTrue($activity->toUserPointApply == -2500, "check if deducted point is recorded.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "check if recorded user activity point after match current user point.");
    isTrue($advToCancel['advertisementPoint'] == 2500, "create SIDEBAR_BANNER for 5 days. 'advertisementPoint' => 2500");

    
    // Error cancelling advertisement without IDX.
    $re = request("advertisement.cancel", [ SESSION_ID => login()->sessionId ]);
    isTrue($re == e()->idx_is_empty, "advertisement IDX is empty.");

    // Advertisement cancellation.
    $re = request("advertisement.cancel", [ SESSION_ID => login()->sessionId, IDX => $advToCancel[IDX] ]);

    // Begin date and End date should be reset.
    isTrue($re[BEGIN_AT] == 0, "advertisement cancelled, begin date reset.");
    isTrue($re[END_AT] == 0, "advertisement cancelled, end date reset.");

    // User point will be refunded 100%
    isTrue($user->getPoint() == 9000, "advertisement cancelled, end date reset.");

    // Check if point is refunded to user (2500).
    // Check if user total point is changed (9000).
    $activity = userActivity()->last(taxonomy: POSTS, entity: $re[IDX], action: 'advertisement');
    isTrue($activity->toUserPointApply == 2500, "check if deducted point is recorded.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "check if recorded user activity point after match current user point.");

    $update = [
        SESSION_ID => login()->sessionId,
        CODE => SIDEBAR_BANNER,
        NAME => 'Advertisement' . time(),
        BEGIN_AT => strtotime("+1 days"),
        END_AT => strtotime("+1 week"),
        IDX => $advToCancel[IDX]
    ];

    // Edit cancelled advertisement to 6 days.
    $updatedAdv = request("advertisement.edit", $update);

    isTrue($updatedAdv[NAME] == $update[NAME], "Advertisement name updated.");
    isTrue($updatedAdv[BEGIN_AT] == $update[BEGIN_AT], "Begin date updated.");
    isTrue($updatedAdv[END_AT] == $update[END_AT], "Begin date updated.");

    // Total advertisement point must be equal to 3500.
    isTrue($updatedAdv['advertisementPoint'] == 3500, "create SIDEBAR_BANNER for 1 day. 'advertisementPoint' => 3500");
    
    // Compare updated user point (9000 - 3500).
    isTrue($user->getPoint() == 5500, "create SIDEBAR_BANNER for 5 days. deduct 2500 points to user.");

    // Check updated record.
    $activity = userActivity()->last(taxonomy: POSTS, entity: $advToCancel[IDX], action: 'advertisement');
    isTrue($activity->toUserPointApply == -3500, "check if deducted point is recorded.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "check if recorded user activity point after match current user point.");

    // // Advertisement to Refund 1 week duration. Begin date starting now (now is considered served).
    $advToRefund = request("advertisement.edit", [
        SESSION_ID => login()->sessionId,
        CODE => SIDEBAR_BANNER,
        BEGIN_AT => $now->getTimestamp(),
        END_AT => strtotime("+6 days"),
    ]);

    // check point deduction for 7 days (default SIDEBAR_BANNER: 5500 - (500 * 7) ).
    isTrue($user->getPoint() == 2000, "create SIDEBAR_BANNER for 7 days. deduct 3500 points to user.");
    isTrue($advToRefund['advertisementPoint'] == 3500, "create SIDEBAR_BANNER for 7 days. 'advertisementPoint' => 3500");
    
    // Check if point is deducted to user (3500).
    // Check if user total point is changed (5500).
    $activity = userActivity()->last(taxonomy: POSTS, entity: $advToRefund[IDX], action: 'advertisement');
    isTrue($activity->toUserPointApply == -3500, "check if deducted point is recorded.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "check if recorded user activity point after match current user point.");

    // Error refunding advertisement without IDX.
    $re = request("advertisement.refund", [ SESSION_ID => login()->sessionId ]);
    isTrue($re == e()->idx_is_empty, "advertisement IDX is empty.");

    // Refund advertisement.
    $re = request("advertisement.refund", [ SESSION_ID => login()->sessionId, IDX => $advToRefund[IDX] ]);

    // Begin date and End date should be reset.
    isTrue($re[BEGIN_AT] == 0, "advertisement refunded, begin date reset.");
    isTrue($re[END_AT] == 0, "advertisement refunded, end date reset.");

    // user point will be refunded with 5% deduction and -1 day served.
    // 3500 - 500 = 3000 (served day deducted).
    // 3000 * 5% = 150 (refund penalty).
    // 3000 - 150 = 2850 (Total refundable points).
    // 2000 + 2850 = 4850 (Current user points after refund).
    isTrue($user->getPoint() == 4850, "advertisement refunded. end date reset. 1 day and 5% deducted.");

    // check if refunded matcher user activity record, including the penalty.
    $activity = userActivity()->last(taxonomy: POSTS, entity: $advToRefund[IDX], action: 'advertisement');

    // Check if point is refunded to user (2850).
    // Check if user total point is changed (5350).
    isTrue($activity->toUserPointApply == 2850, "check if deducted point is recorded.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "check if recorded user activity point after match current user point.");
}


function advertisementFetch()
{


    $user = registerAndLogin();
    $user->setPoint(10000);

    $subcategory = 'xyz' . time();
    $editParams = [
        SUB_CATEGORY => $subcategory,
        SESSION_ID => login()->sessionId
    ];

    $searchParams = [
        CATEGORY_ID => 'advertisement',
        SUB_CATEGORY => $subcategory,
    ];

    $re = request("advertisement.edit", $editParams);

    // US 2 - 1 - top, 1 - sidebar, 2 - line
    $editParams[COUNTRY_CODE] = "US";
    $editParams[CODE] = TOP_BANNER;
    request("advertisement.edit", $editParams);
    $editParams[CODE] = SIDEBAR_BANNER;
    request("advertisement.edit", $editParams);
    $editParams[CODE] = LINE_BANNER;
    request("advertisement.edit", $editParams);
    request("advertisement.edit", $editParams);

    // PH 1 - top
    $editParams[COUNTRY_CODE] = "PH";
    $editParams[CODE] = TOP_BANNER;
    request("advertisement.edit", $editParams);

    $re = request("post.search", $searchParams);

    // Advertisement search with subcategory
    isTrue(count($re) == 4, "Should have 4 advertisement with category(subcategory) of " . $subcategory);

    $searchParams[COUNTRY_CODE] = "PH";
    $re = request("post.search", $searchParams);

    // Advertisement search with subcategory and PH country code.
    isTrue(count($re) == 1, "Should have 1 advertisement with category(subcategory) of " . $subcategory . " and PH country code");

    $searchParams[COUNTRY_CODE] = "US";
    $re = request("post.search", $searchParams);

    // Advertisement search with subcategory and US country code.
    isTrue(count($re) == 2, "Should have 2 advertisement with category(subcategory) of " . $subcategory . " and US country code");

    unset($searchParams[COUNTRY_CODE]);
    $searchParams[CODE] = TOP_BANNER;
    $re = request("post.search", $searchParams);
    isTrue(count($re) == 2, "Should have 2 advertisement with category(subcategory) of " . $subcategory . " and 'top' banner type/place(code)");

    $searchParams[CODE] = SIDEBAR_BANNER;
    $re = request("post.search", $searchParams);
    isTrue(count($re) == 1, "Should have 2 advertisement with category(subcategory) of " . $subcategory . " and 'sidebar' banner type/place(code)");

    $searchParams[CODE] = LINE_BANNER;
    $re = request("post.search", $searchParams);
    isTrue(count($re) == 2, "Should have 2 advertisement with category(subcategory) of " . $subcategory . " and 'line' banner type/place(code)");
}
