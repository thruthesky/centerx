<?php

define("FIREBASE_ADMIN_SDK_SERVICE_ACCOUNT_KEY_PATH", theme()->folder . "keys/sonub-firebase-adminsdk.json");
define("FIREBASE_DATABASE_URI", "https://sonub-version-2020.firebaseio.com/");


/// Kakao Login API 키
/// 각 도메인 마다 다르게 검사를 받아야한다.
if ( get_root_domain() == 'philov.com' ) {
    if ( !defined('KAKAO_CLIENT_ID') ) define('KAKAO_CLIENT_ID', '6f8d49d406555f69828891821ea56c8b');
    // Kakao Redirect URI
    if ( !defined('KAKAO_CALLBACK_URL') ) define('KAKAO_CALLBACK_URL', 'https://main.philov.com/etc/callbacks/kakao-login.callback.php');
}


/// Naver Login API 키
if ( get_root_domain() == 'philov.com' ) {
    if ( !defined('NAVER_CLIENT_ID') ) define('NAVER_CLIENT_ID', 'gCVN3T_vsOmX1ADriDOA');
    if ( !defined('NAVER_CLIENT_SECRET') ) define('NAVER_CLIENT_SECRET', 'JzWh7zPeJF');
    if ( !defined('NAVER_CALLBACK_URL') ) define('NAVER_CALLBACK_URL', urlencode('https://main.philov.com/etc/callbacks/naver-login.callback.php'));
    if ( !defined('NAVER_API_URL') ) define('NAVER_API_URL', "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".NAVER_CLIENT_ID."&redirect_uri=".NAVER_CALLBACK_URL."&state=1");
}


include 'functions.php';


addPage('menu');

