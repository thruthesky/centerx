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
    isTrue($user->getPoint() == 9000, "Expect: user points decrease from 10000 to 9000.");

    // check if point deduction matches user activity record.
    $activity = userActivity()->last(taxonomy: POSTS, entity: $re[IDX], action: 'advertisement');
    isTrue($activity->toUserPointApply == -1000, "Expect: user activity record deduct 1000 points to user.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

    // Both total advertisement point and point per day must be equal to 1000.
    isTrue($re['advertisementPoint'] == 1000, "Expect: 'advertisementPoint' => 1000");
    isTrue($re['pointPerDay'] == 1000, "Expect: 'pointPerDay' => 1000");

    // Error deleting active advertisement.
    $del = request("advertisement.delete", [ SESSION_ID => login()->sessionId, IDX => $re[IDX] ]);
    isTrue($del == e()->advertisement_is_active, "Expect: error deleting active advertisement.");

    $advToCancel = request("advertisement.edit", [
        SESSION_ID => login()->sessionId,
        CODE => SIDEBAR_BANNER,
        BEGIN_AT => strtotime("+3 days"),
        END_AT => strtotime("+1 week"),
    ]);

    // check point deduction for 5 days * 500 (default SIDEBAR_BANNER).
    isTrue($user->getPoint() == 6500, "Expect: user points decrease from 9000 to 6500");

    // check if point deduction matches user activity record.
    $activity = userActivity()->last(taxonomy: POSTS, entity: $advToCancel[IDX], action: 'advertisement');
    isTrue($activity->toUserPointApply == -2500, "Expect: recorded user activity deducted 2500 points to user.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: Expect: recorded user activity points equal current user points.");
    isTrue($advToCancel['advertisementPoint'] == 2500, "Expect: 'advertisementPoint' => 2500");
    isTrue($advToCancel['pointPerDay'] == 500, "Expect: 'pointPerDay' => 500");

    
    // Error cancelling advertisement without IDX.
    $re = request("advertisement.cancel", [ SESSION_ID => login()->sessionId ]);
    isTrue($re == e()->idx_is_empty, "advertisement IDX is empty.");

    // Advertisement cancellation.
    $re = request("advertisement.cancel", [ SESSION_ID => login()->sessionId, IDX => $advToCancel[IDX] ]);

    // Begin date and End date should be reset.
    isTrue($re[BEGIN_AT] == 0, "advertisement cancelled, begin date reset.");
    isTrue($re[END_AT] == 0, "advertisement cancelled, end date reset.");

    // User point will be refunded 100%
    isTrue($user->getPoint() == 9000, "Expect: user points increase from 6500 to 9000.");

    // Check if point is refunded to user (2500).
    // Check if user total point is changed (9000).
    $activity = userActivity()->last(taxonomy: POSTS, entity: $re[IDX], action: 'advertisement');
    isTrue($activity->toUserPointApply == 2500, "Expect: recorded user activity refunded 2500 points to user.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

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

    isTrue($updatedAdv[NAME] == $update[NAME], "Expect: Advertisement name updated to " . $update[NAME] . ".");
    isTrue($updatedAdv[BEGIN_AT] == $update[BEGIN_AT], "Expect: Begin date updated to " . $update[BEGIN_AT] . ".");
    isTrue($updatedAdv[END_AT] == $update[END_AT], "Expect: End date updated to " . $update[END_AT] . ".");

    // Total advertisement point must be equal to 3500.
    isTrue($updatedAdv['advertisementPoint'] == 3500, "Expect: 'advertisementPoint' changed from 2500 to 3500.");
    
    // Compare updated user point (9000 - 3500).
    isTrue($user->getPoint() == 5500, "Expect: user points decrease from 9000 to 5500.");

    // Check updated record.
    $activity = userActivity()->last(taxonomy: POSTS, entity: $advToCancel[IDX], action: 'advertisement');
    isTrue($activity->toUserPointApply == -3500, "Expect: recorded user activity deducted 3500 points to user.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

    // Advertisement to Refund 1 week duration. Begin date starting now (now is considered served).
    $advToRefund = request("advertisement.edit", [
        SESSION_ID => login()->sessionId,
        CODE => SIDEBAR_BANNER,
        BEGIN_AT => $now->getTimestamp(),
        END_AT => strtotime("+6 days"),
    ]);

    // check point deduction for 7 days (default SIDEBAR_BANNER: 5500 - (500 * 7) ).
    isTrue($user->getPoint() == 2000, "Expect: user points decrease from 5500 to 2000.");
    isTrue($advToRefund['advertisementPoint'] == 3500, "Expect. 'advertisementPoint' => 3500");
    isTrue($advToRefund['pointPerDay'] == 500, "Expect. 'pointPerDay' => 500");
    
    // Check if point is deducted to user (3500).
    // Check if user total point is changed (5500).
    $activity = userActivity()->last(taxonomy: POSTS, entity: $advToRefund[IDX], action: 'advertisement');
    isTrue($activity->toUserPointApply == -3500, "Expect: recorded user activity deducted 3500 points to user.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

    // Error refunding advertisement without IDX.
    $re = request("advertisement.refund", [ SESSION_ID => login()->sessionId ]);
    isTrue($re == e()->idx_is_empty, "Expect: error, advertisement IDX is empty.");

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
    isTrue($user->getPoint() == 4850, "Expect: user points increased from 2000 to 4850.");

    // check if refunded matcher user activity record, including the penalty.
    $activity = userActivity()->last(taxonomy: POSTS, entity: $advToRefund[IDX], action: 'advertisement');

    // Check if point is refunded to user (2850).
    // Check if user total point is changed (5350).
    isTrue($activity->toUserPointApply == 2850, "Expect: recorded user activity refunded 2850 points to user.");
    isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

    // Error deleting active advertisement.
    $del = request("advertisement.delete", [ SESSION_ID => login()->sessionId, IDX => $re[IDX] ]);
    isTrue($del[DELETED_AT] != 0, "Expect: refunded advertisement is deleted.");
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
