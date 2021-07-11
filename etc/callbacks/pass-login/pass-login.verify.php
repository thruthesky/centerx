<?php
/**
 * @file pass-login.verify.php
 */

// 인증
//
if ( isset($_REQUEST['test']) && $_REQUEST['test'] ) {
    $res = json_decode(
        '{"ci":"fkxZh3dlJtMa9u+Prs42nkY4IoTUOw9J65gWlVYNpjsZ3psXHJGamA6olV9uW46l9Lge0D36xQkCBN9q5lmuZA==","phoneNo":"01086934225","name":"\uc1a1\uc7ac\ud638","birthdate":"731016","gender":"M","agegroup":"40","foreign":"L","telcoCd":"S","plid":"37efdb39-050b-49b1-9fd6-08aa0c974a3c","autoStatusCheck":"N"}',
        true,);
}
else {
    $res = pass_login_callback($_REQUEST);
}

debug_log("--- pass-login.verify.php > Got data from PASS login server;", $res);

if ( isError($res) ) {
    pass_login_message($res);
    exit;
}

if ( loggedIn() ) {
    debug_log("--- pass-login.verify.php > already logged, updating user data;");

    // 회원 로그인을 한 상태이면, PASS LOGIN 으로 부터 넘어온 정보를 회원 정보로 업데이트한다.
    $res[VERIFIER] = VERIFIER_PASSLOGIN;
    login()->update($res);
} else {
    // 로그인을 하지 않은 상태이면,
    // 이 경우는 오직 테스트 또는 삼사를 받기 위해서만 지원한다. 나중에는 로그인을 먼저 해야지만, 이용 가능하도록 한다.
    $user = pass_login_or_register($res);
    if ( isError($user) ) {
        debug_log("--- pass-login.verify.php > error; $user");
        //    debug_log("pass-login-callback-php:: error code: $profile");
        echo "<h1>ERROR: $user</h1>";
        exit;
    }

    debug_log("--- pass-login.verify.php > setLoginCookies; ", $user);
    setLoginCookies($user);
}

