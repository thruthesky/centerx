<?php

if ( in('route') == 'user.login' || in('route') == 'user.update' ) {
    config()->blockUserFields = [
        EMAIL,
        NAME,
        PHONE_NO,
        BIRTH_DATE,
        GENDER
    ];
}

//debug_log("blockUserFields", config()->blockUserFields);


// 닉네임 변경 불가.
config()->isNicknameChangeable = false;

define("FIREBASE_ADMIN_SDK_SERVICE_ACCOUNT_KEY_PATH", ROOT_DIR . "var/sonub/keys/sonub-firebase-admin-sdk.json");
define("FIREBASE_DATABASE_URI", "https://sonub-version-2020.firebaseio.com/");


//if (!defined('NAVER_CLIENT_ID')) {
//    define('NAVER_CLIENT_ID', 'uCSRMmdn9Neo98iSpduh');
//}
//if (!defined('NAVER_CLIENT_SECRET')) {
//    define('NAVER_CLIENT_SECRET', 'lmEXnwDKAD');
//}
//if (!defined('NAVER_CALLBACK_URL')) {
//    define('NAVER_CALLBACK_URL', urlencode('https://main.philov.com/etc/callbacks/naver/naver-login.callback.php'));
//}
//if (!defined('NAVER_API_URL')) {
//    define('NAVER_API_URL', "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=" . NAVER_CLIENT_ID . "&redirect_uri=" . NAVER_CALLBACK_URL . "&state=1");
//}





//addRoute('user.update', function($in) {
//
//});


