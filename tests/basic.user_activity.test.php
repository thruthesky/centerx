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
testVotePoints_likeAndLikeDeduction();
testVotePoints_dislikeAndDislikeDeduction();

testVoteAgainOnSamePost();
testVoteLikeOnComment();
testVoteDislikeOnComment();

testVoteAgainOnSameComment();
testVoteUntilPointBecomeZero();


testVoteHourlyLimit();
testVoteDailyLimit();
testVoteLimitByChangingDate();



testPointPostCreate();
testPatchPoint();
testPointPostDelete();
testPointPostCreateAndDeleteByChangingCategories();


testPointPostCreateDailyLimit();
testPointPostCreateHourlyLimit();
testPointPostCreateChangeDates();
testPointPostCreateByPointPossession();





testCategoryLimitByDateChange();


/// ##############


//testPointCommentCreate();
//testPointCommentDelete();
//testPointCommentCreateAndDeleteByChangingCategories();
//

//

//testPointCommentCreateDailyLimit();
//testPointCommentCreateHourlyLimit();
//testPointCommentCreateByPointPossession.






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
    isTrue(act()->getPostCreatePoint(POINT) == 1000, 'getPostCreatePoint to be 1,000');


    act()->setPostDeletePoint(POINT, -1200);
    isTrue(act()->getPostDeletePoint(POINT) == -1200, 'getPostDeletePoint to be -1,200');

    act()->setCommentCreatePoint(POINT, 200);
    isTrue(act()->getCommentCreatePoint(POINT) == 200);

    act()->setCommentDeletePoint(POINT, -300);
    isTrue(act()->getCommentDeletePoint(POINT) == -300);

    act()->setLikePoint(100);
    isTrue(act()->getLikePoint() == 100);
    act()->setLikeDeductionPoint(-20);
    isTrue(act()->getLikeDeductionPoint() == -20);
    act()->setDislikePoint(-50);
    isTrue(act()->getDislikePoint() == -50);
    act()->setDislikeDeductionPoint(-30);
    isTrue(act()->getDislikeDeductionPoint() == -30);



    // check point settings
    act()->setPostCreatePoint(POINT, 1000);
    act()->setPostDeletePoint(POINT, -1200);
    act()->setCommentCreatePoint(POINT, 200);
    act()->setCommentDeletePoint(POINT, -300);

    isTrue(act()->getPostCreatePoint(POINT) == 1000);
    isTrue(act()->getPostDeletePoint(POINT) == -1200);
    isTrue(act()->getCommentCreatePoint(POINT) == 200);
    isTrue(act()->getCommentDeletePoint(POINT) == -300);


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
    createPost()->like();
    isTrue($user1->getPoint() == 0, 'Newly registered user point after vote should be 0, but ' . $user1->getPoint());
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

    $A = registerAndLogin(); // login A
    $post = createPost(); // create a post by A

    registerAndLogin(); // login another user

    $post->like();
    isTrue($A->getPoint() == 20, "Got 20");

    $post->like();
    isTrue($A->getPoint() == 20, "Still be 20 since voting on same post");

}


function testVoteLikeOnComment() {
    resetPoints();
    act()->setLikePoint(20);
    act()->setLikeDeductionPoint(-5);
    $A = registerAndLogin(); // login A
    $comment = createComment(); // create a comment by A
    $B = registerAndLogin(); // login B
    $comment->like();

    isTrue($A->getPoint() == 20, 'A got 20 by commenting');
    isTrue($B->getPoint() == 0, 'B got -5. But point cannot go below 0');
}

function testVoteDislikeOnComment() {
    resetPoints();
    act()->setDislikePoint(-20);
    act()->setDislikeDeductionPoint(-30);
    $A = registerAndLogin(); // login A
    $A->setPoint(100);
    $comment = createComment(); // create a comment by A

    $B = registerAndLogin(); // login B
    $B->setPoint(100);

    $comment->dislike();

    isTrue($A->getPoint() == 80, 'A got -20 by commenting');
    isTrue($B->getPoint() == 70, 'B got -30. But point cannot go below 0');

}


function testVoteAgainOnSameComment() {
    resetPoints();
    act()->setLikePoint(20);
    $A = registerAndLogin(); // login A
    $comment = createComment(); // create a comment by A

    registerAndLogin(); // login B
    $comment->like();

    isTrue($A->getPoint() == 20, 'A got 20 by commenting');

    $comment->like(); // like again
    isTrue($A->getPoint() == 20, 'Point does not change on voting again on same comment.');
}
function testVoteUntilPointBecomeZero() {

    resetPoints();
    act()->setDislikePoint(-80);
    act()->setDislikeDeductionPoint(-90);
    $A = registerAndLogin(); // login A
    $A->setPoint(100);
    $post = createComment();
    $comment = createComment(); // create a comment by A

    $B = registerAndLogin(); // login B
    $B->setPoint(100);

    $post->dislike();
    $comment->dislike();

    isTrue($A->getPoint() == 0, 'A point deducted more than he has.');
    isTrue($B->getPoint() == 0, 'B point became 0 sine the point was deducted more than he has.');
}



function testVoteHourlyLimit() {
    resetPoints();

    // prepare
    act()->setLikePoint(100);
    act()->setLikeDeductionPoint(-100);
    act()->setDislikePoint(-100);
    act()->setDislikeDeductionPoint(-100);

    $A = registerAndLogin();

    // test without limit
    $posts = [];
    for($i = 0; $i < 5; $i++) {
        $posts[] = createPost();
    }

    // See? There is no limit.
    $B = registerAndLogin();
    $B->setPoint(1000);
    foreach($posts as $post) {
        $post->like();
    }
    isTrue($A->getPoint() == 500, "Got 500");
    isTrue($B->getPoint() == 500, "Got -500");


    // Set limit. 4 times in 2 hours.
    act()->setLikeHourLimit(2);
    act()->setLikeHourLimitCount(4);

    $C = registerAndLogin();
    $C->setPoint(1000);
    foreach($posts as $post) {
        $post->like();
    }
    isTrue($A->getPoint() == 900, "Got another 400. Vote 5 times but last was not increase point.");
    isTrue($C->getPoint() == 600, "Got -400. One was voted without point deduction due to hourly limitation.");


}
function testVoteDailyLimit() {

    resetPoints();
    act()->setLikePoint(200);
    act()->setLikeDeductionPoint(-100);
    act()->setDislikePoint(-150);
    act()->setDislikeDeductionPoint(-50);


    $A = registerAndLogin()->setPoint(1000);
    $post1 = createPost();
    $post2 = createPost();
    $post3 = createPost();

    $B = registerAndLogin()->setPoint(1000);


    // Limit: 2 times a day.
    act()->setLikeDailyLimitCount(2);

    $post1->like();
    $post2->like();
    $post3->like();

    isTrue($A->getPoint() == 1400, 'A point should be 1400. but ' . $A->getPoint());
    isTrue($B->getPoint() == 800, 'B point should be 800. but ' . $B->getPoint());
}

function testVoteLimitByChangingDate() {

}


function testPointPostCreate() {
    resetPoints();

    // check point settings
    act()->setPostCreatePoint(POINT, 1000);

    // login as A
    $A = registerAndLogin();

    // create post
    $post1 = createPost();
    isTrue($post1->ok, "Post create must be okay. But: " . $post1->getError());
    isTrue($A->getPoint() == 1000, 'A point must be 1000. but ' . $A->getPoint());

    // create another post
    $post2 = post()->create([CATEGORY_ID => POINT]);
    isTrue(login()->getPoint() == 2000, 'A point must be 1000+1000 = 2000. but ' . login()->getPoint());

}

function testPatchPoint() {

    resetPoints();

    // check point settings
    act()->setPostCreatePoint(POINT, 321);

    // login as
    registerAndLogin();

    // create post
    $post1 = createPost();
    isTrue($post1->appliedPoint == 321, "AppliedPoint must be 321. But: " . $post1->getError());


    // change point settings
    act()->setPostCreatePoint(POINT, 222);
    $post2 = createPost();
    isTrue($post2->appliedPoint == 222, "AppliedPoint should be 222. But: " . $post1->getError());

}

function testPointPostDelete() {
    resetPoints();
    // check point settings
    act()->setPostDeletePoint(POINT, -444);
    // login as A
    $A = registerAndLogin();

    // create post
    $post1 = createPost();
    isTrue($post1->ok, "Post1 create must be okay. But: " . $post1->getError());
    $post2 = createPost();
    isTrue($post2->ok, "Post2 create must be okay. But: " . $post2->getError());

    $A->setPoint(500);
    // 게시글 삭제
    $re = $post1->markDelete();
    isTrue(login()->getPoint() == 56, 'A point must be 56. but ' . login()->getPoint());
    $re = $post2->markDelete();
    isTrue(login()->getPoint() == 0, 'A point must be 0. but ' . login()->getPoint());
}


function testPointPostCreateAndDeleteByChangingCategories() {
    resetPoints();


    // login as A
    $A = registerAndLogin();
    $A->setPoint(500);


    // check point settings
    act()->setPostCreatePoint(POINT, 1000);
    act()->setPostDeletePoint(POINT, -1250);

    // create post
    $post1 = createPost();
    isTrue($A->getPoint() == 1500, 'A point must be 1000. but ' . $A->getPoint());
    // create another post
    $post2 = createPost();
    isTrue(login()->getPoint() == 2500, 'A point must be 2500. but ' . login()->getPoint());


    $re = $post1->markDelete();
    isTrue(login()->getPoint() == 1250, 'A point must be 1250. but ' . login()->getPoint());
    $re = $post2->markDelete();
    isTrue(login()->getPoint() == 0, 'A point must be 0. but ' . login()->getPoint());


    // create post
    $post3 = createPost();
    isTrue($A->getPoint() == 1000, 'A point must be 1000. but ' . $A->getPoint());


    // set point settings
    act()->setPostDeletePoint(POINT, -800);
    $post3->update([CATEGORY_ID => CHOICE]);

    $re = $post3->markDelete();
    isTrue(login()->getPoint() == 200, 'A point must be 200. but ' . login()->getPoint());



}



function testCategoryLimitByDateChange() {
    resetPoints();
    act()->enableCategoryBanOnLimit(POINT);

    // 하루에 1번 제한
    act()->setCategoryDailyLimitCount(POINT, 1);

    $A = registerAndLogin();
    $post1 = createPost();
    isTrue($post1->ok, 'testChangeDate() -> post1 must success');

    // 제한 하므로 실패.
    act()->enableCategoryBanOnLimit(POINT);
    $post2 = createPost();
    isTrue($post2->hasError, 'testChangeDate() -> post2 must be error.');
    isTrue($post2->getError() == e()->daily_limit, 'testChangeDate() -> post2 must be error daily limit but::'. $post2->getError());

    // 마지막 추천 기록을 24시간 이전으로 돌림.
    act()->resetError();
    $beforeCheck = act()->last(POSTS, $post1->idx, Actions::$createPost);
    d($beforeCheck, "before check");
    $res = $beforeCheck->update([CREATED_AT => $beforeCheck->createdAt - (60 * 60 * 24)]);
    d($res, "after check");

//    $afterCheck = act()->last(POSTS, $post1->idx, Actions::$createPost);
//    d($beforeCheck->createdAt, $afterCheck->createdAt);
//    isTrue($beforeCheck->createdAt < $afterCheck->createdAt, 'created at must be backdate by a day');
//
//    // 그리고 다시 쓰기 성공.
//    $post3 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 3']);
//    d($post3);
//    isTrue($post3->ok && $post3->title == 'post 3', 'testChangeDate() -> post3 must be success.');
//
//    // 하지만 한번 더 쓰기하면 실패.
//    act()->enableCategoryBanOnLimit(POINT);
//    $post4 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 4']);
//    isTrue($post4->hasError, 'testChangeDate() -> post4 must be error.');
//    isTrue($post4->getError() == e()->daily_limit, 'post4 daily limit');
}
