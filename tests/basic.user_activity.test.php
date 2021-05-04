<?php

testPointSet();
testUserRegisterPoint();
testUserLoginPoint();


function testPointSet() {
    setLogin1stUser()->setPoint(500);
    isTrue(login()->getPoint() == 500, 'A point must be 500. but: ' . login()->getPoint());
}

function testUserRegisterPoint() {
    clearUserActivities();

    /// TEST register point
    act()->setRegister(1000);
    $user = generateUser();
    isTrue($user->getPoint() == act()->getRegister(), "user's register point: " . $user->getPoint());
}

function testUserLoginPoint() {
    clearUserActivities();

    $user = generateUser();
    act()->setLogin(333);
    $login = user()->login([EMAIL => $user->email, PASSWORD => '12345a']);

    isTrue($login->getPoint() == act()->getLogin(), "user's point: " . $login->getPoint());
}


function clearUserActivities()
{

    global $post1, $post2, $post3;

    db()->query('truncate ' . act()->getTable());
    db()->query('truncate ' . voteHistory()->getTable());


    act()->setRegister(0);
    act()->setLogin(0);
    act()->setLike(0);
    act()->setDislike(0);
    act()->setLikeDeduction(0);
    act()->setDislikeDeduction(0);

    act()->setLikeDailyLimitCount(0);
    act()->setLikeHourLimit(0);
    act()->setLikeHourLimitCount(0);

    // POINT is the test forum.
    if (category(POINT)->exists() == false) category()->create([ID => POINT]);

    act()->setPostCreate(category(POINT)->idx, 0);
    act()->setCommentCreate(category(POINT)->idx, 0);
    act()->setPostDelete(category(POINT)->idx, 0);
    act()->setCommentDelete(category(POINT)->idx, 0);
    act()->setCategoryDailyLimitCount(category(POINT)->idx, 0);
    act()->setCategoryHour(category(POINT)->idx, 0);
    act()->setCategoryHourLimitCount(category(POINT)->idx, 0);


    $post1 = post()->create([CATEGORY_ID => POINT, TITLE => TITLE, CONTENT => CONTENT]);
    $post2 = post()->create([CATEGORY_ID => POINT, TITLE => TITLE, CONTENT => CONTENT]);
    $post3 = post()->create([CATEGORY_ID => POINT, TITLE => TITLE, CONTENT => CONTENT]);


}