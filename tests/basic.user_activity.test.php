<?php



if (category(POINT)->exists() == false) category()->create([ID => POINT]); // create POINT category if not exists.
db()->query('truncate ' . userActivity()->getTable()); // empty table
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
testCategoryLimitByDateChange();


testPointCommentCreate();
testCommentPatchPoint();
testPointCommentDelete();

testPointCommentCreateDailyLimit();
testPointCommentCreateHourlyLimit();


testPointPostCreateLimitByPointPossession();
testPointCommentCreateLimitByPointPossession();
testPointReadLimitByPointPossession();








// Set limit. 7 times in 6 hours. and 5 times in a day.
function setVotePointsForTest($hour_count = 7, $hour_limit = 6, $daily_count = 5) {

    userActivity()->setVoteHourLimit($hour_limit);
    userActivity()->setVoteHourLimitCount($hour_count);
    userActivity()->setVoteDailyCount($daily_count);

}


function setCreatePointsForTest($categoryIdx, $hour_limit_count = 7, $hour_limit = 6, $daily_count = 5) {

    userActivity()->setCreateDailyLimitCount($categoryIdx, $daily_count);
    userActivity()->setCreateHourLimit($categoryIdx, $hour_limit);
    userActivity()->setCreateHourLimitCount($categoryIdx, $hour_limit_count);
}


function resetPoints()
{

    userActivity()->setRegisterPoint(0);
    userActivity()->setLoginPoint(0);
    userActivity()->setLikePoint(0);
    userActivity()->setDislikePoint(0);
    userActivity()->setLikeDeductionPoint(0);
    userActivity()->setDislikeDeductionPoint(0);

    userActivity()->setVoteDailyCount(0);
    userActivity()->setVoteHourLimit(0);
    userActivity()->setVoteHourLimitCount(0);

    // POINT is the test forum.
    if (category(POINT)->exists() == false) category()->create([ID => POINT]);

    userActivity()->setPostCreatePoint(category(POINT)->idx, 0);
    userActivity()->setCommentCreatePoint(category(POINT)->idx, 0);
    userActivity()->setPostDeletePoint(category(POINT)->idx, 0);
    userActivity()->setCommentDeletePoint(category(POINT)->idx, 0);
    userActivity()->setCreateDailyLimitCount(category(POINT)->idx, 0);
    userActivity()->setCreateHourLimit(category(POINT)->idx, 0);
    userActivity()->setCreateHourLimitCount(category(POINT)->idx, 0);

    userActivity()->disableBanCreateOnLimit(POINT);


    userActivity()->setPostCreateLimitPoint(POINT, 0);
    userActivity()->setCommentCreateLimitPoint(POINT, 0);
    userActivity()->setReadLimitPoint(POINT, 0);
}


function testUserPointSet() {
    resetPoints();
    $user = registerUser()->setPoint(500);
    isTrue($user->getPoint() == 500, 'A point must be 500. but: ' . $user->getPoint());
}


function testPointSettings() {
    resetPoints();
    userActivity()->setPostCreatePoint(POINT, 1000);
    isTrue(userActivity()->getPostCreatePoint(POINT) == 1000, 'getPostCreatePoint to be 1,000');

    userActivity()->setPostDeletePoint(POINT, -1200);
    isTrue(userActivity()->getPostDeletePoint(POINT) == -1200, 'getPostDeletePoint to be -1,200');

    userActivity()->setCommentCreatePoint(POINT, 200);
    isTrue(userActivity()->getCommentCreatePoint(POINT) == 200);

    userActivity()->setCommentDeletePoint(POINT, -300);
    isTrue(userActivity()->getCommentDeletePoint(POINT) == -300);

    userActivity()->setLikePoint(100);
    isTrue(userActivity()->getLikePoint() == 100);
    userActivity()->setLikeDeductionPoint(-20);
    isTrue(userActivity()->getLikeDeductionPoint() == -20);
    userActivity()->setDislikePoint(-50);
    isTrue(userActivity()->getDislikePoint() == -50);
    userActivity()->setDislikeDeductionPoint(-30);
    isTrue(userActivity()->getDislikeDeductionPoint() == -30);



    // check point settings
    userActivity()->setPostCreatePoint(POINT, 1000);
    userActivity()->setPostDeletePoint(POINT, -1200);
    userActivity()->setCommentCreatePoint(POINT, 200);
    userActivity()->setCommentDeletePoint(POINT, -300);

    isTrue(userActivity()->getPostCreatePoint(POINT) == 1000);
    isTrue(userActivity()->getPostDeletePoint(POINT) == -1200);
    isTrue(userActivity()->getCommentCreatePoint(POINT) == 200);
    isTrue(userActivity()->getCommentDeletePoint(POINT) == -300);





}

function testUserRegisterPoint() {
    resetPoints();

    /// TEST register point
    userActivity()->setRegisterPoint(1000);
    $user = registerUser();
    isTrue($user->getPoint() == userActivity()->getRegisterPoint(), "user's register point: " . $user->getPoint());
}

function testUserLoginPoint() {
    resetPoints(); // set point to 0.
    $user = registerUser(); // register, but point is 0.

    userActivity()->setLoginPoint(333); //
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

    /// expect: test failure due to no point settings.
    $A = registerAndLogin(); // login A
    userActivity()->setDislikePoint(111); // set dislike point.
    $post1 = createPost(); // create a post.
    registerAndLogin(); // login to another user.
    $post1->dislike(); // dislike A's post.
    isTrue($post1->appliedPoint == 0, 'limit is not set.'); // limit is not set, so by default it will failure.


    setVotePointsForTest();         // Set test limit

    $C = registerAndLogin();        // Login C
    $post2 = createPost();          // C creates a post.
    registerAndLogin();             // Login to another user.
    $re = $post2->dislike(); // dislike A's post again !

    // So, C gets 111.
    isTrue($C->getPoint() == 111, "User post was disliked. post must be 111, but" . $C->getPoint());
}

function testDislikePointForMinusPoint() {
    resetPoints();

    setVotePointsForTest();         // Set test limit
    $A = registerAndLogin();
    $A->setPoint(100);
    userActivity()->setDislikePoint(-33);
    $post = createPost();

    registerAndLogin();
    $post->dislike();

    // So, A get -33. And he has 77 point left.
    isTrue($A->getPoint() == 67, "User post was disliked. post must be 111, but: " . $A->getPoint());
}


function testVotePoints_likeAndLikeDeduction() {

    resetPoints();
    setVotePointsForTest();
    userActivity()->setLikePoint(10);
    userActivity()->setLikeDeductionPoint(-5);

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
    setVotePointsForTest();

    // prepare
    userActivity()->setDislikePoint(-20);
    userActivity()->setDislikeDeductionPoint(-50);

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
    setVotePointsForTest();
    userActivity()->setLikePoint(20);
    userActivity()->setLikeDeductionPoint(-5);

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
    setVotePointsForTest();
    userActivity()->setLikePoint(20);
    userActivity()->setLikeDeductionPoint(-5);
    $A = registerAndLogin(); // login A
    $comment = createComment(); // create a comment by A
    $B = registerAndLogin(); // login B
    $comment->like();

    isTrue($A->getPoint() == 20, 'A got 20 by commenting');
    isTrue($B->getPoint() == 0, 'B got -5. But point cannot go below 0');
}

function testVoteDislikeOnComment() {
    resetPoints();
    setVotePointsForTest();
    userActivity()->setDislikePoint(-20);
    userActivity()->setDislikeDeductionPoint(-30);
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
    setVotePointsForTest();
    userActivity()->setLikePoint(20);
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
    setVotePointsForTest();
    userActivity()->setDislikePoint(-80);
    userActivity()->setDislikeDeductionPoint(-90);
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



function testVoteWithoutHourlyLimit() {
    resetPoints();

    // prepare
    userActivity()->setLikeDeductionPoint(-100);

    $A = registerAndLogin();
    $A->setPoint(600);

    // test without limit
    for($i = 0; $i < 5; $i++) {
        loginAs($A);
        $p = createPost();
        registerAndLogin();
        $p->like();
    }

    isTrue($A->getPoint() == 100, '-400');
}

function testVoteHourlyLimit() {

    resetPoints();

    userActivity()->setLikePoint(100);
    userActivity()->setLikeDeductionPoint(-100);


    // See? There is no limit.
    $A = registerAndLogin();
    $A->setPoint(1000);
    $B = registerAndLogin();
    $B->setPoint(1000);


    // Set limit. 4 times in 2 hours.

    setVotePointsForTest(4, 2, 10);



    // vote 7 times. But 4 times point change only.
    for($i = 0; $i < 7; $i++) {
        loginAs($A);
        $p = createPost();
        loginAs($B);
        $p->like();
    }

    isTrue($A->getPoint() == 1400, "A point to be 1400 but: " . $A->getPoint());
    isTrue($B->getPoint() == 600, "B point to be 600. But bot: " . $B->getPoint());

}
function testVoteDailyLimit() {

    resetPoints();
    setVotePointsForTest();
    userActivity()->setLikePoint(200);
    userActivity()->setLikeDeductionPoint(-100);


    $A = registerAndLogin()->setPoint(1000);
    $post1 = createPost();
    $post2 = createPost();
    $post3 = createPost();

    $B = registerAndLogin()->setPoint(1000);


    // Limit: 2 times a day.
    userActivity()->setVoteDailyCount(2);

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
    setCreatePointsForTest(POINT);

    // check point settings
    userActivity()->setPostCreatePoint(POINT, 1000);

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
    setCreatePointsForTest(POINT);

    // check point settings
    userActivity()->setPostCreatePoint(POINT, 321);

    // login as
    registerAndLogin();

    // create post
    $post1 = createPost();
    isTrue($post1->appliedPoint == 321, "AppliedPoint must be 321. But: " . $post1->getError());


    // change point settings
    userActivity()->setPostCreatePoint(POINT, 222);
    $post2 = createPost();
    isTrue($post2->appliedPoint == 222, "AppliedPoint should be 222. But: " . $post1->getError());

}


function testPointPostDelete() {

    resetPoints();
    setCreatePointsForTest(POINT);
    // check point settings
    userActivity()->setPostDeletePoint(POINT, -444);


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
    setCreatePointsForTest(POINT);

    // login as A
    $A = registerAndLogin();
    $A->setPoint(500);

    // check point settings
    userActivity()->setPostCreatePoint(POINT, 100);
    userActivity()->setPostDeletePoint(POINT, -150);

    // create & delete post
    $post1 = createPost();
    isTrue($A->getPoint() == 600, 'A point must be 600. but ' . $A->getPoint());
    $post1->markDelete();
    isTrue($A->getPoint() == 450, 'A point must be 450. but ' . $A->getPoint());


    $post2 = createPost(categoryId: 'newCat' . time());
    isTrue($A->getPoint() == 450, 'New category without point change. So, point not changing. 450. but ' . $A->getPoint());


    createPost();
    isTrue($A->getPoint() == 550, 'Point category again. 550. but ' . $A->getPoint());


}

function testPointPostCreateDailyLimit() {

    resetPoints();

    $categoryId = 'c-daily-test-f-p' . time();
    $category = createCategory($categoryId);



    // 1 day, 2 posts.
    setCreatePointsForTest($categoryId, 5, 5, 2);
    userActivity()->setPostCreatePoint($category->idx, 60);


    registerAndLogin();

    createPost($category->id);
    $p2 = createPost($category->id);
    isTrue($p2->ok, "p2 ok");

    isTrue(login()->getPoint() == 120, "User point must be 120");



    $p3 = createPost($category->id);
//    d($p3);
    isTrue($p3->ok, "testPointPostCreateDailyLimit() -> Expect: ok without createBanOnLimit");
    isTrue(login()->getPoint() == 120, "User point must, still, be 120");

    userActivity()->enableBanCreateOnLimit($category->idx);

    $p4 = createPost($category->id);
    isTrue($p4->getError() == e()->daily_limit, "Expect: error daily limit");
    isTrue(login()->getPoint() == 120, "User point must, still, be 120, again");
}


function testPointPostCreateHourlyLimit() {

    resetPoints();

    $category = createCategory('category-hourly-test-' . time());

//    d("category->idx: ". $category->idx);


    userActivity()->setPostCreatePoint($category->idx, 100);

    // 2 hour, 3 posts.

    setCreatePointsForTest($category->idx, 3, 2, 10);
    userActivity()->setCreateHourLimit($category->idx, 2);
    userActivity()->setCreateHourLimitCount($category->idx, 3);

    registerAndLogin();
//    $p1 = createPost($category->id);
    $p1 = post()->create([CATEGORY_ID => $category->id, TITLE => TITLE, CONTENT => CONTENT]);
//    d($p1);
    isTrue(login()->getPoint() == 100, 'User point must be 100');
    createPost($category->id);
    $p3 = createPost($category->id);
//    d($p3);
    isTrue($p3->ok, "post create");
    isTrue(login()->getPoint() == 300, 'User point must be 300, now;');

    $p4 = createPost($category->id);
    isTrue($p4->ok, "testPointPostCreateHourlyLimit() -> Expect: ok without ban;");
    isTrue(login()->getPoint() == 300, 'User point must still, be 300;');


    userActivity()->enableBanCreateOnLimit($category->idx);

    $p5 = createPost($category->id);
    isTrue($p5->getError() == e()->hourly_limit, "Expect: error hourly limit");
}

function testCategoryLimitByDateChange() {
    resetPoints();
    userActivity()->enableBanCreateOnLimit(POINT);

    // Limit 1 time a day.
    setCreatePointsForTest(POINT, 5, 5, 1);

    $A = registerAndLogin();
    $post1 = createPost();
    isTrue($post1->ok, 'testChangeDate() -> post1 must success');

    // Ban on limit
    userActivity()->enableBanCreateOnLimit(POINT);
    $post2 = createPost();
    isTrue($post2->hasError, 'testChangeDate() -> post2 must be error.');
    isTrue($post2->getError() == e()->daily_limit, 'testChangeDate() -> post2 must be error daily limit but::'. $post2->getError());

    // Post creating is banned now!
    // But change the last post creation history to 1 day before, so it can post again.

    // Get last history of post create
    $beforeCheck = userActivity()->last(POSTS, $post1->idx, Actions::$createPost);
    // so, if it create a post again, then it will not be an error.
    $updated = $beforeCheck->update([CREATED_AT => $beforeCheck->createdAt - (60 * 60 * 24)]);

    // Create a new post. Expect success.
    $post3 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 3']);
    isTrue($post3->ok && $post3->title == 'post 3', 'testChangeDate() -> post3 must be success.');


    // Create again and it must failed.
    $post4 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 4']);
    isTrue($post4->hasError, 'testChangeDate() -> post4 must be error.');
    isTrue($post4->getError() == e()->daily_limit, 'post4 daily limit');
}


function testPointCommentCreate() {
    resetPoints();
    setCreatePointsForTest(POINT);
    userActivity()->setCommentCreatePoint(POINT, 50);

    $A = registerAndLogin();
    $c = createComment();

    // $A point should be 50.
    isTrue($c->ok, "comment create must be okay. But: " . $c->getError());
    isTrue($A->getPoint() == 50, 'A point must be 50. but ' . $A->getPoint());

    $c->create([ROOT_IDX => $c->rootIdx, PARENT_IDX => $c->idx, TITLE => "comment under " . $c->idx]);
    isTrue($A->getPoint() == 100, 'A point must be 100 for commenting twice. but ' . $A->getPoint());

}


function testCommentPatchPoint() {

    resetPoints();

    setCreatePointsForTest(POINT);

    // check point settings
    userActivity()->setCommentCreatePoint(POINT, 111);

    // login as
    registerAndLogin();

    // create comment
    $comment1 = createComment();
    isTrue($comment1->appliedPoint == 111, "AppliedPoint must be 111. But: " . $comment1->getError());


    // change point settings
    userActivity()->setCommentCreatePoint(POINT, 222);
    $comment2 = createComment();
    isTrue($comment2->appliedPoint == 222, "AppliedPoint should be 222. But: " . $comment2->getError());

}


function testPointCommentDelete() {
    resetPoints();
    // check point settings
    userActivity()->setCommentDeletePoint(POINT, -100);

    // login as A
    $A = registerAndLogin();

    // create comment
    $comment1 = createComment();
    // create one more comment
    $comment2 = createComment();
    isTrue($comment1->ok && $comment2->ok, "comment create must be okay. But: C1 " . $comment1->getError() . " C2 " . $comment2->getError());

    $comment3 = comment()->create([ROOT_IDX => $comment1->rootIdx, PARENT_IDX => $comment1->idx, TITLE => "comment under " . $comment1->idx]);
    isTrue($comment3->ok, "comment under comment 1");


    $A->setPoint(250);
    // 게시글 삭제
    $re = $comment1->markDelete();
    isTrue(login()->getPoint() == 150, 'A point must be 400. but ' . login()->getPoint());

    $re = $comment2->markDelete();
    isTrue(login()->getPoint() == 50, 'A point must be 300. but ' . login()->getPoint());

    $re = $comment3->markDelete();
    isTrue(login()->getPoint() == 0, 'A point must be 200. but ' . login()->getPoint());
}


/**
 * @중요, 테스트 포인트 => 코멘트를 하나 생성 할 때, 글을 쓰고 코멘트를 생성한다. 즉, 글/코멘트 증가를 할 때, 결국에는 글을 2개 쓰는 것이다.
 * @throws Exception
 */
function testPointCommentCreateDailyLimit() {

    resetPoints();
    $cat = createCategory('pccdl-' . time());

    setCreatePointsForTest($cat->idx);

    // 2 in a day
    userActivity()->setCreateDailyLimitCount($cat->idx, 4);
    userActivity()->setPostCreatePoint($cat->idx, 300);
    userActivity()->setCommentCreatePoint($cat->idx, 250);

    registerAndLogin();
    $comment1 = createComment($cat->id);
    isTrue($comment1->categoryIdx == $cat->idx, 'Category idx check;');

    isTrue(login()->getPoint() == 550, "User post must be 500;");

//    d($comment1);
//    d(login()->getPoint());

    $comment2 = createComment($cat->id);
    isTrue($comment2->ok, "p2 ok");
//    d($comment2);
//    d(login()->getPoint());

    isTrue(login()->getPoint() == 1100, "User post must be 1100;");


    $comment3 = createComment($cat->id);
    isTrue($comment3->ok, "testPointCommentCreateDailyLimit() -> Expect: ok without createBanOnLimit");

    isTrue(login()->getPoint() == 1100, "User post must, still, be 1100;");

    userActivity()->enableBanCreateOnLimit($cat->idx);

    $comment4 = comment()->create([ ROOT_IDX => $comment3->rootIdx, CONTENT => 'comment content read' ]);
    isTrue($comment4->getError() == e()->daily_limit, "Expect: error daily limit");

}

/**
 * 중요 - 테스트 코멘트를 생성할 때, 글을 하나 생성하고 코멘트를 생성한다.
 * @throws Exception
 */
function testPointCommentCreateHourlyLimit() {

    resetPoints();

    $category = createCategory('tpcchl--' . time());

    setCreatePointsForTest($category->idx);

    // 2 hour, 3 posts.
    userActivity()->setCreateHourLimit($category->idx, 2);
    userActivity()->setCreateHourLimitCount($category->idx, 3);

    userActivity()->setPostCreatePoint($category->idx, 130);
    userActivity()->setCommentCreatePoint($category->idx, 70);


    registerAndLogin();
    $c1 = comment()->create([CATEGORY_ID => $category->id, CONTENT => CONTENT]);
    isTrue($c1->getError() == e()->root_idx_is_empty, 'root idx is empty');

    /// 글 1개, 코멘트 1개. 총 2개 생성.
    createComment($category->id);
    isTrue(login()->getPoint() == 200, 'User point must be 200;');

    $c3 = createComment($category->id);
    isTrue($c3->ok, "testPointCommentCreateHourlyLimit() -> Expect: ok without ban");

    // 주의: 먼저 2개를 생성했고, 여기서는 글 1개만 생성했다.
    isTrue(login()->getPoint() == 330, 'User point must be 330;');

    userActivity()->enableBanCreateOnLimit($category->idx);

    $c4 = comment()->create([ ROOT_IDX => $c3->rootIdx, CONTENT => 'comment content read' ]);
    isTrue($c4->getError() == e()->hourly_limit, "Expect: error hourly limit");

    isTrue(login()->getPoint() == 330, 'User point must, still, be 330;');

}


function testPointPostCreateLimitByPointPossession() {
    resetPoints();
    userActivity()->setPostCreateLimitPoint(POINT, 100);

    $A = registerAndLogin();
    $p = createPost();
    isTrue($p->hasError && $p->getError() == e()->lack_of_point_possession_limit, "User 'u' is Lack of point for post create");

    $A->setPoint(100);
    $p2 = createPost();
    isTrue($p2->ok, "User u created a post");

}

function testPointCommentCreateLimitByPointPossession() {
    resetPoints();
    userActivity()->setCommentCreateLimitPoint(POINT, 100);

    $u2 = registerAndLogin();
    $c = createComment();
    isTrue($c->hasError && $c->getError() == e()->lack_of_point_possession_limit, "User 'u2' is Lack of point for comment create");

    $u2->setPoint(100);
    $c2 = createComment();
    isTrue($c2->ok, "u2 created a comment");

    $u2->setPoint(99);
    $c3 = createComment();
    isTrue($c3->getError() == e()->lack_of_point_possession_limit, "u2 lack of point possession to create a comment");

}


function testPointReadLimitByPointPossession() {
    resetPoints();

    $u3 = registerAndLogin();
    $p3 = createPost();
    isTrue($p3->ok, "u3 created a post. But cannot read");


    userActivity()->setReadLimitPoint(POINT, 50);

    $u3->setPoint(49);

    $read = post()->read($p3->idx);
    isTrue($read->hasError && $read->getError() == e()->lack_of_point_possession_limit, "u3 cannot read point due to lack of point possession");

}