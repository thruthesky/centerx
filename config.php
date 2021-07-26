<?php
/**
 * @file config.php
 */


/**
 * zoomThumbnail() 함수로 썸네일을 저장할 때, 사용할 포멧.
 *
 * 기본적으로 JPEG 포멧으로 저장하는데, 이곳에서 'webp' 를 입력하여, WEBP 로 썸네일 이미지를 저장할 수 있다.
 */
const THUMBNAIL_FORMAT = 'webp';



//const TEMP_IP_ADDRESS = '124.83.114.70'; // Manila IP
const TEMP_IP_ADDRESS = '175.196.80.131'; // Seoul, Korea IP



/**
 * Domain & Theme
 *
 * @see README.md for the details.
 */
const DOMAIN_THEMES = [
    // $_SERVER['HTTP_HOST'] return empty string when the test runs on 'docker php container'.
    // So, when test runs, you can choose which view(theme) do you wan to use by specifying the view into '_' key.
    //
    '_' => 'default',
    'www_docker_nginx' => 'sonub',
    'flutterkorea' => 'default',
    'x.philov' => 'sonub',
    'cherry.philov' => 'sonub',
    'banana.philov' => 'sonub',
    'philov' => 'sonub',
    'sonub' => 'sonub',
    'sonubtheme' => 'sonub',
    'itsuda' => 'itsuda',
    '127.0.0.1' => 'default',
    'localhost' => 'admin',
    '169.254.194.6' => 'itsuda', // JaeHo Song's Emulator Access Point to Host OS.
    '192.168.100.6' => 'itsuda', // Ace's Emulator Access Point to Host OS.
    '192.168.100.17' => 'itsuda', // Charles Ip address
    '192.168.0.146' => 'itsuda', // Charles Ip address

    'tellvi' => 'sonub',
    'goldenage50' => 'itsuda',
    'dating' => 'dating',
];



debug_log("--- view-name : " . view()->folderName );


/**
 * Supported Domain Suffix.
 * 지원 도메인
 *
 * 현재 사이트에서 서비스하는 도메인의 최상위 도메인을 가져오거나 특정 도메인의 루트 도메인을 가져오고자 할 때, 지원되는 도메인들이다.
 * 만약, 필리핀 사이트 도메인을 사용(지원)하려 한다면, ph 와 com.ph 두개를 추가하면 된다.
 * 현재 사이트에서 사용하려는 도메인의 suffix 를 여기에 입력하면 된다. 예를 들어, abc.uk 도메인을 쓴다면, .uk 를 추가하면 된다.
 * 필요하다면, .com, .net, .org, .co.kr, .kr 등이 많이 쓰이는 도메인이므로 이것들을 추가하면 된다.
 */
const SUPPORTED_DOMAIN_SUFFIX = ['.com', '.co.kr', '.kr'];



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
const LOCAL_HOSTS = [
    'localhost', '127.0.0.1', 'local.itsuda50.com', 'main.philov.com', 'apple.philov.com',
    'banana.philov.com', 'cherry.philov.com', 'main.sonub.com', 'dating.com'
];



// Load database connection information.
// `keys` folder is not added to github. so it is safe to put database information in this file.
// DB 접속 정보가 keys 폴더에 존재하는지 확인. 아니면 config.php 의 접속 정보를 사용.
$_db_config_path = "";
if ( file_exists( view()->folder . 'keys/db.config.php') ) {
    $_db_config_path = view()->folder . 'keys/db.config.php';
} else if ( file_exists(ROOT_DIR . 'etc/keys/db.config.php') ) {
    $_db_config_path = ROOT_DIR . 'etc/keys/db.config.php';
}

if ( $_db_config_path ) {
    debug_log("--- loading db.config.php from : " . $_db_config_path );
    include $_db_config_path;
} else {
    debug_log("--- loading db.config.php : [ Not exists ]" );
}


/// @see readme
$_private_config_path = "";
if ( file_exists( view()->folder . 'keys/private.config.php') ) {
    $_private_config_path = view()->folder . 'keys/private.config.php';
} else if ( file_exists(ROOT_DIR . 'etc/keys/private.config.php') ) {
    $_private_config_path = ROOT_DIR . 'etc/keys/private.config.php';
}
if ( $_private_config_path ) {
    debug_log("--- loading private.config from : " . $_private_config_path );
    include $_private_config_path;
} else {
    debug_log("--- loading private.config from : [ Not exists ]");
}

/**
 * Load theme configuration
 * 각 테마별 설정 파일이 있으면 그 설정 파일을 사용한다.
 *
 * 참고로, 각 설정 파일에서 아래에서 정의되는 상수들을 미리 정의해서, 본 설정 파일에서 정의되는 값을 덮어 쓸 수 있다.
 */
$_config_path = view()->file( filename: 'config', prefixThemeName: true );


if ( file_exists($_config_path) ) {
    debug_log("--- loading view config.php from: view/".view()->folderName."/".view()->folderName.".config.php");
    require_once $_config_path;
} else {
    debug_log("--- loading view config.php : [ Not exists ]");
}


const APP_NAME = 'CenterX';

if ( !defined('DB_USER') ) define('DB_USER', 'centerx');
if ( !defined('DB_PASS') ) define('DB_PASS', 'Wc~Cx7');
if ( !defined('DB_NAME') ) define('DB_NAME', 'centerx');
if ( !defined('DB_HOST') ) define('DB_HOST', 'mariadb');


const DB_PREFIX = 'wc_';

// @todo 안보이는데로 이동 시킬 것.
const META_TABLE = DB_PREFIX . 'metas';



const DEFAULT_X_BOX_IMAGE = '/etc/img/x-box.jpg';

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
const UPLOAD_DIR = ROOT_DIR . 'files/uploads/';



/**
 * 현재 홈페이지 URL 을 강제로 지정한다.
 *
 * 기본적으로, HOME_URL 은 현재 웹 브라우저로 접속한 홈 URL 이 된다.
 * 현재 웹브라우저 접속 URL 이 아닌 다른 주소로 지정 할 수 있다.
 * 특히, CLI 로 작업을 하거나 테스트를 하는 경우, 현재 브라우저 접속 URL 값을 찾을 수 없으며,
 * 임시 도메인 주소인 기본 값인 DEFAULT_HOME_URL 상수가 사용한다. 물론변경 가능하다.
 * 주의, API 서버의 URL 이 http 로 시작하고, 슬래시(/)로 끝나야 한다. 예) https://www.abc.com/
 *
 */
if ( isCli() ) {
    define('HOME_URL', DEFAULT_HOME_URL);
} else {
    define('HOME_URL', get_current_root_url());
}

/// 이미지 다운로드 경로
/// 주의, API 서버의 URL 이 http 로 시작하고, 슬래시(/)로 끝난다. 예) https://www.abc.com/
if ( ! defined('UPLOAD_SERVER_URL') ) {
    define('UPLOAD_SERVER_URL', HOME_URL);
}





/**
 * Set admin email address.
 *
 * It can be a single email or multiple emails separated by comma.
 * I.e) 'thruthesky@gmail.com'
 * I.e) 'abc@domain.com,thruthesky@gmail.com,...'
 */
const ADMIN_EMAIL = 'thruthesky@gmail.com,pinedaclp@gmail.com';



/**
 * Firebase Admin Service Account Key, for firebase connection
 */
if ( ! defined('FIREBASE_ADMIN_SDK_SERVICE_ACCOUNT_KEY_PATH') ) {
    define("FIREBASE_ADMIN_SDK_SERVICE_ACCOUNT_KEY_PATH", ROOT_DIR . "etc/keys/firebase-admin-sdk.json");
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
const LIVE_RELOAD = true;
const LIVE_RELOAD_HOST = 'http://localhost';
const LIVE_RELOAD_PORT = '12345';

define('SUPPORTED_LANGUAGES', ['en', 'ko']);


/**
 * If you want the app/site to have a fixed language and ignore user's language, put language code like `en`, `ko`, `ch`, ...
 */
if ( ! defined('FIX_LANGUAGE') ) define('FIX_LANGUAGE', '');



/**
 * 각종 로그인(패스로그인, 카카오로그인, 등) 할 때, 사용되는 비밀번호.
 *
 * 랜덤 문자열을 입력하면 된다.
 * 단, 한번 설정하면 변경을 하면 안된다.
 */
if ( !defined('LOGIN_PASSWORD_SALT') ) define('LOGIN_PASSWORD_SALT', 'Change this string on production - PUP-bKgOW@aku1pa');

/**
 * PASS_LOGIN_MOBILE_PREFIX 은 회원 가입을 할 때, 전화번호로 하는데, 'm010123456789@passlogin.com' 와 같이 기록하기 위한 prefix 이다.
 */
if ( !defined('PASS_LOGIN_MOBILE_PREFIX') ) define('PASS_LOGIN_MOBILE_PREFIX', 'm');
if ( !defined('PASS_LOGIN_CLIENT_ID') ) define('PASS_LOGIN_CLIENT_ID', 'b90hirE4UYwVf2GkHIiK');
if ( !defined('PASS_LOGIN_CLIENT_SECRET_KEY') ) define('PASS_LOGIN_CLIENT_SECRET_KEY', '366c0f3775bfa48f2239226506659f5981afd3eb2b08189f9f9d22cdc4ca63c9');
if ( !defined('PASS_LOGIN_CALLBACK_URL') ) define('PASS_LOGIN_CALLBACK_URL', "https://sonub.com/etc/callbacks/pass-login/pass-login.callback.php");

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
 * Firebase configuration.
 *
 * To override this setting, simple define `FIREBASE_SDK_ADMIN_KEY` on your theme.
 * `FIREBASE_SDK_ADMIN_KEY` must be given a JSON value of the firebase admin JSON key.
 * If `FIREBASE_SDK_ADMIN_KEY` is defined as falsy, then firebase will not be initialized and will not be loaded by default.
 *
 */
if ( !defined('FIREBASE_SDK_ADMIN_KEY') ) {
    define('FIREBASE_SDK_ADMIN_KEY', <<<EOJ
{
    apiKey: "AIzaSyDWiVaWIIrAsEP-eHq6bFBY09HLyHHQW2U",
    authDomain: "sonub-version-2020.firebaseapp.com",
    databaseURL: "https://sonub-version-2020.firebaseio.com",
    projectId: "sonub-version-2020",
    storageBucket: "sonub-version-2020.appspot.com",
    messagingSenderId: "446424199137",
    appId: "1:446424199137:web:f421c562ba0a35ac89aca0",
    measurementId: "G-F86L9641ZQ"
}
EOJ);
}
// If `FIREBASE_SDK_ADMIN_KEY` is defined, then initialize the firebase. This code will be automatically inserted at the
// bottom of all theme.
if ( defined('FIREBASE_SDK_ADMIN_KEY') && FIREBASE_SDK_ADMIN_KEY ) {
    $__firebase_sdk_admin_key = FIREBASE_SDK_ADMIN_KEY;
    define('FIREBASE_BOOT_SCRIPTS', <<<EOH
<script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-messaging.js"></script>

<script>
    // Your web app's Firebase configuration
    var firebaseConfig = $__firebase_sdk_admin_key;
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
</script>
<script src="/etc/js/firebase/firebase.js"></script>
EOH);
}

if ( !defined('PUSH_NOTIFICATION_ICON_URL') ) define('PUSH_NOTIFICATION_ICON_URL', HOME_URL . 'etc/img/messaging/messaging-icon.png');



//
if ( !defined('OPENWEATHERMAP_API_KEY' ) ) define('OPENWEATHERMAP_API_KEY', '7cb555e44cdaac586538369ac275a33b');

// Free currconv api key from https://free.currencyconverterapi.com/
if ( !defined('CURRENCY_CONVERTER_API_KEY') ) define('CURRENCY_CONVERTER_API_KEY', 'bd6ed497a84496be7ee9');
if ( !defined('CURRENCY_CONVERTER_API_URL') ) define('CURRENCY_CONVERTER_API_URL', 'https://free.currconv.com/api/v7/convert');
if ( !defined('CURRENCY_CONVERTER_CACHE_EXPIRE') ) define('CURRENCY_CONVERTER_CACHE_EXPIRE', 60 * 60); // 1 hour



const MESSAGE_CATEGORY = 'message';








/**
 * Advertisement and Banner Settings
 *
 * 'point' is the point for that banner per 1 day.
 *
 * @todo Move banner settings to admin page.
 */
const ADVERTISEMENT_CATEGORY = 'advertisement';
const TOP_BANNER = 'top';
const SIDEBAR_BANNER = 'sidebar';
const SQUARE_BANNER = 'square';
const LINE_BANNER = 'line';
const BANNER_TYPES = [ TOP_BANNER, SIDEBAR_BANNER, SQUARE_BANNER, LINE_BANNER ];

/// @see readme.md
if ( !defined('MATRIX_API_KEYS' ) ) define('MATRIX_API_KEYS', []);
