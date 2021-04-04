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


/**
 * 메인 카페 목록
 *
 * 여기에 기록된 메인 도메인은 2차 도메인이라도, 서브 카페(2차 도메인)로 인식되지 않고, 메인 카페로 인식된다.
 */
define('CAFE_MAIN_DOMAIS', [
    'philov.com', 'www.philov.com', 'main.philov.com',
    'sonub.com', 'www.sonub.com',
]);


/**
 * 카페의 루트 도메인 별로 특정 국가를 고정하고자할 때, 아래의 목록에 루트 도메인과 국가 코드, 사이트 이름, 홈 화면 이름 등을 추가하면 된다.
 *
 * 예를 들면, philov.com 도메인을 필리핀 국가로 고정하는 경우, countryCode 를 PH 로 하고, 해당 도메인으로 접속하면, 카페 생성할 때에 국가 선택을 보여주지 않는다. 또한 각종 커스터마이징에서 필리핀으로 고정을 시킨다.
 *
 * @see README.md
 */
define('CAFE_COUNTRY_DOMAINS', [
    'philov.com' => [
        'countryCode' => 'PH',
        'name' => '필러브',
        'homeButtonLabel' => '홈',
    ],
]);