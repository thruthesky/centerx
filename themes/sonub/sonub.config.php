<?php

define("FIREBASE_ADMIN_SDK_SERVICE_ACCOUNT_KEY_PATH", theme()->folder . "keys/sonub-firebase-adminsdk.json");
define("FIREBASE_DATABASE_URI", "https://sonub-version-2020.firebaseio.com/");


/// Kakao Login API 키
/// 카카오 프로젝트 1개의 도메인 10개, Redirect URL 10 개를 사용 할 수 있다.
if ( !defined('JAVASCRIPT_KAKAO_CLIENT_ID') ) define('JAVASCRIPT_KAKAO_CLIENT_ID', '937af10cf8688bd9a7554cf088b2ac3e');
// Kakao Redirect URI
if ( !defined('JAVASCRIPT_KAKAO_CALLBACK_URL') ) define('JAVASCRIPT_KAKAO_CALLBACK_URL', '/etc/callbacks/kakao/kakao-login.callback.php');



/// Naver Login API 키
/// README 참고
if ( get_root_domain() == 'philov.com' || get_root_domain() == 'sonub.com' ) {
    if ( !defined('NAVER_CLIENT_ID') ) define('NAVER_CLIENT_ID', 'uCSRMmdn9Neo98iSpduh');
    if ( !defined('NAVER_CLIENT_SECRET') ) define('NAVER_CLIENT_SECRET', 'lmEXnwDKAD');
    if ( isLocalhost() ) {
        $host = get_domain();
    } else {
        $host = get_root_domain();
    }
    if ( !defined('NAVER_CALLBACK_URL') ) define('NAVER_CALLBACK_URL', urlencode('https://'. $host .'/etc/callbacks/naver/naver-login.callback.php'));
    if ( !defined('NAVER_API_URL') ) define('NAVER_API_URL', "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".NAVER_CLIENT_ID."&redirect_uri=".NAVER_CALLBACK_URL."&state=" . get_domain());
}



include_once 'sonub.defines.php';
