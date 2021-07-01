<?php

include_once ROOT_DIR . "routes/user.route.php";

$att = new ATokenTest();

$att->register();
$att->recommend();
$att->maximumRecommends();


/**
 * Class ATokenTest
 */
class ATokenTest {

    public function register() {
        $user = user()->register(['email' => 'email' . time() . '@gmail.com', 'password' => '12345a']);
        isTrue($user->atoken == 300, "User got a token 300");
    }

    public function recommend() {
        $a = createUser();
        $b = createUserAndLogin();
        isTrue($b->atoken == 300, "User got a token 300");

        $userRoute = new UserRoute();
        $re = $userRoute->recommend(['otherUserIdx' => $a->idx]);
        isTrue($re['idx'] > 0, '성공: 회원 추천 완료');
        $b->read($b->idx);
        isTrue($b->atoken == 450, "추천 완료");

    }


    public function doubleRecommend() {
        $a = createUser();
        $b = createUserAndLogin();
        $userRoute = new UserRoute();
        $re = $userRoute->recommend(['otherUserIdx' => $a->idx]);
        $re = @$userRoute->recommend(['otherUserIdx' => $a->idx]);
        isTrue($re == e()->insert_failed, '중복 추천 에러 발생.');

        $b->read($b->idx);
        isTrue($b->atoken == 450, "추천 atoken은 그대로 450");
    }


    public function maximumRecommends() {
        $me = createUserAndLogin();
        $userRoute = new UserRoute();

        isTrue($me->atoken == 300, "가입 포인트 300");

        for( $i = 0; $i < 10; $i ++ ) {
            $user = createUser();
            $userRoute->recommend(['otherUserIdx' => $user->idx]);
            $me->read($me->idx);
            isTrue($me->atoken == (300 + 150 * ($i+1)), "회원 추천 150 증가: {$me->atoken}");
        }
        $re = $userRoute->recommend(['otherUserIdx' => $user->idx]);
        isTrue($re == e()->maximum_recommends, "최대 추천은 10명까지만 가능.");


    }



}

//$at = aToken();
//
//
//
//isTrue(true, 'true');

