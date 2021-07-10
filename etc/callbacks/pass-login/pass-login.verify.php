<?php
/**
 * @file pass-login.verify.php
 */

// 인증
//
if ( $_REQUEST['test'] ) {
    $res = json_decode(
        '{"ci":"fkxZh3dlJtMa9u+Prs42nkY4IoTUOw9J65gWlVYNpjsZ3psXHJGamA6olV9uW46l9Lge0D36xQkCBN9q5lmuZA==","phoneNo":"01086934225","name":"\uc1a1\uc7ac\ud638","birthdate":"731016","gender":"M","agegroup":"40","foreign":"L","telcoCd":"S","plid":"37efdb39-050b-49b1-9fd6-08aa0c974a3c","autoStatusCheck":"N"}',
        true,);
}
else {
    $res = pass_login_callback($_REQUEST);
}

if ( isError($res) ) {
    pass_login_message($res);
    exit;
}

if ( loggedIn() ) {
    // 회원 로그인을 한 상태이면,
    $res[VERIFIER] = VERIFIER_PASSLOGIN;
    login()->update($res);
} else {
    // 로그인을 하지 않은 상태이면,
    // 이 경우는 오직 테스트 또는 삼사를 받기 위해서만 지원한다. 나중에는 로그인을 먼저 해야지만, 이용 가능하도록 한다.
    $profile = pass_login_or_register($res);
    if ( isError($profile) ) {
        //    debug_log("pass-login-callback-php:: error code: $profile");
        echo "<h1>ERROR: $profile</h1>";
        exit;
    }
}
