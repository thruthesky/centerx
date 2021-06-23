<?php

// advertisementCRUDsetA();
// advertisementCRUDsetB();
// advertisementCRUDsetC();
// advertisementFetch();

// function advertisementCRUDsetA()
// {

//   $now = new DateTime();

//   $re = request("advertisement.edit");
//   isTrue($re == e()->not_logged_in, "not logged in.");

//   $user = registerAndLogin();
//   $user->setPoint(10000);

//   $re = request("advertisement.edit", [
//     SESSION_ID => login()->sessionId
//   ]);
//   // Code (Banner type/place) is required.
//   isTrue($re == e()->empty_code, "empty code (banner type/place).");

//   $re = request("advertisement.edit", [
//     SESSION_ID => login()->sessionId,
//     CODE => TOP_BANNER,
//     BEGIN_AT => $now->getTimestamp(),
//     END_AT => $now->getTimestamp(),
//   ]);

//   // check point deduction for 1 day * 1000 (default TOP_BANNER).
//   isTrue($user->getPoint() == 9000, "Expect: user points decrease from 10000 to 9000.");

//   // check if point deduction matches user activity record.
//   $activity = userActivity()->last(taxonomy: POSTS, entity: $re[IDX], action: 'advertisement');
//   isTrue($activity->toUserPointApply == -1000, "Expect: user activity record deduct 1000 points to user.");
//   isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

//   // Both total advertisement point and point per day must be equal to 1000.
//   isTrue($re['advertisementPoint'] == 1000, "Expect: 'advertisementPoint' => 1000");
//   isTrue($re['pointPerDay'] == 1000, "Expect: 'pointPerDay' => 1000");

//   // Error deleting active advertisement.
//   $del = request("advertisement.delete", [SESSION_ID => login()->sessionId, IDX => $re[IDX]]);
//   isTrue($del == e()->advertisement_is_active, "Expect: error deleting active advertisement.");

//   $advToCancel = request("advertisement.edit", [
//     SESSION_ID => login()->sessionId,
//     CODE => SIDEBAR_BANNER,
//     BEGIN_AT => strtotime("+3 days"),
//     END_AT => strtotime("+1 week"),
//   ]);

//   // check point deduction for 5 days * 500 (default SIDEBAR_BANNER).
//   isTrue($user->getPoint() == 6500, "Expect: user points decrease from 9000 to 6500");

//   // check if point deduction matches user activity record.
//   $activity = userActivity()->last(taxonomy: POSTS, entity: $advToCancel[IDX], action: 'advertisement');
//   isTrue($activity->toUserPointApply == -2500, "Expect: recorded user activity deducted 2500 points to user.");
//   isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: Expect: recorded user activity points equal current user points.");
//   isTrue($advToCancel['advertisementPoint'] == 2500, "Expect: 'advertisementPoint' => 2500");
//   isTrue($advToCancel['pointPerDay'] == 500, "Expect: 'pointPerDay' => 500");


//   // Error cancelling advertisement without IDX.
//   $re = request("advertisement.cancel", [SESSION_ID => login()->sessionId]);
//   isTrue($re == e()->idx_is_empty, "advertisement IDX is empty.");

//   // Advertisement cancellation.
//   $re = request("advertisement.cancel", [SESSION_ID => login()->sessionId, IDX => $advToCancel[IDX]]);

//   // Begin date and End date should be reset.
//   isTrue($re[BEGIN_AT] == 0, "advertisement cancelled, begin date reset.");
//   isTrue($re[END_AT] == 0, "advertisement cancelled, end date reset.");

//   // User point will be refunded 100%
//   isTrue($user->getPoint() == 9000, "Expect: user points increase from 6500 to 9000.");

//   // Check if point is refunded to user (2500).
//   // Check if user total point is changed (9000).
//   $activity = userActivity()->last(taxonomy: POSTS, entity: $re[IDX], action: 'advertisement');
//   isTrue($activity->toUserPointApply == 2500, "Expect: recorded user activity refunded 2500 points to user.");
//   isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

//   $update = [
//     SESSION_ID => login()->sessionId,
//     CODE => SIDEBAR_BANNER,
//     NAME => 'Advertisement' . time(),
//     BEGIN_AT => strtotime("+1 day"),
//     END_AT => strtotime("+1 week"),
//     IDX => $advToCancel[IDX]
//   ];

//   $updatedAdv = request("advertisement.edit", $update);

//   isTrue($updatedAdv[NAME] == $update[NAME], "Expect: Advertisement name updated to " . $update[NAME] . ".");
//   isTrue($updatedAdv[BEGIN_AT] == $update[BEGIN_AT], "Expect: Begin date updated to " . $update[BEGIN_AT] . ".");
//   isTrue($updatedAdv[END_AT] == $update[END_AT], "Expect: End date updated to " . $update[END_AT] . ".");

//   // Total advertisement point must be equal to 3500.
//   isTrue($updatedAdv['advertisementPoint'] == 3500, "Expect: 'advertisementPoint' changed from 2500 to 3500.");

//   // Compare updated user point (9000 - 3500).
//   isTrue($user->getPoint() == 5500, "Expect: user points decrease from 9000 to 5500.");

//   // Check updated record.
//   $activity = userActivity()->last(taxonomy: POSTS, entity: $advToCancel[IDX], action: 'advertisement');
//   isTrue($activity->toUserPointApply == -3500, "Expect: recorded user activity deducted 3500 points to user.");
//   isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

//   // Advertisement to Refund 1 week duration. Begin date starting now (now is considered served).
//   $advToRefund = request("advertisement.edit", [
//     SESSION_ID => login()->sessionId,
//     CODE => SIDEBAR_BANNER,
//     BEGIN_AT => $now->getTimestamp(),
//     END_AT => strtotime("+6 days"),
//   ]);

//   // check point deduction for 7 days (default SIDEBAR_BANNER: 5500 - (500 * 7) ).
//   isTrue($user->getPoint() == 2000, "Expect: user points decrease from 5500 to 2000.");
//   isTrue($advToRefund['advertisementPoint'] == 3500, "Expect. 'advertisementPoint' => 3500");
//   isTrue($advToRefund['pointPerDay'] == 500, "Expect. 'pointPerDay' => 500");

//   // Check if point is deducted to user (3500).
//   // Check if user total point is changed (5500).
//   $activity = userActivity()->last(taxonomy: POSTS, entity: $advToRefund[IDX], action: 'advertisement');
//   isTrue($activity->toUserPointApply == -3500, "Expect: recorded user activity deducted 3500 points to user.");
//   isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

//   // Error refunding advertisement without IDX.
//   $re = request("advertisement.refund", [SESSION_ID => login()->sessionId]);
//   isTrue($re == e()->idx_is_empty, "Expect: error, advertisement IDX is empty.");

//   // Refund advertisement.
//   $re = request("advertisement.refund", [SESSION_ID => login()->sessionId, IDX => $advToRefund[IDX]]);

//   // Begin date and End date should be reset.
//   isTrue($re[BEGIN_AT] == 0, "advertisement refunded, begin date reset.");
//   isTrue($re[END_AT] == 0, "advertisement refunded, end date reset.");

//   // user point will be refunded with 5% deduction and -1 day served.
//   // 3500 - 500 = 3000 (served day deducted).
//   // 3000 * 5% = 150 (refund penalty).
//   // 3000 - 150 = 2850 (Total refundable points).
//   // 2000 + 2850 = 4850 (Current user points after refund).
//   isTrue($user->getPoint() == 4850, "Expect: user points increased from 2000 to 4850.");

//   // check if refunded matcher user activity record, including the penalty.
//   $activity = userActivity()->last(taxonomy: POSTS, entity: $advToRefund[IDX], action: 'advertisement');

//   // Check if point is refunded to user (2850).
//   // Check if user total point is changed (5350).
//   isTrue($activity->toUserPointApply == 2850, "Expect: recorded user activity refunded 2850 points to user.");
//   isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

//   // Error deleting active advertisement.
//   $del = request("advertisement.delete", [SESSION_ID => login()->sessionId, IDX => $re[IDX]]);
//   isTrue($del[DELETED_AT] != 0, "Expect: refunded advertisement is deleted.");
// }

// function advertisementCRUDsetB()
// {

//   $now = new DateTime();
//   $user = registerAndLogin();
//   $user->setPoint(10000);

//   // CREATE
//   // Line banner (800) - PH
//   // 5 days
//   $re = request("advertisement.edit", [
//     SESSION_ID => login()->sessionId,
//     CODE => LINE_BANNER,
//     COUNTRY_CODE => "PH",
//     BEGIN_AT => strtotime('+2 days'),
//     END_AT => strtotime('+6 days'),
//   ]);

//   isTrue($user->getPoint() == 6000, "Expect: deduct 4000 points.");
//   isTrue($re['pointPerDay'] == 800, "Expect: 'pointPerDay' => 800");
//   isTrue($re['advertisementPoint'] == 4000, "Expect: 'advertisementPoint' => 4000");

//   $activity = userActivity()->last(taxonomy: POSTS, entity: $re[IDX], action: 'advertisement');
//   isTrue($activity->toUserPointApply == -4000, "Expect: activity deduct 4000 to user.");
//   isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

//   // CANCEL
//   $re = request("advertisement.cancel", [
//     SESSION_ID => login()->sessionId,
//     IDX => $re[IDX],
//   ]);

//   isTrue($user->getPoint() == 10000, "Expect: refund 4000 points.");
//   isTrue($re[BEGIN_AT] == 0, "Expect: reset begin date.");
//   isTrue($re[END_AT] == 0, "Expect: reset end date.");

//   $activity = userActivity()->last(taxonomy: POSTS, entity: $re[IDX], action: 'advertisement');
//   isTrue($activity->toUserPointApply == 4000, "Expect: activity refunded 4000 to user.");
//   isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");


//   // EDIT
//   // Square banner (1400) - US
//   // 6 days
//   $re = request("advertisement.edit", [
//     SESSION_ID => login()->sessionId,
//     CODE => SQUARE_BANNER,
//     COUNTRY_CODE => "US",
//     BEGIN_AT => $now->getTimeStamp(),
//     END_AT => strtotime('+5 days'),
//   ]);

//   isTrue($re[CODE] == SQUARE_BANNER, "Expect: Square banner type.");
//   isTrue($re[COUNTRY_CODE] == 'US', "Expect: US banner listing.");

//   isTrue($user->getPoint() == 1600, "Expect: deduct 8400 points.");
//   isTrue($re['pointPerDay'] == 1400, "Expect: 'pointPerDay' => 1400");
//   isTrue($re['advertisementPoint'] == 8400, "Expect: 'advertisementPoint' => 8400");

//   $activity = userActivity()->last(taxonomy: POSTS, entity: $re[IDX], action: 'advertisement');
//   isTrue($activity->toUserPointApply == -8400, "Expect: activity deduct 8600 to user.");
//   isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

//   // REFUND
//   // 6 days * 1400 = 8400
//   // 8400 - 1 day served (1400) = 7000
//   // 5% of 7000 = 350 penalty.
//   // Total refundable points: 7000 - 350 = 6650
//   // User point after refund: 1600 + 6650 = 8250
//   $re = request("advertisement.refund", [
//     SESSION_ID => login()->sessionId,
//     IDX => $re[IDX],
//   ]);

//   isTrue($user->getPoint() == 8250, "Expect: refund 6650 points.");
//   isTrue($re[BEGIN_AT] == 0, "Expect: reset begin date.");
//   isTrue($re[END_AT] == 0, "Expect: reset end date.");

//   $activity = userActivity()->last(taxonomy: POSTS, entity: $re[IDX], action: 'advertisement');
//   isTrue($activity->toUserPointApply == 6650, "Expect: activity refunded 6650 to user.");
//   isTrue($activity->toUserPointAfter == $user->getPoint(), "Expect: recorded user activity points equal current user points.");

//   // DELETE
//   $re = request("advertisement.delete", [SESSION_ID => login()->sessionId, IDX => $re[IDX]]);
//   isTrue($re[DELETED_AT] > 0, "Expect: refunded advertisement is deleted.");
// }

// /**
//  * Scenario
//  * 
//  * User creates advertisement which starts today and ends tomorrow.
//  * User updated advertisement name.
//  * 
//  * Expected: Upon updating, user points must not be deducted.
//  * Expected: Upon refunding, user point should not be changed since it is only 2 day advertisement.
//  */
// function advertisementCRUDsetC()
// {

//   $now = new DateTime();
//   $user = registerAndLogin();
//   $user->setPoint(4000);

//   $adName = 'adv-' . time();
//   $re = request("advertisement.edit", [
//     SESSION_ID => login()->sessionId,
//     CODE => TOP_BANNER,
//     BEGIN_AT => $now->getTimestamp(),
//     END_AT => strtotime('+1 day'),
//     NAME => $adName,
//   ]);

//   isTrue($user->getPoint() == 2000, "Expect: user points should be the same.");
//   isTrue($re[NAME] == $adName, "Expect: advertisement name equal to " . $adName);

//   $adName = 'up-adv-' . time();
//   $re = request("advertisement.edit", [
//     SESSION_ID => login()->sessionId,
//     CODE => TOP_BANNER,
//     IDX => $re[IDX],
//     NAME => $adName,
//   ]);

//   isTrue($user->getPoint() == 2000, "Expect: user points should be the same.");
//   isTrue($re[NAME] == $adName, "Expect: advertisement name updated to " . $adName);

//   $re = request("advertisement.refund", [
//     SESSION_ID => login()->sessionId,
//     IDX => $re[IDX],
//   ]);

//   isTrue($user->getPoint() == 2000, "Expect: user points should be the same.");
//   isTrue($re[END_AT] == 0, "Expect: End date should be reset.");
// }

// function advertisementFetch()
// {


//   $user = registerAndLogin();
//   $user->setPoint(10000);

//   $subcategory = 'xyz' . time();
//   $editParams = [
//     SUB_CATEGORY => $subcategory,
//     SESSION_ID => login()->sessionId
//   ];

//   $searchParams = [
//     CATEGORY_ID => 'advertisement',
//     SUB_CATEGORY => $subcategory,
//   ];

//   // Square
//   $editParams[CODE] = SQUARE_BANNER;
//   $re = request("advertisement.edit", $editParams);

//   // US 2 - 1 - top, 1 - sidebar, 2 - line
//   $editParams[COUNTRY_CODE] = "US";
//   $editParams[CODE] = TOP_BANNER;
//   request("advertisement.edit", $editParams);
//   $editParams[CODE] = SIDEBAR_BANNER;
//   request("advertisement.edit", $editParams);
//   $editParams[CODE] = LINE_BANNER;
//   request("advertisement.edit", $editParams);
//   request("advertisement.edit", $editParams);

//   // PH 1 - top
//   $editParams[COUNTRY_CODE] = "PH";
//   $editParams[CODE] = TOP_BANNER;
//   request("advertisement.edit", $editParams);

//   $re = request("post.search", $searchParams);

//   // Advertisement search with subcategory
//   isTrue(count($re) == 6, "Should have 6 advertisement with category(subcategory) of " . $subcategory);

//   $searchParams[COUNTRY_CODE] = "PH";
//   $re = request("post.search", $searchParams);

//   // Advertisement search with subcategory and PH country code.
//   isTrue(count($re) == 1, "Should have 1 advertisement with category(subcategory) of " . $subcategory . " and PH country code");

//   $searchParams[COUNTRY_CODE] = "US";
//   $re = request("post.search", $searchParams);

//   // Advertisement search with subcategory and US country code.
//   isTrue(count($re) == 4, "Should have 4 advertisement with category(subcategory) of " . $subcategory . " and US country code");

//   unset($searchParams[COUNTRY_CODE]);
//   $searchParams[CODE] = TOP_BANNER;
//   $re = request("post.search", [
//     CATEGORY_ID => 'advertisement',
//     SUB_CATEGORY => $subcategory,
//   ]);
//   isTrue(count($re) == 2, "Should have 2 advertisement with category(subcategory) of " . $subcategory . " and 'top' banner type/place(code)");

//   $searchParams[CODE] = SIDEBAR_BANNER;
//   $re = request("post.search", $searchParams);
//   isTrue(count($re) == 1, "Should have 2 advertisement with category(subcategory) of " . $subcategory . " and 'sidebar' banner type/place(code)");

//   $searchParams[CODE] = LINE_BANNER;
//   $re = request("post.search", $searchParams);
//   isTrue(count($re) == 2, "Should have 2 advertisement with category(subcategory) of " . $subcategory . " and 'line' banner type/place(code)");
// }




// ------------------------------ //


    // function fetchWithCategoryCountryAndCode()
    // {
    // $alpha = 'alpha' . time();
    // $omega = 'omega' . time();
    // $adOpts = [
    //     CODE => TOP_BANNER,
    //     'beginDate' => time(),
    //     'endDate' => time()
    // ];

    // $this->loginSetPoint(1000000);

    // $adOpts[SUB_CATEGORY] = $alpha;
    // $adOpts[COUNTRY_CODE] = "US";
    // $adOpts[CODE] = TOP_BANNER;
    // $this->createAndStartAdvertisement($adOpts); // a - us - top
    // $this->createAndStartAdvertisement($adOpts); // a - us - top

    // $adOpts[CODE] = SIDEBAR_BANNER;
    // $this->createAndStartAdvertisement($adOpts); // a - us - side
    // $this->createAndStartAdvertisement($adOpts); // a - us - side

    // $adOpts[COUNTRY_CODE] = "PH";
    // $this->createAndStartAdvertisement($adOpts); // a - ph - side
    // $this->createAndStartAdvertisement($adOpts); // a - ph - side

    // $adOpts[CODE] = LINE_BANNER;
    // $this->createAndStartAdvertisement($adOpts); // a - ph - line

    // $adOpts[SUB_CATEGORY] = $omega;
    // $adOpts[CODE] = SQUARE_BANNER;
    // $this->createAndStartAdvertisement($adOpts); // o - ph - square
    // $this->createAndStartAdvertisement($adOpts); // o - ph - square

    // $adOpts[COUNTRY_CODE] = "US";
    // $this->createAndStartAdvertisement($adOpts); // o - us - square
    // $this->createAndStartAdvertisement($adOpts); // o - us - square

    // $adOpts[CODE] = SIDEBAR_BANNER;
    // $this->createAndStartAdvertisement($adOpts); // o - us - side

    // $adOpts[CODE] = TOP_BANNER;
    // $this->createAndStartAdvertisement($adOpts); // o - us - top

    // $adOpts[CODE] = LINE_BANNER;
    // $this->createAndStartAdvertisement($adOpts); // o - us - line
    // $this->createAndStartAdvertisement($adOpts); // o - us - line


    // --- fetch with category (subcategory) --- //
    // alpha
    // $searchOpts[SUB_CATEGORY] = $alpha;
    // $re = request("advertisement.loadBanners", $searchOpts);
    // isTrue(count($re) == 7, "Expect: 7 advertisement with " . $alpha . " category.");

    // omega
    // $searchOpts[SUB_CATEGORY] = $omega;
    // $re = request("post.search", $searchOpts);
    // isTrue(count($re) == 8, "Expect: 8 advertisement with " . $omega . " category.");


    // // --- fetch with category (subcategory) and country code. --- //
    // // omega - PH
    // $searchOpts[COUNTRY_CODE] = "PH";
    // $re = request("post.search", $searchOpts);
    // isTrue(count($re) == 2, "Expect: 2 advertisement with " . $omega . " category and PH country code");

    // // omega - US
    // $searchOpts[COUNTRY_CODE] = "US";
    // $re = request("post.search", $searchOpts);
    // isTrue(count($re) == 6, "Expect: 6 advertisement with " . $omega . " category and US country code");

    // // alpha - US
    // $searchOpts[SUB_CATEGORY] = $alpha;
    // $re = request("post.search", $searchOpts);
    // isTrue(count($re) == 4, "Expect: 4 advertisement with " . $omega . " category and US country code");

    // // alpha - PH
    // $searchOpts[COUNTRY_CODE] = "PH";
    // $re = request("post.search", $searchOpts);
    // isTrue(count($re) == 3, "Expect: 3 advertisement with " . $omega . " category and PH country code");

    // unset($searchOpts[COUNTRY_CODE]);

    // // --- fetch with category (subcategory) and banner type (code). --- //
    // // alpha - top
    // $searchOpts[CODE] = TOP_BANNER;
    // $re = request("post.search", $searchOpts);
    // isTrue(count($re) == 2, "Expect: 2 advertisement with " . $alpha . " category and top banner type.");

    // // alpha - side
    // $searchOpts[CODE] = SIDEBAR_BANNER;
    // $re = request("post.search", $searchOpts);
    // isTrue(count($re) == 4, "Expect: 4 advertisement with " . $alpha . " category and sidebar banner type.");

    // // alpha - line
    // $searchOpts[CODE] = LINE_BANNER;
    // $re = request("post.search", $searchOpts);
    // isTrue(count($re) == 1, "Expect: 1 advertisement with " . $alpha . " category and line banner type.");

    // // alpha - square
    // $searchOpts[CODE] = SQUARE_BANNER;
    // $re = request("post.search", $searchOpts);
    // isTrue(count($re) == 0, "Expect: 0 advertisement with " . $alpha . " category and square banner type.");

    // // omega - square
    // $searchOpts[SUB_CATEGORY] = $omega;
    // $re = request("post.search", $searchOpts);
    // isTrue(count($re) == 4, "Expect: 4 advertisement with " . $omega . " category and square banner type.");

    // // omega - top
    // $searchOpts[CODE] = TOP_BANNER;
    // $re = request("post.search", $searchOpts);
    // isTrue(count($re) == 1, "Expect: 1 advertisement with " . $omega . " category and top banner type.");

    // // omega - side
    // $searchOpts[CODE] = SIDEBAR_BANNER;
    // $re = request("post.search", $searchOpts);
    // isTrue(count($re) == 1, "Expect: 1 advertisement with " . $omega . " category and sidebar banner type.");

    // // omega - line
    // $searchOpts[CODE] = LINE_BANNER;
    // $re = request("post.search", $searchOpts);
    // isTrue(count($re) == 2, "Expect: 2 advertisement with " . $omega . " category and line banner type.");
    // }