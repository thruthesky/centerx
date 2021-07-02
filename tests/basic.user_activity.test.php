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
testCategoryLimitByDateChange();


testPointCommentCreate();
testCommentPatchPoint();
testPointCommentDelete();

testPointCommentCreateDailyLimit();
testPointCommentCreateHourlyLimit();

testPointPostCreateLimitByPointPossession();
testPointCommentCreateLimitByPointPossession();
testPointReadLimitByPointPossession();








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
    act()->setCreateDailyLimitCount(category(POINT)->idx, 0);
    act()->setCreateHourLimit(category(POINT)->idx, 0);
    act()->setCreateHourLimitCount(category(POINT)->idx, 0);

    act()->disableBanCreateOnLimit(POINT);


    act()->setPostCreateLimitPoint(POINT, 0);
    act()->setCommentCreateLimitPoint(POINT, 0);
    act()->setReadLimitPoint(POINT, 0);
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



function testVoteWithoutHourlyLimit() {
    resetPoints();

    // prepare
    act()->setLikeDeductionPoint(-100);

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
    act()->setLikePoint(100);
    act()->setLikeDeductionPoint(-100);


    // See? There is no limit.
    $A = registerAndLogin();
    $A->setPoint(1000);
    $B = registerAndLogin();
    $B->setPoint(1000);


    // Set limit. 4 times in 2 hours.
    act()->setLikeHourLimit(2);
    act()->setLikeHourLimitCount(4);


    // test without limit
    for($i = 0; $i < 5; $i++) {
        loginAs($A);
        $p = createPost();
        loginAs($B);
        $p->like();
    }

    isTrue($A->getPoint() == 1400, "A point to be 1500 but: " . $A->getPoint());
    isTrue($B->getPoint() == 600, "B point to be 600");

}
function testVoteDailyLimit() {

    resetPoints();
    act()->setLikePoint(200);
    act()->setLikeDeductionPoint(-100);


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
    act()->setPostCreatePoint(POINT, 100);
    act()->setPostDeletePoint(POINT, -150);

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

//    d(category(POINT));

    // 1 day, 2 posts.
    act()->setCreateDailyLimitCount(POINT, 2);



    registerAndLogin();
    createPost();
    $p2 = createPost();
    isTrue($p2->ok, "p2 ok");

    $p3 = createPost();
//    d($p3);
    isTrue($p3->ok, "testPointPostCreateDailyLimit() -> Expect: ok without createBanOnLimit");

    act()->enableBanCreateOnLimit(POINT);

    $p4 = createPost();
    isTrue($p4->getError() == e()->daily_limit, "Expect: error daily limit");
}


function testPointPostCreateHourlyLimit() {

    resetPoints();

    $category = createCategory('category-hourly-test-' . time());

//    d("category->idx: ". $category->idx);


    // 2 hour, 3 posts.
    act()->setCreateHourLimit($category->idx, 2);
    act()->setCreateHourLimitCount($category->idx, 3);

    registerAndLogin();
//    $p1 = createPost($category->id);
    $p1 = post()->create([CATEGORY_ID => $category->id, TITLE => TITLE, CONTENT => CONTENT]);
//    d($p1);
    createPost($category->id);
    $p3 = createPost($category->id);
//    d($p3);
    isTrue($p3->ok, "testPointPostCreateHourlyLimit() -> Expect: ok without ban");



    act()->enableBanCreateOnLimit($category->idx);

    $p4 = createPost($category->id);
    isTrue($p4->getError() == e()->hourly_limit, "Expect: error hourly limit");
}

function testCategoryLimitByDateChange() {
    resetPoints();
    act()->enableBanCreateOnLimit(POINT);

    // Limit 1 time a day.
    act()->setCreateDailyLimitCount(POINT, 1);

    $A = registerAndLogin();
    $post1 = createPost();
    isTrue($post1->ok, 'testChangeDate() -> post1 must success');

    // Ban on limit
    act()->enableBanCreateOnLimit(POINT);
    $post2 = createPost();
    isTrue($post2->hasError, 'testChangeDate() -> post2 must be error.');
    isTrue($post2->getError() == e()->daily_limit, 'testChangeDate() -> post2 must be error daily limit but::'. $post2->getError());

    // Post creating is banned now!
    // But change the last post creation history to 1 day before, so it can post again.

    // Get last history of post create
    $beforeCheck = act()->last(POSTS, $post1->idx, Actions::$createPost);
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
    act()->setCommentCreatePoint(POINT, 50);

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

    // check point settings
    act()->setCommentCreatePoint(POINT, 111);

    // login as
    registerAndLogin();

    // create comment
    $comment1 = createComment();
    isTrue($comment1->appliedPoint == 111, "AppliedPoint must be 111. But: " . $comment1->getError());


    // change point settings
    act()->setCommentCreatePoint(POINT, 222);
    $comment2 = createComment();
    isTrue($comment2->appliedPoint == 222, "AppliedPoint should be 222. But: " . $comment2->getError());

}


function testPointCommentDelete() {
    resetPoints();
    // check point settings
    act()->setCommentDeletePoint(POINT, -100);

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

function testPointCommentCreateDailyLimit() {

    resetPoints();
    // 2 in a day
    act()->setCreateDailyLimitCount(POINT, 2);

    registerAndLogin();
    createComment();
    $comment2 = createComment();
    isTrue($comment2->ok, "p2 ok");

    $comment3 = createComment();
    isTrue($comment3->ok, "testPointCommentCreateDailyLimit() -> Expect: ok without createBanOnLimit");

    act()->enableBanCreateOnLimit(POINT);

    $comment4 = comment()->create([ ROOT_IDX => $comment3->rootIdx, CONTENT => 'comment content read' ]);
    isTrue($comment4->getError() == e()->daily_limit, "Expect: error daily limit");

}

function testPointCommentCreateHourlyLimit() {

    resetPoints();

    $category = createCategory('category-hourly-test-' . time());

    // 2 hour, 3 posts.
    act()->setCreateHourLimit($category->idx, 2);
    act()->setCreateHourLimitCount($category->idx, 3);

    registerAndLogin();
    $c1 = comment()->create([CATEGORY_ID => $category->id, CONTENT => CONTENT]);
    createComment($category->id);
    $c3 = createComment($category->id);
    isTrue($c3->ok, "testPointCommentCreateHourlyLimit() -> Expect: ok without ban");



    act()->enableBanCreateOnLimit($category->idx);

    $c4 = comment()->create([ ROOT_IDX => $c3->rootIdx, CONTENT => 'comment content read' ]);
    isTrue($c4->getError() == e()->hourly_limit, "Expect: error hourly limit");


}


function testPointPostCreateLimitByPointPossession() {
    resetPoints();
    act()->setPostCreateLimitPoint(POINT, 100);

    $A = registerAndLogin();
    $p = createPost();
    isTrue($p->hasError && $p->getError() == e()->lack_of_point_possession_limit, "User 'u' is Lack of point for post create");

    $A->setPoint(100);
    $p2 = createPost();
    isTrue($p2->ok, "User u created a post");

}

function testPointCommentCreateLimitByPointPossession() {
    resetPoints();
    act()->setCommentCreateLimitPoint(POINT, 100);

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


    act()->setReadLimitPoint(POINT, 50);

    $u3->setPoint(49);

    $read = post()->read($p3->idx);
    isTrue($read->hasError && $read->getError() == e()->lack_of_point_possession_limit, "u3 cannot read point due to lack of point possession");

}