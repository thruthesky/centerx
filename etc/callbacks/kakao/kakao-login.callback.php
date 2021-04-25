<?php
require_once('../../../boot.php');
if ( in('kakao_id') ) {
    $user = user()->loginOrRegister([
        'email' => 'kakao' . in('kakao_id') . '@kakao.com',
        'password' => LOGIN_PASSWORD_SALT,
        'provider' => PROVIDER_KAKAO,
        'photoUrl' => in('profile_image'),
    ]);
    if ( ! $user->nickname ) {
        $user->update([NICKNAME => in(NICKNAME)]);
    }
    setLoginCookies($user->profile());
    jsGo('/');
}

