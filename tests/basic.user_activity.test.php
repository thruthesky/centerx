<?php

if (category(POINT)->exists() == false) category()->create([ID => POINT]); // create POINT category if not exists.
db()->query('truncate ' . act()->getTable()); // empty table
db()->query('truncate ' . voteHistory()->getTable()); // emtpy table

testUserPointSet();
testPointSettings();
testUserRegisterPoint();
testUserLoginPoint();
testLikePoint();
testDislikePoint();
testDislikePointForMinusPoint();


function testUserPointSet() {
    resetPoints();
    $user = registerUser()->setPoint(500);
    isTrue($user->getPoint() == 500, 'A point must be 500. but: ' . $user->getPoint());
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
    $user1 = registerUser();
    isTrue($user1->getPoint() == 0, 'Newly registered user point must be 0.');

    setLogin($user1->idx);
    $post1 = createPost()->like();
    isTrue($user1->getPoint() == 0, 'Newly registered user point after vote should be 0, but ' . $user1->getPoint());

    act()->setLikePoint(123);
    $post2 = createPost()->like();
    isTrue($user1->getPoint() == 0, 'The point must be 0 since the post belongs to the voter., but ' . $user1->getPoint());

    $anotherUser = registerUser();
    setLogin($anotherUser->idx);
    $post2->like();
    isTrue($anotherUser->getPoint() == 0, 'Another user registered, logged, voted. And the point of another user must be 0, but ' . $anotherUser->getPoint());

    isTrue($user1->getPoint() == 123, 'user1 point must be 123, but ' . $user1->getPoint());
}

function testDislikePoint() {
    resetPoints();
    $A = registerAndLogin(); // login A
    act()->setDislikePoint(111); // set dislike point.
    $post1 = createPost(); // create a post.
    registerAndLogin(); // login to another user.
    $post1->dislike(); // dislike A's post.
    // So, A gets 111.
    isTrue($A->getPoint() == 111, "User post was disliked. post must be 111, but" . $A->getPoint());
}

function testDislikePointForMinusPoint() {
    resetPoints();
    $A = registerAndLogin();
    $A->setPoint(100);
    act()->setDislikePoint(-33);
    $post = createPost();

    registerAndLogin();
    $post->dislike();

    // So, A get -33. And he has 77 point left.
    isTrue($A->getPoint() == 67, "User post was disliked. post must be 111, but: " . $A->getPoint());
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