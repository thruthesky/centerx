<?php


testUserRegister();
testUserRegisterResponse();
testUserRegisterIsMine();
testUserRegisterLoginWithMeta();
testUserLoginOrRegister();
testUserBy();
testUserVerification();



function testUserRegister() {
    $email = 'user-create' . time() . '@test.com';
    $pw = '12345a';
    $user = user()->register([EMAIL=>$email, PASSWORD=>$pw]);
    isTrue($user->ok, 'no error on create user');

    $user = user()->register([EMAIL=>$email, PASSWORD=>$pw]);
    isTrue($user->hasError == true, 'error on same email');
    isTrue($user->getError() == e()->email_exists, 'email exists');
}

function testUserRegisterResponse() {
    $email = 'user-response' . time() . '@test.com';
    $pw = '12345a';
    $response = user()->register([EMAIL=>$email, PASSWORD=>$pw])->response();
    isTrue(is_array($response) && $response[CREATED_AT] > 0, 'create->response');
    $arr = explode('-', $response[SESSION_ID]);
    isTrue(count($arr) == 2 , 'sessionId');
}


function testUserRegisterIsMine() {
    $email = 'user-is-mine' . time() . '@test.com';
    $pw = '12345a';
    $user = user()->register([EMAIL=>$email, PASSWORD=>$pw]);
    setLogin($user->idx);
    isTrue(loggedIn(), 'mine: loggedIn()');
    isTrue($user->idx, 'mine: $this->idx');
    isTrue($user->isMine() == false, '->isMine() fails since `userIdx` field not exists.');
}



function testUserRegisterLoginWithMeta() {
    $email = 'user-login' . time() . '@test.com';
    $pw = '12345a';
    $registered = user()->register([EMAIL=>$email, PASSWORD=>$pw, 'color' => 'blue']);
    isTrue($registered->color == 'blue', 'color blue');
    $logged = user()->login([EMAIL=>$email, PASSWORD=>$pw, 'color' => 'yellow']);

    isTrue($registered->color == 'blue', 'color blue');
    isTrue($logged->color == 'yellow', 'color yellow');
}

function testUserLoginOrRegister() {
    $email = 'user-login-or-register' . time() . '@test.com';
    $pw = '12345a';
    isTrue( user()->emailExists($email) ==  false, 'loginOrRegister: email not exists');
    $registered = user()->loginOrRegister([EMAIL=>$email, PASSWORD=>$pw, 'color' => 'green']);
    isTrue( user()->emailExists($email) == true, 'loginOrRegister: email now exists');
    isTrue($registered->color == 'green', 'green');

    $login = user()->loginOrRegister([EMAIL=>$email, PASSWORD=>$pw, 'color' => 'red']);
    isTrue($registered->idx == $login->idx, "loginOrRegister: success");
    isTrue($login->color == 'red', 'expect: red, but: ' . $login->color);
}

function testUserBy() {
    $email = 'user-by' . time() . '@test.com';
    $pw = '12345a';
    $registered = user()->register([EMAIL=>$email, PASSWORD=>$pw, 'color' => 'green']);
    isTrue($registered->idx == user()->by($email)->idx, 'user by');
}

function testUserVerification() {
    $testUser = createTestUser();
    isTrue($testUser->provider == '', 'no provider');
    isTrue($testUser->verified == false, 'not verified');
    $testUser->update(['provider' => PROVIDER_NAVER]);
    isTrue($testUser->provider == 'naver', 'has provider: naver');
    $testUser->update(['verifier' => VERIFIER_PASSLOGIN]);
    isTrue($testUser->verified == true, 'verified');

}