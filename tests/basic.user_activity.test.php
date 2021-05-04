<?php

if (category(POINT)->exists() == false) category()->create([ID => POINT]); // create POINT category if not exists.
db()->query('truncate ' . act()->getTable()); // empty table
db()->query('truncate ' . voteHistory()->getTable()); // emtpy table

testUserPointSet();
testPointSettings();
testUserRegisterPoint();
testUserLoginPoint();
testLikePoint();

function testUserPointSet() {
    resetPoints();
    setLogin1stUser()->setPoint(500);
    isTrue(login()->getPoint() == 500, 'A point must be 500. but: ' . login()->getPoint());
}

function testPointSettings() {
    resetPoints();
    act()->setPostCreatePoint(POINT, 1000);
    act()->setPostDeletePoint(POINT, -1200);
    act()->setCommentCreatePoint(POINT, 200);
    act()->setCommentDeletePoint(POINT, -300);

    isTrue(act()->getPostCreatePoint(POINT) == 1000);
    isTrue(act()->getPostDeletePoint(POINT) == -1200);
    isTrue(act()->getCommentCreatePoint(POINT) == 200);
    isTrue(act()->getCommentDeletePoint(POINT) == -300);

    act()->setLikePoint(100);
    isTrue(act()->getLikePoint() == 100);
    act()->setLikeDeductionPoint(-20);
    isTrue(act()->getLikeDeductionPoint() == -20);
    act()->setDislikePoint(-50);
    isTrue(act()->getDislikePoint() == -50);
    act()->setDislikeDeductionPoint(-30);
    isTrue(act()->getDislikeDeductionPoint() == -30);

}

function testUserRegisterPoint() {
    resetPoints();

    /// TEST register point
    act()->setRegisterPoint(1000);
    $user = registerUser();
    isTrue($user->getPoint() == act()->getRegisterPoint(), "user's register point: " . $user->getPoint());
}

function testUserLoginPoint() {
    resetPoints(); // set point to 0.
    $user = registerUser(); // register, but point is 0.

    act()->setLoginPoint(333); //
    $login = user()->login([EMAIL => $user->email, PASSWORD => '12345a']);
    isTrue($login->getPoint() == 333, "user's point: " . $login->getPoint());
}


function testLikePoint() {

    resetPoints();
    $user = registerUser();
    isTrue($user->getPoint() == 0, 'Newly registered user point must be 0.');

    createPost()->like();
    isTrue(login()->getPoint() == 0, 'Newly registered user point after vote should be 0, but ' . login()->getPoint());

    act()->setLikePoint(123);
    createPost()->like();
    isTrue(login()->getPoint() == 123, 'Like point is 123. and user point must be 123 after vote, but ' . login()->getPoint());

}

function resetPoints()
{

    act()->setRegisterPoint(0);
    act()->setLoginPoint(0);
    act()->setLikePoint(0);
    act()->setDislikePoint(0);
    act()->setLikeDeductionPoint(0);
    act()->setDislikeDeductionPoint(0);

    act()->setLikeDailyLimitCount(0);
    act()->setLikeHourLimit(0);
    act()->setLikeHourLimitCount(0);

    // POINT is the test forum.
    if (category(POINT)->exists() == false) category()->create([ID => POINT]);

    act()->setPostCreatePoint(category(POINT)->idx, 0);
    act()->setCommentCreatePoint(category(POINT)->idx, 0);
    act()->setPostDeletePoint(category(POINT)->idx, 0);
    act()->setCommentDeletePoint(category(POINT)->idx, 0);
    act()->setCategoryDailyLimitCount(category(POINT)->idx, 0);
    act()->setCategoryHour(category(POINT)->idx, 0);
    act()->setCategoryHourLimitCount(category(POINT)->idx, 0);

}