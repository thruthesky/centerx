<?php
/**
 * @file functions.php
 */
use PHPHtmlParser\Dom;


/**
 *
 * @note By default it returns null if the key does not exist.
 *
 *
 * @param $name
 * @param null $default
 * @return mixed
 *
 */
function in($name = null, $default = null): mixed
{

    // If the request is made by application/json content-type,
    // Then get the data as JSON input.
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

    if (stripos($contentType, 'application/json') !== false) {
        $_REQUEST = get_JSON_input();
    }

    if ($name === null) {
        return $_REQUEST;
    }
    if (isset($_REQUEST[$name])) {
        return $_REQUEST[$name];
    } else {
        return $default;
    }
}


/**
 * JSON input from Client
 * @return mixed|null
 */
function get_JSON_input()
{

    // Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));

    // Attempt to decode the incoming RAW post data from JSON.
    $decoded = json_decode($content, true);

    // If json_decode failed, the JSON is invalid.
    if (!is_array($decoded)) {
        return null;
    }

    return $decoded;
}



function d($obj, $msg = null) {
//    print_r(debug_backtrace());
    if ( isCli() || isTesting() ) echo "\nd(): ";
    else echo "<xmp>";
    if ($msg) echo "\n$msg\n";
    print_r($obj);
    if ( isCli() || isTesting() ) echo "\n";
    else echo "</xmp>";
}


/**
 * @return bool
 */
function isCli(): bool
{
    return php_sapi_name() == 'cli';
}


/**
 * Returns true if the web is running on localhost (or developers computer).
 * @return bool
 */
function isLocalhost(): bool
{
    if (isCli()) return false;
    if ( isset($_SERVER['SERVER_ADDR']) ) {
        if ( str_starts_with($_SERVER['SERVER_ADDR'], '127.') ) return true;
        if ( str_starts_with($_SERVER['SERVER_ADDR'], '192.') ) return true;
        if ( str_starts_with($_SERVER['SERVER_ADDR'], "172.22.")) return true;
        if ( str_starts_with($_SERVER['SERVER_ADDR'], "172.18.")) return true; // charles docker
    }
    if ( in_array(get_domain_name(), LOCAL_HOSTS) ) return true;

    return false;
}


/**
 * 모바일이면 참을 리턴한다.
 * @return bool
 */
function isMobile() {
    $mobileDetect = new \Detection\MobileDetect();
    return $mobileDetect->isMobile() || $mobileDetect->isTablet();
}


/**
 * Live reload
 *
 * When PHP, Javascript, CSS files are edited, the browser will automatically reload.
 *
 * @note This method display live reload javascript code ONLY when `node live-reload.js` is running
 *  And when it should do 'live-reload'.
 */
function live_reload()
{
    if ( canLiveReload() ) {
        $rootUrl = LIVE_RELOAD_HOST;
        $port = LIVE_RELOAD_PORT;

        $url = "$rootUrl:$port/socket.io/socket.io.js";

        echo <<<EOH
    <script src="$url"></script>
    <script>
        if( window.Cypress || typeof io === 'undefined') {
            // Don't watch for live-reload if it is Cypress testing or failed to load socket.io.js (that means, live-reload.js is not running)
        } else {
            console.log("Live reload enabled...");
            var socket = io("$rootUrl:$port/");
            socket.on('reload', function (data) {
                console.log('live reloading...', data);
                location.reload();
            });            
        }
    </script>
EOH;
    }
}




function canLiveReload(): bool {

    // index.php 가 아니면, live reload 안 함.
    if ( !isset($_SERVER['PHP_SELF']) || !str_ends_with($_SERVER['PHP_SELF'], 'index.php')  ) {
        return false;
    }

    if ( str_ends_with(in('p', ''), '.submit') ) {
        return false;
    }

    if ( LIVE_RELOAD == false ) return false;
    if ( ! LIVE_RELOAD_HOST ) return false;

    // API call 이면, false. 단, reload 에 값이 들어오면, reload.
    if ( API_CALL ) {
        if ( ! in('reload') ) return false;
    }
    // CLI 에서 실행하면 false
    if ( isCli() ) return false;

    // PhpThumb 이면 false
    if ( isPhpThumb() ) return false;

    // 로컬 도메인이 아니면, false
    if ( isLocalhost() == false ) return false;

    //
    if ( defined('STOP_LIVE_RELOAD') && STOP_LIVE_RELOAD ) return false;

    return true;

//    return !API_CALL && !isCli() && !isPhpThumb();
}



/**
 * 도메인을 리턴한다.
 * 예) www.abc.com, second.host.abc.com
 * Returns requested url domain
 * @return string
 */
function get_host_name(): string
{
    if (isset($_SERVER['HTTP_HOST'])) return $_SERVER['HTTP_HOST'];
    else return '';
}


/**
 * Alias of get_host_name()
 * @return string
 */
function get_domain() : string
{
    return get_host_name();
}
/**
 * Alias of get_host_name()
 * @return string
 */
function get_domain_name(): string
{
    return get_host_name();
}

/**
 * Returns the root url of current page(url) including ending slash(/).
 * If HOME_URL is set, then it will use HOME_URL as its root url.
 * @return string
 */
function get_current_root_url(): string {
    if ( ! isset($_SERVER['HTTP_HOST']) ) return DEFAULT_HOME_URL;
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'] . '/';
}


/**
 * 1차 도메인을 리턴한다.
 *
 * 예)
 * www.abc.co.kr -> abc.co.kr
 * apple.banana.philgo.com -> philgo.com
 *
 * @param string|null $_domain 테스트 할 도메인
 * @return string
 *
 * @see api/phpunit/GetDomainNamesTest.php for test.
 */
function get_root_domain(string $_domain = null): string {
    if ( $_domain == null ) $_domain = get_domain_name();
    if ( empty($_domain) ) return '';


    foreach( SUPPORTED_DOMAIN_SUFFIX as $_root ) {
        if ( stripos($_domain, $_root) !== false ) {
            $_without_root = str_ireplace($_root, '', $_domain);
            $_parts = explode('.', $_without_root);
            $_1st = array_pop($_parts);
            $_domain = $_1st . $_root;
            break;
        }
    }
    return $_domain;
}



function jsGo($url)
{
    echo "
    <script>
        location.href='$url';
    </script>
    ";
    exit;
}


function jsAlertGo($msg, $url)
{
    echo "
    <script>
        alert('$msg');
        location.href='$url';
    </script>
    ";
    exit;
}



/**
 * Javascript 로 돌아가기를 하고, PHP exit 한다.
 * @param $msg
 *
 */
function jsBack($msg) {
    echo "
    <script>
        alert('$msg');
        history.go(-1);
    </script>
    ";
    exit;
}


function jsAlert($msg)
{
    echo "
    <script>
        alert('$msg');
    </script>
    ";
    return 0;
}



/**
 * 로그인한 사용자의 프로필을 담는 변수.
 *
 * 이 변수에 사용자 프로필이 있으면 그 사용자가 로그인을 한 사용자가 된다. 로그인 사용자를 변경하고자 한다면 이 변수를 다른 사용자의 users 레코드를 넣으면 된다.
 * 이 변수를 직접 사용하지 말고, 사용자 로그인을 시킬 때에는 setUserAsLogin() 을 쓰고, 사용 할 때에는 login() 을 사용하면 된다.
 */
global $__login_user_profile;

/**
 * Set the user of $profile as logged into the system.
 *
 * @attention, it does not save login information into cookies. It only set the user login in current session.
 *
 * @param int|array $profile
 * @return UserModel
 * @todo memory cache login user object
 */
function setUserAsLogin(int|array $profile): UserModel {
    global $__login_user_profile;
    if ( is_int($profile) ) $profile = user($profile)->getData();
    $__login_user_profile = $profile;
    return user($profile[IDX] ?? 0);
}

/**
 * API(라우트) 호출이 아닌 경우, 쿠키의 값을 확인해서 로그인을 한다.
 */
function cookieLogin() {

    if ( API_CALL ) return;

    // Login into PHP runtime.
    setUserAsLogin(getProfileFromCookieSessionId());

}


function setLogout() {
    global $__login_user_profile;
    $__login_user_profile = [];
}

/**
 * 문자열을 암호화한다.
 * MD5 가 아니라, 더 복잡한 암호화를 한다.
 *
 * @param $str
 * @return false|string|null
 */
function encryptPassword( $str ) {
    return password_hash( $str, PASSWORD_DEFAULT );
}


/**
 * 입력된 plain text 문자열이 암호화된 문자열과 동일한지 확인한다.
 * Returns true if password matches.
 *
 * @param $plain_text_password
 * @param $encrypted_password
 * @return bool
 *
 * @code
 *      if ( ! checkPassword( in('old_password'), $user->password ) ) return ERROR_WRONG_PASSWORD;
 * @endcode
 */
function checkPassword( $plain_text_password, $encrypted_password ) {
    return password_verify( $plain_text_password, $encrypted_password );
}



/**
 *
 * Set login cookies
 *
 * 입력된 사용자($user 객체)를 바탕으로 자바스크립트와 호환되도록 쿠키에 로그인 sessionId 를 저장한다.
 *
 * @참고, Matrix 버전에서는 백엔드 용으로만 사용되므로, PHP 에서 쿠키를 저장 할 이유가 없다.
 *  다만, "휴대폰번호 PASS 로그인" 등과 같이 백엔드에서 로그인을 한 다음 웹(클라이언트)에 로그인을 공유해야 할 경우 등에서 사용된다.
 *
 * When user login, the session_id must be saved in cookie. And it is shared with Javascript.
 *
 * @param UserModel $user - 사용자.
 */
function setLoginCookies(UserModel $user): void {
    setAppCookie(SESSION_ID , $user->sessionId);
}

/**
 * Set login cookies
 *
 * When user login, the session_id must be saved in cookie. And it is shared with Javascript.
 * @param $profile
 */
function unsetLoginCookies() {
    removeAppCookie(SESSION_ID);
    removeAppCookie(NICKNAME);
    removeAppCookie(PHOTO_URL);
}

/**
 * 앱(PWA, Client Web app)과 통신하기 위해서 쿠키를 저장한다.
 *
 * @param $name
 * @param $value
 */
function setAppCookie($name, $value) {
    setcookie ( $name , $value, time() + 365 * 24 * 60 * 60 , '/' , COOKIE_DOMAIN);
}

/**
 * @param $name
 */
function removeAppCookie($name) {
    setcookie($name, "", time()-3600, '/', COOKIE_DOMAIN);
}

/**
 * 앱에서 사용하는 쿠키를 가져온다.
 *
 * 이 쿠키 정보는 자바스크립트 클라이언트 엔드와 호환되어야 한다. 즉, Vue.js 나 Angular 에서 로그인을 하면, PHP 에서도 자동 로그인이 되도록 한다.
 * @param $name
 * @return mixed|null
 */
function getAppCookie($name) {
//    $name = md5($name);
    if ( !isset($_COOKIE[$name]) ) return null;
    else return $_COOKIE[$name];
}



/**
 * 사용자의 세션 ID 를 리턴한다.
 * 비밀번호를 세션 ID 생성에 포함하지 않는다. 즉, 비밀번호를 변경해도 로그인이 풀리지 않는다.
 * @see README.md
 * @param $profile
 * @return false|string|null
 */
function getSessionId($profile) {
    if ( !$profile || !isset($profile[IDX]) ) return null;
    $str= $profile[IDX] . $profile[CREATED_AT] . $profile[EMAIL] . LOGIN_PASSWORD_SALT;
    return $profile[IDX] . '-' . md5($str);
}


/**
 * 로그인한 사용자의 User()->profile()을 리턴한다. 주의: 비밀번호 포함.
 * @return array|bool - 쿠키에 세션 정보가 없거나 올바르지 않으면 false 를 리턴한다.
 *
 * 예제) 쿠키에 있는 정보로 회원 로그인을 시킬 때, 아래와 같이 한다.
 *
 * ```
 * setUserAsLogin(getProfileFromCookieSessionId());
 * ```
 */
function getProfileFromCookieSessionId() : array|bool {
    $sid = getAppCookie(SESSION_ID);
    if ( empty($sid) ) return false;
    return getProfileFromSessionId($sid);
}

/**
 * Let user login with sessionId.
 *
 * @param string $sessionId
 * @return array|bool|string
 * - false if `sessionId` is empty.
 * - error_user_not_found if there is no user by that session_id.
 * - error_wrong_session_id if the sessionId is wrong.
 * - or user profile if there is no error.
 *
 * 예제) 세션 아이디를 입력받아 해당 사용자를 로그인 시킬 때,
 *  setUserAsLogin( getProfileFromSessionId( in(SESSION_ID) ) );
 */
function getProfileFromSessionId(string $sessionId): array|bool|string
{
    if ( ! $sessionId ) return false;
    $arr = explode('-', $sessionId);
    $userIdx = $arr[0];
    $user = user(intval($userIdx));
    if ( $user->notFound ) return e()->user_not_found_by_that_session_id;
    $profile = $user->profile();
    if ( !$profile || !isset($profile[SESSION_ID]) ) return false;

    if ( $sessionId == $profile[SESSION_ID] ) return $profile;
    else {
        return e()->wrong_session_id;
    }
}




/**
 * 로그인을 했는지 안했는지만 확인한다.
 * @return bool
 *
 * 예제)
 *      d(loggedIn() ? 'loggedIn' : 'not loggedIn');
 *      d(login()->profile());
 */
function loggedIn(): bool {
    return login(IDX) ? true: false;
//    global $__login_user_profile;
//    if ( isset($__login_user_profile) && $__login_user_profile && isset($__login_user_profile[IDX]) ) {
//        return true;
//    }
//    return false;
}
function notLoggedIn(): bool {
    return ! loggedIn();
}


/**
 * Return true if login user is admin.
 * @return bool
 *
 * @warning When tests run, `ADMIN` config will be changed, meaning you have to set it again.
 */
function admin(string $email = null): bool {
    if ( $email == null ) {
        if ( login()->idx == 0 ) return false;
        $email = login()->email;
    }
    if ( str_contains(ADMIN_EMAIL, $email) ) return true;
    return str_contains(metaConfig()->get(ADMIN), $email);
}

function debug_log($message, $data='') {
    if ( DEBUG_LOG == false ) return;
    $str = print_r($message, true);
    $str .= ' ' . print_r($data, true);
    $str .= "\n";
    error_log($str, 3, DEBUG_LOG_FILE_PATH);
}

function leave_starting_debug_log() {
    if ( DEBUG_LOG == false ) return;
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    $phpSelf = $_SERVER['PHP_SELF'] ?? '';
    debug_log("\n>\n>\n> --- start --- $phpSelf / (uri) $uri --> boot.code.php:", date('m/d H:i:s') . "\n>\n>\n");
    if ( str_contains($phpSelf, 'phpThumb.php') == false ) {
        debug_log('in();', in());
    }
}


/**
 *
 * - widget_id 가 없으면, 설정을 하지 않는다. 즉, 설정없이 그냥 사용하는 것이다.
 * - 최소 한번만 설정을 한다, 따라서, 설정을 매번 스크립트가 로드할 때마다 바꾸고 싶다면, $widgetId 를 변경해 주면 된다.
 *
 * @param string $path
 * @param array $options
 *
 * @return string
 * @example
 *  include widget('post-latest/post-latest-default')
 */
function widget(string $path, array $options=[]) {
    setWidgetOptions($options);
    return get_widget_script_path($path);
}

function get_widget_script_path(string $path, string $filename = null): string {
    $arr = explode('/', $path);
    $filename ??= $arr[1];
    $path = ROOT_DIR . "widgets/$arr[0]/$arr[1]/$filename.php";
    return $path;
}

/**
 * 위젯 옵션 변수를 설정 할 때, 변수가 하나 뿐이므로, 덮어쓰여질 수 있으니 주의해야 한다.
 * @todo 각 위젯 호출 마다, 옵션 값을 따로 저장 할 것.
 */
$__widget_options = [];
function setWidgetOptions(array $options) {
    global $__widget_options;
    $__widget_options = $options;
}

/**
 * @warning You MUST put the return value into a unique variable
 *  IF you are going to include widgets in nested loops.
 * @example
 *  $op = getWidgetOptions();
 * @return array
 *
 */
function getWidgetOptions() {
    global $__widget_options;
    return $__widget_options;
}



/**
 * @attention Use this function only for Api call.
 * @param string $code
 */
function error(string $code) {
    header('Content-Type: application/json');
    echo json_encode([
        'response' => $code,
        'request' => in(),
    ]);
    exit;
}

/**
 * @attention Use this function only for Api call.
 * @param mixed $data
 */
function success(mixed $data) {
    header('Content-Type: application/json');

    hook()->run(HOOK_SUCCESS, $data);
    echo json_encode([
        'response' => $data,
        'request' => in(),
    ]);
    exit;
}

/**
 * Custom Api Route 를 추가한다.
 *
 * $__routes holds routes functions.
 *
 * 참고, 훅과 다르게 Api Route 는 같은 Route 에 여러개의 함수를 정의 할 수 없고, 하나만 정의 할 수 있다.
 * 참고, view 에서 controller 에 존재하는 것들을 overwrite 할 수 있다.
 */
$__routes = [];
function addRoute($routeName, $func) {
    global $__routes;
    $__routes[ $routeName ] = $func;
}

/**
 * Return route function or false.
 * @param string|null $routeName
 * @return mixed
 */
function getRoute(string|null $routeName): mixed
{
    global $__routes;
    if ( isset($__routes[$routeName]) ) return $__routes[$routeName];
    return false;
}




/**
 * @param $email
 *
 * @return bool
 */
function checkEmailFormat($email): bool
{

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}


/**
 * Safe file name to write in HDD.
 * @param string $name
 * @return string
 */
function safeFilename(string $name) {
    $pi = pathinfo($name);
    if ( isset($pi['extension']) ) {
        $name = $pi['filename'];
    }
    $name = seoFriendlyString($name);
    if ( isset($pi['extension']) ) {
        $name = $name . '.' . $pi['extension'];
    }
    return $name;
}

/**
 * Transform the $s into SEO friendly.
 *
 * It can be used to convert a filename into safe file name when uploading files.
 *
 * Ex) 'Hotels in Buenos Aires' => 'hotels-in-buenos-aires'
 *
 *    - converts all alpha chars to lowercase
 *    - not allow two "-" chars continued, convert them into only one single "-"
 *
 * @param string $s
 * @return string
 */
function seoFriendlyString(string $s): string {

    $s = trim($s);

    $s = html_entity_decode($s);

    $s = strip_tags($s);


    // 모두 소문자로 변경한다.
    $s = strtolower($s);

    // 여러개의 --- 를 한개의 - 로 변경한다.
    $s = preg_replace('~-+~', '-', $s);


    // 특수 문자를 없애거나 - 로 대체한다.

    $s = str_replace("+"," ", $s); // 특히, + 문자는 문제를 일으킬 소지가 많다. 그렇다고 + 를 - 로 변경하면 의미가 크게 변경 될 수 있다. 그래서 공백으로 변경을 한다.
    $s = str_replace('`', '', $s);
    $s = str_replace('~', ' ', $s);
    $s = str_replace('!', ' ', $s);
    $s = str_replace('@', '', $s);
    $s = str_replace('#', ' ', $s);
    $s = str_replace('$', '', $s);
    $s = str_replace('%', '', $s);
    $s = str_replace('^', '', $s);
    $s = str_replace('&', ' ', $s);
    $s = str_replace('*', '', $s);
    $s = str_replace('(', '', $s);
    $s = str_replace(')', '', $s);
    $s = str_replace('_', '', $s);
    $s = str_replace('=', ' ', $s);
    $s = str_replace('\\', '', $s);
    $s = str_replace('|', '', $s);
    $s = str_replace('{', '', $s);
    $s = str_replace('[', '', $s);
    $s = str_replace(']', '', $s);
    $s = str_replace('"', '', $s);
    $s = str_replace("'", '', $s);
    $s = str_replace(';', '', $s);
    $s = str_replace(':', '', $s);
    $s = str_replace('/', '', $s);
    $s = str_replace('?', '', $s);
    $s = str_replace('.', ' ', $s);
    $s = str_replace('<', '', $s);
    $s = str_replace('>', '', $s);
    $s = str_replace(',', ' ', $s);

    // 여러개의 공백을 한개의 공백으로 변경한다.
    $s = preg_replace('/ +/', ' ', $s);

    $s = trim($s, '- ');

    return $s;
}


/**
 * HTML FORM 을 전송할 때 반드시, mode 값이 create, update, delete, submit 중에 하나라야 한다.
 * Helper function to detect if form have submitted for creation
 * @return bool
 */
function modeCreate(): bool {
    return in('mode') == 'create';
}
/**
 * Helper function to detect if form have submitted for update
 * @return bool
 */
function modeUpdate(): bool {
    return in('mode') == 'update';
}
/**
 * Helper function to detect if form have submitted for delete
 * @return bool
 */
function modeDelete(): bool {
    return in('mode') == 'delete' || in('button') == 'delete';
}

/**
 * Helper function to detect if form have submitted
 * @return bool
 */
function modeSubmit(): bool {
    return in('mode') == 'submit';
}

/**
 * HTML FORM 이 전송되었는지 검사한다.
 * @return bool
 */
function modeAny(): bool {
    $mode = in('mode');
    return !empty($mode);
}

/**
 *
 */
function bsAlert($text) {
    echo <<<EOH
<div class="alert alert-secondary">$text</div>
EOH;

}


/**
 * Returns true if the $data is php serialize().
 *
 * @usage Use this to check if a value is php serialized. so, you can unserialize(). Especially on meta.
 *
 * @param $data
 * @param bool $strict
 * @return bool
 */
function is_serialized( $data, $strict = true ): bool {
    // If it isn't a string, it isn't serialized.
    if ( ! is_string( $data ) ) {
        return false;
    }
    $data = trim( $data );
    if ( 'N;' === $data ) {
        return true;
    }
    if ( strlen( $data ) < 4 ) {
        return false;
    }
    if ( ':' !== $data[1] ) {
        return false;
    }
    if ( $strict ) {
        $lastc = substr( $data, -1 );
        if ( ';' !== $lastc && '}' !== $lastc ) {
            return false;
        }
    } else {
        $semicolon = strpos( $data, ';' );
        $brace     = strpos( $data, '}' );
        // Either ; or } must exist.
        if ( false === $semicolon && false === $brace ) {
            return false;
        }
        // But neither must be in the first X characters.
        if ( false !== $semicolon && $semicolon < 3 ) {
            return false;
        }
        if ( false !== $brace && $brace < 4 ) {
            return false;
        }
    }
    $token = $data[0];
    switch ( $token ) {
        case 's':
            if ( $strict ) {
                if ( '"' !== substr( $data, -2, 1 ) ) {
                    return false;
                }
            } elseif ( false === strpos( $data, '"' ) ) {
                return false;
            }
        // Or else fall through.
        case 'a':
        case 'O':
            return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
        case 'b':
        case 'i':
        case 'd':
            $end = $strict ? '$' : '';
            return (bool) preg_match( "/^{$token}:[0-9.E+-]+;$end/", $data );
    }
    return false;
}

/**
 * Returns true if the access is for generating/reading images through phpThumb.
 * @return bool
 */
function isPhpThumb() : bool {
    $_phpThumb = false;
    if ( isset($_SERVER['PHP_SELF']) ) {
        if ( strpos($_SERVER['PHP_SELF'], 'phpThumb.php') !== false ) $_phpThumb = true;
    }
    return $_phpThumb;
}


/**
 * Gets values of a field in array from two dimensional array and returns it.
 * 2차원 배열에서 하나의 키(필드)의 값을 배열로 모아 리턴한다.
 *
 * Note that, it can collect not only `userIdx` but also any field by by specifying $field.
 * 예를 들어, 사용자 정보를 추출하는 쿼리를 할 때, 한번에 모든 정보를 다 가져오면 DB 에 무리가 가니까, 아래와 같이 idx 만 먼저 가져 올 수 있다.
 *
 * Array (
 *   [0] => Array
 *     (
 *       [idx] => 341404
 *     )
 *   [1] => Array
 *     (
 *       [idx] => 341403
 *     )
 * )
 *
 * 위에서, idx 만 모아서, [341404, 341403] 와 같이 리턴 할 수 있게 해 준다.
 *
 * @param array $rows
 * @param string $field
 * @return array
 *
 * @example
 *  ids([ ['idx'=>1, ...], [], ... ]) 와 같이 호출
 */
function ids(array $rows, string $field=IDX): array
{
    $ret = [];
    foreach ($rows as $u) {
        $ret[] = $u[$field];
    }
    return $ret;
}

/**
 * ids() 를 사용하기 쉽게 한다.
 * @param array $users
 * @return array
 */
function idxes(array $users): array {
    return ids($users);
}

/**
 * To indicating testing.
 */
$_testing = false;
function isTesting(): bool {
    global $_testing;
    return $_testing;
}
function enableTesting() {
    global $_testing;
    $_testing = true;
}
function disableTesting() {
    global $_testing;
    $_testing = false;
}

/**
 * To indicating debugging range.
 * @example
enableDebugging();
post($post3[IDX])->vote('Y');
disableDebugging();
 */
//$_debugging = false;
//function isDebugging(): bool {
//    global $_debugging;
//    return $_debugging;
//}
//function enableDebugging() {
//    global $_debugging;
//    $_debugging = true;
//}
//function disableDebugging() {
//    global $_debugging;
//    $_debugging = false;
//}


function select_list_widgets($categoryIdx,  $widget_type, $setting_name) {

    $default_selected = category($categoryIdx)->v($setting_name, $widget_type . '-default');



    echo "<select name='$setting_name' class='w-100'>";
    select_list_widgets_option($widget_type, $default_selected);
    echo "</select>";

}

/**
 *
 * Doc block 에서 '@type admin' 을 하면, 관리자 전용위젯으로, 사용자에게는 표시가 되지 않는 위젯이다.
 * 따라서, 표시를 하지 않는 위젯을 'admin' 으로 표시하면 된다.
 *
 * @param $type
 * @param $default_selected
 *
 *
 */
function select_list_widgets_option($type, $default_selected) {
    foreach( glob(ROOT_DIR . "/widgets/$type/**/*.php") as $file ) {
        $info = parseDocBlock(file_get_contents($file));
        if ( isset($info['type']) && $info['type'] == 'admin' ) continue;

        $arr = explode('/', $file);
        array_pop($arr);
        $widget_folder_name = array_pop($arr);

        $description = isset($info['name']) ? $info['name'] : $widget_folder_name;


        $value = "$type/$widget_folder_name";
        if ( str_contains($value, $default_selected) ) $selected = "selected";
        else $selected = "";

        echo "<option value='$value' $selected>$description</option>";
    }
}


/**
 * Parses docblock. It's not perfect but useful.
 *
 * You can add some information/annotation in php comments.
 * It is used for reading widget information.
 *
 * @param $str
 * @return array|null
 *
 * @example
 *
 *
$str = '
 * @param  Okay. @ comes after space and *
@return Okay. @ comes after space
 * - @note Nope. @ is after -
Some content
@this This still works. As long as it comes after space or white.
/ **
 * @then This works.
 * /
';
d(parseDocBlock($str));
 */
function parseDocBlock($str) {
    if (preg_match_all('/^[\s\*]*@(\w+)\s+(.*)\r?\n/m', $str, $matches)) {
        $result = array_combine($matches[1], $matches[2]);
        return $result;
    }
    return null;
}





/**
 * Returns an array of user ids that are in the path(tree) of comment hierarchy.
 *
 * @note it does not include the login user and it does not have duplicated user id.
 *
 * @param $idx - comment idx
 *
 * @return array - array of user ids
 *
 * @attention  It will recursively read database records. Make it minimal.
 *
 * @todo move this method to `PostModel`
 */
function getCommentAncestors(int $idx): array
{
    $comment = comment($idx);
    $asc     = [];
    while (true) {
        $comment = comment($comment->parentIdx);
        if ( $comment->notFound ) break;
        if ($comment->userIdx == login()->idx) continue;
        $asc[] = $comment->userIdx;
    }
    $asc = array_unique($asc);
    return $asc;
}


/**
 * 1) get post owner id
 * 2) get comment ancestors users_id
 * 3) make it unique to eliminate duplicate
 * 4) get topic subscriber
 * 5) remove all subscriber from token users
 * 6) get users token
 * 7) send batch 500 is maximum
 *
 *  get all the user id of comment ancestors. - name as '$usersIdx'
 *  get all the user id of topic subscribers. - named as 'topic subscribers'.
 *  remove users of 'topic subscribers' from 'token users'. - with array_diff($array1, $array2) return the array1 that has no match from array2
 *  get the tokens of the users_id and filtering those who want to get comment notification
 *
 *
 * @param CommentModel|PostModel $cp
 * @throws Exception
 */
function onCommentCreateSendNotification(CommentModel|PostModel $cp)
{

    $post = post($cp->rootIdx);
    $usersIdx = [];

    /**
     * add post owner id if not mine
     */

    if ($post->isMine() == false) {
        $usersIdx[] = $post->userIdx;
    }

    /**
     * get comment ancestors id
     */
    if ($cp->parentIdx > 0) {
        $usersIdx = array_merge($usersIdx, getCommentAncestors($cp->idx));
    }

    /**
     * get unique user ids
     */
    $usersIdx = array_unique($usersIdx);

    /**
     * get user who subscribe to comment forum topic
     */
    $cat = category($cp->categoryIdx);
    $topic_subscribers = getForumSubscribers(NOTIFY_COMMENT . $cat->id);

    /**
     * remove users_id that are registered to comment topic. So, one user will not have two messages.
     */
    $usersIdx = array_diff($usersIdx, $topic_subscribers);

    /**
     * Get tokens of users that are not registered to forum comment topic and want to get notification on user settings
     */
    $tokens = getTokensFromUserIDs($usersIdx, NEW_COMMENT_ON_MY_POST_OR_COMMENT);




    $req = [
        'title' => getCommentPushNotificationTitle($post),
        'body' => $cp->content,
        'click_action' => $post->relativeUrl,
        'data' => [
            'senderIdx' => login()->idx,
            'type' => 'post',
            'idx'=> $post->idx,
        ]
    ];

    /**
     * send notification to users who subscribe to comment topic
     */
    sendMessageToTopic(NOTIFY_COMMENT . $cat->id, $req);


    /**
     * send notification to comment ancestors who enable reaction notification
     */
    if (!empty($tokens)) sendMessageToTokens($tokens, $req);
}

/**
 * prepare title data from PostModel
 */
function getCommentPushNotificationTitle(PostModel $post): string {
    $title = login()->name . " Comment to ";
    /**
     * It indicate that the post has photo if the post title is empty and has photo
     */
    if ($post->title) {
        return $title . $post->title;
    }
    else if (!$post->title) {
        if (!empty($post->fileIdxes)) {
            return $title . " uploaded photos post# " . $post->idx;
        }
    }
    return $title . "post# " . $post->idx;
}



/**
 * @param $topic - topic as string.
 *  It likes like `notificationPost_qna`.
 * @return array - array of user ids
 * @throws Exception
 */
function getForumSubscribers(string $topic): array
{
    return meta()->entities([CODE => $topic, DATA => ON], limit: 10000);
//    return getMetaEntities([CODE => $topic, DATA => ON], limit: 10000);
}


/**
 * 패스로그인 관련 라이브러리는 etc/callbacks/pass-login.lib.php 에 있다.
 * @param string $state
 * @return string
 */
function passLoginUrl($state = '')
{
    return "https://id.passlogin.com/oauth2/authorize?client_id=" . PASS_LOGIN_CLIENT_ID . "&redirect_uri=" . urlencode(PASS_LOGIN_CALLBACK_URL) . "&response_type=code&state=$state&prompt=select_account";
}


function inHome() {
    $p = in('p');
    return empty($p);
}


function displayWarning($msg): mixed {
    $root_domain = get_root_domain();
    echo <<<EOH
<div style="padding: 1em; border-radius: 16px; background-color: #ffc9c9;">
<div class="d-flex justify-content-between">
<div>알림</div>
<div>$root_domain</div>
</div>
<hr>
$msg
</div>
EOH;

    return '';

}


//////// next
function table(string $taxonomy): string {
    return DB_PREFIX . $taxonomy;
}

function separateByComma($str) {
    $rets = [];
    $str = trim($str);
    if ( $str ) {
        $parts = explode(",", $str);
        foreach( $parts as $part ) {
            $_part = trim($part);
            if ( empty($_part) ) continue;
            $rets[] = $_part;
        }
    }
    return $rets;
}

/**
 * 현재 글 idx 는 알고 있지만, 그 categoryIdx 는 모를 때 사용하는 함수이다.
 * @param $rootIdx
 * @return int
 */
function postCategoryIdx($rootIdx): int {
    return post()->column(CATEGORY_IDX, [IDX => $rootIdx]);
}
/**
 * category.idx 를 입력받아 category.id 를 리턴한다.
 * @param int $categoryIdx
 * @return int
 */
function postCategoryId(int $categoryIdx): string {
    return category()->column(ID, [IDX => $categoryIdx]);
}


/**
 * 키/값 배열을 입력 받아 SQL WHERE 조건문에 사용 할 문자열을 리턴한다.
 *
 * 예) [a => apple, b => banana] 로 입력되면, "a=apple AND b=banana" 로 리턴.
 *
 * 조건 식 사용법
 * 필드는 공백이 들어갈 수 없다는 점을 착안해서, 필드에 공백을 넣고, 다음에 조건식을 넣을 수 있도록 한다.
 *  - ['abc >' => 0] 과 같이 하면, "abc > 0" 으로 된다.
 *  - ['abc !=' => ''] 와 같이 하면 "abc != ''" 와 같이 된다.
 *
 * 값이 문자열이면 따옴표로 둘러싼다.
 *
 *
 * @param array $conds - 키/값을 가지는 배열
 * @param string $conj - 'AND' 또는 'OR' 등의 연결 expression
 * @param string $field - 이 파라메타에 값이 들어가면, $conds 에는 값만 들어간다. 즉, $field 를 필드로 해서, $conds 의 값을 사용해서 비교한다.
 *  예를 들어, 특정 필드에 여러 값 중 하나가 있는지 검사를 하기 위해서 사용 할 수 있다. 이 대, $field 에는 연산자를 지원하지 않는다.
 * @return string
 *
 * @example
 *  sqlCondition([a => apple, b => banana], $conj); // returns `a='apple' AND b='banana'`
 *  sqlCondition(['apple', 'banana'], 'OR', REASON); // returns `reason='apple' OR reason='banana'`
 *
 * @example tests/basic.sql.php
 */
function sqlCondition(array $conds, string $conj = 'AND', string $field = ''): string
{
    $arc = [];
    if ( $field ) {
        foreach( $conds as $v ) {
            if ( is_string($v) ) $v = "'$v'";
            $arc[] = "$field=$v";
        }
    } else {
        foreach($conds as $k => $v )  {
            $k = trim($k);
            if ( is_string($v) ) $v = "'$v'";
            if ( str_contains($k, ' ')) {
                $ke = explode(' ', $k, 2);
                $arc[] = "`$ke[0]` $ke[1] $v";
            }
            else {
                $arc[] = "`$k`=$v";
            }
        }
    }
    return implode(" $conj ", $arc);
}



/**
 *
 * @example
 *  <?php js('/etc/js/chartjs-2/chart.bundle.min.js') ?>
 */
global $__js;
function js(string $src, int $priority=1) {
    global $__js;
    if ( isset($__js) == false || empty($__js) ) $__js = [];
    if ( $priority > 10 ) $priority = 10;
    $__js[$priority][] = $src;
}

/**
 * @return string
 */
function get_javascript_tags(string $scripts_and_styles): string {

    global $__js;
    if ( isset($__js) == false || empty($__js) ) return '';
    $ret = '';

    /// Get Javascript from priority 10 to 1.
    $compile = [];
    for($i=10; $i>=1; $i--) {
        if ( isset($__js[$i]) ) $compile = [ ...$compile, ...$__js[$i]];
    }
    $compile = array_unique($compile);
    foreach($compile as $src) {
        $ret .= "<script src=\"$src\"></script>\n";
    }

    /// Add captured scripts and styles.
    $ret .= $scripts_and_styles;

    // Get Javascripts for priority 0.
    if ( isset($__js[0]) ) {
        $compile = array_unique($__js[0]);
        foreach($compile as $src) {
            $ret .= "<script src=\"$src\"></script>\n";
        }
    }

    return $ret;
}


function get_default_javascript_tags() : string {
    $COOKIE_DOMAIN = COOKIE_DOMAIN;
    $default_script = <<<EOH
<script>
    const COOKIE_DOMAIN = '$COOKIE_DOMAIN';
</script>
EOH;

    if ( defined('FIREBASE_BOOT_SCRIPTS') ) $default_script .= FIREBASE_BOOT_SCRIPTS;
    return $default_script;
}


/**
 * HTML FORM 에서 input 태그 중 hidden 으로 지정되는 값들 보다 편하게 하기 위한 함수.
 *
 * @param array $in
 *  입력된 HTTP VAR 의 변수와 <input type=hidden name=...> 에서 name 의 값이 동일한 경우, 여기에 기록을 하면 된다.
 *  이 값이 ['p', 'w'] 와 같이 입력되면, HTTP PARAM 의 키 p, w 와 그 값을 그대로 hidden tag 로 만든다.
 *  예) hiddens(in: ['p']) 와 같이 전달되면, <input type=hidden name=p value=in('p')> 와 같이 각 name 을 p 로 하고, in('p')  값을
 *  채운다.
 * @param string $mode
 *  <input type=hidden name=mode value=...> 와 같이 form submit mode 를 지정한다.
 * @param array $kvs
 *  추적으로 지정할 name 과 value 를 지정한다.
 *  예) hiddens(kvs: ['p' => 'user.profile.submit']) 와 같이 호출하면, 아래와 같이 된다.
 *
 *      <input type='hidden' name='p' value='user.profile.submit'>
 *
 * @param string $p FORM 값을 넘길 페이지.
 * @param string $return_url 돌아갈 URL 지정
 *
 *
 * @return string
 *
 * 호출 예)
 *  hiddens(in: ['p', 'w', 's'], mode: 'submit', kvs: ['idx' => $post->idx])
 *
 * 리턴 값 예)
 *  <input type='hidden' name='mode' value='submit'>
 *  <input type='hidden' name='p' value='admin.index'>
 *  <input type='hidden' name='w' value='shopping-mall/admin-shopping-mall'>
 *  <input type='hidden' name='s' value='edit'>
 *  <input type='hidden' name='idx' value='0'>
 */
function hiddens(array $in=[], string $mode='', string $p="", string $return_url="", array $kvs=[]): string {
    $str = '';
    if ( $p ) {
        $str .= "<input type='hidden' name='p' value='$p'>\n";
    }
    if ( $mode ) {
        $str .= "<input type='hidden' name='mode' value='$mode'>\n";
    }
    if ( $in ) {
        foreach( $in as $k ) {
            $str .= "<input type='hidden' name='$k' value='".in($k)."'>\n";
        }
    }
    if ( $kvs ) {
        foreach( $kvs as $k => $v ) {
            $str .= "<input type='hidden' name='$k' value='$v'>\n";
        }
    }
    if ( $return_url ) {
        $str .= "<input type='hidden' name='".RETURN_URL."' value='$return_url'>\n";
    }
    return $str;
}


/**
 * @param int $stamp
 * @return string
 */
function short_date_time(int $stamp): string
{
    $Y = date('Y', $stamp);
    $m = date('m', $stamp);
    $d = date('d', $stamp);
    if ($Y == date('Y') && $m == date('m') && $d == date('d')) {
        $dt = date("h:i a", $stamp);
    } else {
        $dt = "$Y-$m-$d";
    }
    return $dt;
}


/**
 * file.idx 를 입력 받아, 썸네일 URL 을 리턴한다.
 *
 * @param int $fileIdx
 * @param int $width
 * @param int $height
 * @return string
 */
function thumbnailUrl(int $fileIdx, int $width=200, int $height=200): string
{
    if ( empty($fileIdx) ) return 'file.idx is empty.';
    $file = files($fileIdx);
    $thumbnailPath = zoomThumbnail($file->path, $width, $height);
    if ( str_contains($thumbnailPath, '/files/') ) {
        $arr = explode('/files/', $thumbnailPath);
        return UPLOAD_SERVER_URL . "files/$arr[1]";
    } else {
        return $thumbnailPath;
    }

}


/**
 * 실명 인증을 한 사용자인지 확인을 한다.
 * CenterX 는 한국 시스템에 특화된 것으로, 패스 로그인을 했으면 실명 인증한 것으로 한다.
 * @return bool
 */
function isRealNameAuthUser(): bool {
    return !login()->v('plid');
}


/**
 * Custom error handling 을 할 수 있는 상황이면, true 를 리턴한다.
 * @return bool
 */
function canHandleError(): bool {
    return !API_CALL && !isCli() && !isPhpThumb();
}

/**
 * @param $errno
 * @param $errstr
 * @param $error_file
 * @param $error_line
 */
function customErrorHandler($errno, $errstr, $error_file, $error_line) {
    $APP_NAME = APP_NAME;

    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting, so let it fall
        // through to the standard PHP error handler
        return false;
    }


    echo <<<EOE
<div style="margin-bottom: 8px; padding: 16px; border-radius: 10px; background-color: #5a3764; color: white;">
    <div>{$APP_NAME} Error</div>
    <div style="margin-top: 16px; padding: 16px; border-radius: 10px; background-color: white; color: black;">
EOE;

    // $errstr may need to be escaped:
    $errstr = htmlspecialchars($errstr);

    switch ($errno) {
        case E_ERROR:
        case E_CORE_ERROR:
        case E_USER_ERROR:
            echo "<b>ERROR</b> [$errno] $errstr<br />\n";
            echo "  Fatal error on line $error_line in file $error_file";
            echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
            echo "Aborting...<br />\n";
            exit(1);

        case E_WARNING:
        case E_USER_WARNING:
            echo "<b>WARNING</b>";
            break;

        case E_PARSE: echo "<b>PARSE</b>"; break;

        case E_NOTICE:
        case E_USER_NOTICE:
            echo "<b>NOTICE</b>";
            break;

        default:
            echo "<b>Unknown error type</b>";
            break;
    }

    echo <<<EOE
         :  [$errno] $errstr<br />\n on line $error_line in file $error_file
    </div>
</div>
EOE;
    d(debug_backtrace());


    /* Don't execute PHP internal error handler */
    return true;

}


/**
 * $content 에서 style 과 script 를 추철하여 리턴한다. 이 때, $content 는 call by reference 로 전달되어서 원래 변수에서도 삭제된다.
 *
 * @param string $content
 * @return string
 */
function capture_styles_and_scripts(string &$content)
{
    $res = '';

    $pos = stripos($content, "<body"); // <body ...> 와 같이 속성이 들어 갈 수 있음.
    $before = substr($content, 0, $pos);
    $after = substr($content, $pos);


    /// Get javascript
    /// 자바스크립트가 <script src=...></script> 와 같이 되면, 아래의 + 옵션에 맞지 않으므로, 추출되지 않는다.
    /// 즉, <script src=...> 와 같이 외부 import 는 하단으로 이동되지 않는다.
    $re = preg_match_all('/\<script(.*?)?\>(.|\s)+?\<\/script\>/i', $after, $m);
    if ($re) {
        $scripts = $m[0];
        foreach ($scripts as $script) {
            $after = str_replace($script, '', $after);
        }
        $res .= implode("\n", $scripts);
    }


    /// Get styles

    $re = preg_match_all("/\<style\>[^\<]*\<\/style\>/s", $after, $m);
    if ($re) {
        $styles = $m[0];
        foreach ($styles as $style) {
            $after = str_replace($style, '', $after);
        }
        $res .= implode("\n", $styles);
    }

    $content = $before . $after;

    return $res;
}


/**
 * @deprecated Use xxxXxxUrl() functions.
 *
 * in('categoryId') 로 들어오는 값을 '?categoryId=xxxx' 또는 '&categoryId=xxxx' 로 리턴한다.
 *
 * @param bool $question
 * @return string
 */
function inCategoryId(bool $question=false) {
    if ( ! in('categoryId') ) return '';
    if ( $question ) return "?categoryId=" . in('categoryId');
    else return "&categoryId=" . in('categoryId');
}

/**
 * @deprecated Use xxxXxxUrl() functions.
 *
 * in('subcategori') 로 들어오는 값을 '?inSubcategory=xxxx' 또는 '&inSubcategory=xxxx' 로 리턴한다.
 * @param bool $question
 * @return string
 */
function inSubcategory(bool $question=false) {
    if ( ! in('subcategory') ) return '';
    if ( $question ) return "?subcategory=" . in('subcategory');
    else return "&subcategory=" . in('subcategory');
}


/**
 * 사용자의 IP 를 리턴한다.
 * 만약, 개발자 컴퓨터이거나 IP 정보가 없다면, config 에 지정된 TEMP_IP_ADDRESS 를 리턴한다.
 */
function clientIp() {
    if ( isLocalhost() ) return TEMP_IP_ADDRESS;
    else if ( isset($_SERVER['REMOTE_ADDR']) === false ) return TEMP_IP_ADDRESS;
    else return $_SERVER['REMOTE_ADDR'];
}


/**
 * @param string $filePath
 * @return string
 */
function mimeType(string $filePath): string {
    return mime_content_type($filePath);
}


/**
 * @param int $userIdx
 * @return string
 */
function messageSendUrl(int $userIdx): string {
    return postEditUrl(MESSAGE_CATEGORY) . "&otherUserIdx=$userIdx";
}

function messageInboxUrl(): string {
    return postListUrl(MESSAGE_CATEGORY) . "&otherUserIdx=" . login()->idx;
}

function messageOutboxUrl(): string {
    return postListUrl(MESSAGE_CATEGORY) . "&userIdx=" . login()->idx;
}

function postListUrl(int|string $categoryId): string {
    return "/?p=forum.post.list&categoryId=" . $categoryId;
}

function postEditUrl(int|string $categoryId = '', string $subcategory=null, int $postIdx=0 ): string {
    $url = "/?p=forum.post.edit";
    if ( $categoryId ) $url .= "&categoryId=$categoryId";
    if ( $subcategory ) $url .= "&subcategory=$subcategory";
    if ( $postIdx ) $url .= "&idx=$postIdx";
    return $url;
}

function postViewUrl(PostModel $post): string {
    $url = $post->url;

    $tags = [];
    if ( in('page') ) {
        $tags[ 'page' ] = in('page');
    }

    if ( $tags ) {
        $url .= '?' . http_build_query($tags);
    }

    return $url;
}

function postDeleteUrl(int $idx) {
    return "/?p=forum.post.delete.submit&idx=$idx";
}

function postMessagingUrl(int $idx) {
    return "/?p=admin.index&w=push-notification/push-notification-create&idx=$idx";
}

/**
 * HTTP PARAMS 으로 들어오는 키/값들을 파싱하여 글 목록 또는 글 추출을 하기 위한 SQL 쿼리에 사용 할 where 와 params 을 리턴한다.
 * 이 함수는 PHP 형식과 Restful Api 방식에서 공용으로 사용된다.
 *
 * 단, order, by, page, limit 등은 외부 함수에서 별도로 적절히 처리를 해야 한다.
 *
 *
 * @param array $in
 *
 *  - categoryId - 카테고리 아이디
 *  - categoryIdx - 카테고리 번호
 *  - ids - 콤마로 분리된 여러개의 카테고리 번호, 또는 카테고리 아이디.
 *      예) "apple, 2, cherry"
 *      여러개의 카테고리에서 글을 가져 올 수 있도록 한다.
 *  - subcategory - 서브 카테고리.
 *      주의 할 점은, 서브카테고리가 빈 값은 검색하지 않는다. 즉, 서브카테고리가 없는 빈 서브카테고리만 따로 검색하지는 않는다. 그럴 이유가 없기 때문이다.
 *  - searchKey - 검색어
 *  - userIdx - 사용자 번호
 *  - otherUserIdx - 다른 사용자 번호
 *  - code - 글 코드
 *  - countryCode - the country code.
 *  - within - 특정 시간 내의 글을 리턴한다. 단위 초.
 *      예를 들어, 60 이면, 1분 이내의 글. 360 이면, 10분 이내의 글만 리턴한다.
 *  - betweenFrom, betweenTo - 특정 시간 구간 사이의 글을 검색하여 리턴한다. 단위 초.
 *      예를 들어, betweenFrom 이, "60 * 60 * 30" 이고, betweenTo 가, "60 * 60 * 50" 이면,
 *      30시간 전 부터 50시간 전 사이의 글을 리턴한다.
 *      과거의 시간을 계산하는 것으로 betweenFrom 이, 현재로 부터 가까운 시간, betweenTo 가 현재로 부터 먼 시간이된다.
 *
 *  - files - it is set to truthy value, then it searches for posts that has attached files.
 *  If it is falsy value like empty string, false, 0, then it searches posts that has no attached files.
 *
 * @return array|string
 * - It returns 'where' and 'params' only.
 *
 *
 * @attention both of categoryIdx and categoryId are set, then categoryIdx will be used.
 *  if none of them are set, then it will search all the posts.
 *
 * @todo Make a new function that fix the input '$in' as call-by-reference. If there is no error, it returns false, or if there is error, it return error_string,
 */
function parsePostSearchHttpParams(array $in): array|string {

    $params = [];

    // 기본 검색 조건
    //
    // 부모 글만 검색. 삭제된 글도 포함.
    $where = "parentIdx=0";


    // 카테고리 idx 또는 카테고리 id 또는 0
    $catIdx = $in[CATEGORY_IDX] ?? $in[CATEGORY_ID] ?? 0;

    // 카테고리가 1 개 지정된 경우,
    if ($catIdx) {
        $category = category( $catIdx );
        // 카테고리가 존재하지 않으면, 에러
        if ( $category->exists() == false ) return e()->category_not_exists;

        // 카테고리 아이디를 입력 받아, category.idx 숫자로 지정하기 때문에, params 으로 bind 하지 않아도 된다.
        $where .= " AND categoryIdx=" . $category->idx;
    } else if ( isset($in[IDS]) ) {
        // 카테고리가 여러개 입력 된 경우,
        // @todo 이 부분 Unit test 해야 함.
        $ids = explode(',', $in[IDS]);
        $cats = [];
        foreach( $ids as $id ) {
            $id = trim($id);
            $cat = category($id);
            $cats[] = "categoryIdx=" . $cat->idx;
        }

        // 카테고리 아이디를 입력 받아, category.idx 숫자로 지정하기 때문에, params 으로 bind 하지 않아도 된다.
        $where .= " AND ( " . implode(" OR ", $cats ) . " ) ";

    }

    // sub category
    if (isset($in['subcategory']) && $in['subcategory']) {
        $where .= " AND subcategory=?";
        $params[] = $in['subcategory'];
    }

    // code
    if (isset($in['code'])) {
        $where .= " AND code=?";
        $params[] = $in['code'];
    }

    // files
    if (isset($in['files'])) {
        if ($in['files']) {
            $where .= " AND fileIdxes != ''";
        } else {
            $where .= " AND fileIdxes = ''";
        }
    }


    // 국가 코드 훅. @see README `HOOK_POST_LIST_COUNTRY_CODE` 참고
    // Get country code from input
    $countryCode = $in['countryCode'] ?? '';
    // Run hook to update country code
    $updatedCountryCode = hook()->run(HOOK_POST_LIST_COUNTRY_CODE, $countryCode);
    // If there is updated country code, use it
    if ( $updatedCountryCode ) {
        $where .= " AND countryCode=?";
        $params[] = $updatedCountryCode;
    } else if ( $countryCode ) {
        // Or if there is country code, then use it.
        $where .= " AND countryCode=?";
        $params[] = $countryCode;
    }

    // 검색어가 입력되면, 제목과 내용에서 검색한다.
    // @TODO private 게시판의 경우, 옵션에 따라, userIdx, otherUserIdx 가 내 값이면, privateTitle 과 privateContent 를 찾을 수 있도록 해야 한다.
    if ( isset($in['searchKey']) ) {
        $where .= " AND (title LIKE ? OR content LIKE ?) ";
        $params[] = '%' . $in['searchKey'] . '%';
        $params[] = '%' . $in['searchKey'] . '%';
    }

    if ( isset($in['within']) && is_numeric($in['within']) && $in['within'] ) {
        $where .= " AND createdAt > " . (time() - $in['within']);
    }

    if (
        isset($in['betweenFrom']) && isset($in['betweenTo']) &&
        is_numeric($in['betweenFrom']) && is_numeric($in['betweenTo']) &&
        $in['betweenFrom'] && $in['betweenTo']
    ) {
        $where .= " AND createdAt < " . (time() - $in['betweenFrom']) . " AND createdAt > "  . (time() - $in['betweenTo']);
    }

    // 사용자 글 번호. 특정 사용자가 쓴 글만 목록. 쪽지 기능에서는 보내는 사람.
    if ( isset($in[USER_IDX]) && is_numeric($in[USER_IDX]) ) {
        $where .= " AND userIdx=? ";
        $params[] = $in[USER_IDX];
    }
    // 다른 사용자 글 번호. 즉, 글이 특정 사용자에게 전달되는 것. 쪽지 기능에서는 받는 사람.
    if ( isset($in[OTHER_USER_IDX]) && is_numeric($in[OTHER_USER_IDX]) ) {
        $where .= " AND otherUserIdx=? ";
        $params[] = $in[OTHER_USER_IDX];
    }

    return [ $where, $params ];
}

/**
 *
 * @param array $in
 *  - searchKey
 *
 *
 *
 * @return array
 *
 */
function parseUserSearchHttpParams(array $in): array {
    $params = [];
    $conds = [];

    if ( isset($in['searchKey']) && $in['searchKey'] ) {
//        $conds[] = "(name LIKE ? OR nickname LIKE ? OR email LIKE ? OR phoneNo LIKE ? OR firebaseUid=? OR domain=?) ";
        $conds[] = "(name LIKE ? OR nickname LIKE ? OR email LIKE ? OR phoneNo LIKE ? OR firebaseUid=?) ";
        $params[] = '%' . $in['searchKey'] . '%';
        $params[] = '%' . $in['searchKey'] . '%';
        $params[] = '%' . $in['searchKey'] . '%';
        $params[] = '%' . $in['searchKey'] . '%';
        $params[] = $in['searchKey'];
//        $params[] = $in['searchKey'];
    }

    if ( $conds ) {

        $where = implode(' AND ', $conds);
    } else {
        $where = '1';
    }

    return [ $where, $params ];
}


/**
 *
 * @param array $in
 *  - searchKey
 *
 *
 * @return array
 *
 */
function parseFileSearchHttpParams(array $in): array {

    $params = [];
    $conds = [];

    if ( isset($in['idx']) && $in['idx'] ) {
        $conds[] = "(idx=?)";
        $params[] = $in['idx'];
    }

    if ( isset($in['taxonomy']) && $in['taxonomy'] ) {
        $conds[] = "(taxonomy=?)";
        $params[] = $in['taxonomy'];
    }
    if ( isset($in['entity']) && $in['entity'] ) {
        $conds[] = "(entity=?)";
        $params[] = $in['entity'];
    }
    if ( isset($in['userIdx']) && $in['userIdx'] ) {
        $conds[] = "(userIdx=?)";
        $params[] = $in['userIdx'];
    }
    if ( isset($in['code']) && $in['code'] ) {
        $conds[] = "(code=?)";
        $params[] = $in['code'];
    }

    if ( isset($in['name']) && $in['name'] ) {
        $conds[] = "(name LIKE ?)";
        $params[] = '%' . $in['name'] . '%';
    }


    if ( $conds ) {
        $where = implode(' AND ', $conds);
    } else {
        $where = '1';
    }


    return [ $where, $params ];

}




/**
 * Saves the search keyword for listing(searching) posts.
 * @param string $searchKey
 */
function saveSearchKeyword(string $searchKey): void {
    if ($searchKey) {
        db()->insert(DB_PREFIX . 'search_keys', ['searchKey' => $searchKey, 'createdAt' => time(), UPDATED_AT => time()]);
    }
}




/**
 * Convert the input to timestamp if the input is not number.
 *
 * @see https://www.php.net/manual/en/datetime.formats.date.php for details
 *
 * @param int|string $date
 * @return int
 *  - if $date is int, return $date
 *  - if $date is string, return after `strtotime`.
 *  - else return 0.
 *
 * @example
 * ```
 * dateToTime("2021-12-30");
 * dateToTime($in[BEGIN_AT] ?? '');
 * ```
 */
function dateToTime(int|string $date): int {
    if ( empty($date) ) return 0;
    if ( is_numeric($date) || is_int($date) ) return $date;
    if ( is_string($date) ) return strtotime($date);
    return 0;
}


/**
 * 두 시간 stamp 사이의 일 수를 구한다.
 * $stamp1 에 값이 없으면 오늘 stamp 값이 기본 지정된다.
 * @param int $stamp1
 * @param int $stamp2
 * @return int
 *
 * @example
 * ```
 * daysBetween($post->beginAt, $post->endAt)
 * daysBetween(0, $post->endAt)
 * ```
 */
function daysBetween($stamp1, $stamp2) {
    if ( empty($stamp1) ) $stamp1 = time();
    if ( empty($stamp2) ) return 0;
    $date1 = \Carbon\Carbon::createFromTimestamp($stamp1)->startOfDay();
    $date2 = \Carbon\Carbon::createFromTimestamp($stamp2)->startOfDay();
    return $date1->diffInDays($date2, false);
}

/**
 * Returns true if the $stamp is between the first and second.
 * @param $stamp
 * @param $firstStamp
 * @param $secondStamp
 */
function isBetween($stamp, $firstStamp, $secondStamp) {
    $curr = \Carbon\Carbon::createFromTimestamp($stamp);
    $first = \Carbon\Carbon::createFromTimestamp($firstStamp);
    $second = \Carbon\Carbon::createFromTimestamp($secondStamp);
    
    return $curr->betweenIncluded($first, $second);
}


/**
 * Stamp of 0 second of today. That is the beginning of today.
 * @return int
 */
function today(): int {
    return \Carbon\Carbon::today()->getTimestamp();
}
/**
 * Stamp of 0 second of tomorrow. That is the beginning of tomorrow.
 * @return int
 */
function tomorrow(): int {
    return \Carbon\Carbon::tomorrow()->getTimestamp();
}

/**
 * Returns true if the $stamp is between the first and second.
 * @param $stamp
 * @param $firstStamp
 * @param $secondStamp
 */
function isBetweenDay($stamp, $firstStamp, $secondStamp) {
    $curr = \Carbon\Carbon::createFromTimestamp($stamp);
    $first = \Carbon\Carbon::createFromTimestamp($firstStamp);
    $second = \Carbon\Carbon::createFromTimestamp($secondStamp);
    
    if ($curr->diffInDays($first) == 0) return true;
    if ($curr->diffInDays($second) == 0) return true;
    return $curr->betweenIncluded($first, $second);
}

/**
 * Returns true if the input stamp is today or future. ( not past )
 */
function isTodayOrFuture(int $stamp): bool {
    return isToday($stamp) || isFuture($stamp);
//    $carbon = \Carbon\Carbon::createFromTimestamp($stamp);
//    return  $carbon->isToday() || $carbon->isFuture();
}
/**
 * Returns true if the input stamp is today or past. ( not future )
 */
function isTodayOrPast(int $stamp): bool {
    return isToday($stamp) || isPast($stamp);
//    $carbon = \Carbon\Carbon::createFromTimestamp($stamp);
//    return  $carbon->isToday() || $carbon->isPast();
}
function isToday($stamp): bool {
    $carbon = \Carbon\Carbon::createFromTimestamp($stamp);
    return $carbon->isToday();
}
function isPast($stamp): bool {
    $carbon = \Carbon\Carbon::createFromTimestamp($stamp);
    return $carbon->isPast();
}
function isFuture($stamp): bool {
    $carbon = \Carbon\Carbon::createFromTimestamp($stamp);
    return $carbon->isFuture();
}

/**
 * 이미지를 썸네일로 제작한다.
 *
 * @note 이 함수는 썸네일 이미지를 파일에 저장하고, 그 경로를 리턴한다.
 *  - 즉, 실시간으로 썸네일을 생성할 수가 없다.
 *  - 실시간으로 썸네일을 생성하기 위해서는 이미지 경로가 아니라 이미지 자체를 리턴해야 한다.
 *  - 실시간으로 썸네일 생성하고, 이미지를 리턴하는 코드는 /etc/thumbnail.php 에 있다.
 *
 * "PHP 썸네일 - Zoom Crop" 요약 문서 - https://docs.google.com/document/d/1RWYRWiATRdgT02cqG5TbVtJCOTSKtlAzXxeOM2-NkXA/edit#heading=h.2ryanntdiu14
 * 위 문서를 보면, 어떻게 zoom crop 을 하는지 알 수 있다.
 *
 * 큰 이미지를 비율에 맞추어 작게해서, 원하는 사이즈로 정확히 crop 한다. 예제는 문서를 참고한다.
 *
 * @return string - 썸네일 이미지 경로를 리턴한다.
 */
function zoomThumbnail(string $source_path, int $width=150, int $height=150, int $quality=95): string {

    // 저장 할 경로 찾기.
    $destination_path = thumbnailPath($source_path, $width, $height);

    // 이미 썸네일이 생성되어져 있으면 그 걸 리턴.
    if ( file_exists($destination_path) ) {
        debug_log('------------> $destination_path: exists: ' . $destination_path);
        return $destination_path;
    } else {
        debug_log('------------> $destination_path: NOT exists: ' . $destination_path);
    }


    // @todo return defualt image if the source files does not exists.
    if ( file_exists($source_path) == false ) {
        return DEFAULT_X_BOX_IMAGE;
    }

    /*
     * Add file validation code here
     */

    list($source_width, $source_height, $source_type) = getimagesize($source_path);

    switch ($source_type) {
        case IMAGETYPE_GIF:
            $source_gdim = imagecreatefromgif($source_path);
            break;
        case IMAGETYPE_JPEG:
            $source_gdim = imagecreatefromjpeg($source_path);
            break;
        case IMAGETYPE_PNG:
            $source_gdim = imagecreatefrompng($source_path);
            break;
    }

    $source_aspect_ratio = $source_width / $source_height;
    $desired_aspect_ratio = $width / $height;

    if ($source_aspect_ratio > $desired_aspect_ratio) {
        /*
         * Triggered when source image is wider
         */
        $temp_height = $height;
        $temp_width = ( int )($height * $source_aspect_ratio);
    } else {
        /*
         * Triggered otherwise (i.e. source image is similar or taller)
         */
        $temp_width = $width;
        $temp_height = ( int )($width / $source_aspect_ratio);
    }

    /*
     * Resize the image into a temporary GD image
     */

    $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
    imagecopyresampled(
        $temp_gdim,
        $source_gdim,
        0, 0,
        0, 0,
        $temp_width, $temp_height,
        $source_width, $source_height
    );

    /*
     * Copy cropped region from temporary image into the desired GD image
     */

    $x0 = ($temp_width - $width) / 2;
    $y0 = ($temp_height - $height) / 2;
    $desired_gdim = imagecreatetruecolor($width, $height);
    imagecopy(
        $desired_gdim,
        $temp_gdim,
        0, 0,
        $x0, $y0,
        $width, $height
    );



    // 파일 저장
    imagejpeg($desired_gdim, $destination_path, $quality);


    return $destination_path;
    /*
     * Add clean-up code here
     */
}

function thumbnailPath($path, $w, $h) {
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $new_path = str_replace($ext, "{$w}x{$h}.$ext", $path);
    $new_path = str_replace("uploads/", "thumbnails/", $new_path);
    return $new_path;
}


function fileTable(): string {
    return DB_PREFIX . FILES;
}
function postTable(): string {
    return DB_PREFIX . POSTS;
}

function metaTable(): string {
    return DB_PREFIX . METAS;
}


/**
 * 각 레벨 별 포인트.
 *
 * @see readme.md
 *
 * 예를 들면, levelByPoint(928) 와 같이 하면, 4 를 리턴한데, 928 포인트는 4 레벨에 속한다는 뜻이다.
 * 참고, 더 많은 예제는 functions.test.php 참고
 *
 * @param int $point
 * @return int
 *
 */
function levelByPoint(int $point): int {
    $i = 0;
    do {
        $i ++;
        $target = pointByLevel($i);
    } while( $point >= $target );
    return $i;
}

/**
 * 포인트 공식
 *
 * 각 레벨의 최대 포인트를 리턴한다.
 *
 * 주의, 레벨은 1 부터 시작하지만, 포인트는 0 부터 시작한다.
 * 그래서, 이 함수의 공식은 입력된 레벨의 -1 을 해야, 해야 된다.
 *
 * 예를 들면, 4 레벨의 시작 포인트를 얻고 싶다면, pointByLevel(4-1) 와 같이 하면, 4 레벨의 시작 포인트인 927 을 리턴한다.
 *
 * 가능한 이 함수를 직접 사용하지 않도록 한다.
 *
 *
 * @param int $lv
 * @return int
 *
 * @example 레벨별 (시작)포인트 목록하기
 *  for($i=1; $i<100; $i++) {
 *      echo "Lv. $i: " . pointByLevel( $i - 1 ) . "\n";
 *  }
 *
 * 참고, 더 많은 예제는 functions.test.php 참고
 */
function pointByLevel(int $lv): int {
    return (100 + $lv) * $lv * $lv;
}

/**
 * 특정 레벨에서 다음 레벨까지 올라 가려고 할 때, 얻어야 하는 포인트를 리턴한다.
 *
 * 현재 내 레벨에서 다음 레벨까지 도달하려면 얻어야하는 포인트를 나타내고, 백분율로 표시하고자 할 때 사용한다.
 *
 * 예를 들면, pointBetween(4) 로 입력하면 737 을 리턴하는데, 4 레벨에서 5레벨 까지 걸리는(획득해야하는) 포인트이다.
 *
 * @param int $lv
 * @return int
 *
 * 참고, 더 많은 예제는 functions.test.php 참고
 */
function pointBetween(int $lv): int {
    return pointByLevel( $lv) - pointByLevel($lv - 1);
}

/**
 * 포인트를 입력하면, 다음 레벨까지 몇 % 진행했는지를 정수로 리턴한다.
 *
 * 특정 포인트를 입력하면,
 *      1) 입력된 포인트의 레벨을 구하고, Lv-Low
 *      2) 다음 레벨에 도달하기 까지의 포인트를 구하고, Point-High
 *      3) 입력된 포인트의 레벨의 가장 낮은 점수를 구하고, Point-Low
 *      4) 현재 레벨에서 다음 레벨 까지의 총 포인트 차이를 구하고, total
 *      5) 내 포인트가 현재 레벨의 가장 낮은 점수에서 얼마를 벌었는지 구하고, myP
 *      6) 백분율을 구한다. 총 포인트: PH-PL 에서 MY-P 가 몇 퍼센트인지 구한다.
 *
 * 사용 예)
 *  나의 포인트가 1234567 이면, percentageOf(1234567) 와 같이 호출하면 29가 리턴된다.
 *  즉, 현재 내 레벨에서 다음 레벨까지 29% 진행했고, 71% 남은 셈이다.
 *
 * 참고, 더 많은 예제는 functions.test.php 참고
 *
 * @param int $point
 * @return int
 */
function percentageOf(int $point): int {
    $lv = levelByPoint($point);
    $myP = $point - pointByLevel($lv-1);
    $total = pointBetween($lv);
    $p = round($myP / $total * 100);
    return $p;
}