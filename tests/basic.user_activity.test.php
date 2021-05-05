<?php

if (category(POINT)->exists() == false) category()->create([ID => POINT]); // create POINT category if not exists.
db()->query('truncate ' . act()->getTable()); // empty table
db()->query('truncate ' . voteHistory()->getTable()); // emtpy table

//testUserPointSet();
//testPointSettings();
//testUserRegisterPoint();
//testUserLoginPoint();


testPointPostCreate();
testPointPostDelete();
testPointPostCreateAndDeleteByChangingCategories();




//testLikePoint();
//testDislikePoint();
//testDislikePointForMinusPoint();
//testVotePoints_likeAndLikeDeduction();
//testVotePoints_dislikeAndDislikeDeduction();
//
//testVoteAgainOnSamePost();
//testVoteOnComment();
//testVoteAgainOnSameComment();
//testVoteUntilPointBecomeZero();
//testVotePointNeverGoBelowZero();
//
//testVoteHourlyLimit();
//testVoteDailyLimit();
//testVoteLimit();
//testVoteLimitByChangingDate();
//






/// ##############


//testPointCommentCreate();
//testPointCommentDelete();
//testPointCommentCreateAndDeleteByChangingCategories();
//
//testPointPostCreateDailyLimit();
//testPointPostCreateHourlyLimit();
//testPointPostCreateDailyAndHourlyLimit();
//
//testPointCommentCreateDailyLimit();
//testPointCommentCreateHourlyLimit();
//testPointCommentCreateDailyAndHourlyLimit();




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
//
//    act()->setLikePoint(123);
//    $post2 = createPost()->like();
//    isTrue($user1->getPoint() == 0, 'The point must be 0 since the post belongs to the voter., but ' . $user1->getPoint());
//
//    $anotherUser = registerUser();
//    setLogin($anotherUser->idx);
//    $post2->like();
//    isTrue($anotherUser->getPoint() == 0, 'Another user registered, logged, voted. And the point of another user must be 0, but ' . $anotherUser->getPoint());
//
//    isTrue($user1->getPoint() == 123, 'user1 point must be 123, but ' . $user1->getPoint());
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


function testVotePoints_likeAndLikeDeduction() {

    resetPoints();
    act()->setLikePoint(10);
    act()->setLikeDeductionPoint(-5);

    $A = registerAndLogin();
    $aPost = createPost();
    isTrue($A->getPoint() == 0, "A point must be 0.");

    $B = registerAndLogin(); // @attention. B point is 0.
    isTrue($B->getPoint() == 0, "B point must be 0.");

    $aPost->like();
    isTrue($A->getPoint() == 10, "A point. 10");
    isTrue($B->getPoint() == 0, "B point to be 0"); // The deduction is -5. but point never goes below 0. So, it is still 0.

    $aPost->dislike();
    isTrue($A->getPoint() == 10, "A point. 10"); // Once vote for a post, point never changes.
    isTrue($B->getPoint() == 0, "B point to be 0");



    // Now, A point is 10. And B point is 0.

    $bPost = createPost(); // B logged in. So, B creates a post.
    setLogin($A->idx); // A logs in.
    $bPost->like(); // A like B's post. A's point shrinks to 5 since the deduction for like vote is -5.
    isTrue($A->getPoint() == 5, "A point to be 5." );
    isTrue($B->getPoint() == 10, "B point to be 10."); // B got 10 for like.

}

function testVotePoints_dislikeAndDislikeDeduction() {


    resetPoints();

    // prepare
    act()->setDislikePoint(-20);
    act()->setDislikeDeductionPoint(-50);

    $A = registerAndLogin();
    $aPost = createPost();
    $B = registerAndLogin();
    $bPost = createPost();

    $A->setPoint(130);
    $B->setPoint(130);

    // test
    loginAs($A);
    $bPost->dislike();
    isTrue($A->getPoint() == 80, "Deduction test. A point to be 80. But: " . $A->getPoint());
    isTrue($B->getPoint() == 110, "Deduction test. B point to be 110.");

    loginAs($B);
    $aPost->dislike();
    isTrue($A->getPoint() == 60, "Deduction test. A point to be 60. But: " . $A->getPoint());
    isTrue($B->getPoint() == 60, "Deduction test. B point to be 60.");

    $bPost2 = createPost();
    $bPost3 = createPost();

    loginAs($A);
    $bPost2->dislike();
    $bPost3->dislike();

    isTrue($A->getPoint() == 0, "Deduction test. A point to be 0");
    isTrue($B->getPoint() == 20, "Deduction test. A point to be 20");

}


function testVoteAgainOnSamePost() {

    resetPoints();

    act()->setLikePoint(20);
    act()->setLikeDeductionPoint(-5);

    $A = registerAndLogin();
    $post = createPost();

    $B = registerAndLogin();

    $post->like();
    isTrue($A->getPoint() == 20, "Got 20");

    $post->like();
    isTrue($A->getPoint() == 20, "Still be 20 since voting on same post");

}


function testVoteOnComment() {

}

function testVoteAgainOnSameComment() {

}
function testVoteUntilPointBecomeZero() {
    // vote until other user point become 0.

    // vote until my point become 0.
}

function testVotePointNeverGoBelowZero() {
    // vote to decrease point to check it does not go below 0.
}


function testVoteHourlyLimit() {

}
function testVoteDailyLimit() {

}
function testVoteLimit() {

}
function testVoteLimitByChangingDate() {

}


function testPointPostCreate() {

    resetPoints();

    // check point settings
    act()->setPostCreatePoint(POINT, 1000);
    act()->setPostDeletePoint(POINT, -1200);
    act()->setCommentCreatePoint(POINT, 200);
    act()->setCommentDeletePoint(POINT, -300);

    isTrue(act()->getPostCreatePoint(POINT) == 1000);
    isTrue(act()->getPostDeletePoint(POINT) == -1200);
    isTrue(act()->getCommentCreatePoint(POINT) == 200);
    isTrue(act()->getCommentDeletePoint(POINT) == -300);

    // login as A
    $A = registerAndLogin();

    // create post
    $post1 = post()->create([CATEGORY_ID => POINT]);
    isTrue(login()->getPoint() == 1000, 'A point must be 1000. but ' . login()->getPoint());
//    $post2 = post()->create([CATEGORY_ID => POINT]);
//    isTrue(login()->getPoint() == 2000, 'A point must be 2000. but ' . login()->getPoint());
//    // 게시글 삭제
//    $re = $post1->markDelete();
//    isTrue(login()->getPoint() == 800, 'A point must be 800. but ' . login()->getPoint());
//    $re = $post2->markDelete();
//    isTrue(login()->getPoint() == 0, 'A point must be 0. but ' . login()->getPoint());

}

function testPointPostDelete() {

}


function testPointPostCreateAndDeleteByChangingCategories() {

}
