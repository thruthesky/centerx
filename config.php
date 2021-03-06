<?php

define('DOMAIN_THEMES', [
    'philov' => 'sonub',
    'tellvi' => 'sonub',
    'sonub' => 'sonub',
    'goldenage50' => 'itsuda',
    'itsuda' => 'itsuda',
    '127.0.0.1' => 'itsuda',
    'localhost' => 'itsuda',
    '169.254.194.6' => 'itsuda', // JaeHo Song's Emulator Access Point to Host OS.
    '192.168.100.6' => 'itsuda', // Ace's Emulator Access Point to Host OS.
    '192.168.100.17' => 'itsuda', // Charles Ip address
]);


/**
 * 각 테마별 설정 파일이 있으면 그 설정 파일을 사용한다.
 *
 * 참고로, 각 설정 파일에서 아래에서 정의되는 상수들을 미리 정의해서, 본 설정 파일에서 정의되는 값을 덮어 쓸 수 있다.
 */
$_path = theme()->file( filename: 'config', prefixThemeName: true );
if ( file_exists($_path) ) {
    require_once $_path;
}


define('APP_NAME', 'Center Backend');



define('DB_USER', 'myuser');
define('DB_PASS', 'mypass');
define('DB_NAME', 'mydatabase');
define('DB_HOST', 'mariadb');


define('DB_PREFIX', 'wc_');



/**
 * Cookie domain
 *
 * If you set the cookie domain, it will apply the cookies on that domain.
 * This is useful to apply login cookie to all subdomains.
 *
 * To apply login cookie(and all other cookies) to all sub domains, set the root domain(like `.domain.com`) name here
 *   - note, that dot(.) must be added on root domain.
 *
 * 만약, 개별 설정에서 정의된 쿠키가 없으면, 자동으로 ROOT_DOMAINS 에 있는 것을 기반으로 최상위 도메인(1차) 도메인으로 지정한다.
 */
if ( !defined('COOKIE_DOMAIN') ) {
    define('COOKIE_DOMAIN', '.' . get_root_domain());
}



define('DEBUG_LOG_FILE_PATH', ROOT_DIR . 'var/logs/debug.log');



/**
 * This can be an absolute or relative path.
 */
define('UPLOAD_DIR', ROOT_DIR . 'files/uploads/');
define('THUMBNAILS_DIR', ROOT_DIR . 'files/thumbnails/');

if ( isCli() ) {
    define('ROOT_URL', UPLOAD_DIR);
} else {
    define('ROOT_URL', get_current_root_url());
}


define('UPLOAD_URL', ROOT_URL . 'files/uploads/');
define('THUMBNAILS_URL', ROOT_URL . 'files/thumbnails/');


/**
 * Set admin email address.
 */
define('ADMIN_EMAIL', 'thruthesky@gmail.com');



/**
 * Firebase Admin Service Account Key, for firebase connection
 */
if ( ! defined('FIREBASE_ADMIN_SDK_SERVICE_ACCOUNT_KEY_PATH') ) {
    define("FIREBASE_ADMIN_SDK_SERVICE_ACCOUNT_KEY_PATH", ROOT_DIR . "etc/keys/itsuda50-firebase-adminsdk.json");
}
if ( ! defined('FIREBASE_DATABASE_URI') ) {
    define("FIREBASE_DATABASE_URI", "https://itsuda50-default-rtdb.firebaseio.com/");
}


/**
 * If this is set to true, the user who registers will subscribe for 'new comments' under his post or comment.
 * If this is set to false, the registering user will not subscribe to 'new comments'.
 * The user can change this option on settings.
 * By default it is set to 'true'
 */
define('SUBSCRIBE_NEW_COMMENT_ON_REGISTRATION', true);


define('DEFAULT_DELIVERY_FEE_FREE_LIMIT', 3000);
define('DEFAULT_DELIVERY_FEE_PRICE', 2500);



define('LIVE_RELOAD_HOST', 'main.philov.com');
define('LIVE_RELOAD_PORT', '12345');



define('SUPPORTED_LANGUAGES', ['en', 'ko']);


/**
 * If you want the app/site to have a fixed language and ignore user's language, put language code like `en`, `ko`, `ch`, ...
 */
if ( ! defined('FIX_LANGUAGE') ) define('FIX_LANGUAGE', '');




/**
 * 각종 로그인(패스로그인, 카카오로그인, 등) 할 때, 사용되는 비밀번호.
 */
define('LOGIN_PASSWORD_SALT', 'Random_Salt_oO^.^7Oo_S.0.48.PM,*, Once set, should not be changed!'); // This is any random (secret) string.

/**
 * PASS_LOGIN_MOBILE_PREFIX 은 회원 가입을 할 때, 전화번호로 하는데, 'm010123456789@passlogin.com' 와 같이 기록하기 위한 prefix 이다.
 */
if ( !defined('PASS_LOGIN_MOBILE_PREFIX') ) define('PASS_LOGIN_MOBILE_PREFIX', 'm');
if ( !defined('PASS_LOGIN_CLIENT_ID') ) define('PASS_LOGIN_CLIENT_ID', 'b90hirE4UYwVf2GkHIiK');
if ( !defined('PASS_LOGIN_CLIENT_SECRET_KEY') ) define('PASS_LOGIN_CLIENT_SECRET_KEY', '366c0f3775bfa48f2239226506659f5981afd3eb2b08189f9f9d22cdc4ca63c9');
if ( !defined('PASS_LOGIN_CALLBACK_URL') ) define('PASS_LOGIN_CALLBACK_URL', "https://local.itsuda50.com/etc/callbacks/pass-login.callback.php");

// 날짜 설정
//
// 추천/비추천 및 게시글/코멘트 쓰기 제한 등에서, 일/수 단위로 제한을 할 때, 한국 시간으로 할지, 어느나라 시간으로 할 지 지정 할 수 있다.
date_default_timezone_set('Asia/Seoul');


// Kakao Javascript Api 키
if ( !defined('KAKAO_CLIENT_ID') ) define('KAKAO_CLIENT_ID', '6f8d49d406555f69828891821ea56c8b');
// Kakao Redirect URI
if ( !defined('KAKAO_CALLBACK_URL') ) define('KAKAO_CALLBACK_URL', 'https://main.philov.com/wp-content/themes/sonub/callbacks/kakao-login.callback.php');



if ( !defined('NAVER_CLIENT_ID') ) define('NAVER_CLIENT_ID', 'gCVN3T_vsOmX1ADriDOA');
if ( !defined('NAVER_CLIENT_SECRET') ) define('NAVER_CLIENT_SECRET', 'JzWh7zPeJF');
if ( !defined('NAVER_CALLBACK_URL') ) define('NAVER_CALLBACK_URL', urlencode('https://main.philov.com/wp-content/themes/sonub/callbacks/naver-login.callback.php'));
if ( !defined('NAVER_API_URL') ) define('NAVER_API_URL', "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".NAVER_CLIENT_ID."&redirect_uri=".NAVER_CALLBACK_URL."&state=1");


/**
 * Local hosts
 *
 * 현재 컴퓨터에서 테스트하는 도메인을 기록. 이 도메인으로 접속하면, 실제 서버가 아닌 현재 컴퓨터로 접속을 하며, 테스트를 위한 것이다.
 * 특히, 이 도메인으로 접속하면, isLocalhost() 에서 참을 리턴한다.
 */
define('LOCAL_HOSTS', ['localhost', 'local.itsuda50.com']);