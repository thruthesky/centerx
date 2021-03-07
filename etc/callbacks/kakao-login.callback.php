<?php
require_once('../../boot.php');
if ( in('kakao_id') ) {
    $profile = user()->loginOrRegister([
        'email' => md5(in('kakao_id')) . '@kakao.com',
        'password' => LOGIN_PASSWORD_SALT,
        'provider' => 'kakao'
    ]);
    setLoginCookies($profile);
    jsGo('/');
}

