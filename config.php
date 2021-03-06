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





