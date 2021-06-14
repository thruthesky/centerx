<?php

setLogout();

// advertisementCRUD();
advertisementFetch();


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
    // check if right category
    isTrue(category($re[CATEGORY_IDX])->id == 'advertisement', "create TOP_BANNER for 1 day. deduct 1000 points to user.");

    $advToCancel = request("advertisement.edit", [
        SESSION_ID => login()->sessionId,
        CODE => SIDEBAR_BANNER,
        BEGIN_AT => strtotime("+3 days"),
        END_AT => strtotime("+1 week"),
    ]);
    // check point deduction for 5 days * 500 (default SIDEBAR_BANNER).
    isTrue($user->getPoint() == 6500, "create SIDEBAR_BANNER for 5 days. deduct 2500 points to user.");

    $re = request("advertisement.cancel", [
        SESSION_ID => login()->sessionId,
    ]);
    // error no advertisement IDX
    isTrue($re == e()->idx_is_empty, "advertisement IDX is empty.");

    $re = request("advertisement.cancel", [
        SESSION_ID => login()->sessionId,
        IDX => $advToCancel[IDX],
    ]);
    // Begin date and End date should be reset.
    isTrue($re[BEGIN_AT] == 0, "advertisement cancelled, begin date reset.");
    isTrue($re[END_AT] == 0, "advertisement cancelled, end date reset.");

    // user point will be refunded 100%
    isTrue($user->getPoint() == 9000, "advertisement cancelled, end date reset.");

    $advToRefund = request("advertisement.edit", [
        SESSION_ID => login()->sessionId,
        CODE => SIDEBAR_BANNER,
        BEGIN_AT => $now->getTimestamp(),
        END_AT => strtotime("+6 days"),
    ]);

    // check point deduction for 7 days * 500 (default SIDEBAR_BANNER).
    isTrue($user->getPoint() == 5500, "create SIDEBAR_BANNER for 7 days. deduct 3500 points to user.");

    $re = request("advertisement.refund", [
        SESSION_ID => login()->sessionId,
    ]);
    // error no advertisement IDX
    isTrue($re == e()->idx_is_empty, "advertisement IDX is empty.");

    $re = request("advertisement.refund", [
        SESSION_ID => login()->sessionId,
        IDX => $advToRefund[IDX],
    ]);
    // Begin date and End date should be reset.
    isTrue($re[BEGIN_AT] == 0, "advertisement refunded, begin date reset.");
    isTrue($re[END_AT] == 0, "advertisement refunded, end date reset.");

    // user point will be refunded with 5% deduction and -1 day served.
    // 3500 - 500 = 3000 (served day deducted).
    // 3000 * 5% = 150 (refund penalty).
    // 3000 - 150 = 2850 (Total refundable points).
    // 5500 + 2850 = 8350 (Current user points after refund).
    isTrue($user->getPoint() == 8350, "advertisement refunded. end date reset. 1 day and 5% deducted.");
}


function advertisementFetch()
{


    $user = registerAndLogin();
    $user->setPoint(10000);

    $subcategory = 'xyz' . time();
    $editParams = [
        SUB_CATEGORY => $subcategory,
        CODE => SIDEBAR_BANNER,
        SESSION_ID => login()->sessionId
    ];

    $searchParams = [
        CATEGORY_ID => 'advertisement',
        SUB_CATEGORY => $subcategory,
    ];

    $re = request("advertisement.edit", $editParams);

    $params[COUNTRY_CODE] = "US";
    request("advertisement.edit", $editParams);
    request("advertisement.edit", $editParams);

    $params[COUNTRY_CODE] = "PH";
    request("advertisement.edit", $editParams);


    $re = request("post.search", $searchParams);

    // Advertisement search with subcategory
    isTrue(count($re) == 4, "Should have 4 advertisement with category(subcategory) of " . $subcategory);

    $searchParams[COUNTRY_CODE] = "PH";
    $re = request("post.search", $searchParams);
    // d($re);

    // Advertisement search with subcategory and PH country code.
    isTrue(count($re) == 1, "Should have 1 advertisement with category(subcategory) of " . $subcategory . " with PH country code");

    // $searchParams[COUNTRY_CODE] = "US";
    // $re = request("post.search", $searchParams);
    // // Advertisement search with subcategory and US country code.
    // isTrue(count($re) == 2, "Should have 2 advertisement with category(subcategory) of " . $subcategory . " with US country code");
}
