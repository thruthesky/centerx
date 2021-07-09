<?php
/**
 *
 */
/// 인증
$user = pass_login_callback($_REQUEST);
if ( isError($user) ) {
    pass_login_message($user);
    exit;
}
/// 로그인 또는 회원 가입
/*
$profile = pass_login_or_register($user);
if ( isError($profile) ) {
    //    debug_log("pass-login-callback-php:: error code: $profile");
    echo "<h1>ERROR: $profile</h1>";
    exit;
}
*/

d(login());

/**
 * 여기까지 오면 로그인 성공. DB 에 verified 에 기록을 남기고, 홈으로 이동.
 */
//user($profile[IDX])->update([in('state') => $profile[SESSION_ID]]);


