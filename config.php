<?php
/**
 * @file config.php
 */
/**
 * Debug Configurations
 * 디버그 옵션 및 기록할 로그 파일 경로
 *
 * If DEBUG_LOG is set to false, no debug log will recorded.
 */
const DEBUG_LOG = true;
const DEBUG_LOG_FILE_PATH = ROOT_DIR . 'var/logs/debug.log';

const TEMP_IP_ADDRESS = '124.83.114.70'; // Manila IP

/**
 * Domain & Theme
 *
 * @see README.md for the details.
 */
define('DOMAIN_THEMES', [
    'cherry.philov' => 'x',
    'itsuda' => 'itsuda',
    '127.0.0.1' => 'default',
    'localhost' => 'default',
    '169.254.194.6' => 'itsuda', // JaeHo Song's Emulator Access Point to Host OS.
    '192.168.100.6' => 'itsuda', // Ace's Emulator Access Point to Host OS.
    '192.168.100.17' => 'itsuda', // Charles Ip address
    '192.168.0.146' => 'itsuda', // Charles Ip address

    'philov' => 'sonub',
    'tellvi' => 'sonub',
    'sonub' => 'sonub',
    'goldenage50' => 'itsuda',
    'dating' => 'dating',
]);



/**
 * Supported Domain Suffix.
 * 지원 도메인
 *
 * 현재 사이트에서 서비스하는 도메인의 최상위 도메인을 가져오거나 특정 도메인의 루트 도메인을 가져오고자 할 때, 지원되는 도메인들이다.
 * 만약, 필리핀 사이트 도메인을 사용(지원)하려 한다면, ph 와 com.ph 두개를 추가하면 된다.
 * 현재 사이트에서 사용하려는 도메인의 suffix 를 여기에 입력하면 된다. 예를 들어, abc.uk 도메인을 쓴다면, .uk 를 추가하면 된다.
 * 필요하다면, .com, .net, .org, .co.kr, .kr 등이 많이 쓰이는 도메인이므로 이것들을 추가하면 된다.
 */
define('SUPPORTED_DOMAIN_SUFFIX', ['.com', '.co.kr', '.kr']);



/**
 * Local hosts
 *
 * Add test domains. This is to determine whether the service is local development or not.
 * All the domains specified here are considered as local server.
 *
 * 현재 컴퓨터에서 테스트하는 도메인을 기록. 이 도메인으로 접속하면, 실제 서버가 아닌 현재 컴퓨터로 접속을 하며, 테스트를 위한 것이다.
 * 특히, 이 도메인으로 접속하면, isLocalhost() 에서 참을 리턴한다.
 *
 * 참고, 테마 설정 파일에서 isLocalhost() 를 사용 할 수 있으므로, 테마 설정이 로드되기 전에 정의되어야 한다.
 */
define('LOCAL_HOSTS',
    ['localhost', '127.0.0.1', 'local.itsuda50.com', 'main.philov.com', 'apple.philov.com',
    'banana.philov.com', 'cherry.philov.com',
    'main.sonub.com', 'dating.com',
]);



/// DB 접속 정보가 keys 폴더에 존재하는지 확인. 아니면 config.php 의 접속 정보를 사용.
if ( file_exists( theme()->folder . 'keys/db.password.php') ) {
    include theme()->folder . 'keys/db.password.php';
} else if ( file_exists(ROOT_DIR . 'etc/keys/db.password.php') ) {
    include ROOT_DIR . 'etc/keys/db.password.php';
}


/**
 * Load theme configuration
 * 각 테마별 설정 파일이 있으면 그 설정 파일을 사용한다.
 *
 * 참고로, 각 설정 파일에서 아래에서 정의되는 상수들을 미리 정의해서, 본 설정 파일에서 정의되는 값을 덮어 쓸 수 있다.
 */
$_path = theme()->file( filename: 'config', prefixThemeName: true );

debug_log("Theme Config Path: $_path");
if ( file_exists($_path) ) {
    require_once $_path;
}



define('APP_NAME', 'CenterX');

if ( !defined('DB_USER') ) define('DB_USER', 'centerx');
if ( !defined('DB_PASS') ) define('DB_PASS', 'Wc~Cx7');
if ( !defined('DB_NAME') ) define('DB_NAME', 'centerx');
if ( !defined('DB_HOST') ) define('DB_HOST', 'mariadb');


define('DB_PREFIX', 'wc_');

// @todo 안보이는데로 이동 시킬 것.
define('META_TABLE', DB_PREFIX . 'metas');



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
    $_rootDomain = get_root_domain();
    if ( $_rootDomain == 'localhost' || $_rootDomain == '127.0.0.1' ) $_cookieDomain = $_rootDomain;
    else $_cookieDomain = ".$_rootDomain";
    define('COOKIE_DOMAIN', $_cookieDomain);
}






/**
 * This can be an absolute or relative path.
 */
define('UPLOAD_DIR', ROOT_DIR . 'files/uploads/');
define('THUMBNAILS_DIR', ROOT_DIR . 'files/thumbnails/');


/**
 * 현재 홈페이지 URL 을 강제로 지정한다.
 *
 * 기본적으로, HOME_URL 은 현재 웹 브라우저로 접속한 홈 URL 이 된다.
 * 현재 웹브라우저 접속 URL 이 아닌 다른 주소로 지정 할 수 있다.
 * 특히, CLI 로 작업을 하거나 테스트를 하는 경우, 현재 브라우저 접속 URL 값을 찾을 수 없으며,
 * 임시 도메인 주소인 기본 값인 DEFAULT_HOME_URL 상수가 사용한다. 물론변경 가능하다.
 * 주의, URL 이 슬래시(/)로 끝나야 한다.
 *
 */
if ( isCli() ) {
    define('HOME_URL', DEFAULT_HOME_URL);
} else {
    define('HOME_URL', get_current_root_url());
}
define('UPLOAD_URL', HOME_URL . 'files/uploads/');
define('THUMBNAILS_URL', HOME_URL . 'files/thumbnails/');







/**
 * Set admin email address.
 *
 * It can be a single email or multiple emails separated by comma.
 * I.e) 'thruthesky@gmail.com'
 * I.e) 'abc@domain.com,thruthesky@gmail.com,...'
 */
define('ADMIN_EMAIL', 'admin@itsuda50.com,thruthesky@gmail.com');



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
 * 인앱구매를 할 때에, 안드로이드 앱에서 결제 후, 서버에서 검증하기 위한 GCP service account json 파일과 package name.
 * iOS 에서는 따로 설정 할 것이 없다.
 */
define("GCP_SERVICE_ACCOUNT_KEY_JSON_FILE_PATH", ROOT_DIR . "themes/itsuda/keys/gcp_service_account_key.json");
define("ANDROID_APP_ID", "com.itsuda50.app3");




/**
 * If this is set to true, the user who registers will subscribe for 'new comments' under his post or comment.
 * If this is set to false, the registering user will not subscribe to 'new comments'.
 * The user can change this option on settings.
 * By default it is set to 'true'
 */
define('SUBSCRIBE_NEW_COMMENT_ON_REGISTRATION', true);


define('DEFAULT_DELIVERY_FEE_FREE_LIMIT', 3000);
define('DEFAULT_DELIVERY_FEE_PRICE', 2500);



/**
 * @see readme#Live Reload
 */
define('LIVE_RELOAD_HOST', 'https://main.philov.com');
define('LIVE_RELOAD_PORT', '12345');


define('SUPPORTED_LANGUAGES', ['en', 'ko']);


/**
 * If you want the app/site to have a fixed language and ignore user's language, put language code like `en`, `ko`, `ch`, ...
 */
if ( ! defined('FIX_LANGUAGE') ) define('FIX_LANGUAGE', '');




/**
 * 각종 로그인(패스로그인, 카카오로그인, 등) 할 때, 사용되는 비밀번호.
 */
if ( !defined('LOGIN_PASSWORD_SALT') ) define('LOGIN_PASSWORD_SALT', 'Random_Salt_oO^.^7Oo_S.0.48.PM,*, Once set, should not be changed!'); // This is any random (secret) string.

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
if ( !defined('JAVASCRIPT_KAKAO_CLIENT_ID') ) define('JAVASCRIPT_KAKAO_CLIENT_ID', '6f8d49d406555f69828891821ea56c8b');
// Kakao Redirect URI
if ( !defined('JAVASCRIPT_KAKAO_CALLBACK_URL') ) define('JAVASCRIPT_KAKAO_CALLBACK_URL', '/etc/callbacks/kakao/kakao-login.callback.php');



if ( !defined('NAVER_CLIENT_ID') ) define('NAVER_CLIENT_ID', 'gCVN3T_vsOmX1ADriDOA');
if ( !defined('NAVER_CLIENT_SECRET') ) define('NAVER_CLIENT_SECRET', 'JzWh7zPeJF');
if ( !defined('NAVER_CALLBACK_URL') ) define('NAVER_CALLBACK_URL', urlencode('https://main.philov.com/wp-content/themes/sonub/callbacks/naver-login.callback.php'));
if ( !defined('NAVER_API_URL') ) define('NAVER_API_URL', "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".NAVER_CLIENT_ID."&redirect_uri=".NAVER_CALLBACK_URL."&state=1");


/**
 * Firebase 사용을 위한 설정
 *
 * Firebase 콘솔에서 해당 프로젝트에서 제공하는 설정을 그대로 이곳에 복사해 넣으면 된다.
 * 그리고 필요한 firebase auth 또는 firebase firestore 등을 추가하면 된다.
 *
 * 만약, Firebase 를 사용하지 않는다면, 이 값을 null 로 주면 된다.
 */
$__firebase_sdk = <<<EOH
<!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>

<!-- Add Firebase products like firestore -->
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-firestore.js"></script>

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyBx4GE4qdL1tMxPzxlhfyYlnlTdid17wig",
    authDomain: "itsuda503.firebaseapp.com",
    projectId: "itsuda503",
    storageBucket: "itsuda503.appspot.com",
    messagingSenderId: "855580642229",
    appId: "1:855580642229:web:6df58a658839d249fd27fc"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
</script>
EOH;
if ( !defined('FIREBASE_SDK') ) define('FIREBASE_SDK', $__firebase_sdk);


// Free currconv api key from https://free.currencyconverterapi.com/
if ( !defined('CURRCONV_API_KEY') ) define('CURRCONV_API_KEY', 'bd6ed497a84496be7ee9');


if ( !defined('OPENWEATHERMAP_API_KEY' ) ) define('OPENWEATHERMAP_API_KEY', '7cb555e44cdaac586538369ac275a33b');

