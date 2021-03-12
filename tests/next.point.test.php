<?php

// 다섯명의 사용자 준비
$rows = user()->search(limit: 5);

define('A', $rows[0][IDX]);
define('B', $rows[1][IDX]);
define('C', $rows[2][IDX]);
define('D', $rows[3][IDX]);
define('E', $rows[4][IDX]);

// 글 3개 준비
$post1 = new Post(0);
$post2 = new Post(0);
$post3 = new Post(0);




// 테스트 용 이메일 주소와 비번
$email = time() . "@point-test.com";
$pw = '12345a';




testPointbasics();

testLikeHourlyLimit();
testLikeDailyLimit();
testPostCreateDelete();
testCommentCreateDelete();
testPostCommentCreateHourlyLimit();
testPostCommentCreateDailyLimit();


function testPointBasics() {

    global $post1, $post2, $post3, $email, $pw;


    setLogin(A);
    user(A)->setPoint(500);
    isTrue(user(A)->getPoint() == 500, 'A point must be 500. but: ' . user(A)->getPoint());

// 사용자 가입 포인트
    clearTestPoint();
    point()->setRegister(1000);
    $user = user()->register([EMAIL => $email, PASSWORD => $pw]);
    isTrue($user->getPoint() == point()->getRegister(), "user's register point: " . $user->getPoint());


// 로그인 포인트 테스트
    clearTestPoint();
    user()->by($email)->setPoint(0);
    point()->setLogin(333);

    $login = user()->login([EMAIL => $email, PASSWORD => $pw]);
    isTrue($login->getPoint() == point()->getLogin(), "user's point: " . $login->getPoint());


// 추천 차감 포인트
    clearTestPoint();
    point()->setLike(100);
    point()->setLikeDeduction(-20);
    point()->setDislike(-50);
    point()->setDislikeDeduction(-30);

//print("D point: " . user(D)->getPoint() . "\n");



// B 포인트가 0 인데, -20 만큼 감소를 해도, 0 이하로 저장되지 않으므로 0 이다.
    setLogin(B);
    $post1->vote('Y');
    isTrue(login()->getPoint() == 0, 'B point should be 0, but ' . login()->getPoint());



// 주의: 이미 같은 글에 두번 추천. 포인트 변화 없음
    user(B)->setPoint(30);
    $post1->vote('Y');
    isTrue(login()->getPoint() == 30, 'B point should be 30. but: ' . login()->getPoint());

// 다른 글에 추천. 포인트를 30 으로 지정. 추천 하면 -20 감소되므로, 10이 됨.
    user(B)->setPoint(30);
    $post2->vote('Y');
    isTrue(login()->getPoint() == 10, 'B point should be 10. but: ' . login()->getPoint());

// D 는 두번 추천 받았으므로, 포인트 200
    isTrue(user(D)->getPoint() == 200, 'D point must be 200. but: ' . user(D)->getPoint());


// B 가 D 에게 비추.
// B 는 10 포인트를 가지고 있는데, -30을 차감하면, 최소 0이 남음.
// D 는 -50 감소해서 150 남음
    $post3->vote('N');
    isTrue(user(B)->getPoint() == 0, 'B point 0');
    isTrue(user(D)->getPoint() == 150, 'D point must be 150. but ' . user(D)->getPoint());

}

function testPostCommentCreateDailyLimit(): void
{
    clearTestPoint();

    // 하루에 3번 제한
    point()->setCategoryDailyLimitCount(POINT, 3);

    setLogin(A);
    $post1 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 1']);
    $post2 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 2']);
    $post3 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 3']);
    $post4 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 4']);
    // 제한 없으므로 성공
    isTrue($post4->ok, 'post 4 should success');


    // 제한 하므로 실패.
    point()->enableCategoryBanOnLimit(POINT);
    $post5 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 5']);
    isTrue($post5->hasError, 'post 5 must error');


    point()->disableCategoryBanOnLimit(POINT);
    $post6 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 6']);
    isTrue($post6->ok, 'post 6 must success');


    // 제한 하므로 다시 실패.
    point()->enableCategoryBanOnLimit(POINT);
    $cmt1 = comment()->create([ROOT_IDX => $post6->idx, PARENT_IDX => $post6->idx, CONTENT => 'yo']);
    isTrue($cmt1->hasError, 'cmt1 must fail');

}


function testPostCommentCreateHourlyLimit(): void
{
    clearTestPoint();

    // 2시간에 3번 제한
    point()->setCategoryHour(POINT, 2);
    point()->setCategoryHourLimitCount(POINT, 3);

    setLogin(A);


    point()->disableCategoryBanOnLimit(POINT);
    $post1 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 1']);
    isTrue($post1->ok, 'post1');
    $post2 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 2']);
    isTrue($post2->ok, 'post2');
    $post3 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 3']);
    isTrue($post3->ok, 'post3');


    // 제한을 하지 않았으므로 성공! 단, 포인트 증감하지 안혹, point history table 에 기록되지 않음.
    $post4 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 4']);
    isTrue($post4->ok, 'post4');
//    isTrue(isSuccess($post4), 'post 4 should success. but got: ' . is_array($post4) ? '' : $post4);

    // 제한을 한다. 에러가 발생해야 함.
    point()->enableCategoryBanOnLimit(POINT);
//    enableDebugging();
    $post5 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 5']);
//    disableDebugging();
    isTrue($post5->hasError, 'post 5 must error');
    isTrue($post5->getError() == e()->hourly_limit, 'post 5 must error of hourly limit');
    point()->disableCategoryBanOnLimit(POINT);

    // 제한을 해제 했다. 에러가 발생하지 않아야 함.
    $post6 = post()->create([CATEGORY_ID => POINT, TITLE => 'post 6']);
    isTrue($post6->ok, 'post 6 must success');
    
    // 다시 제한 한다. 에러가 발생해야 함.
    point()->enableCategoryBanOnLimit(POINT);
    $cmt1 = comment()->create([ROOT_IDX => $post6->idx, PARENT_IDX => $post6->idx, CONTENT => 'yo']);
    isTrue($cmt1->hasError, 'cmt1 must fail: ' . $cmt1->getError());
    point()->disableCategoryBanOnLimit(POINT);

}


function testCommentCreateDelete(): void
{
    global $post1;
    clearTestPoint();
    setLogin(A)->setPoint(1000);

    point()->setCommentCreate(POINT, 200);
    point()->setCommentDelete(POINT, -300);


    $cmt1 = comment()->create([ROOT_IDX => $post1->idx, PARENT_IDX => $post1->idx]);
    isTrue(login()->getPoint() == 1200, 'A point must be 1200. But: ' . login()->getPoint());

    /// 코멘트 삭제
    $cmt1->markDelete();
    isTrue(login()->getPoint() == 900, 'A point must be 900. But: ' . login()->getPoint());

}


function testPostCreateDelete(): void
{
    clearTestPoint();

    point()->setPostCreate(POINT, 1000);
    point()->setPostDelete(POINT, -1200);
    point()->setCommentCreate(POINT, 200);
    point()->setCommentDelete(POINT, -300);

    isTrue(point()->getPostCreate(POINT) == 1000);
    isTrue(point()->getPostDelete(POINT) == -1200);
    isTrue(point()->getCommentCreate(POINT) == 200);
    isTrue(point()->getCommentDelete(POINT) == -300);

    setLogin(A);

    // 게시글 생성

    $post1 = post()->create([CATEGORY_ID => POINT]);
    isTrue(login()->getPoint() == 1000, 'A point must be 1000. but ' . login()->getPoint());
    $post2 = post()->create([CATEGORY_ID => POINT]);
    isTrue(login()->getPoint() == 2000, 'A point must be 2000. but ' . login()->getPoint());
    // 게시글 삭제
    $re = $post1->markDelete();
    isTrue(login()->getPoint() == 800, 'A point must be 800. but ' . login()->getPoint());
    $re = $post2->markDelete();
    isTrue(login()->getPoint() == 0, 'A point must be 0. but ' . login()->getPoint());

}


function testLikeDailyLimit(): void
{
    global $post1, $post2, $post3;

    clearTestPoint();
    point()->setLike(200);
    point()->setLikeDeduction(-100);
    point()->setDislike(-150);
    point()->setDislikeDeduction(-50);

    // 포인트 일/수 제한. 하루 2번.
    setLogin(B)->setPoint(1000);
    point()->setLikeDailyLimitCount(2);

    $post1->vote('Y');
    $post2->vote('Y');
    $post3->vote('Y');

    isTrue(login()->getPoint() == 800, 'B point should be 800. but ' . login()->getPoint());
}


function testLikeHourlyLimit(): void
{


    clearTestPoint();
    setLogin(B);

    point()->setLike(1000);
    point()->setLikeDeduction(-1000);
    point()->setDislike(-1000);
    point()->setDislikeDeduction(-1000);


    // 포인트 시간/수 제한 없음.
    user(B)->setPoint(10000);
//    return;
//    d(my(IDX));
//    enableDebugging();
    $posts = post()->search(where: "userIdx != " . login()->idx);
//    disableDebugging();
//    d($posts);
    for ($i = 0; $i < 10; $i++) {
//        d($posts[$i][IDX]);
        post($posts[$i][IDX])->vote('N');
    }

    isTrue(user(B)->getPoint() == 0, '(no limit) B point should be 0. but ' . user(B)->getPoint());


    // 시간/수 = 2시간에 11번.
    clearTestPoint();
    setLogin(B);

    point()->setLike(1000);
    point()->setLikeDeduction(-1000);
    point()->setDislike(-1000);
    point()->setDislikeDeduction(-1000);

    point()->setLikeHourLimit(2);
    point()->setLikeHourLimitCount(11);

    // 충분함.
    user(B)->setPoint(10000);

    for ($i = 0; $i < 10; $i++) {
        $post = post($posts[$i][IDX])->vote('N');
    }
    isTrue(user(B)->getPoint() == 0, '(2/11) B point should be 0. but ' . user(B)->getPoint());


//    // 시간/수 = 2시간에 9번.
    clearTestPoint();
    setLogin(B);
    point()->setLike(1000);
    point()->setLikeDeduction(-1000);
    point()->setDislike(-1000);
    point()->setDislikeDeduction(-1000);


    point()->setLikeHourLimit(2);
    point()->setLikeHourLimitCount(9);

    // 마지막 1번은 안됨. 그래서 1천 포인트가 남아야 함.
    user(B)->setPoint(10000);
    for ($i = 0; $i < 9; $i++) {
        $post = post($posts[$i][IDX])->vote('N');
    }
    isTrue(user(B)->getPoint() == 1000, '(2/9) B point should be 1000. but ' . user(B)->getPoint());

}


function clearTestPoint()
{

    global $post1, $post2, $post3;

    db()->query('truncate ' . pointHistory()->getTable());
    db()->query('truncate ' . voteHistory()->getTable());


    point()->setRegister(0);
    point()->setLogin(0);
    point()->setLike(0);
    point()->setDislike(0);
    point()->setLikeDeduction(0);
    point()->setDislikeDeduction(0);

    point()->setLikeDailyLimitCount(0);
    point()->setLikeHourLimit(0);
    point()->setLikeHourLimitCount(0);

    if (category(POINT)->exists() == false) category()->create([ID => POINT]);


    point()->setPostCreate(category(POINT)->idx, 0);
    point()->setCommentCreate(category(POINT)->idx, 0);
    point()->setPostDelete(category(POINT)->idx, 0);
    point()->setCommentDelete(category(POINT)->idx, 0);
    point()->setCategoryDailyLimitCount(category(POINT)->idx, 0);
    point()->setCategoryHour(category(POINT)->idx, 0);
    point()->setCategoryHourLimitCount(category(POINT)->idx, 0);


    setUserAsLogin(D);
    $post1 = post()->create([CATEGORY_ID => POINT, TITLE => TITLE, CONTENT => CONTENT]);
    $post2 = post()->create([CATEGORY_ID => POINT, TITLE => TITLE, CONTENT => CONTENT]);
    $post3 = post()->create([CATEGORY_ID => POINT, TITLE => TITLE, CONTENT => CONTENT]);


    user(A)->setPoint(0);
    user(B)->setPoint(0);
    user(C)->setPoint(0);
    user(D)->setPoint(0);


}